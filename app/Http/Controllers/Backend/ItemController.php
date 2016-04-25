<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        return view('content.backend.item.index');
    }

    public function add()
    {
        return view('content.backend.item.add');
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