<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class MediaController extends Controller
{
    public function index()
    {
        return view('content.backend.media.index');
    }

    public function add()
    {
        $input = Input::all();
        $rules = array(
            'images' => 'image|max:8000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

        $destinationPath = 'uploads';
        $extension = Input::file('images')->getClientOriginalExtension();
        $fileName = rand(11111,99999).'.'.$extension;
        Input::file('images')->move($destinationPath, $fileName);

        return Response::json(200);

    }

    public function edit($id)
    {

    }

    public function save($id = null)
    {

    }

    public function delete($id)
    {

    }

}