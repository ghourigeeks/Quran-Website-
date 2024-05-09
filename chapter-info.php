<?php require 'Api/fetch-chapter-info.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>
        <?php
        if ($chapterInfo !== null && isset($chapterInfo['chapter']['id'])) {
            // Display chapter name and verse range in the title
            echo 'Surah ' . $chapterInfo['chapter']['name_simple'] . ' (' . $chapterInfo['chapter']['verses_count'] . ') - Quran.rf.gd';
        } else {
            echo 'Chapter Information';
        }
        ?>
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body style="background-color: #1f2125;">
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

    <div class="info-container">
      <div class="img-back">
      <a href="chapter-details.php?id=<?= $chapterInfo['chapter']['id'] ?? '' ?>">
        <div class="back">
          <svg
            class="back-icon"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="m9 19 1.41-1.41L5.83 13H22v-2H5.83l4.59-4.59L9 5l-7 7 7 7Z"
              fill="currentColor"
            ></path>
          </svg>
          <p class="back-txt">Go to Surah</p>
        </div>
        </a>
        <div class="img">
          <img
            src="assets/images/khane-kaba.jpeg"
            alt="Picure of Khane kaba"
          />
        </div>
      </div>
      <div class="info">
      <?php if ($chapterInfo !== null && isset($chapterInfo['chapter']['id'])) : ?>
        <div class="about-surah">
          <p class="surah-name-info">Surah <?= $chapterInfo['chapter']['name_simple'] ?? 'N/A' ?></p>
          <div class="ayats">
            <p class="ayat-txt">Ayahs</p>
            <p class="ayat-no"><?= $chapterInfo['chapter']['verses_count'] ?? 'N/A' ?></p>
          </div>
          <div class="revelation">
            <p class="place">Revelation Place</p>
            <p class="place-name"><?= ucfirst($chapterInfo['chapter']['revelation_place'] ?? 'N/A') ?></p>
          </div>
        </div>
        <hr class="line-breaker" />
        <div class="information-of-surah">
          <p class="desc-of-info">
          <?= $chapterInfo['chapter_info']['text'] ?? 'N/A' ?>
          </p>
        </div>
        <?php else : ?>
        <p>Error: No chapter information available.</p>
        <?php // Uncomment the line below for debugging purposes ?>
        <?php // print_r($chapterInfo); ?>
        <?php endif; ?>
      </div>
    </div>

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
