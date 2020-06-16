<header>
	<!-- Header desktop -->
	<div class="container-menu-desktop">
		<div class="topbar">
			<div class="content-topbar container h-100">
				<div class="left-topbar">

					@auth
					<a href="{{route('frontend.user.dashboard')}}" class="left-topbar-item {{ active_class(Route::is('frontend.user.dashboard')) }}">
						@lang('navs.frontend.dashboard')
					</a>
					@endauth

					@guest
					<a href="{{route('frontend.auth.login')}}" class="left-topbar-item {{ active_class(Route::is('frontend.auth.login')) }}">@lang('navs.frontend.login')</a>

					@if(config('access.registration'))
						<a href="{{route('frontend.auth.register')}}" class="left-topbar-item {{ active_class(Route::is('frontend.auth.register')) }}">@lang('navs.frontend.register')</a>
					@endif
					@else
						<li class="nav-item dropdown">
							<a href="#" class="left-topbar-item dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">{{ $logged_in_user->name }}</a>

							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
								@can('view backend')
									<a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
								@endcan

								<a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Route::is('frontend.user.account')) }}">@lang('navs.frontend.user.account')</a>
								<a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>
							</div>
						</li>
					@endguest

					<a href="{{route('frontend.about')}}" class="left-topbar-item {{ active_class(Route::is('frontend.contact')) }}">
						About
					</a>

					<a href="{{route('frontend.contact')}}" class="left-topbar-item {{ active_class(Route::is('frontend.contact')) }}">
						@lang('navs.frontend.contact')
					</a>
				</div>

				<div class="right-topbar">
					<a href="#">
						<span class="fab fa-facebook-f"></span>
					</a>

					<a href="#">
						<span class="fab fa-twitter"></span>
					</a>

					<a href="#">
						<span class="fab fa-youtube"></span>
					</a>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
			<a href="{{Route('frontend.index')}}"><img src="{{Route('frontend.index')}}/images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze m-r--8">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li class="left-topbar">
					<a href="{{route('frontend.user.dashboard')}}" class="left-topbar-item {{ active_class(Route::is('frontend.user.dashboard')) }}">
						@lang('navs.frontend.dashboard')
					</a>

					@guest
					<a href="{{route('frontend.auth.login')}}" class="left-topbar-item {{ active_class(Route::is('frontend.auth.login')) }}">@lang('navs.frontend.login')</a>

					@if(config('access.registration'))
						<a href="{{route('frontend.auth.register')}}" class="left-topbar-item {{ active_class(Route::is('frontend.auth.register')) }}">@lang('navs.frontend.register')</a>
					@endif
					@else
						<li class="nav-item dropdown">
							<a href="#" class="left-topbar-item dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">{{ $logged_in_user->name }}</a>

							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
								@can('view backend')
									<a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
								@endcan

								<a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Route::is('frontend.user.account')) }}">@lang('navs.frontend.user.account')</a>
								<a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>
							</div>
						</li>
					@endguest

					<a href="{{route('frontend.about')}}" class="left-topbar-item {{ active_class(Route::is('frontend.contact')) }}">
						About
					</a>

					<a href="{{route('frontend.contact')}}" class="left-topbar-item {{ active_class(Route::is('frontend.contact')) }}">
						@lang('navs.frontend.contact')
					</a>
				</li>

				<li class="right-topbar">
					<a href="#">
						<span class="fab fa-facebook-f"></span>
					</a>

					<a href="#">
						<span class="fab fa-twitter"></span>
					</a>
				</li>
			</ul>
		</div>

		<!--  -->
		<div class="wrap-logo container">
			<!-- Logo desktop -->
			<div class="logo">
			<a href="{{Route('frontend.index')}}"><img src="{{Route('frontend.index')}}/images/icons/logo-01.png" alt="LOGO"></a>
			</div>
			<form action="{{ route('frontend.category') }}" method="get">
				<select class="select2" id="source" name="source" placeholder="Sources">
					<option value="">🔍 Sources</option>
					<?php
					$query           = DB::table( 'sources' )->select( 'name', 'canonical', 'country' )->get();
					$queryDB_sources = $query->toArray();
					$country_code    = array_intersect_key(
						all_countries(),
						array_flip( $query->pluck( 'country' )->toArray() )
					);
					?>
					@foreach( $queryDB_sources as $sources  )
					<option value="{{ $sources->name }}">{{ $sources->canonical }}</option>
					@endforeach
				</select>
				<select class="select2"  id="country" name="country" placeholder="Country">
					<option value="">🏳️ Countries</option>
					@foreach( $country_code as $key => $value  )
					<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
				<?php
					unset( $query, $queryDB_sources, $country_code );
				?>
				<button type="submit" class="pagi-item hov-btn1 trans-03 m-all-7 pagi-active">
					<i class="zmdi zmdi-search"></i>
				</button>
			</form>
		</div>
	</div>
</header>
