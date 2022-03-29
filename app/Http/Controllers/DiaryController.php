<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDiaryRequest;
use App\Models\Diary;
use App\Models\Post;
use App\Models\User;
use App\Service\BBCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DiaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index diary
     * @param Diary $diary diary
     * @return Responsable
     */
    public function show(Diary $diary)
    {
        $posts = Post::with('diary', "user.statuses")->where("diary_id", $diary->id)->orderBy('created_at', 'asc')->get()->toArray();
        $idDiary = $diary->id;
        $replys = BBCode::replyShit($posts);
        $posts = array_map(function ($item) {
            $item['message'] = BBCode::parseBB($item['message'], $item["id"]);
            return $item;
        }, $posts);
        return view('diary', compact("posts", "idDiary", "replys"));
    }

    /**
     * Form for add diary
     * @param
     * @return Responsable
     */
    public function createForm()
    {
        return view('adddiary');
    }

    /**
     * Create handler
     * @param AddDiaryRequest $request diary data
     * @return Redirect
     */
    public function create(AddDiaryRequest $request)
    {
        $request->validated();
        $diary = new Diary();
        $diary->name = $request->name;
        $diary->description = $request->description;
        $diary->user_id = \Auth::user()->id;
        $diary->whitelist = false;
        $diary->save();
        $post = new Post();
        $post->message = "init diary";
        $post->user_id = \Auth::user()->id;
        $diary->posts()->save($post);
        return redirect("/home");
    }

    public function editForm(Diary $diary)
    {
        $whitelist = $diary->usersWhiteList()->get();
        return view('editdiary', compact("diary", "whitelist"));
    }

    public function addwhitelist(User $user, Diary $diary)
    {
        $diary->usersWhiteList()->save($user);
        return \redirect("/diary/edit/" . $diary->id);
    }

    public function deletewhitelist(User $user, Diary $diary)
    {
        $diary->usersWhiteList()->detach($user);
        return \redirect("/diary/edit/" . $diary->id);
    }

    public function setWhitelist(Diary $diary, int $status)
    {
        $diary->whitelist = (boolean)$status;
        $diary->save();
        return \redirect("/diary/edit/" . $diary->id);
    }


}
