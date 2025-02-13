<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunter;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hunters = Hunter::all();
        return view('admin.dashboard', compact('hunters'));
    }
}
