<div class="card-header bg-white py-3">
    <div class="row align-items-center">
        {{-- AVATAR --}}
        <div class="col-auto">
            <a href="{{route('profile.show', $post->user->id)}}">
                @if($post->user->avatar)
                   <img src="{{$post->user->avatar}}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
                @else
                   <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                @endif
            </a>
        </div>
        {{-- name --}}
        <div class="col">
            <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
        </div>
        {{-- Ellipsois --}}
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                {{-- If the login user is the owner of the post, you can edit or delete the post --}}
                @if(Auth::user()->id === $post->user->id)
                   <div class="dropdown-menu">
                       <a href="{{route('post.edit', $post->id)}}" class="dropdown-item">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                       </a>
                       <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                           <i class="fa-regular fa-trash-can"></i> Delete
                       </button>
                   </div>
                   {{-- Include Modal here --}}
                   @include('users.posts.contents.modals.delete')
                @else
                  <div class="dropdown-menu">
                    {{-- <form action="{{route('follow.destroy', $post->user->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                    </form> --}}
                        @if($post->user->isFollowed())
                            <form action="{{route('follow.destroy', $post->user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">Following</button>
                            </form>
                       @else
                            <form action="{{route('follow.store', $post->user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-primary">Follow</button>
                            </form>
                       @endif
                  </div>
                @endif
            </div>
        </div>
    </div>
</div>