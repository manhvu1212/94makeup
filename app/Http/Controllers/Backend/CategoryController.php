<?php
namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function edit($id)
    {

    }

    public function save($id = null)
    {
        if($id == null) {
            $category = new Category();
        } else {
            $category = Category::find($id);
        }
        $input = Input::all();

        $category->slug = str_slug($input['name']);
        $category->name = $input['name'];
        $category->parent = $input['parent'];
        $category->type = $input['type'];
        if ($input['image'] != null) {
            $category->image = $input['image'];
        }
        $category->description = $input['description'];
        $category->author = Session::get('user.id');
        $category->save();

        return Redirect::back();
    }

    public function delete($id)
    {

    }

    public function item()
    {
        return view('content.backend.category.index');
    }

    public function blog()
    {
        $category = new Category();
        $categories = $category->where('type', 'blog')->get();
        return view('content.backend.blog.category', ['categories' => $categories]);
    }
}