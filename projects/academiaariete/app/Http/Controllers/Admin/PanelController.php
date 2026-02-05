<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Muestra el panel principal de administración.
     */
    public function index()
    {
        return view('admin.panel');
    }
}
