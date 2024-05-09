var hoverableWords = document.querySelectorAll('.hoverable-word');
    var audioElement = document.getElementById('chapterAudio');

    // Mapping of Arabic words to audio URLs
    var arabicWordAudioUrls114 = {
        "قُلْ": "https://audio.qurancdn.com/wbw/114_001_001.mp3",
        "أَعُوذُ": "https://audio.qurancdn.com/wbw/114_001_002.mp3",
        "بِرَبِّ": "https://audio.qurancdn.com/wbw/114_001_003.mp3",
        "ٱلنَّاسِ": "https://audio.qurancdn.com/wbw/114_001_004.mp3",
        "مَلِكِ": "https://audio.qurancdn.com/wbw/114_002_001.mp3",
        "ٱلنَّاسِ": "https://audio.qurancdn.com/wbw/114_001_004.mp3",
        "إِلَـٰهِ": "https://audio.qurancdn.com/wbw/114_003_001.mp3",
        "ٱلنَّاسِ": "https://audio.qurancdn.com/wbw/114_003_002.mp3",
        "مِن": "https://audio.qurancdn.com/wbw/114_004_001.mp3",
        "شَرِّ": "https://audio.qurancdn.com/wbw/114_004_002.mp3",
        "ٱلْوَسْوَاسِ": "https://audio.qurancdn.com/wbw/114_004_003.mp3",
        "ٱلْخَنَّاسِ": "https://audio.qurancdn.com/wbw/114_004_004.mp3",
        "ٱلَّذِى": "https://audio.qurancdn.com/wbw/114_005_001.mp3",
        "يُوَسْوِسُ": "https://audio.qurancdn.com/wbw/114_005_002.mp3",
        "فِى": "https://audio.qurancdn.com/wbw/114_005_003.mp3",
        "صُدُورِ": "https://audio.qurancdn.com/wbw/114_005_004.mp3",
        "ٱلنَّاسِ": "https://audio.qurancdn.com/wbw/114_005_005.mp3",
        "مِنَ": "https://audio.qurancdn.com/wbw/114_006_001.mp3",
        "ٱلْجِنَّةِ": "https://audio.qurancdn.com/wbw/114_006_002.mp3",
        "وَٱلنَّاسِ": "https://audio.qurancdn.com/wbw/114_006_003.mp3",
        // Add other words as needed
    };

    hoverableWords.forEach(function (word) {
        word.addEventListener('click', function () {
            var clickedWord = this.textContent.trim();

            // Look up audio URL based on the clicked Arabic word
            var audioUrl = arabicWordAudioUrls114[clickedWord];

            if (audioUrl) {
                // Set the audio source dynamically based on the constructed URL
                audioElement.src = audioUrl;

                // Play the audio
                audioElement.play();
            } else {
                // console.log(clickedWord);
            }
        });
    });