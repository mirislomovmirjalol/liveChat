<?php

namespace App\Http\Controllers;

use App\Models\UserWebsite;
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


        $this->validate($request,[
           'name' => 'required|max:255',
            'url' => 'required',
            'title' => '',
            'description' => '',
            'welcome_text' => '',
            'logo' => 'image|max:5128',
        ]);

        $userwebsite = new UserWebsite();

        $userwebsite->name = $request->name;
        $userwebsite->url = $request->url;
        $userwebsite->title = $request->title;
        $userwebsite->description = $request->description;
        $userwebsite->welcome_text = $request->welcome_text;
        $userwebsite->logo = $request->logo;
        $userwebsite->token = uniqid().time().rand(0,1000);

        $userwebsite->save();

        $websiteoperator = new WebsiteOperator();

        $websiteoperator->user_id = Auth::user()->id;

        $websiteoperator->website_id = $userwebsite->id;
        $websiteoperator->status = 1;

        $websiteoperator->save();

        return redirect('/manage_sites');
    }
    public function edit()
    {


        return view('website.edit');
    }
}
