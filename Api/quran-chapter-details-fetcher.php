<?php

class QuranChapterDetailsFetcher
{
    private $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function fetchArabicVerses($chapterId)
    {
        $url = $this->apiUrl . "/quran/verses/uthmani/?chapter_number=$chapterId";
        return $this->fetchApiData($url);
    }

    public function fetchEnglishTranslation($chapterId)
    {
        $url = $this->apiUrl . "/quran/translations/131?chapter_number=$chapterId";
        return $this->fetchApiData($url);
    }

    public function fetchUrduTranslation($chapterId)
    {
        $url = $this->apiUrl . "/quran/translations/831?chapter_number=$chapterId";
        return $this->fetchApiData($url);
    }

    public function fetchRomanUrduTranslation($chapterId)
    {

    $url = $this->apiUrl . "/quran/translations/158?chapter_number=$chapterId";
    return $this->fetchApiData($url);
    
    }  

    public function fetchChapterById($chapterId)
    {
        $url = $this->apiUrl . "/chapters/{$chapterId}?language=en";
        return $this->fetchApiData($url);
    }

    public function fetchAdditionalChapterInfo($chapterId)
    {
        $url = $this->apiUrl . "/chapters/{$chapterId}/info?language=en";
        return $this->fetchApiData($url);
    }

    public function fetchChapterAudio($chapterId)
    {
        $url = $this->apiUrl . "/chapter_recitations/7/{$chapterId}";
        return $this->fetchApiData($url);
    }

    public function fetchTafsir($chapterId, $verseKey, $tafsirSlug)
    {
        $url = $this->apiUrl . "/chapters/{$chapterId}/verses/{$verseKey}/tafsirs/{$tafsirSlug}";
        return $this->fetchApiData($url);
    }

    private function fetchApiData($url)
    {
        // Generate a timestamp for cache busting
        $timestamp = time();

        // Append the timestamp as a query parameter to the URL
        $url .= "?_=" . $timestamp;

        $response = @file_get_contents($url);

        if ($response === false) {
            throw new Exception("Error fetching data from the API. Check the API endpoint and try again.");
        }

        $data = json_decode($response, true);

        if ($this->isValidApiResponse($data)) {
            return $data;
        }

        throw new Exception("Error parsing data from the API. Data structure issue.");
    }

    private function isValidApiResponse($data)
    {
        return is_array($data);
    }
}

?>
