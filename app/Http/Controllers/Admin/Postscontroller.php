<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;


class Postscontroller extends Controller
{
    private $post;
    private $user;
    private $category;

    public function __construct(Post $post, User $user, Category $category)
    {
        $this->post = $post;
        $this->user = $user;
        $this->category = $category;
    }

    public function index()
    {
        $all_posts = $this->post->withTrashed()->latest()->paginate(5);
        $all_categories  = $this->category->all();

        return view('admin.posts.index')->with('all_posts', $all_posts)
                                        ->with('all_categories', $all_categories);
    }

    public function hide($id)
    {
        $this->post->destroy($id);
        return redirect()->back();
    }
    
    public function unhide($id)
    {
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    private function search(Request $request) 
    {
        $request->validate([
            'search' => 'required||regex:/^[0-9a-zA-Z]+$/u'
        ]);

        $searchCategory = $request->input('search_category');

        if($searchCategory)
        {
            $result_search_name_with_category = $this->post->join('users', 'posts.user_id', '=', 'users.id')
                            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
                            ->join('categories', 'category_post.category_id', '=', 'categories.id')
                            ->where('categories.name', '=', $searchCategory)
                            ->where('users.name', 'like', '%' . $request->search . '%')
                            ->select('posts.*')
                            ->get(); 
        }
        else
        {
            $result_search_name_with_category = $this->post->join('users', 'posts.user_id', '=', 'users.id')
                            ->where('users.name', 'like', '%' . $request->search . '%')
                            ->select('posts.*')
                            ->get();  
                            
        }

        $result_search_with_post_description = $this->post->where('posts.description', 'like', '%' . $request->search . '%')->get();
                                                          
        $posts = $result_search_name_with_category->merge($result_search_with_post_description);
                                                           
        return [$posts, $searchCategory];                       
    }

    public function searchResults(Request $request)
    {
        [$posts, $searchCategory] = $this->search($request);

        return view('admin.posts.search')->with('posts', $posts)
                                         ->with('search', $request->search)
                                         ->with('searchCategory', $searchCategory);
    }
}
