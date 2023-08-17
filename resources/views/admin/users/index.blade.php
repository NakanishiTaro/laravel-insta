@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
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
            @foreach($all_users as $user)
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
                        <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$user->name}}
                        </a>
                    </td>
                    {{-- email --}}
                    <td>{{$user->email}}</td>
                    {{-- created_at --}}
                    <td>{{$user->created_at}}</td>
                    {{-- status --}}
                    <td>
                        {{-- <i class="fa-solid fa-circle text-success"></i>&nbsp; Active --}}
                        @if($user->trashed())
                            <i class="fa-regular fa-circle text-success"></i>&nbsp; Inactive
                        @else
                            <i class="fa-solid fa-circle text-success"></i>&nbsp; Active
                        @endif
                    </td>
                    {{-- dropdown menu/allipse --}}
                    <td>
                        @if(Auth::user()->id !== $user->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    {{-- <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{$user->id}}">
                                        <i class="fa-solid fa-user-slash"></i> Deactivate {{$user->name}}
                                    </button> --}}
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
                            {{-- include the modal here --}}
                            @include('admin.users.modal.status')
                        @endif
                    </td>
                 </tr>
            @endforeach
        </tbody>
   </table>
   <div class="d-flex justify-content-center">
      {{$all_users->links()}}
   </div> 
@endsection