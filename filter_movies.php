<?php
session_start();
require 'functions.php';

$videos = getVideos();

// Initialize variables to store filter values
$title = '';
$genre = '';
$format = '';
$release_year = '';

// Process form submission if any filter is applied
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $format = $_POST['format'];
    $release_year = $_POST['release_year'];

    // Filter videos based on the criteria
    $filteredVideos = array_filter($videos, function($video) use ($title, $genre, $format, $release_year) {
        $titleMatch = empty($title) || stripos($video['title'], $title) !== false;
        $genreMatch = empty($genre) || $video['genre'] === $genre;
        $formatMatch = empty($format) || $video['format'] === $format;
        $releaseYearMatch = empty($release_year) || $video['release_year'] == $release_year;

        return $titleMatch && $genreMatch && $formatMatch && $releaseYearMatch;
    });

    // Update $videos to filtered videos
    $videos = array_values($filteredVideos); // Reindex array after filtering
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filtered Movies</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: auto;
            margin-top: 40px;
            background-color: rgba(0, 0, 0, 0.7); /* Adjust background color and opacity */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add box shadow for card effect */
            color: #fff;
        }
        .card {
            margin-bottom: 20px;
            color: black;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: #fff !important;
        }
        .nav-link {
            color: #fff !important;
        }
        .edit-container {
            margin-top: 20px;
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .footer {
            background-color: rgba(0, 0, 0, 1);
            color: #fff;
            padding: 20px 0;
            text-align: center; 
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php">Video Rental</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="filter_movies.php">Search Video</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=view">View Videos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add Video</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4 mb-4" style="text-align:center;">Search Your Favorite Movie!</h1>
        <!-- Filter Form -->
        <form method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select class="form-control" id="genre" name="genre">
                    <option value="">Select Genre</option>
                    <option value="action" <?php echo ($genre === 'action') ? 'selected' : ''; ?>>Action</option>
                    <option value="comedy" <?php echo ($genre === 'comedy') ? 'selected' : ''; ?>>Comedy</option>
                    <option value="fantasy" <?php echo ($genre === 'fantasy') ? 'selected' : ''; ?>>Fantasy</option>
                    <option value="drama" <?php echo ($genre === 'drama') ? 'selected' : ''; ?>>Drama</option>
                    <!-- Add more options for other genres -->
                </select>
            </div>
            <div class="form-group">
                <label for="format">Format:</label>
                <select class="form-control" id="format" name="format">
                    <option value="">Select Format</option>
                    <option value="DVD" <?php echo ($format === 'DVD') ? 'selected' : ''; ?>>DVD</option>
                    <option value="Blu-ray" <?php echo ($format === 'Blu-ray') ? 'selected' : ''; ?>>Blu-ray</option>
                    <option value="Digital" <?php echo ($format === 'Digital') ? 'selected' : ''; ?>>Digital</option>
                </select>
            </div>
            <div class="form-group">
                <label for="release_year">Release Year:</label>
                <input type="number" class="form-control" id="release_year" name="release_year" value="<?php echo htmlspecialchars($release_year); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filter Movies</button>
        </form>

        <!-- Display Filtered Movies if Filtered -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($videos)): ?>
            <div class="mt-4 row">
                <?php foreach ($videos as $video): ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($video['title']); ?></h5>
                                <p class="card-text">Director: <?php echo htmlspecialchars($video['director']); ?></p>
                                <a href="movie_details.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($videos)): ?>
            <p class="mt-4">No movies found based on the selected criteria.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="fcontainer">
            <p>&copy; 2024 Video Rental. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
