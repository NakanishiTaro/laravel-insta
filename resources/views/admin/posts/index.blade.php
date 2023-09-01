@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
<div class="contaier">
    <h4 class="text-secondary"><i class="fa-solid fa-newspaper"></i>Post</h4>
    <div class="card border-0 mb-3">
        <form action="{{route('admin.posts.search')}}">
            <div class="row">      
                <div class="col-lg-10 col-md-8 col-sm-6 offset-4">
                    <div class="row">
                        <div class="col-4">
                            <input type="search" name="search" class="form-control form-control" placeholder="Search owner...">
                            @error('search')
                                <div class="text-danger small">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <select name="search_category" id="categories" class="form-control">
                                <option value="" class="select">Select Category</option>
                                @forelse($all_categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @empty 
                                @endforelse
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="reset" class="btn btn-outline-primary"><i class="fa-solid fa-rotate-left"></i></button>
                        </div>
                        
                    </div>   
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-lg col-md col-sm">
            <table class="table table-hover align-middle bg-white border text-secondary">
                <thead class="table-primary text-secondary small">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>CATEGORY</th>
                        <th>OWNER</th>
                        <th>CREATED_AT</th>
                        <th>STATUS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($all_posts as $post)
                        <tr>
                            <td class="text-end">{{$post->id}}</td>
                            <td>
                                @if($post->trashed())
                                <img src="{{$post->image}}" alt="post id {{$post->id}}" class="d-block ms-auto image-lg">
                                @else
                                    <a href="{{route('post.show', $post->id)}}">
                                        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="d-block ms-auto image-lg">
                                    </a>
                                @endif
                                
                            </td>
                            <td>
                                @forelse($post->categoryPost as $category_post)
                                    <span class="badge bg-secondary bg-opacity-50">{{$category_post->category->name}}</span>
                                @empty
                                    <div class="badge bg-dark text-wrap">Uncategorized</div>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{route('profile.show', $post->user->id)}}" class="text-dark text-decoration-none">{{$post->user->name}}</a>
                            </td>
                            <td>
                                {{$post->created_at}}
                            </td>
                            <td>
                                @if($post->trashed())
                                    <i class="fa-solid fa-circle-minus text-secondary"></i>&nbsp; Hidden
                                @else
                                    <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if($post->trashed())
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post-{{$post->id}}">
                                                <i class="fa-solid fa-eye"></i> Unhide Post {{$post->id}}
                                            </button>
                                        @else 
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                                <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                {{-- Include the modal here --}}
                                @include('admin.posts.modal.status')
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td colspan="7" class="lead text-muted text-center">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{$all_posts->links()}}
            </div>
        </div>
    </div>    
</div>
@endsection