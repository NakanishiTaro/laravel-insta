<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;

    public function __construct(Post $post)
    { 
        $this->post =$post;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //get all the post of the login user andd the user that is being followed by the login user
    private function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post)
        {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id)
            {
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    } 

    public function index()
    {
        // return view('users.home');
        // $all_posts = $this->post->latest()->get();
        $all_posts = $this->getHomePosts();

        return view('users.home')->with('all_posts', $all_posts);
    }

}
