@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Setting</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$setting->id}}" />
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="site_name">Site Name</label>
                                <input type="text" name="site_name" id="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $setting->site_name) }}">
                                @error('site_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="site_url">Site URL</label>
                                <input type="text" name="site_url" id="site_url" class="form-control @error('site_url') is-invalid @enderror" value="{{ old('site_url', $setting->site_url) }}">
                                @error('site_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="site_logo">Site Logo</label>
                                <input type="file" name="site_logo" id="site_logo" class="form-control-file @error('site_logo') is-invalid @enderror">
                                @error('site_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="site_type">Site Type</label>
                                <select name="site_type" id="site_type" class="form-control @error('site_type') is-invalid @enderror">
                                    <option value="single_site" {{ $setting->site_type == 'single_site' ? 'selected' : '' }}>Single Site</option>
                                    <option value="multi_site" {{ $setting->site_type == 'multi_site' ? 'selected' : '' }}>Multi Site</option>
                                </select>
                                @error('site_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="default_site_id">Default Site</label>
                                <select name="default_site_id" id="default_site_id" class="form-control @error('default_site_id') is-invalid @enderror">
                                    <?php foreach ($sites as $key => $site) { ?>
                                        <option value="{{$site->id}}" {{ $setting->default_site_id == $site->id ? 'selected' : '' }}>{{$site->name}}</option>
                                    <?php } ?>
                                </select>
                                @error('default_site_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" {{ $setting->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $setting->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="header_script">Header Script</label>
                            <textarea name="header_script" id="header_script" class="form-control @error('header_script') is-invalid @enderror" rows="4">{{ old('header_script', $setting->header_script) }}</textarea>
                            @error('header_script')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="footer_script">Footer Script</label>
                            <textarea name="footer_script" id="footer_script" class="form-control @error('footer_script') is-invalid @enderror" rows="4">{{ old('footer_script', $setting->footer_script) }}</textarea>
                            @error('footer_script')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="header_style">Header Style</label>
                            <textarea name="header_style" id="header_style" class="form-control @error('header_style') is-invalid @enderror" rows="4">{{ old('header_style', $setting->header_style) }}</textarea>
                            @error('header_style')
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