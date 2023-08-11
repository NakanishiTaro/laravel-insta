@extends('layouts.app')

@section('title', 'Suggestion')

@section('content')
     <div class="row justify-content-center">
        <div class="col-5">
            <p class="text-muted">Suggested</p>   
            @if($suggested_users)
            <div class="row">
                <div class="col">    
                    @foreach($suggested_users as $user)
                        <div class="row align-items-center mb-3">
                            <div class="col-2 pe-2">
                                <a href="{{route('profile.show', $user->id)}}">
                                    @if($user->avatar)
                                    <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-sm">
                                    @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col-8 ps-0 text-truncase">
                                <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">{{$user->name}}</a><br>
                                <span class="text-muted">{{$user->email}}</span><br>
                                <span class="text-muted">follower {{$user->followers->count()}}</span>
                            </div>
                            <div class="col-2">
                                <form action="{{route('follow.store', $user->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                </form>
                            </div>          
                        </div>
                    @endforeach
                </div>
            </div> 
            @else
                <div class="row">
                    <div class="col-auto">
                        <p class="fw-bold text-secondary">Suggested</p>
                    </div>
                    {{-- <div class="col text-end">
                        <a href="#" class="fw-bold text-dark text-decoration-none">See all</a>
                    </div> --}}
                </div>   
                <p>Nothing to Suggest</p>
            @endif
        </div>
    </div>
@endsection