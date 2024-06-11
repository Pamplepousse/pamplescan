@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Catégories</h1>
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->id) }}" class="list-group-item list-group-item-action">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</div>
@endsection
