@extends('layouts.app')

@section('title', 'Follwers')

@section('content')
    @include('users.profile.header')
    
    <div  style="margin-top:100px">
        @if($user->followers->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-muted text-center">Following</h3>
                    @foreach($user->following as $follower)
                        <div class="row align-item-center mt-3">
                            <div class="col-auto">
                                {{-- image --}}
                                @if($follower->following->avatar)
                                    <a href="{{route('profile.show', $follower->following->id)}}">
                                        <img src="{{$follower->following->avatar}}" alt="{{$follower->following->name}}" class="rounded-circle avatar-sm">
                                    </a>
                                @else
                                    <i class="fa-solid fa-circle-user text-decondary icon-sm"></i>
                                @endif
                            </div>
                            {{-- name --}}
                            <div class="col ps-0 text-truncate">
                                <a href="{{route('profile.show', $follower->following->id)}}" class="text-decoration-none text-dark fw-bold">{{$follower->following->name}}</a>
                            </div>
                            {{-- button follow/following --}}
                            <div class="col-auto text-end">
                                @if($follower->follower->id != Auth::user()->id)
                                   @if($follower->follower->isFollowed())
                                       <form action="{{route('follow.destroy', $follower->follower->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Following</button>
                                       </form>
                                   @else
                                       <form action="{{route('follow.store', $follower->follower->id)}}" method="post">
                                             @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                       </form>
                                   @endif
                                @endif
                            </div>                           
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            
        @endif
    </div>
@endsection