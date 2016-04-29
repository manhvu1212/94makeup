<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MediaController extends Controller
{
    public function index($year = null, $month = null)
    {
        $media = Media::all()->sortByDesc('created_at');

        $filters = DB::table('media')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('count(id) as count'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('content.backend.media.index', ['media' => $media, 'filters' => $filters]);
    }

    public function add()
    {
        $input = Input::all();
        $rules = array(
            'image' => 'image|max:9000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::json('error', 400);
        }

        $current = Date::now();
        $year = $current->year;
        $month = $current->month;
        $day = $current->day;

        $file = Input::file('image');
        $destinationPath = 'uploads/' . $year . '/' . $month . '/' . $day;
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileUpload = $filename . '-' . $current->timestamp . '.' . $extension;
        $fileThumbnail = $filename . '-' . $current->timestamp . '-300x300.' . $extension;
        try {
            $newFile = $file->move($destinationPath, $fileUpload);
            Image::make($newFile)->fit(300)->save($destinationPath . '/' . $fileThumbnail);
        } catch (FileException $e) {
            return Response::json('error', 400);
        }

        $media = new Media();
        $media->filename = $filename;
        $media->full = $newFile;
        $media->thumbnail = $destinationPath . '/' . $fileThumbnail;
        $media->author = Session::get('user.id');
        $media->save();

        return Response::json(json_encode($media));
    }

    public function edit($id)
    {

    }

    public function save($id = null)
    {

    }

    public function delete($id)
    {
        $media = Media::find($id);
        try {
            File::delete($media->full, $media->thumbnail);
        } catch(FileException $e) {
            return Response::json('error', 400);
        }
        $media->delete();
        return Response::json('success', 200);
    }

}