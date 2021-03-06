<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        return view('content.backend.dashboard');
    }

    public function login()
    {
        return view('layout.backend.login');
        // if (!Session::has('user.id') || Session::get('user.role') != 'ADMINISTER') {
        //     $helper = $this->fb->getRedirectLoginHelper();
        //     return Redirect::to($helper->getLoginUrl(route('admin::loginCallback'), ['email', 'user_friends', 'user_birthday', 'manage_pages']));
        // } else {
        //     return redirect(route('admin::dashboard'));
        // }
    }

    public function loginCallback()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            return redirect('/')->with('message', 'Graph returned an error: ' . $e->getMessage());
        } catch (FacebookSDKException $e) {
            return redirect('/')->with('message', 'Facebook SDK returned an error: ' . $e->getMessage());
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                $message = "Error: " . $helper->getError() . "\n";
                $message .= "Error Code: " . $helper->getErrorCode() . "\n";
                $message .= "Error Reason: " . $helper->getErrorReason() . "\n";
                $message .= "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                $message = 'Bad request';
            }
            return redirect('/')->with('message', $message);
        }

        if (!$accessToken->isLongLived()) {
            $client = $this->fb->getOAuth2Client();
            try {
                $accessToken = $client->getLongLivedAccessToken($accessToken);
            } catch(FacebookSDKException $e) {
                return redirect('/')->with('message', 'Facebook SDK returned an error: ' . $e->getMessage());
            }
        }

        $this->fb->setDefaultAccessToken($accessToken);
        $me = $this->fb->get('/me')->getDecodedBody();
        $avatar = $this->fb->get('/me/picture?height=320&width=320&redirect=0')->getDecodedBody();
        $pages = $this->fb->get('/me/accounts?limit=100')->getDecodedBody();
        foreach ($pages['data'] as $page) {
            if ($page['id'] == env('FACEBOOK_PAGE_ID')) {
                if (in_array("ADMINISTER", $page['perms'])) {
                    Session::put('user.id', $me['id']);
                    Session::put('user.role', 'ADMINISTER');
                    Session::put('user.name', $me['name']);
                    Session::put('user.token', $accessToken);
                    if (isset($avatar['data'])) {
                        Session::put('user.avatar', $avatar['data']['url']);
                    }
                }
            }
        }
        return redirect(route('admin::dashboard'));
    }

    public function logout()
    {
        Session::flush();
        return redirect(route('homepage'));
    }
}