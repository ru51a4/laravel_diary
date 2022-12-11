<?php


namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\Post;
use App\Models\Product;
use App\Service\BBCode;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class RESTApiController extends Controller
{
    //


    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page)
    {
        $diarys = Diary::with(['user.statuses']);
        $count = $diarys->count();
        $pages = ($count % 5 === 0) ? $count / 5 : $count / 5 + 1;
        $diarys = $diarys->offset(5 * ($page - 1))->take(5)->get();
        return ["d" => $diarys, "p" => $pages];
    }


    public function diary(Diary $diary)
    {
        $posts = Post::with('diary', "user.statuses")->where("diary_id", $diary->id)->orderBy('created_at', 'asc')->get()->toArray();
        $idDiary = $diary->id;
        $replys = BBCode::replyShit($posts);
        $posts = array_map(function ($item) {
            $item['message'] = BBCode::parseBB($item['message'], $item["id"]);
            return $item;
        }, $posts);
        return $posts;
    }

    public function createPost(Diary $diary, Request $request)
    {
        $user = \Auth::user();
        $post = new Post();
        $post->message = $request->message;
        $post->user_id = $user->id;
        $diary->posts()->save($post);;
    }

    public function createDiary(Request $request)
    {
        $diary = new Diary();
        $diary->name = $request->name;
        $diary->description = $request->desc;
        $diary->user_id = $this->user->id;
        $diary->whitelist = false;
        $diary->save();
        $post = new Post();
        $post->message = "init diary";
        $post->user_id = $this->user->id;;
        $diary->posts()->save($post);
        return $diary;
    }

    public function editPost(Post $post, Request $request)
    {
        if ($this->user->id != $post->user->id) {
            return;
        }
        $msg = $request->message;
        $post->editPost($msg);
        return $post;
    }

    public function deletePost(Post $post)
    {
        if ($this->user->id != $post->user->id) {
            return;
        }
        $is_op = false;
        if ($post->diary->posts[0]->id == $post->id) {
            $post->diary->delete();
            return;
        }
        $post->delete();
        return;
    }

    public function updateUser(Request $request)
    {
        $this->user->avatar = $request->avatar;
        $this->user->update();
        return;
    }
}
