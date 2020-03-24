@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
	<!-- Headline -->
	<div class="container">
		<div class="bg0 flex-wr-sb-c p-rl-20 p-tb-8">
			<div class="f2-s-1 p-r-30 size-w-0 m-tb-6 flex-wr-s-c">
				<span class="text-uppercase cl2 p-r-8">
					Trending Now:
				</span>
				<span class="dis-inline-block cl6 slide100-txt pos-relative size-w-0" data-in="fadeInDown" data-out="fadeOutDown">
					@foreach ( $headlines = headlines()  as $titleTuple )
						<span class="dis-inline-block slide100-txt-item animated visible-false">
							<a href="{{ route( 'frontend.slug', $titleTuple->slug ) }}" target="_blank">{{ $titleTuple->title }}</a>
						</span>
					@endforeach
				</span>
			</div>
		</div>
	</div>

    <!-- Feature post -->
    @if( isset( $headlines[0], $headlines[1], $headlines[2], $headlines[3] ) )
	<section class="bg0">
		<div class="container">
			<div class="row m-rl--1">
				<div class="col-md-6 p-rl-1 p-b-2">
					<div class="bg-img1 size-a-3 how1 pos-relative" style="background-image: url({{ 'null' !== (string) $headlines[0]->urlToImage ? $headlines[0]->urlToImage : 'images/post-01.jpg'}});">
                    <a href="{{ route( 'frontend.slug', $headlines[0]->slug ) }}" class="dis-block how1-child1 trans-03"></a>

						<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
							<h3 class="how1-child2 m-t-14 m-b-10">
								<a href="{{ route( 'frontend.slug', $headlines[0]->slug ) }}" class="how-txt1 size-a-6 f1-l-1 cl0 hov-cl10 trans-03">
									{{ $headlines[0]->title }}
								</a>
							</h3>
						</div>
					</div>
                </div>

				<div class="col-md-6 p-rl-1">
					<div class="row m-rl--1">
						<div class="col-12 p-rl-1 p-b-2">
							<div class="bg-img1 size-a-4 how1 pos-relative" style="background-image: url({{ 'null' !== (string) $headlines[1]->urlToImage ? $headlines[1]->urlToImage : 'images/post-02.jpg'}});">
								<a href="{{ route( 'frontend.slug', $headlines[1]->slug ) }}" class="dis-block how1-child1 trans-03"></a>

								<div class="flex-col-e-s s-full p-rl-25 p-tb-24">

									<h3 class="how1-child2 m-t-14">
										<a href="{{ route( 'frontend.slug', $headlines[1]->slug ) }}" class="how-txt1 size-a-7 f1-l-2 cl0 hov-cl10 trans-03">
											{{ $headlines[1]->title }}
										</a>
									</h3>
								</div>
							</div>
						</div>

						<div class="col-sm-6 p-rl-1 p-b-2">
							<div class="bg-img1 size-a-5 how1 pos-relative" style="background-image: url({{ 'null' !== (string) $headlines[2]->urlToImage ? $headlines[2]->urlToImage : 'images/post-03.jpg'}});">
								<a href="{{ route( 'frontend.slug', $headlines[2]->slug ) }}" class="dis-block how1-child1 trans-03"></a>

								<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
									<h3 class="how1-child2 m-t-14">
										<a href="{{ route( 'frontend.slug', $headlines[2]->slug ) }}" class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
											{{ $headlines[2]->title }}
										</a>
									</h3>
								</div>
							</div>
						</div>

						<div class="col-sm-6 p-rl-1 p-b-2">
							<div class="bg-img1 size-a-5 how1 pos-relative" style="background-image: url({{ 'null' !== (string) $headlines[3]->urlToImage ? $headlines[3]->urlToImage : 'images/post-04.jpg'}});">
								<a href="{{ route( 'frontend.slug', $headlines[3]->slug ) }}" class="dis-block how1-child1 trans-03"></a>

								<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
									<h3 class="how1-child2 m-t-14">
										<a href="{{ route( 'frontend.slug', $headlines[3]->slug ) }}" class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
											{{ $headlines[3]->title }}
										</a>
									</h3>
								</div>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</div>
	</section>
    @endif

	<span class="p-t-20 p-b-20"></span>

    <!-- Post -->
    <div class="class">
	@foreach( $news as $key => $value )
	@if( 0 < count( $value ) )
        <section class="bg0 p-t-20 p-b-10">
            <div>
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-12 p-b-20">
                        <div class="how2 how2-cl4 flex-s-c m-r-10 m-r-0-sr991">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                {{ strtoupper($key) }}
                            </h3>
                        </div>
                        <div class="container p-r-30 p-l-30">
                            <div class="row p-t-20">
                                @foreach( $value as $newsTuple )
                                <div class="col-sm-6 p-r-25 p-r-15-sr991">
                                    <div class="m-b-45">
                                        <a href="{{route('frontend.slug',  $newsTuple['slug'] )}}" class="wrap-pic-w hov1 trans-03">
                                            <img src="{{ 'null' !== (string) $newsTuple['urlToImage'] ? $newsTuple['urlToImage'] : 'images/latest-06.jpg'}}" alt="IMG" width="720px" height="350px">
                                        </a>

                                        <div class="p-t-16">
                                            <h5 class="p-b-5">
                                                <a href="{{route('frontend.slug', $newsTuple['slug'] )}}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                                    {{ $newsTuple['title'] }}
                                                </a>
                                            </h5>

                                            <span class="cl8">
                                                <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                                                    by {{ $newsTuple['author'] }}
                                                </a>

                                                <span class="f1-s-3 m-rl-3">
                                                    -
                                                </span>

                                                <span class="f1-s-3">
                                                    {{ $newsTuple['created_at'] }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	@endif
	<span class="p-b-40"></span>
    @endforeach
    </div>
@endsection
