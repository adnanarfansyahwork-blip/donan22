@extends('admin.layouts.app')

@section('title', 'Preview Sitemap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Preview Sitemap.xml</h3>
                    <a href="{{ route('admin.sitemap.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($content)
                        <pre class="bg-dark text-light p-4 rounded" style="max-height: 600px; overflow-y: auto;"><code>{{ $content }}</code></pre>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Sitemap.xml belum ada. Silakan generate terlebih dahulu.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection