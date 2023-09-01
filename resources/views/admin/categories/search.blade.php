@extends('layouts.app')

@section('title', 'Admin: serach category')

@section('content')
  <a href="{{route('admin.categories')}}" class="btn btn-outline-warning mb-3">Back</a>
    <div class="row">
        <div class="col-12">
            <table class="table table-hover align-middle bg-white border table-sm text-secondary text-center">
                <thead class="table-warning small text-secondary">
                    <th>#</th>
                    <th>NAME</th>
                    <th>COUNT</th>
                    <th>LAST UPDATED</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td class="text-dark">{{$category->name}}</td>
                            <td>{{$category->categoryPost->count()}}</td>
                            <td>{{$category->updated_at}}</td>
                            <td>
                                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{$category->id}}" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                        @include('admin.categories.modal.action')
                    @empty 
                        <tr>
                            <td colspan="5" class="text-muted lead text-center">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {{$categories->links()}} --}}
            </div>
        </div>
    </div>
@endsection