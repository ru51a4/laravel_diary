<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Status;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    /**
     * Index user page
     * @return Responsable
     */
    public function index()
    {
        $user = \Auth::user();
        $statuses = Status::all();
        $users = User::with("statuses")->get();
        return view('userpage', compact("statuses", 'users'));
    }

    /**
     * Update user handler
     * @param UserRequest $request user data
     * @return Redirect
     */
    public function update(UserRequest $request)
    {
        $request->validated();
        $user = \Auth::user();
        $user->avatar = htmlspecialchars($request->avatar);
        $user->save();
        return redirect("/userpage/");
    }

    public function getUsersByStr(Request $request)
    {
        $str = $request->str;
        $diaryId = $request->diaryId;
        return User::whereDoesntHave('diarysWhiteList', function ($query) use ($diaryId) {
            $query->where('users_diarys.diary_id', '=', $diaryId);
        })->select('name', 'id')->where("name", "like", $str . "%")->limit(10)->get();

    }

}
