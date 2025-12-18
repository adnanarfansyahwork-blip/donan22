@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori: {{ $category->name }}</h3>
                </div>
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Parent Kategori</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">-- Tidak Ada Parent --</option>
                                        @foreach($parents as $cat)
                                            @if($cat->id != $category->id)
                                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Urutan</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Icon (Font Awesome)</label>
                                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon) }}" placeholder="fa-folder">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Gambar Kategori</label>
                                    @if($category->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="" class="img-thumbnail" style="max-height: 150px">
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} id="is_active">
                                        <label class="form-check-label" for="is_active">Aktif</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="show_in_menu" class="form-check-input" value="1" {{ old('show_in_menu', $category->show_in_menu) ? 'checked' : '' }} id="show_in_menu">
                                        <label class="form-check-label" for="show_in_menu">Tampilkan di Menu</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>SEO</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $category->meta_title) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $category->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
