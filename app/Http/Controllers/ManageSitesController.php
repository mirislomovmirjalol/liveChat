<?php

namespace App\Http\Controllers;

use App\Models\WebsiteOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageSitesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $websites = WebsiteOperator::where("user_id", Auth::user()->id)->get();


        return view('website.manage_sites', ['websites' => $websites]);
    }

    public function create()
    {
        return view('website.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'unique:posts', 'max:255'],
            'body' => ['required'],
        ]);


    }
}
