<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Models\UserWebsite;
use App\Models\WebsiteOperator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ManageSitesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $websites = WebsiteOperator::where("user_id", Auth::user()->id)->latest()->get();

        return view('website.manage_sites', compact('websites'));
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

        return redirect()->route('manage_sites');
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
        if ($website->user_id == Auth::user()->id) {
            if ($website->delete()) {
                return redirect('manage_sites');
            } else {
                return redirect('manage_sites');
            }
        } else {
            return abort(404);
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
        $websiteOperators = WebsiteOperator::where('website_id', $website->id)->latest()->get();
        $attach = User::where('created_by', Auth::user()->id)->first();

        if ($website->user_id == Auth::user()->id) {
            return view('website.operators', compact('website', 'websiteOperators', 'attach'));
        } else {
            return abort(404);
        }
    }

    public function showConversations(UserWebsite $website)
    {
        if ($website->user_id == Auth::user()->id) {
            $conversations = Conversation::where('website_id', $website->id)->latest()->get();
            return view('website.conversations', compact('website','conversations'));
        } else {
            return abort(404);
        }
    }

    public function showOperator(Request $request)
    {
        if ($request->get('website')) {
            $website = UserWebsite::query()->where('id', (int)$request->get('website'))->where('user_id', Auth::user()->id)->first();
            if ($website) {
                return view('website.create_operator', compact('website'));
            }
        }
        return view('website.create_operator');
    }

    public function createOperator(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $operator = new User();
        $operator->name = $request->name;
        $operator->email = $request->email;
        $operator->password = bcrypt($request->password);
        $operator->created_by = auth()->user()->id;
        $operator->type = User::TYPE_OPERATOR;
        $operator->telegram_start_token = Carbon::now()->timestamp . '.' .Str::random(30);

        $operator->save();

        if ($request->get('website_id')) {
            $website = WebsiteOperator::where('website_id', $request->get('website_id'))->where('user_id', Auth::user()->id)->first();
            if ($website) {
                $websiteOperator = new WebsiteOperator();
                $websiteOperator->user_id = $operator->id;
                $websiteOperator->status = WebsiteOperator::STATUS_ACTIVE;
                $websiteOperator->website_id = $request->get('website_id');
                $websiteOperator->save();
                return redirect()->route('site.operators', $request->get('website_id'));
            }
        }

        return abort(404);
    }

    public function attachOperators(UserWebsite $website)
    {
        $websiteOperators = User::where('created_by', auth()->user()->id)
            ->whereNotIn('id', function ($query) use ($website) {
                $query->select('user_id')->where('website_id', $website->id)->from('website_operators');
            })
            ->get();


        if ($website->user_id == Auth::user()->id) {
            return view('website.attach_operators', compact('website', 'websiteOperators'));
        } else {
            return abort(404);
        }
    }

    public function attachedOperators(Request $request, UserWebsite $website)
    {
        $this->validate($request, [
            'operator' => ['required',
                Rule::unique("website_operators", 'user_id')
                    ->where(function ($query) use ($website) {
                        return $query->where('website_id', $website->id);
                    })],
        ]);

        $websiteOperator = new WebsiteOperator();
        $websiteOperator->website_id = $website->id;
        $websiteOperator->user_id = $request->operator;
        $websiteOperator->save();
        return redirect()->route('site.operators', $website->id);
    }

    public function deleteOperator(UserWebsite $website, User $operator)
    {
        if ($operator->id == Auth::user()->id) {
            return abort(404);
        }
        if ($website->user_id == Auth::user()->id) {
            if (WebsiteOperator::query()->where('user_id', $operator->id)->where('website_id', $website->id)->delete()) {
                return redirect()->route('site.operators', $website);
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function toggleStatus(Request $request, UserWebsite $website, User $operator)
    {
        if ($website->user_id == Auth::user()->id) {
            $toggle = WebsiteOperator::where('user_id', $operator->id)
                ->where('website_id', $website->id)
                ->first();

            if ($toggle) {
                if ($toggle->status == User::STATUS_ACTIVE) {
                    $toggle->status = User::STATUS_INACTIVE;
                    $toggle->save();
                    return redirect()->route('site.operators', $website);
                } else {
                    $toggle->status = User::STATUS_ACTIVE;
                    $toggle->save();
                    return redirect()->route('site.operators', $website);
                }
            }
        }
        return abort(404);
    }
}
