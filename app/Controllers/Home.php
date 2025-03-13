<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to(route_to('academics'));
    }

    public function unauthorized()
    {
        return view('errors/error403');
    }
}
