<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDiaryRequest;
use App\Models\Diary;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DiaryController extends Controller
{
    /**
     * Index diary
     * @param Diary $diary diary
     * @return Responsable
     */
    public function show(Diary $diary)
    {
        $posts = Post::with('diary', "user.statuses")->where("diary_id", $diary->id)->orderBy('created_at', 'asc')->get()->toArray();
        $idDiary = $diary->id;
        $user = \Auth::user();
        $posts = array_map(function ($item) {
            $item['message'] = \App\Service\BBcode::parseBB($item['message']);
            return $item;
        }, $posts);
        return view('diary', compact("posts", "idDiary", "user"));
    }

    /**
     * Form for add diary
     * @param
     * @return Responsable
     */
    public function createForm()
    {
        $user = \Auth::user();
        return view('adddiary', compact('user'));
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
        $post = new Post();
        $post->message = "init diary";
        $post->user_id = \Auth::user()->id;
        $diary->save();
        $diary->posts()->save($post);
        return redirect("/home");
    }


}
