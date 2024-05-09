<?php

class QuranChaptersFetcher
{
    private $apiUrl;

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function fetchData(): array
    {
        try {
            // Generate a timestamp for cache busting
            $timestamp = time();

            // Append the timestamp as a query parameter to the API URL
            $url = $this->apiUrl . "&_=" . $timestamp;

            $response = @file_get_contents($url);

            if ($response === false) {
                throw new Exception("Error fetching Quran chapters. Unable to connect to API.");
            }

            $data = json_decode($response, true);

            if ($this->isValidApiResponse($data)) {
                return $data['chapters'];
            }

            throw new Exception("Error fetching Quran chapters. Invalid data structure.");
        } catch (Exception $e) {
            throw new Exception("Error fetching Quran chapters: " . $e->getMessage());
        }
    }

    private function isValidApiResponse($data): bool
    {
        return is_array($data) && isset($data['chapters']);
    }
}

// Initialize variables
$chapters = [];
$errorMessage = null;

try {
    // Fetch Quran chapters data
    $quranChaptersFetcher = new QuranChaptersFetcher('https://api.quran.com/api/v4/chapters?language=en');
    $chapters = $quranChaptersFetcher->fetchData();
} catch (Exception $e) {
    // Log the exception for debugging purposes
    error_log("Error: " . $e->getMessage());

    // Set an appropriate error message for the user
    $errorMessage = "An error occurred while fetching Quran chapters. Please try again later.";
}

?>
