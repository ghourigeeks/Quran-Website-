$(document).ready(function () {
    // Next Surah Button Click Event
    $('.next-surah').on('click', function () {
        var nextChapterId = parseInt($(this).data('chapter-id'));
        window.location.href = 'chapter-details.php?id=' + nextChapterId;
    });

    // Previous Surah Button Click Event
    $('.previous-surah').on('click', function () {
        var previousChapterId = parseInt($(this).data('chapter-id'));
        window.location.href = 'chapter-details.php?id=' + previousChapterId;
    });
});