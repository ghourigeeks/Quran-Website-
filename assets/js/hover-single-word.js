$(document).ready(function () {
    $('.hoverable-word').hover(function () {
        $(this).css('background-color', '#FFFFCC');
    }, function () {
        $(this).css('background-color', '');
    });
});

