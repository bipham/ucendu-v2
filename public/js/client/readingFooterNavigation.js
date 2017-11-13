function toggleLeftMenu() {
    $('.nav-left-menu').toggleClass('transform-left-custom-active');
    $('.icon-hide-left-menu').toggleClass('hidden');
    $('.button-area').toggleClass('hidden');
    $('.feedback-area').toggleClass('hidden');
    $('.icon-show-left-menu').toggleClass('hidden');
    $('.overlay').toggleClass('overlay-active');
}

$(".overlay").click(function() {
    $(this).toggleClass('overlay-active');
    $('.nav-left-menu').toggleClass('transform-left-custom-active');
    $('.icon-hide-left-menu').toggleClass('hidden');
    $('.icon-show-left-menu').toggleClass('hidden');
    $('.button-area').toggleClass('hidden');
    $('.feedback-area').toggleClass('hidden');
});