<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

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
            'image' => 'image|max:8000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

        $current = Carbon::now();
        $year = $current->year;
        $month = $current->month;
        $day = $current->day;

        $file = Input::file('image');
        $destinationPath = 'uploads/' . $year . '/' . $month . '/' . $day;
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . $current->timestamp;
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileUpload = $filename . '.' . $extension;
        $newFile = $file->move($destinationPath, $fileUpload);
        Image::make($newFile)->fit(300)->save($destinationPath . '/' . $filename . '-300x300.' . $extension);

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