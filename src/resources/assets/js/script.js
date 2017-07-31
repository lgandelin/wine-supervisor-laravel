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
	});

	//SLIDER SALES
	for (var i = 1; i <= 10; i++) {
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

	//SUPPRESSION CONFIRMATION
	$('.delete').click(function(e) {
		if (!confirm('Etes-vous sûrs de vouloir supprimer cet élément ?')) {
			e.preventDefault();
			return false;
		}
		return true;
	});

	//ID WS FIELDS
	$('input.id_ws').keyup(function(){
		if($(this).val().length==$(this).attr("maxlength")){
			$(this).next().next().focus();
		}
	});
});