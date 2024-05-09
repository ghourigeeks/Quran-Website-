<?php

require 'quran-chapter-details-fetcher.php';

try {
    if (isset($_GET['id'])) {
        $chapterId = $_GET['id'];

        $apiUrl = "https://api.quran.com/api/v4";
        $quranChapterDetailsFetcher = new QuranChapterDetailsFetcher($apiUrl);

        // Fetch chapter information
        $chapterInfo = $quranChapterDetailsFetcher->fetchChapterById($chapterId);

        // Fetch additional chapter information with cache-busting
        $chapterInfoExtended = fetchAdditionalChapterInfo($chapterId);

        // Merge the additional information into the existing chapter info array
        $chapterInfo = array_merge($chapterInfo, $chapterInfoExtended);

        // Check if the request wants JSON response
        if (isset($_GET['format']) && strtolower($_GET['format']) === 'json') {
            sendJsonResponse(['chapter' => $chapterInfo]);
        }
    } else {
        // Return JSON response for error
        sendJsonResponse(['error' => 'No chapter ID specified.']);
    }
} catch (Exception $e) {
    // Return JSON response for error
    sendJsonResponse(['error' => $e->getMessage()]);
}

/**
 * Fetch additional chapter information from the API with cache-busting.
 *
 * @param int $chapterId The ID of the chapter.
 * @return array The additional chapter information.
 * @throws Exception If there is an issue fetching data from the API.
 */
function fetchAdditionalChapterInfo($chapterId)
{
    // Generate a timestamp for cache busting
    $timestamp = time();

    $apiUrl = "https://api.quran.com/api/v4/chapters/{$chapterId}/info?language=en&_={$timestamp}";
    return fetchApiData($apiUrl);
}

/**
 * Fetch data from the API.
 *
 * @param string $url The API endpoint URL.
 * @return array The decoded API response.
 * @throws Exception If there is an issue fetching data from the API or if the response is invalid.
 */
function fetchApiData($url)
{
    $response = @file_get_contents($url);

    if ($response === false) {
        throw new Exception("Error fetching data from the API. Unable to connect.");
    }

    $data = json_decode($response, true);

    if (!isValidApiResponse($data)) {
        throw new Exception("Error fetching data from the API. Invalid data structure.");
    }

    return $data;
}

/**
 * Check if the API response is valid.
 *
 * @param mixed $data The API response data.
 * @return bool Whether the response is valid.
 */
function isValidApiResponse($data)
{
    return is_array($data);
}

/**
 * Send JSON response with proper headers and exit the script.
 *
 * @param array $data The data to be encoded and sent as JSON.
 */
function sendJsonResponse($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
