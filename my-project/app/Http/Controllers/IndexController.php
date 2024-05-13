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

        $diarys = \DB::SELECT('SELECT * FROM diaries AS a INNER JOIN
            (SELECT diary_id as di, MAX(id) as kek FROM posts group by diary_id) gg ON a.id = gg.di
            ORDER BY gg.kek DESC LIMIT 5 OFFSET ?', [5 * ($page - 1)]);

        $ids = array_map(function ($item) {
            return $item->id;
        }, $diarys);

        $diarys = Diary::whereIn('id', $ids)->with(['user.statuses'])->get()->sortBy(function ($item) use ($ids){
            return array_search($item->id, $ids);
        });

        $count = \DB::SELECT('SELECT COUNT(*) as count FROM diaries')[0]->count;

        $pages = ($count % 5 === 0) ? $count / 5 : $count / 5 + 1;

        return view('home', compact('diarys', 'pages', "page"));
    }

    public function test()
    {

    }


}
