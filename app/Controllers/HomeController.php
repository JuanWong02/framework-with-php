<?php

namespace App\Controllers;

use Jc\Http\Controller;

class HomeController extends Controller {
    public function show() {
        return view('home');
    }
}