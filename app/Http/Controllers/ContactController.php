<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the public contact page.
     */
    public function show()
    {
        return view('pages.contact');
    }
}
