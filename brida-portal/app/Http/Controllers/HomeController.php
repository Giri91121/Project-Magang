<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function layanan()
    {
        return view('landing.layanan');
    }

    public function informasiPublik()
    {
        return view('landing.informasi-publik');
    }

    public function berita()
    {
        return view('landing.berita');
    }
}
