<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Diary;
use App\Models\Post;
use App\Service\hcaptcha;
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
    public function create(hcaptcha $hcaptcha, Diary $diary, PostRequest $request)
    {
        if (!$request->validated() || !$hcaptcha->check($request->{'h-captcha-response'})) {
            return redirect("/diary/" . $diary->id);
        }
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
        return view('editpost', compact("diary", "post"));
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
        if ($diary->posts[0]->id === $post->id) {
            $diary->delete();
            return redirect("/home/");
        }
        $post->delete();

        return redirect("/diary/" . $diary->id);
    }
}
