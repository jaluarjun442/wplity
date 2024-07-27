@section('title')
<title>Home - {{ config('app.name', 'Home') }}</title>
@endsection
@section('description')
<meta name="description" content="{{ config('app.name', 'Home') }}">
@endsection
@section('schema')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "{{ config('app.name', 'Home') }}",
        "description": "{{ config('app.name', 'Home') }}"
    }
</script>
@endsection
@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <h1>Sites</h1> -->
    <div class="row">
        @foreach ($sites as $site)
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{!! $site['name'] !!}</h5>
                    <a href="{{ route('posts.site_index', ['site_id' => $site['id'],'site_slug' => Str::slug($site['name'])]) }}" class="btn btn-primary">View All</a>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection