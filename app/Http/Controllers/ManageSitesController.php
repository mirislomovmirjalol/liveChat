<?php

namespace App\Http\Controllers;

use App\Models\UserWebsite;

class ManageSitesController extends Controller
{
    public function index()
    {

        return view('manage_sites');
    }
}
