$(document).ready(function() {

	//SLIDER NEWS
	$('.news-slider').slick({
		infinite: false,
		dots: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		appendDots: $('.news-slider-dots'),
	});

	//SLIDER PARTNERS
	$('.partners-slider').slick({
		autoplay: true,
		autoplaySpeed: 5000,
		infinite: true,
		dots: false,
		slidesToShow: 4,
		slidesToScroll: 4,
		arrows: true,
		appendArrows: $('.partners-slider-arrows'),
		responsive: [
			{
				breakpoint: 780,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

	//SLIDER SALES
	for (var i = 0; i <= 10; i++) {
		$('.sales-slider-' + i).on('init', function(event, slick, direction) {
			if (!$(this).closest('.container').hasClass('first'))
				$(this).closest('.container').hide();
		});

		$('.sales-slider-' + i).slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			appendArrows: $('.sales-slider-arrows-' + i),
		});
	}

	//SALES NAVIGATION
	$('.sales-navigation li').click(function() {
		$('.sales-navigation li').removeClass('active');
		$(this).addClass('active');

		$('.sales-slider').closest('.container').hide();
		$('.sales-slider-' + $(this).data('slider')).closest('.container').show();
		$('.sales-slider-' + $(this).data('slider')).slick('resize');
	});

	$('.home-template .sales-navigation').slick({
		autoplay: false,
		autoplaySpeed: 5000,
		infinite: false,
		dots: false,
		slidesToShow: 3,
		slidesToScroll: 3,
		centerMode: true,
		centerPadding: '0px',
		arrows: true,
		appendArrows: $('.sales-navigation-arrows'),
		initialSlide: current_sale_slide,
		responsive: [
			{
				breakpoint: 780,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

	//SCROLLTO
    $('a[href^="#"]').click(function() {
        var id = $(this).attr("href");
        var offset = $(id).offset().top - $('header').height();
        $('html, body').animate({scrollTop: offset}, 800);

        return false;
    });

	//LOGIN
	$('.account-icon').on('mouseenter', function() {
		$('.account .login').show();
	});

	$('.account .login').on('mouseleave', function(e) {
		setTimeout(function() {
			if (!$(e.target).is('input') && !$('.login:hover').length != 0) {
				$('.account .login').fadeOut();
			}
		}, 300);
	});

	//DELETE CONFIRMATION
	$('.delete').click(function(e) {
		if (!confirm('Etes-vous sûrs de vouloir supprimer cet élément ?')) {
			e.preventDefault();
			return false;
		}
		return true;
	});

	//MENU MOBILE
	$('.hamburger').click(function() {
		$('.logo-navigation nav').toggle();
	});

	$('.logo-navigation .close').click(function() {
		$('.logo-navigation nav').hide();
	});
});