
$(document).ready(function () {
    // Handle bookmarking
    $('.bookmark-verse').on('click', function () {
        var verseKey = $(this).data('verse-key');
        var chapterId = $(this).data('chapter-id');

        // Make an AJAX request to store the bookmarked verse in the session
        $.ajax({
            type: 'POST',
            url: 'Api/bookmark-verse.php', // Create a new PHP file to handle bookmarking
            data: { verseKey: verseKey, chapterId: chapterId },
            success: function (response) {
                alert('Verse bookmarked successfully!');
            },
            error: function (error) {
                console.error('Error bookmarking verse:', error);
            }
        });
    });
});