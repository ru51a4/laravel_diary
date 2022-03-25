<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use App\Service\Auth;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Responsable
     */
    public function index($page = 1)
    {
        $diarys = Diary::with(['user.statuses']);
        $count = $diarys->count();
        $pages = ($count % 5 === 0) ? $count / 5 : $count / 5 + 1;
        $diarys = $diarys->offset(5 * ($page - 1))->take(5)->get();
        $user = \Auth::user();
        return view('home', compact('diarys', 'pages', "user", "page"));
    }

    public function test()
    {

    }


}
