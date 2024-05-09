<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Add any additional meta tags or stylesheets as needed -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>

    <div class="container">
        <?php
        session_start();
        require 'Api/quran-chapter-details-fetcher.php';

        try {
            if (isset($_GET['id'])) {
                $chapterId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                if ($chapterId === false || $chapterId === null) {
                    throw new Exception("Invalid chapter ID specified.");
                }

                $apiUrl = "https://api.quran.com/api/v4";
                $quranChapterDetailsFetcher = new QuranChapterDetailsFetcher($apiUrl);
                

                $arabicVerses = $quranChapterDetailsFetcher->fetchArabicVerses($chapterId);
                $urduTranslationResponse = $quranChapterDetailsFetcher->fetchUrduTranslation($chapterId);
                $urduTranslation = $urduTranslationResponse['translations'] ?? [];
                $englishTranslationResponse = $quranChapterDetailsFetcher->fetchEnglishTranslation($chapterId);
                $englishTranslation = $englishTranslationResponse['translations'] ?? [];
                $romanUrduTranslationResponse = $quranChapterDetailsFetcher->fetchRomanUrduTranslation($chapterId);
                $romanUrduTranslation = $romanUrduTranslationResponse['translations'] ?? [];
                $audioFileResponse = $quranChapterDetailsFetcher->fetchChapterAudio($chapterId);
                $audioUrl = $audioFileResponse['audio_file']['audio_url'] ?? '';

                $count = count($arabicVerses['verses']);

                echo "<a href='javascript:void(0);' class='chapter-link play-urdu-audio' data-chapter-id='$chapterId'>Play Urdu Audio</a> <br>";
                echo "<a href='javascript:void(0);' class='chapter-link play-audio' data-audio-url='$audioUrl'>Play Audio</a> <br>";
                echo "<a href='chapter-info.php?id=$chapterId' class='chapter-link'>Info<br></a>";
                
                ?>

                <p>
                    <audio id="chapterAudio" controls>
                        <source src='' type='audio/mpeg'>
                        Your browser does not support the audio element.
                    </audio>
                </p>


                <?php

                function convertToArabicNumerals($number)
                {
                    $arabicNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                    return str_replace(range(0, 9), $arabicNumerals, $number);
                }

                $verseCounter = 1; // Initialize verse counter

                    for ($i = 0; $i < $count; $i++) {
                        $arabicVerse = $arabicVerses['verses'][$i];
                        $urduTranslationText = $urduTranslation[$i]['text'] ?? '';
                        $englishTranslationText = $englishTranslation[$i]['text'] ?? '';
                        $romanUrduTranslationText = $romanUrduTranslation[$i]['text'] ?? '';
                        $verseKey = $arabicVerse['verse_key']; // Add this line to get the verse key

                        $verseWords = explode(' ', $arabicVerse['text_uthmani']); // Define $verseWords here

                        echo "<strong>Verse Key:</strong> $verseKey<br>";
                        echo "<p id='verse$verseKey'>"; // Add an identifier to the Arabic verse element
                        echo "<strong>Arabic Translation:</strong> ";
                        foreach ($verseWords as $word) {
                            echo '<span class="hoverable-word" data-toggle="tooltip" data-placement="top">' . $word . '</span> ';
                        }
                        $arabicVerseCounter = convertToArabicNumerals($verseCounter);

                        echo " {$arabicVerseCounter}";

                        echo "<br>";
                        echo "<strong>English Translation:</strong> {$englishTranslationText}<br>";
                        echo "<strong>Roman Translation:</strong> {$urduTranslationText}<br>";
                        echo "<strong>Urdu Translation:</strong> {$romanUrduTranslationText}<br>";
                        echo "<button class='chapter-link open-tafsir-modal' data-toggle='modal' data-target='#tafsirModal_$i' data-verse-key='$verseKey' data-chapter-id='$chapterId'>Tafsirs</button>";
                        echo "<button class='chapter-link play-verse' data-verse-key='$verseKey' data-chapter-id='$chapterId'>Play Verse</button>";
                        $isBookmarked = false;
                        // Check if $_SESSION['bookmarks'] is set and is an array
                        if (isset($_SESSION['bookmarks']) && is_array($_SESSION['bookmarks'])) {
                            foreach ($_SESSION['bookmarks'] as $bookmark) {
                                if ($bookmark['verseKey'] == $verseKey && $bookmark['chapterId'] == $chapterId) {
                                    $isBookmarked = true;
                                    break;
                                }
                            }
                        } else {
                            // Handle the case when bookmarks are not set or not an array
                            $_SESSION['bookmarks'] = []; // Initialize bookmarks as an empty array
                        }

                        // Display the appropriate button based on the bookmark status
                        if (!$isBookmarked) {
                            echo "<button class='chapter-link bookmark-verse' data-verse-key='$verseKey' data-chapter-id='$chapterId'>Bookmark Verse</button>";
                        } else {
                            echo "<button class='chapter-link already-bookmarked' data-verse-key='$verseKey' data-chapter-id='$chapterId'>Already Bookmarked</button>";
                        }

                        echo "</p>";

                        $verseCounter++; // Increment verse counter
                    }
                ?>
                
                    <button class='chapter-link previous-surah' data-chapter-id='<?php echo $chapterId - 1; ?>'>Previous Surah</button>
                    <button class='chapter-link next-surah' data-chapter-id='<?php echo $chapterId + 1; ?>'>Next Surah</button>

                    <?php
                    echo "<script>";
                    echo "var chapterId = $chapterId;";
                    echo "var previousButton = document.querySelector('.previous-surah');";
                    echo "if (chapterId === 1) {";
                    echo "  previousButton.style.display = 'none';";
                    echo "} else {";
                    echo "  previousButton.style.display = 'block';"; // or 'inline' depending on your CSS
                    echo "}";
                    echo "</script>";
                    ?>

                <?php for ($i = 0; $i < $count; $i++) : ?>
                    <div class='modal fade' id='tafsirModal_<?php echo $i; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Tafsirs</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <div class='form-group'>
                                        <label for='languageSelect_<?php echo $i; ?>'>Select Language:</label>
                                        <select class='form-control' id='languageSelect_<?php echo $i; ?>'>
                                            <option value='english'>English</option>
                                            <option value='urdu'>Urdu</option>
                                        </select>
                                    </div>
                                    <div class='tafsir-content' id='tafsirContent_<?php echo $i; ?>'>
                                        <!-- Tafsir content goes here... -->
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>

            </div>

            <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
            <script src="Api/fetch-tafsir.js"></script>
            <script src="assets/js/urdu-audio.js"></script>
            <script src="assets/js/audio-play-pause.js"></script>
            <script src="assets/js/hover-single-word.js"></script>
            <script src="assets/js/bookmark.js"></script>
            <script src="assets/js/verse-caught.js"></script>
            <script src="assets/js/next-prev.js"></script>

            <script>$(function () {
            $('[data-toggle="tooltip"]').tooltip() })
            </script>



        <head>

        <script src="assets/js/quran-chapter-names.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var chapterId = <?php echo $chapterId; ?>; // Get the chapter ID from PHP

                var verseCount = <?php echo $count; ?>; // Get the count of verses from PHP

                if (chapterNames.hasOwnProperty(chapterId)) {
                    document.title = chapterNames[chapterId] + ' (' + verseCount + ')' + ' - ' + 'Quran.rf.gd';
                } else {
                    console.error('Chapter ID not found in chapterNames object:', chapterId);
                }
            });
        </script>

        </head>
            <?php
        } else {
            throw new Exception("No chapter ID specified.");
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>

</body>
</html>
