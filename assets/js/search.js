var currentPage = 1;
var isSearchResultsVisible = false; // Track the visibility of search results

function toggleChaptersListVisibility() {
    var chaptersListContainer = document.getElementById('chapters-list-container');
    chaptersListContainer.style.display = isSearchResultsVisible ? 'none' : 'grid';
}

function deleteBookmark(index) {
    if (confirm("Are you sure you want to delete this bookmark?")) {
        window.location.href = "?delete=" + index;
    }
}

function validateAndSearch() {
    var searchInput = document.getElementById('search-input').value;

    // Check if the search input is not empty
    if (searchInput.trim() !== '') {
        // If not empty, proceed with the search
        searchSurah();
    } else {
        // If empty, display an alert or handle it as per your requirement
        alert('Please enter text before searching.');
    }
}

function searchSurah() {
    var loader = document.getElementById('loader');
    var searchBtn = document.getElementById('search-btn');

    loader.style.display = 'block';
    searchBtn.style.display = 'none';

    var searchQuery = document.getElementById('search-input').value.trim();

    if (searchQuery !== '') {
        var timestamp = new Date().getTime();
        var apiUrl = 'https://api.quran.com/api/v4/search?q=' + encodeURIComponent(searchQuery) + '&page=' + currentPage + '&timestamp=' + timestamp;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.search && data.search.results && data.search.results.length > 0) {
                    document.getElementById('results').innerHTML = '';

                    data.search.results.forEach(result => {
                        var resultItem = document.createElement('div');
                        resultItem.className = 'result-item';
                    
                        // Get the chapter number from the verse key
                        var chapterNumber = parseInt(result.verse_key.split(':')[0]);
                    
                        // Get the chapter name from the provided list
                        var chapterName = chapterNames[chapterNumber] || 'Unknown Chapter';
                    
                        // Display Surah name, verse information, and translation
                        var surahInfo = document.createElement('div');
                        surahInfo.className = 'verse-text';
                    
                        // Add chapter name and verse key
                        var chapterNameSpan = document.createElement('a');
                        chapterNameSpan.textContent = `${chapterName} ${result.verse_key}: `;
                        chapterNameSpan.href = `chapter-details.php?id=${chapterNumber}#verse${result.verse_key}`;
                        chapterNameSpan.addEventListener('click', function(event) {
                            // Prevent the default behavior of the link
                            event.preventDefault();
                            // Navigate to the chapter-details.php page using JavaScript
                            window.location.href = chapterNameSpan.href;
                        });
                        surahInfo.appendChild(chapterNameSpan);
                    
                        // Wrap each word in a span with hoverable-word class
                        var words = result.text.split(' ');
                        words.forEach(word => {
                            var wordSpan = document.createElement('span');
                            wordSpan.textContent = word + ' ';
                            wordSpan.className = 'hoverable-word';
                            surahInfo.appendChild(wordSpan);
                        });
                    
                        var translationText = document.createElement('div');
                        translationText.className = 'translation-text';
                    
                        // Check if translations array and text property exist before accessing
                        if (result.translations && result.translations[0] && result.translations[0].text) {
                            translationText.innerHTML = result.translations[0].text;
                        } else {
                            translationText.innerHTML = 'Translation not available';
                        }
                    
                        resultItem.appendChild(surahInfo);
                        resultItem.appendChild(translationText);
                    
                        document.getElementById('results').appendChild(resultItem);
                        loader.style.display = 'none';
                        searchBtn.style.display = 'block';
                    });

                    displayPagination(data.search.total_pages);

                    // Show the chapters list container when displaying search results
                    isSearchResultsVisible = true;
                } else {
                    var errorMessage = 'No results found for ' + searchQuery;
                    document.getElementById('results').innerHTML = errorMessage;

                    // Hide the chapters list container when no search results are found
                    isSearchResultsVisible = false;
                    loader.style.display = 'none';
                    searchBtn.style.display = 'block';
                    // Display the error message in an alert
                    alert(errorMessage);
                }

                // Toggle visibility of the chapters list based on search results
                toggleChaptersListVisibility();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById('results').innerHTML = 'An error occurred while fetching data.';
                loader.style.display = 'none';
                searchBtn.style.display = 'block';
            });
    } else {
        document.getElementById('results').innerHTML = 'Please enter a Surah name to search.';
    }
}

function displayPagination(totalPages) {
    var paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    for (var i = 1; i <= totalPages; i++) {
        var pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.className = 'page-link';
        pageLink.textContent = i;
        pageLink.onclick = function (page) {
            return function () {
                currentPage = page;
                searchSurah();
            };
        }(i);

        if (i === currentPage) {
            pageLink.classList.add('active');
        }

        paginationContainer.appendChild(pageLink);
    }
}

// Initial hide of the chapters list container
toggleChaptersListVisibility();
