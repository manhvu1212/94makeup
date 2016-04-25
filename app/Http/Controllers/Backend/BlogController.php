<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('content.backend.blog.index');
    }

    public function add()
    {
        return view('content.backend.blog.add');
    }

    public function edit($id)
    {

    }

    public function save($id =null)
    {

    }

    public function delete($id)
    {

    }

}