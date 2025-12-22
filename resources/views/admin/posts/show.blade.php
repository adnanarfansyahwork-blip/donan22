@extends('admin.layouts.app')

@section('title', 'View Post: ' . $post->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Post Details</h1>
        <div>
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="h4 mb-3">{{ $post->title }}</h2>
                    
                    @if($post->featured_image)
                    <div class="mb-3">
                        <img src="{{ asset('uploads/posts/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="img-fluid rounded">
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong>Excerpt:</strong>
                        <p>{{ $post->excerpt }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Content:</strong>
                        <div class="post-content">
                            {!! $post->content !!}
                        </div>
                    </div>

                    @if($post->meta_title)
                    <div class="mb-3">
                        <strong>Meta Title:</strong>
                        <p>{{ $post->meta_title }}</p>
                    </div>
                    @endif

                    @if($post->meta_description)
                    <div class="mb-3">
                        <strong>Meta Description:</strong>
                        <p>{{ $post->meta_description }}</p>
                    </div>
                    @endif

                    @if($post->tags->isNotEmpty())
                    <div class="mb-3">
                        <strong>Tags:</strong>
                        <div>
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($post->softwareDetail)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Software Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Version</th>
                            <td>{{ $post->softwareDetail->version }}</td>
                        </tr>
                        <tr>
                            <th>Developer</th>
                            <td>{{ $post->softwareDetail->developer }}</td>
                        </tr>
                        <tr>
                            <th>File Size</th>
                            <td>{{ $post->softwareDetail->file_size }}</td>
                        </tr>
                        <tr>
                            <th>System Requirements</th>
                            <td>{!! nl2br(e($post->softwareDetail->system_requirements)) !!}</td>
                        </tr>
                        @if($post->softwareDetail->license_type)
                        <tr>
                            <th>License Type</th>
                            <td>{{ $post->softwareDetail->license_type }}</td>
                        </tr>
                        @endif
                        @if($post->softwareDetail->release_date)
                        <tr>
                            <th>Release Date</th>
                            <td>{{ $post->softwareDetail->release_date->format('d M Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            @endif

            @if($post->downloadLinks->isNotEmpty())
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Download Links</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>URL</th>
                                <th>File Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($post->downloadLinks as $link)
                            <tr>
                                <td>{{ $link->name }}</td>
                                <td>
                                    <a href="{{ $link->url }}" target="_blank">{{ Str::limit($link->url, 50) }}</a>
                                </td>
                                <td>{{ $link->file_size ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Post Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Author:</strong>
                        <p class="mb-0">{{ $post->user->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Category:</strong>
                        <p class="mb-0">{{ $post->category->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Post Type:</strong>
                        <p class="mb-0">{{ $post->postType->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Slug:</strong>
                        <p class="mb-0">{{ $post->slug }}</p>
                    </div>

                    @if($post->published_at)
                    <div class="mb-3">
                        <strong>Published At:</strong>
                        <p class="mb-0">{{ $post->published_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong>Created At:</strong>
                        <p class="mb-0">{{ $post->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Updated At:</strong>
                        <p class="mb-0">{{ $post->updated_at->format('d M Y H:i') }}</p>
                    </div>

                    @if($post->is_featured)
                    <div class="mb-3">
                        <span class="badge bg-warning">
                            <i class="bi bi-star-fill"></i> Featured
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
