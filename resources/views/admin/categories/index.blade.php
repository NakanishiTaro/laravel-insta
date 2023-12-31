@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <h4 class="text-secondary"> <i class="fa-solid fa-tags"></i> Category 
        <button class="btn" data-bs-toggle="modal" data-bs-target="#add-category-" title="Add">
            <i class="fa-solid fa-circle-plus text-secondary fa-2x"></i>
        </button>
    </h4>
    <div class="mb-3">
        <div class="row">   
            <div class="col-12">
                <div class="row">
                    <div class="col-6 offset-6">
                        <form action="{{route('admin.categories.search')}}">
                            <div class="input-group">
                                <input type="search" name="search" placeholder="Search category...." class="form-control">
                                <button type="submit" class="btn btn-primary text-white"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <button type="reset" class="btn btn-secondary"><i class="fa-solid fa-rotate-left"></i></button>
                            </div>         
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
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
                    @forelse($all_categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td class="text-dark">{{$category->name}}</td>
                            <td>{{$category->categoryPost->count()}}</td>
                            <td>{{$category->updated_at}}</td>
                            <td>
                                {{-- Edit Button --}}
                                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{$category->id}}" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                {{-- Delete Button --}}
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
                    <tr>
                        <td></td>
                        <td class="text-dark">
                            Uncategorized
                            <p class="xsmall mb-0 text-muted">Hidden posts are not included.</p>
                        </td>
                        <td>{{$uncategorized_count}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>    
            <div class="d-flex justify-content-center">
                {{$all_categories->links()}}
            </div>
        </div>
    </div>
@endsection