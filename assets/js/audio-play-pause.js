document.addEventListener('DOMContentLoaded', function () {
    var playAudioLinks = document.querySelectorAll('.play-audio');
    var audioElement = document.getElementById('chapterAudio');

    playAudioLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            var audioUrl = this.getAttribute('data-audio-url');
            audioElement.src = audioUrl;

            // Show loading animation.
            var playPromise = audioElement.play();

            if (playPromise !== undefined) {
                playPromise.then(_ => {
                    // Automatic playback started!
                    // Show playing UI.
                })
                .catch(error => {
                    // Auto-play was prevented
                    // Show paused UI or take necessary actions.
                });
            }
        });
    });

    var playVerseButtons = document.querySelectorAll('.play-verse');
    playVerseButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var chapterId = this.getAttribute('data-chapter-id');
            var verseKey = this.getAttribute('data-verse-key');
            var formattedChapterId = ('00' + chapterId).slice(-3);
            var verseNumber = verseKey.split(':')[1];
            var formattedVerseNumber = ('00' + verseNumber).slice(-3);
            var audioUrl;

            if (chapterId >= 100) {
                audioUrl = `https://everyayah.com/data/Alafasy_128kbps/${chapterId}${formattedVerseNumber}.mp3`;
            } else if (chapterId >= 10) {
                audioUrl = `https://everyayah.com/data/Alafasy_128kbps/${formattedChapterId}${formattedVerseNumber}.mp3`;
            } else {
                audioUrl = `https://everyayah.com/data/Alafasy_128kbps/${formattedChapterId}${formattedVerseNumber}.mp3`;
            }

            audioElement.src = audioUrl;

            // Show loading animation.
            var playPromise = audioElement.play();

            if (playPromise !== undefined) {
                playPromise.then(_ => {
                    // Automatic playback started!
                    // Show playing UI.
                })
                .catch(error => {
                    // Auto-play was prevented
                    // Show paused UI or take necessary actions.
                });
            }
        });
    });
});
