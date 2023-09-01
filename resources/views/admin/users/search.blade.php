@extends('layouts.app')

@section('title', 'Admin:Search Users')

@section('content')
    <div class="row gx-2">
        <div class="col-6 offset-6">
            <form method="GET" action="{{route('admin.search.users')}}">
                <div class="input-group">
                    <input type="search" placeholder="Search by NAME or E-MAIL ..." name="search" class="form-control">  
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass text-white"></i></button>
                    <a href="{{route('admin.users')}}" class="btn btn-secondary"><i class="fa-solid fa-rotate-left text-white"></i></a>
                </div>
                {{-- error --}}
                @error('search')
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </form>
        </div>
    </div>
    <div class="text-end mb-2">
        @if($users->count() <= 1)
            <p class="mb-0 mt-2"><span class="text-success fw-bold">{{$users->count()}}</span> result</p>
        @else
            <p class="mb-0 mt-2"><span class="text-success fw-bold">{{$users->count()}}</span> results</p>
        @endif
    </div>

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-success text-secondary">
            <tr>
                <th></th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    {{-- image --}}
                    <td>
                        @if($user->avatar)
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle d-block mx-auto avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user d-block text-center icon-md"></i>
                        @endif
                    </td>
                    {{-- name --}}
                    <td>
                        @if($user->trashed())
                            <p class="mb-0 fw-bold"> {{$user->name}}</p>
                        @else
                            <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                                    {{$user->name}}
                            </a>
                        @endif
                    </td>
                    {{-- email --}}
                    <td>{{$user->email}}</td>
                    {{-- created_at --}}
                    <td>{{$user->created_at}}</td>
                    {{-- status --}}
                    <td>
                        @if($user->trashed())
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Inactive
                        @else
                            <i class="fa-solid fa-circle text-success"></i>&nbsp; Active
                        @endif
                    </td>
                    {{-- dropdown menu/ellipsis --}}
                    <td>
                        @if(Auth::user()->id !== $user->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                   
                                    @if($user->trashed())
                                        <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{$user->id}}">
                                            <i class="fa-solid fa-user-check"></i> Activate {{$user->name}}
                                        </button>
                                    @else
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{$user->id}}">
                                            <i class="fa-solid fa-user-slash"></i> Deactivate {{$user->name}}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            {{-- Include the modal here --}}
                            @include('admin.users.modal.status')
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection