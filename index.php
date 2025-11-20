<?php
// load config.php
include("config/config.php");

// API key
$api_key = "15e4d9d307424160ace92aec43c2fd95";

// URL API
$url = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=" . $api_key;

// Simulasi API gagal jika parameter ?source=error
if (isset($_GET['source']) && $_GET['source'] == 'error') {
    $data = null;
} else {
    $data = http_request_get($url);
}

// konversi data JSON
$hasil = json_decode($data, true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>REST Client dengan cURL</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        body.dark-mode {
            background-color: #121212;
            color: #eaeaea;
        }

        .dark-mode .card {
            background-color: #1e1e1e;
            color: #eaeaea;
            border: 1px solid #333;
        }

        .dark-mode .navbar {
            background-color: #222 !important;
        }

        .dark-mode a.nav-link, 
        .dark-mode .navbar-brand {
            color: #f1f1f1 !important;
        }

        .mode-toggle {
            cursor: pointer;
            border: none;
            background: none;
            color: white;
            font-size: 16px;
            margin-left: 10px;
        }

        .mode-toggle i {
            margin-right: 5px;
        }

        /* Pesan error */
        .error-message {
            color: red;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }

        .dark-mode .error-message {
            color: #ff6666; /* tetap terlihat di dark mode */
        }
    </style>
</head>
<body>
<!-- navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" 
          data-target="#navbarNav" aria-controls="navbarNav" 
          aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="#">News</a></li>
      <li class="nav-item"><a class="nav-link" href="#">About</a></li>
    </ul>
    <button id="modeToggle" class="mode-toggle">
      🌙 Dark Mode
    </button>
  </div>
</nav>
<!-- navbar -->

<div class="container" style="margin-top: 75px;">
    <div class="row">
        <?php 
        if (!isset($hasil['articles']) || empty($hasil['articles'])) {
            // TC03: Pesan error
            echo '<div class="error-message">Gagal memuat berita. Silakan coba lagi.</div>';
        } else {
            // TC01: Tampilkan daftar berita
            foreach ($hasil['articles'] as $row) { ?>
                <div class="col-md-4" style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="card" style="width: 100%;">
                        <?php if(!empty($row['urlToImage'])){ ?>
                        <img src="<?php echo $row['urlToImage']; ?>" class="card-img-top" height="180px">
                        <?php } ?>
                        <div class="card-body">
                            <p class="card-text"><strong><?php echo $row['title']; ?></strong></p>
                            <p class="card-text"><i>Oleh <?php echo $row['author']; ?></i></p>
                            <p class="text-right">
                              <!-- TC02: Link detail berita -->
                              <a href="<?php echo $row['url']; ?>" target="_blank">Selengkapnya..</a>
                            </p>
                        </div>
                    </div>
                </div>
        <?php } } ?>
    </div>
</div>

<!-- JS Bootstrap -->
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Script Dark/Light Mode -->
<script>
    const body = document.body;
    const modeToggle = document.getElementById('modeToggle');

    // Cek mode tersimpan di localStorage
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        modeToggle.textContent = '☀ Light Mode';
    }

    modeToggle.addEventListener('click', function () {
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            modeToggle.textContent = '☀ Light Mode';
        } else {
            localStorage.setItem('theme', 'light');
            modeToggle.textContent = '🌙 Dark Mode';
        }
    });
</script>
</body>
</html>
