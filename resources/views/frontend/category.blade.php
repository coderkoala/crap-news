@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('Category'))

@section('content')

<!-- Post -->
<section class="bg0 p-b-55 p-t-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-80">
                @if( ! empty( $results ) )
                <div id="news" data-slugUri="{{ route( 'frontend.slug', '' ) }}" class="row">
                    @foreach ( $results as $titleTuple)
                    <div class="col-sm-6 p-r-25 p-r-15-sr991">
                        <div class="m-b-45">
                            <a href="{{ route( 'frontend.slug', $titleTuple->slug ) }}" class="wrap-pic-w hov1 trans-03">
                                {{-- <img src="images/entertaiment-12.jpg" alt="IMG"> --}}
                                <img src="{{ 'null' !== (string) $titleTuple->urlToImage ? $titleTuple->urlToImage : '/images/latest-06.jpg'}}" alt="IMG" height="200px">
                            </a>

                            <div class="p-t-16">
                                <h5 class="p-b-5">
                                    <a href="{{ route( 'frontend.slug', $titleTuple->slug ) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                        {{ $titleTuple->title }}
                                    </a>
                                </h5>

                                <span class="cl8">
                                    <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                                        {{ $titleTuple->author }}
                                    </a>

                                    <span class="f1-s-3 m-rl-3">
                                        -
                                    </span>

                                    <span class="f1-s-3">
                                        {{ $titleTuple->publishedAt }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <button id="loader" class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 hov-btn1 trans-03" data-uri='{{$get_url}}'>
                    Load More
                </button>
                @else
                <p href="#" class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 trans-03" style="color: crimson;">No news with the filters found.</p>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
