<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HapvidaController extends Controller
{
    public function index()
    {
        return view('admin.pages.hapvida.index');
    }
}
