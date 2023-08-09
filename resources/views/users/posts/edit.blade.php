@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(up to 3)</span>
        </label>

        @foreach($all_categories as $category)
            <div class="form-check form-check-inline">
                    {{-- <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input'>  --}}
                    {{-- 1st itr; 1, check if the id=1 is inside the array[1,2] 
                         2nd ite; 2, check if the id=2 is inside the array[1,2]  
                         3rd itr; 3, check if the id=3 is inside the array[1,2] 
                         --}}
                    @if(in_array($category->id, $selected_categories))
                    <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input" checked>
                    @else
                    <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                    @endif

                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>  
        @endforeach
        {{-- Error --}}
        @error('category')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" rows="3" placeholder="what's on your mind" class="form-control">{{ old('description', $post->description)}}</textarea>
        {{-- Error --}}
        @error('description')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="row mb-4">
        <div class="col-6">
            <label for="image" class="form-label fw-bold">Image</label>
            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="img-thumbnail w-100">
            <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                The acceptable formats are ipeg, leg, pdf, and gif only<br>
                Max File sixe is 1048kb.
            </div>
            {{-- Error --}}
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>      
    </div>

    <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection