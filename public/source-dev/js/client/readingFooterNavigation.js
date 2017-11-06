/**
 * Created by BiPham on 9/27/2017.
 */

$( document ).ready(function() {

});

function toggleLeftMenu() {
    $('.nav-left-menu').toggleClass('transform-left-custom-active');
    $('.icon-hide-left-menu').toggleClass('hidden');
    $('.icon-show-left-menu').toggleClass('hidden');
    $('.overlay').toggleClass('overlay-active');
}

$(".overlay").click(function() {
    $(this).toggleClass('overlay-active');
    $('.nav-left-menu').toggleClass('transform-left-custom-active');
    $('.icon-hide-left-menu').toggleClass('hidden');
    $('.icon-show-left-menu').toggleClass('hidden');
});