@extends('admin.layouts.app')

@section('title', 'Edit Post: ' . $post->title)

@section('content')
@include('admin.posts._form', ['post' => $post])
@endsection
