@extends('admin.layouts.app')

@section('title', 'Buat Post Baru')

@section('content')
@include('admin.posts._form', ['post' => null])
@endsection
