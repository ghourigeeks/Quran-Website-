var hoverableWords = document.querySelectorAll('.hoverable-word');
    var audioElement = document.getElementById('chapterAudio');

    // Mapping of Arabic words to audio URLs
    var arabicWordAudioUrls = {
        "بِسْمِ": "https://audio.qurancdn.com/wbw/001_001_001.mp3",
        "ٱللَّهِ": "https://audio.qurancdn.com/wbw/001_001_002.mp3",
        "ٱلرَّحْمَـٰنِ": "https://audio.qurancdn.com/wbw/001_001_003.mp3",
        "ٱلرَّحِيمِ": "https://audio.qurancdn.com/wbw/001_001_004.mp3",
        "ٱلْحَمْدُ": "https://audio.qurancdn.com/wbw/001_002_001.mp3",
        "لِلَّهِ": "https://audio.qurancdn.com/wbw/001_002_002.mp3",
        "رَبِّ": "https://audio.qurancdn.com/wbw/001_002_003.mp3",
        "ٱلْعَـٰلَمِينَ": "https://audio.qurancdn.com/wbw/001_002_004.mp3",
        "ٱلرَّحْمَـٰنِ": "https://audio.qurancdn.com/wbw/001_003_001.mp3",
        "ٱلرَّحِيمِ": "https://audio.qurancdn.com/wbw/001_003_002.mp3",
        "مَـٰلِكِ": "https://audio.qurancdn.com/wbw/001_004_001.mp3",
        "يَوْمِ": "https://audio.qurancdn.com/wbw/001_004_002.mp3",
        "ٱلدِّينِ": "https://audio.qurancdn.com/wbw/001_004_003.mp3",
        "إِيَّاكَ": "https://audio.qurancdn.com/wbw/001_005_001.mp3",
        "نَعْبُدُ": "https://audio.qurancdn.com/wbw/001_005_002.mp3",
        "وَإِيَّاكَ": "https://audio.qurancdn.com/wbw/001_005_003.mp3",
        "نَسْتَعِينُ": "https://audio.qurancdn.com/wbw/001_005_004.mp3",
        "ٱهْدِنَا": "https://audio.qurancdn.com/wbw/001_006_001.mp3",
        "ٱلصِّرَٰطَ": "https://audio.qurancdn.com/wbw/001_006_002.mp3",
        "ٱلْمُسْتَقِيمَ": "https://audio.qurancdn.com/wbw/001_006_003.mp3",
        "صِرَٰطَ": "https://audio.qurancdn.com/wbw/001_007_001.mp3",
        "ٱلَّذِينَ": "https://audio.qurancdn.com/wbw/001_007_002.mp3",
        "أَنْعَمْتَ": "https://audio.qurancdn.com/wbw/001_007_003.mp3",
        "عَلَيْهِمْ": "https://audio.qurancdn.com/wbw/001_007_004.mp3",
        "غَيْرِ": "https://audio.qurancdn.com/wbw/001_007_005.mp3",
        "ٱلْمَغْضُوبِ": "https://audio.qurancdn.com/wbw/001_007_006.mp3",
        "عَلَيْهِمْ": "https://audio.qurancdn.com/wbw/001_007_007.mp3",
        "وَلَا": "https://audio.qurancdn.com/wbw/001_007_008.mp3",
        "ٱلضَّآلِّينَ": "https://audio.qurancdn.com/wbw/001_007_009.mp3",
        // Add other words as needed
    };

    hoverableWords.forEach(function (word) {
        word.addEventListener('click', function () {
            var clickedWord = this.textContent.trim();

            // Look up audio URL based on the clicked Arabic word
            var audioUrl = arabicWordAudioUrls[clickedWord];

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