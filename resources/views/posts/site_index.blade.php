@php
use App\Helpers\Helper;
@endphp
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
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @foreach ($paginator as $post)

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="row no-gutters">
                    @php
                    $div_col='12';
                    @endphp
                    @if($thumbnail_display == 'true' &&
                    isset($post['_embedded']) &&
                    isset($post['_embedded']['wp:featuredmedia']) &&
                    isset($post['_embedded']['wp:featuredmedia'][0]) &&
                    isset($post['_embedded']['wp:featuredmedia'][0]['source_url']))
                    <div class="col-md-4">
                        <a href="{{ route('posts.show', ['site_id' => $site_id, 'id' => $post['id'], 'slug' => $post['slug']]) }}">
                            <img src="{{Helper::replaceImageUrls($post['_embedded']['wp:featuredmedia'][0]['source_url'],$site_id,$site_url)}}" class="img-thumbnail" style="width: 100%; height: auto;" alt="{{ $post['title']['rendered'] }}">
                        </a>
                    </div>
                    @php
                    $div_col='8';
                    @endphp
                    @endif
                    <div class="col-md-{{$div_col}}">
                        <div class="card-body">
                            <a href="{{ route('posts.show', ['site_id' => $site_id, 'id' => $post['id'], 'slug' => $post['slug']]) }}" style="text-decoration: none;">
                                <h6 style="color: black;" class="card-title">{!! $post['title']['rendered'] !!}</h6>
                                <!-- <p class="card-text">{!! Str::limit($post['excerpt']['rendered'], 150) !!}</p> -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <nav aria-label="Page navigation" class="mx-auto">
            <ul class="pagination">
                <!-- Previous Button -->
                @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug, 'page' => $paginator->currentPage() - 1]) }}" aria-label="Previous">Previous</a>
                </li>
                @endif

                <!-- First Page Link -->
                @if ($paginator->lastPage() > 1)
                <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug, 'page' => 1]) }}">1</a>
                </li>
                @if ($paginator->currentPage() > 4)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
                @endif
                @endif

                <!-- Numbered Page Links -->
                @php
                $start = max($paginator->currentPage() - 3, 2); // Ensure at least 1 page is visible before current page
                $end = min($paginator->currentPage() + 3, $paginator->lastPage() - 1); // Ensure at least 1 page is visible after current page
                @endphp

                @for ($page = $start; $page <= $end; $page++) <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug, 'page' => $page]) }}">{{ $page }}</a>
                    </li>
                    @endfor

                    <!-- Last Page Link -->
                    @if ($paginator->lastPage() > 1 && $paginator->currentPage() < $paginator->lastPage())
                        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug, 'page' => $paginator->lastPage()]) }}">{{ $paginator->lastPage() }}</a>
                            </li>
                            @endif

                            <!-- Next Button -->
                            @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug, 'page' => $paginator->currentPage() + 1]) }}" aria-label="Next">Next</a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                            @endif
            </ul>
        </nav>
    </div>
</div>
@endsection