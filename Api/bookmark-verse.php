<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get verse key and chapter ID from the POST data
    $verseKey = $_POST['verseKey'];
    $chapterId = $_POST['chapterId'];

    // Initialize the bookmarks array in the session if not already set
    if (!isset($_SESSION['bookmarks'])) {
        $_SESSION['bookmarks'] = [];
    }

    // Check if the verse is already bookmarked
    $isBookmarked = false;
    foreach ($_SESSION['bookmarks'] as $bookmark) {
        if ($bookmark['verseKey'] == $verseKey && $bookmark['chapterId'] == $chapterId) {
            $isBookmarked = true;
            break;
        }
    }

    // If not bookmarked, then add it to the session
    if (!$isBookmarked) {
        $_SESSION['bookmarks'][] = ['verseKey' => $verseKey, 'chapterId' => $chapterId];

        // Respond with a success message
        echo json_encode(['success' => true]);
    } else {
        // Respond with a message indicating that the verse is already bookmarked
        echo json_encode(['error' => 'Verse already bookmarked']);
    }
} else {
    // Respond with an error message for unsupported request method
    echo json_encode(['error' => 'Invalid request method']);
}


?>