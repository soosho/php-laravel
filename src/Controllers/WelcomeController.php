<?php

namespace Laravel\PhpLaravel\Controllers;

use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('php-laravel.phplaravel.welcome');
    }
}
