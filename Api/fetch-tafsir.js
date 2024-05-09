$(document).ready(function() {
    // Function to fetch Tafsir based on language and update the modal content
    function fetchTafsir(verseKey, modalIndex, chapterId, language) {
        // Generate a timestamp for cache busting
        var timestamp = new Date().getTime();

        var apiUrl = language === 'urdu' ?
            'https://api.quran.com/api/v3/chapters/' + chapterId + '/verses/' + verseKey + '/tafsirs/tafsir-bayan-ul-quran?_=' + timestamp :
            'https://api.quran.com/api/v3/chapters/' + chapterId + '/verses/' + verseKey + '/tafsirs/en-tafsir-maarif-ul-quran?_=' + timestamp;

        $.ajax({
            url: apiUrl,
            method: 'GET',
            success: function(response) {
                var tafsirData = response.tafsir;
                var modalTitle = 'Tafsirs for ' + tafsirData.verse_key;

                // Check if tafsir text is empty
                var modalContent = tafsirData.text.trim() !== '' ? tafsirData.text : 'Our latest Tafsir is a compilation of previous interpretations. If you ve already covered the prior Tafsirs, feel free to move forward.';

                $('#tafsirModal_' + modalIndex + ' .modal-title').html(modalTitle);
                $('#tafsirContent_' + modalIndex).html(modalContent);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching Tafsir:', status, error);
                // Handle error if needed
            }
        });
    }

    // Event listener for language selection dropdown
    $('.open-tafsir-modal').on('click', function() {
        var verseKey = $(this).data('verse-key');
        var modalIndex = $(this).data('target').split('_')[1];
        var chapterId = $(this).data('chapter-id');

        // Fetch Tafsir based on the selected language
        var languageSelect = $('#languageSelect_' + modalIndex);

        // Initial fetch on modal open
        fetchTafsir(verseKey, modalIndex, chapterId, languageSelect.val());

        // Event listener for language dropdown change
        languageSelect.on('change', function() {
            var selectedLanguage = $(this).val();
            fetchTafsir(verseKey, modalIndex, chapterId, selectedLanguage);
        });
    });
});
