@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
	<!-- Content -->
	<section class="bg0 p-b-110">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-8 p-b-30">
					<div class="p-r-10 p-r-0-sr991">
						<p class="f1-s-11 cl6 p-b-25">
							Curabitur volutpat bibendum molestie. Vestibulum ornare gravida semper. Aliquam a dui suscipit, fringilla metus id, maximus leo. Vivamus sapien arcu, mollis eu pharetra vitae, condimentum in orci. Integer eu sodales dolor. Maecenas elementum arcu eu convallis rhoncus. Donec tortor sapien, euismod a faucibus eget, porttitor quis libero.
						</p>

						<p class="f1-s-11 cl6 p-b-25">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet est vel orci luctus sollicitudin. Duis eleifend vestibulum justo, varius semper lacus condimentum dictum. Donec pulvinar a magna ut malesuada. In posuere felis diam, vel sodales metus accumsan in. Duis viverra dui eu pharetra pellentesque. Donec a eros leo. Quisque sed ligula vitae lorem efficitur faucibus. Praesent sit amet imperdiet ante. Nulla id tellus auctor, dictum libero a, malesuada nisi. Nulla in porta nibh, id vestibulum ipsum. Praesent dapibus tempus erat quis aliquet. Donec ac purus id sapien condimentum feugiat.
						</p>

						<p class="f1-s-11 cl6 p-b-25">
							Praesent vel mi bibendum, finibus leo ac, condimentum arcu. Pellentesque sem ex, tristique sit amet suscipit in, mattis imperdiet enim. Integer tempus justo nec velit fringilla, eget eleifend neque blandit. Sed tempor magna sed congue auctor. Mauris eu turpis eget tortor ultricies elementum. Phasellus vel placerat orci, a venenatis justo. Phasellus faucibus venenatis nisl vitae vestibulum. Praesent id nibh arcu. Vivamus sagittis accumsan felis, quis vulputate
						</p>
					</div>
				</div>

				<!-- Sidebar -->
				<div class="col-md-5 col-lg-4 p-b-30">
					<div class="p-l-10 p-rl-0-sr991 p-t-5">
						<!-- Popular Posts -->
						<div>
							<div class="how2 how2-cl4 flex-s-c">
								<h3 class="f1-m-2 cl3 tab01-title">
									Popular Post
								</h3>
							</div>

                            @foreach ( headlines( 3 )  as $titleTuple )
							<ul class="p-t-35">
								<li class="flex-wr-sb-s p-b-30">
									<a href="{{route( 'frontend.slug', $titleTuple->slug )}}" class="size-w-10 wrap-pic-w hov1 trans-03">
										<img src="{{ 'null' !== (string) $titleTuple->urlToImage ? $titleTuple->urlToImage : route( 'frontend.index' ) . '/images/popular-post-06.jpg' }}" alt="IMG" width="100px" height="75px">
									</a>

									<div class="size-w-11">
										<h6 class="p-b-4">
											<a href="{{route( 'frontend.slug', $titleTuple->slug )}}" class="f1-s-5 cl3 hov-cl10 trans-03">
												{{ $titleTuple->title }}
											</a>
										</h6>
									</div>
								</li>
                            </ul>
                            @endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
