<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index():View
    {
        return view('admin.profile.index');
    }
}
