@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create New Site</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sites.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="url">URL</label>
                                <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}">
                                @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last_updated_fetch">Last Updated Fetch</label>
                                <input type="text" name="last_updated_fetch" id="last_updated_fetch" class="form-control @error('last_updated_fetch') is-invalid @enderror" value="{{ old('last_updated_fetch','2023-01-01T00:00:01') }}">
                                @error('last_updated_fetch')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last_updated_api_send">Last Updated Api Send</label>
                                <input type="text" name="last_updated_api_send" id="last_updated_api_send" class="form-control @error('last_updated_api_send') is-invalid @enderror" value="{{ old('last_updated_api_send','2023-01-01T00:00:01') }}">
                                @error('last_updated_api_send')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="api_send_url">API Send Url</label>
                                <input type="text" name="api_send_url" id="api_send_url" class="form-control @error('api_send_url') is-invalid @enderror" value="{{ old('api_send_url','') }}">
                                @error('api_send_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-3">
                                <label for="last_id">Last id</label>
                                <input type="text" name="last_id" id="last_id" class="form-control @error('last_id') is-invalid @enderror" value="{{ old('last_id',0) }}">
                                @error('last_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
                                    <option value="true">True</option>
                                    <option value="false">False</option>
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
                                    <option value="true">True</option>
                                    <option value="false">False</option>
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
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection