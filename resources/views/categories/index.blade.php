@extends('layouts.main_with_sidebar')
@php

@endphp
@section('title', )
@section('content')
<div class="container_categories mt-4">
    <h4>All categories</h4>
    <div class="row">
        @foreach($allCategories as $category)
        <div class="card col-sm-8 col-md-5 col-lg-3 mb-3 mt-3 mx-3 p-2">
            <img src="{{asset('storage/category_photos/'.$category->image)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$category->name}}</h5>
                <p class="card-text"><a href="{{route('categories.subcategories',$category->id)}}" class="btn btn-success show-subcategories-btn ">View subcategories</a></p>
            </div>
        </div>

        @endforeach
        <div class="pagination ">
            <a href="{{ $allCategories->previousPageUrl() }}" class="{{ $allCategories->onFirstPage() ? 'disabled' : '' }} pagination-btn "><- Previous Page </a>
                    <a href="{{ $allCategories->nextPageUrl() }}" class="{{ !$allCategories->hasMorePages() ? 'disabled' : '' }}  pagination-btn ">Next Page -></a>
        </div>

    </div>
</div>

@endsection