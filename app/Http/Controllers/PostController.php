<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Diary;
use App\Models\Post;
use http\Env\Response;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Create handler
     * @param Diary $diary diary
     * @param PostRequest $request post data
     * @return Redirect
     */
    public function create(Diary $diary, PostRequest $request)
    {
        $request->validated();
        $user = \Auth::user();
        $post = new Post();
        $post->message = $request->message;
        $post->user_id = $user->id;
        $diary->posts()->save($post);
        return redirect("/diary/" . $diary->id);
    }

    /**
     * Form for update post
     * @param Diary $diary diary
     * @param Post $post post
     * @return Responsable
     */
    public function updateForm(Diary $diary, Post $post)
    {
        $user = \Auth::user();
        return view('editpost', compact("diary", "user", "post"));
    }

    /**
     * Update handler
     * @param Diary $diary diary
     * @param Post $post post
     * @param PostRequest $request post data
     * @return Redirect
     */
    public function update(Diary $diary, Post $post, PostRequest $request)
    {
        $this->authorize('update', $post);
        $msg = $request->message;
        $post->editPost($msg);
        return redirect("/diary/" . $diary->id);
    }

    /**
     * Delete handler
     * @param Diary $diary diary
     * @param Post $post post
     * @return Redirect
     */
    public function delete(Diary $diary, Post $post)
    {
        $this->authorize('delete', $post);
        $user = \Auth::user();
        $post->delete();
        $isDiaryEmpty = (count($diary->posts) == 0);
        if ($isDiaryEmpty) {
            $diary->delete();
            return redirect("/home/");
        }
        return redirect("/diary/" . $diary->id);
    }
}
