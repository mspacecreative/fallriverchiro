// FAQ accordion
$('.question').click(function(){
	$(this).next().slideToggle('fast');
	$(".answer").not($(this).next()).slideUp('fast');
	$(this).find('.fa').toggleClass('rotate');
	$('.question').not(this).each(function() {
	$(this).find('.fa').removeClass('rotate');
	});
});

$('.staff_carousel').slick({
  arrows: true,
  dots: true,
});