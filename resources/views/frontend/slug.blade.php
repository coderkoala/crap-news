@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . $article['title'] )

@section('content')
<!-- Content -->
<section class="bg0 p-b-140 p-t-15">
<div id="container" data-session="{{session('key')}}" data-rate-url="{{route('frontend.user.rate')}}" data-slug={{$article['slug']}} class="container">
		<div class="row justify-content-center">
			<div class="col-md-10 col-lg-8 p-b-30">
				<div class="p-r-10 p-r-0-sr991">
					<!-- Blog Detail -->
					<div class="p-b-70">
						<a href="#" class="f1-s-10 cl2 hov-cl10 trans-03 text-uppercase">
							{{ ucfirst( $article['category'] ) }}
						</a>

						<h3 class="f1-l-3 cl2 p-b-16 p-t-33 respon2">
							{{ $article['title'] }}
						</h3>

						<div class="flex-wr-s-s p-b-40">
							<span class="f1-s-3 cl8 m-r-15">
								<a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
									by {{ $article['author'] }}
								</a>

								<span class="m-rl-3">-</span>

								<span>
									{{ $article['created_at'] }}
								</span>
							</span>

							<span class="f1-s-3 cl8 m-r-15">
								{{ $rating['pagehits'] }} Page Hit(s)
							</span>
						</div>

						<div class="wrap-pic-max-w p-b-30">
							<img src={{ 'null' === (string) $article['urlToImage'] ? route( 'frontend.index' ) . "/images/blog-list-01.jpg" : $article['urlToImage'] }} alt="IMG">
                        </div>

                        {!!
                            format_news_content( $article['content'] )
                        !!}

						<!-- Tag -->
						<div class="flex-s-s p-t-12 p-b-15">
							<span class="f1-s-12 cl5 m-r-8">
								Read More at:
							</span>

							<div class="flex-wr-s-s size-w-0">
								<a href="{{$article['url']}}" class="f1-s-12 cl8 hov-link1 m-r-15" target="_blank">
									{{ $article['canonical'] }}'s Page
								</a>
							</div>
                        </div>

                        {{-- <button><i class="fa fa-thumbs-up"></i></button> Likes
                        <button><i class="fa fa-thumbs-down"></i></button> Dislikes --}}

                        <div class="flex-s-s pb-20">
							<span class="f1-s-12 cl5 p-t-1 m-r-15">
								Rate:
							</span>

							<div class="flex-wr-s-s size-w-0">
                            <button id="like" class="rate pagi-item{{ 'like' === $current_user ? ' like' : '' }}" data-type="like"><i class="fa fa-thumbs-up"></i>&nbsp;<small id="likes">{{$rating['likes']}}</small></button>&nbsp;
                                <button id="dislike" class="rate pagi-item{{ 'dislike' === $current_user ? ' dislike' : '' }}" data-type="dislike"><i class="fa fa-thumbs-down"></i>&nbsp;<small id="dislikes">{{$rating['dislikes']}}</small></button>
							</div>
						</div>

						<!-- Share -->
						<div class="flex-s-s m-t-20">
							<span class="f1-s-12 cl5 p-t-1 m-r-15">
								Share:
							</span>

							<div class="flex-wr-s-s size-w-0">
								<a href="#" class="dis-block f1-s-13 cl0 bg-facebook borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
									<i class="fab fa-facebook-f m-r-7"></i>
									Facebook
								</a>

								<a href="#" class="dis-block f1-s-13 cl0 bg-twitter borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
									<i class="fab fa-twitter m-r-7"></i>
									Twitter
								</a>

								<a href="#" class="dis-block f1-s-13 cl0 bg-google borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
									<i class="fab fa-google-plus-g m-r-7"></i>
									Google+
								</a>

								<a href="#" class="dis-block f1-s-13 cl0 bg-pinterest borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
									<i class="fab fa-pinterest-p m-r-7"></i>
									Pinterest
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
