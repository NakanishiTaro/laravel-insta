@extends('layouts.app')

@section('title', 'Home')

@section('content')
{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>--}}
    <div class="row gx-5">
        <div class="col-8">
           @forelse($all_posts as $post)
           {{--<p>{{ $post }}</p>--}}
               <div class="card mb-4">
                {{-- TITLE --}}
                 @include('users.posts.contents.title')
                  {{--BODY --}} 
                 @include('users.posts.contents.body')    
               </div>
           @empty
           {{-- If hte login userdose not has apost yet --}}
           <div class="text-enter">
                <h2>Share Photos</h2>
                <p class="text-muted">When you share photos, they'll appear on your priflie.</p>
                <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo.</a>
           </div>
           @endforelse
        </div>
        <div class="col-4">
            {{-- PROFILE OVERVIEW --}}
            <div class="row align-item-center mb-5 bg-white shadow-sm rounded-3 py-3">
                <div class="col-auto">
                    <a href="{{route('profile.show', Auth::user()->id)}}">
                        @if(Auth::user()->avatar)
                           <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-md">
                        @else
                        <i class="fa-solid fa-circle-user text-secondry icon-md"></i>
                        @endif
                    </a>
                </div>
                {{-- name + email --}}
                <div class="col ps-0">
                    <a href="{{route('profile.show', Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{Auth::user()->name}}
                    </a>
                    <p class="text-muted mb-0">{{Auth::user()->email}}</p>
                </div>
            </div>

            {{-- SUGGESSTIONS --}}
            SUGGESSTIONS
        </div>
    </div>
@endsection
