<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function edit($id)
    {

    }

    public function save($id = null)
    {

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
        return view('content.backend.category.index');
    }
}