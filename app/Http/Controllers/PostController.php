<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post     = $post;
        $this->category = $category;
    }

    public function create()
    {
        $all_categories = $this->category->all();
        //dd($all_categories);
        
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image'       => 'required|mimes:jpg,png,jpeg,gif|max:1048'
        ]);


        $this->post->user_id = Auth::user()->id;
        // this will return and save the base64 encode image
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        // [1,2]
        foreach($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id
            ];
        }
    // ref: post id = 1
        // category id = 1, 2
        /***
         * [
         *   [1,1],
         *   [1,2]
         * ]
         */
        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    //     $request->validate([
    //         'category'    => 'required|array|between:1,3',
    //         'description' => 'required|string|min:1|max:1000',
    //         'image'       => 'required|mimes:jpg,png,jpeg,gif|max:1048'
    //     ]);
        
    //     //$ is post
    //     $this->post->user_id = Auth::user()->id;
    //     //this will return and the base64 encode image
    //     $this->post->image   = 'date:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
    //     $this->post->description = $request->description;
    //     $this->post->save();

    //     //[1,2]
    //     foreach($request->category as $category_id)
    //     {
    //         $category_post[] = [
    //             'category_id' => $category_id
    //         ];
    //     }
    //  // ref; post id = 1
    //  // category id = 1, 2
    //    $this->post->categoryPost()->createMany($category_post);

    //    return redirect()->route('index');
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post =$this->post->findOrFail($id);

        //if the Auth user is not the owner of th post. redirect page
        if(Auth::user()->id != $post->user->id)
        {
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();

        //get all category IDs od  this post. Save it in an array
        $selected_categories = [];

        foreach($post->categoryPost as $category_post)
        {
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
              ->with('post', $post)
              ->with('all_categories', $all_categories)
              ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image'       => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        //update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        if($request->image)
        {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        //update/delete the category_post entry/entries
        $post->categoryPost()->delete();

        foreach($request->category as $category_id)
        {
            $category_post[] = [
                'category_id' => $category_id,
            ];
        }

        $post->categoryPost()->createMany($category_post);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id)
    {
       $this->post->destroy($id);
       return redirect()->route('index');
    }

}
