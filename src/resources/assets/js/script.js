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
		infinite: true,
		dots: false,
		slidesToShow: 4,
		slidesToScroll: 4,
		arrows: true,
		appendArrows: $('.partners-slider-arrows'),
	});

	//SLIDER PARTNERS
	$('.sales-slider').slick({
		infinite: true,
		dots: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		appendArrows: $('.sales-slider-arrows'),
	});

	//SCROLLTO
    $('a[href^="#"]').click(function() {
        var id = $(this).attr("href");
        var offset = $(id).offset().top - $('header').height();
        $('html, body').animate({scrollTop: offset}, 800);

        return false;
    });
});