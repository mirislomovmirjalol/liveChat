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
        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required',
            'title' => 'required',
            'description' => '',
            'welcome_text' => '',
            'logo' => 'image|max:5128',
        ]);

        $userwebsite = new UserWebsite();

        $userwebsite->user_id = Auth::user()->id;
        $userwebsite->name = $request->name;
        $userwebsite->url = $request->url;
        $userwebsite->title = $request->title;
        $userwebsite->description = $request->description;
        $userwebsite->welcome_text = $request->welcome_text;
        $userwebsite->logo = $request->logo;
        $userwebsite->token = uniqid() . time() . rand(0, 1000);

        $userwebsite->save();

        $websiteoperator = new WebsiteOperator();

        $websiteoperator->user_id = Auth::user()->id;

        $websiteoperator->website_id = $userwebsite->id;
        $websiteoperator->status = 1;

        $websiteoperator->save();

        return redirect('/manage_sites');
    }

    public function edit(UserWebsite $website)
    {
        if ($website->user_id == Auth::user()->id) {
            return view('website.edit', compact('website'));
        } else {
            return abort(404);
        }
    }

    public function update(Request $request,UserWebsite $website)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required',
            'title' => '',
            'description' => '',
            'welcome_text' => '',
            'logo' => 'image|max:5128',
        ]);

        $website = UserWebsite::where('id',$request->id)->first();

        $website::update([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'url' => $request->url,
            'title' => $request->title,
            'description' => $request->description,
            'welcome_text' => $request->welcome_text,
            'logo' => $request->logo,
            'token' => uniqid() . time() . rand(0, 1000),
        ]);

        return redirect('/manage_sites');
    }
}
