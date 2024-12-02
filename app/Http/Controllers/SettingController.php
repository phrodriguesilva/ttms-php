<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Exibe a página de configurações gerais
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('settings.index');
    }
}
