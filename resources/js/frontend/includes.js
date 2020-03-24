(function ($) {
    "use strict";


    try {
        $( document.body ).ready( function() {
            $('.select2').select2();
        });
    } catch( er ){}

    try {
        $( document.body ).ready( function() {

            $('.rate').on( 'click', function( e ) {
                e.stopPropagation();
                let csrf = $('meta[name="csrf-token"]').attr('content'),
                    $this = $(this),
                    type = $this.data('type');


                if ( '1' === $this.data('doing-ajax') ) {
                    return;
                }

                $('.rate').data('doing-ajax', '1');

                $.ajax({
                    type: "POST",
                    url: $('#container').data('rate-url'),
                    data: {
                        '_token' : csrf,
                        'slug'   : $('#container').data('slug'),
                        'type'   : type
                    },
                    success: function( message, status ) {

                        if ( 'redundant' !== message.data ) {
                            Swal.fire({
                                position: 'top-end',
                                toast: 'true',
                                icon: 'success',
                                title: 'Your reaction has been recorded.',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('.rate ').removeClass('like dislike');
                            $('#likes').text(message.data.likes);
                            $('#dislikes').text(message.data.dislikes);
                            $('#' + message.data.type ).addClass( message.data.type );
                            $('.rate').data('doing-ajax', '0');
                        } else {
                            var prompt = 'Something went wrong. Try refreshing your browswer.';

                            if ( 'redundant' === message.data ) {
                                prompt = 'You have already reacted to this news.';
                            }
                            Swal.fire({
                                position: 'top-end',
                                toast: 'true',
                                icon: 'error',
                                title: prompt,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('.rate').data('doing-ajax', '0');
                        }
                    },
                    error: function( data, status ) {
                        Swal.fire({
                            position: 'top-end',
                            toast: 'true',
                            icon: 'error',
                            title: 'You need to login before you can rate news.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.rate').data('doing-ajax', '0');
                    },
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
            });

            // Init Select2
            $('.select2').select2();
        });
    } catch( er ){}

    try {
        $( document.body ).ready( function() {
            $( '#loader' ).on( 'click', function( e ) {
                var $this = $( this ),
                    url = $this.data('uri');

                $this.toggle('slow');
                $.get( url, ( data, status ) => {
                    if ( 'success' === status ) {
                        var values = data.payload.results,
                            uri = $('#news').data('sluguri'),
                            loader = $('#loader'),
                            htmlBuilder = '';

                        $this.data('uri', data.payload.get_url );

                        if ( ! data.payload.get_url ) {

                            loader.before( '<p id="error" href="#" class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 trans-03" style="color: crimson;">No news with the filters found.</p>' );
                            loader.remove();
                            return;
                        } else {

                            values.forEach( element => {
                                htmlBuilder += '<div class="col-sm-6 p-r-25 p-r-15-sr991">';
                                htmlBuilder += '<div class="m-b-45">';
                                htmlBuilder += '<a href="' + uri + '/' + element.slug + '" class="wrap-pic-w hov1 trans-03">';
                                if( 'null' !== element.urlToImage && null != typeof element.urlToImage ) {
                                    htmlBuilder += '<img src="' + element.urlToImage + '" alt="IMG" height="200px"></img>';

                                } else{
                                    htmlBuilder += '<img src="/images/latest-06.jpg" alt="IMG" height="200px"></img>';
                                }

                                htmlBuilder += '</a><div class="p-t-16"><h5 class="p-b-5">';
                                htmlBuilder += '<a href="' + uri + '/' + element.slug + '" class="f1-m-3 cl2 hov-cl10 trans-03">';
                                htmlBuilder += element.title;
                                htmlBuilder += '</a></h5><span class="cl8"><a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">';
                                htmlBuilder += element.author;
                                htmlBuilder += '</a><span class="f1-s-3 m-rl-3">-</span><span class="f1-s-3">';
                                htmlBuilder += element.publishedAt;
                                htmlBuilder += '</span></span></div></div></div>';
                            });
                            $('.p-r-15-sr991').last().after( htmlBuilder );
                            $('#loader').toggle();
                            return;
                        }
                    } else {
                        loader.remove();
                        htmlBuilder = '<p id="error" href="#" class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 trans-03" style="color: crimson;">No news with the filters found.</p>';
                        $('.container').after( htmlBuilder );
                    }

                });
            });
        });
    } catch (e) {}
})(jQuery);
