@section('title')
<title>{{ $post['title']['rendered'] }}</title>
@endsection
@section('description')
<meta name="description" content="{{ $post['title']['rendered'] }}">
@endsection
@section('schema')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "{{ $post['title']['rendered'] }}",
        "description": "{{ $post['title']['rendered'] }}"
    }
</script>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{!! $post['title']['rendered'] !!}</h1>
    <div>
        {!! $post['content']['rendered'] !!}
    </div>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Home</a>
</div>
@endsection