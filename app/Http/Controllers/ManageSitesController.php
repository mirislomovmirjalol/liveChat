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
        $websites = WebsiteOperator::where("user_id", Auth::user()->id)->latest()->get();


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
            'description' => 'required',
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

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required',
            'title' => '',
            'description' => '',
            'welcome_text' => '',
            'logo' => 'image|max:5128',
        ]);

        $website = UserWebsite::where('id', $request->id)->first();

        $website->name = $request->name;
        $website->url = $request->url;
        $website->title = $request->title;
        $website->description = $request->description;
        $website->welcome_text = $request->welcome_text;
        $website->logo = $request->logo;

        if ($website->save()) {
            return redirect('manage_sites');
        } else {
            return redirect()->back();
        }
    }

    public function delete(UserWebsite $website)
    {
        if ($website->delete()) {
            return redirect('manage_sites');
        } else {
            return redirect('manage_sites');
        }
    }

    public function showAbout(UserWebsite $website)
    {
        if ($website->user_id == Auth::user()->id) {
            return view('website.about', compact('website'));
        } else {
            return abort(404);
        }
    }

    public function showOperators(UserWebsite $website)
    {
        if ($website->user_id == Auth::user()->id) {
            return view('website.operators', compact('website'));
        } else {
            return abort(404);
        }
    }

    public function showConversations(UserWebsite $website)
    {
        if ($website->user_id == Auth::user()->id) {
            return view('website.Conversations', compact('website'));
        } else {
            return abort(404);
        }
    }
}
