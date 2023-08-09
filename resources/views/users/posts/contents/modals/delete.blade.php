<div class="modal fade" id="delete-post-{{$post->id}}">
   <div class="modal-dialog">
    <div class="modal-content border-danger">
        {{-- Header --}}
        <div class="modal-header border-danger">
            <h3 class="h5 modal-title-danger">
                <i class="fa-solid fa-circle-exclamation"></i> Delete Post
            </h3>
        </div>
        {{-- Body --}}
        <div class="modal-body">
            <p>Are your sure you want to delete this post?</p>
            <div class="mt-3">
                <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="img-lg">
                <p class="mt-1 text-muted">{{ $post->description }}</p>
            </div>
        </div>
        {{-- Footer --}}
        <div class="modal-footer border-0">
            <form action="{{route('post.destroy', $post->id)}}" method="post">
                @csrf
                @method("DELETE")
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>
        </div>
    </div>
   </div>
</div>