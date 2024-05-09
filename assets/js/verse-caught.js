document.addEventListener("DOMContentLoaded", function() {
    // Check if there is a verse key in the URL
    var urlParams = new URLSearchParams(window.location.search);
    var verseKey = urlParams.get("verseKey");
    
    if (verseKey) {
        // Scroll to the corresponding verse
        var verseElement = document.getElementById("verse" + verseKey);
        
        if (verseElement) {
            verseElement.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    }
});