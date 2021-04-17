<?php

namespace App\Http\Controllers;

use App\Models\WebsiteOperator;
use Illuminate\Support\Facades\Auth;

class ManageSitesController extends Controller
{
    public function index()
    {
        $websites = WebsiteOperator::where("user_id", Auth::user()->id)->get();


        return view('website.manage_sites', ['websites' => $websites]);
    }
    public function create()
    {
        return view('website.create');
    }
}
