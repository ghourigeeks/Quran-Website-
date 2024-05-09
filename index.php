<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Nobel Quran - Quran.rd.gd</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php

        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $deleteIndex = (int)$_GET['delete'];
            if (isset($_SESSION['bookmarks'][$deleteIndex])) {
                unset($_SESSION['bookmarks'][$deleteIndex]);
                // Optional: Reindex the array to ensure consecutive numeric keys
                $_SESSION['bookmarks'] = array_values($_SESSION['bookmarks']);

                // Redirect without the delete parameter
                header("Location: http://localhost/quran.rf.gd/");
                exit();
            }
        }

        try {
            // Sample API URL, replace it with your actual API endpoint
            $apiUrl = "https://api.quran.com/api/v4/chapters";

            // Append timestamp to the API URL to prevent caching
            $apiUrl .= '?timestamp=' . time();

            // Sample logic to fetch chapters from the API
            $chaptersResponse = file_get_contents($apiUrl);
            $chapters = json_decode($chaptersResponse, true);

            if ($chapters === null || !isset($chapters['data'])) {
                throw new Exception("Error fetching chapters from the API.");
            }

            $chapters = $chapters['data'];

            $errorMessage = null;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }

        require 'Api/fetch-all-quran-chapters.php';

        ?>

        <header id="header">
            <div class="ham-logo-container">
                <div class="logo">Logo</div>
            </div>
            <div class="search-icon-container">
                <i class="fab fa-facebook"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-twitter"></i>
                <i class="far fa-envelope"></i> 
            </div>
        </header>

        

        <main>
            <div id="chapters-list-container">
                <div class="quran-search-container">
                    <div class="quran-logo">
                        <img src="assets/images/logo.png" alt="Logo">
                    </div>
                    <div class="search-container">
                        <div class="search-input-container">
                            <div class="search-input">
                                <input id="search-input" type="text" placeholder="What do you want to read?">
                                <a href="#" id="search-btn" onclick="validateAndSearch()">
                                    <img src="assets/images/search2.png" alt="Search">
                                </a>
                                <div id="loader" class="loader"></div>
                            </div>
                        </div>
                    </div>
                    <div class="about">
                        <p class="learn-more">New! Learn more</p>
                        <h1 class="introduction">Introducing Quran Growth Journey</h1>
                        <p class="question">
                            Do you find it challenging to maintain consistency with your Quran
                            reading goals?
                        </p>
                        <p class="answer">
                            Quran Growth Journey is a dynamic feature developed to help you
                            remain consistent on your journey with the Quran. Whether you aim to
                            read 10 minutes a day, complete a Juz in a month, or finish the
                            entire Quran in a year, etc., Quran.com can now help you set a
                            custom goal and keep track of your daily reading streaks, while
                            adjusting as you make progress. It is completely free to use and we
                            hope it will help you stay motivated to reach your goal!
                        </p>
                        <p class="goal">Create Goal</p>
                    </div>
                </div>


                <div class="bookmark-container">
                    <?php if (!empty($_SESSION['bookmarks'])) : ?>
                    <div class="bookmark">
                        <div class="bookmark-txt">Bookmark</div>
                    </div>

                    <div class="bookmark1" style="overflow-x: auto;">
                    <?php foreach ($_SESSION['bookmarks'] as $key => $bookmark) : ?>
                        <div class="bookmarks">
                            <p>
                                <a href="chapter-details.php?id=<?= $bookmark['chapterId'] ?>#verse<?= $bookmark['verseKey'] ?>">
                                    <?= $chapters[$bookmark['chapterId'] - 1]['name_simple'] ?>
                                </a>
                                <a href="chapter-details.php?id=<?= $bookmark['chapterId'] ?>#verse<?= $bookmark['verseKey'] ?>">
                                    <?= $bookmark['verseKey'] ?>
                                </a>
                                <a href="#" class="delete-link" onclick="deleteBookmark(<?= $key ?>)">
                                    <img src="assets/images/cross.png" alt="Delete" class="delete-icon">
                                </a>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="bookmark">
                            <div class="bookmark-txt">Bookmark</div>
                        </div>
                        <p class="no-bookmark">You do not have any bookmarks yet.</p>
                    <?php endif; ?>

                    <?php if ($errorMessage): ?>
                        <p class="error-message"><?= $errorMessage ?></p>
                    <?php else: ?>
                        <div class="grid-container">
                            <?php foreach ($chapters as $chapter): ?>
                                <a href="chapter-details.php?id=<?= $chapter['id'] ?>">
                                    <div class="surah">
                                        <div class="surah-no-name">
                                            <div class="surah-number-container">
                                                <div class="surah-number"><?= $chapter['id'] ?></div>
                                            </div>
                                            <div class="surah-name-meaning">
                                                <div class="surah-name"><?= ucfirst($chapter['name_simple']) ?></div>
                                                <div class="name-meaning"><?= $chapter['translated_name']['name'] ?></div>
                                            </div>
                                        </div>
                                        <div class="surah-arabic-name-ayats">
                                            <div class="arabic-name"><?= $chapter['name_arabic'] ?></div>
                                            <div class="ayat"><?= $chapter['verses_count'] ?> Ayahs</div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div id="results"></div>
            <div id="pagination" class="pagination"></div>
        </main>

<script src="assets/js/quran-chapter-names.js"></script>
<script src="assets/js/search.js"></script>

<script>
      
      let lastScrollTop = 0;
      const header = document.getElementById('header');

      window.addEventListener('scroll', function() {
        const scrollTop = window.scrollY || window.pageYOffset;

        if (scrollTop > lastScrollTop) {
          header.style.top = `-${header.offsetHeight}px`;
        } else {
          header.style.top = '0';
        }

        lastScrollTop = scrollTop;
      });

    </script>
    
</body>
</html>