@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Site</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sites.update', $site->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $site->name) }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="url">URL</label>
                                <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $site->url) }}">
                                @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last_updated_fetch">Last Updated Fetch</label>
                                <input type="text" name="last_updated_fetch" id="last_updated_fetch" class="form-control @error('last_updated_fetch') is-invalid @enderror" value="{{ old('last_updated_fetch',$site->last_updated_fetch) }}">
                                @error('last_updated_fetch')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="last_id">Last id</label>
                                <input type="text" name="last_id" id="last_id" class="form-control @error('last_id') is-invalid @enderror" value="{{ old('url', $site->last_id) }}">
                                @error('last_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" {{ $site->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $site->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="thumbnail_display">Thumbnail Display</label>
                                <select name="thumbnail_display" id="thumbnail_display" class="form-control @error('thumbnail_display') is-invalid @enderror">
                                    <option value="true" {{ $site->thumbnail_display == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $site->thumbnail_display == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                                @error('thumbnail_display')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="category_display">Category Display</label>
                                <select name="category_display" id="category_display" class="form-control @error('category_display') is-invalid @enderror">
                                    <option value="true" {{ $site->category_display == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $site->category_display == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                                @error('category_display')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $site->description) }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection