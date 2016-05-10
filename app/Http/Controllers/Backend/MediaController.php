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
        $filters = DB::table('media')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('count(id) as count'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('content.backend.media.index', ['media' => $this->getMedia(), 'filters' => $filters, 'year' => $year, 'month' => $month]);
    }

    public function getMedia($paging = 1, $year = null, $month = null)
    {
        $media = new Media();
        if ($year != null && $month != null) {
            return $media->orderBy('created_at', 'desc')
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->forPage($paging, env('PAGING_MEDIA'))
                ->get();
        } else {
            return $media->orderBy('created_at', 'desc')
                ->forPage($paging, env('PAGING_MEDIA'))
                ->get();
        }
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
        try {
            $orientation = exif_read_data($file)['Orientation'];
        } catch (\Exception $e) {
            $orientation = 0;
        }
        $destinationPath = 'uploads/' . $year . '/' . $month . '/' . $day;
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileUpload = $filename . '-' . $current->timestamp . '.' . $extension;
        $fileCrop = $filename . '-' . $current->timestamp . '-crop' . '.' . $extension;
        $fileThumbnail = $filename . '-' . $current->timestamp . '-thumbnail.' . $extension;
        try {
            $newFile = $file->move($destinationPath, $fileUpload);
            $newFile = $newFileThumbnail = Image::make($newFile);
            switch ($orientation) {
                case 3:
                case 4:
                    $newFile->rotate(180);
                    break;
                case 5:
                case 6:
                    $newFile->rotate(-90);
                    break;
                case 7:
                case 8:
                    $newFile->rotate(90);
                    break;
            }
            $newFile->save($destinationPath . '/' . $fileUpload);
            $newFile->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $fileCrop);
            $newFileThumbnail->fit(300)->save($destinationPath . '/' . $fileThumbnail);
        } catch (FileException $e) {
            return Response::json('error', 400);
        }

        $media = new Media();
        $media->filename = $filename;
        $media->full = $destinationPath . '/' . $fileUpload;
        $media->crop = $destinationPath . '/' . $fileCrop;
        $media->thumbnail = $destinationPath . '/' . $fileThumbnail;
        $media->author = Session::get('user.id');
        $media->save();
        $media->url = route('admin::media::edit', $media->id);

        return $media;
    }

    public function edit($id)
    {
        $media = Media::find($id);
        $author = $this->fb->get('/' . $media->author, Session::get('user.token'))->getDecodedBody();
        $media->nameAuthor = $author['name'];
        return $media;
    }

    public function save($id)
    {
        return 1;
    }

    public function delete($id)
    {
        $media = Media::find($id);
        try {
            File::delete($media->full, $media->crop, $media->thumbnail);
        } catch (FileException $e) {
            return Response::json('error', 400);
        }
        $media->delete();
        return Response::json('success', 200);
    }

}