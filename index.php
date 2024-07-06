<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

$videos = getVideos();

// Function to filter videos by search criteria
function filterVideos($videos, $searchTerm, $genre, $releaseYear) {
    $filteredVideos = [];

    foreach ($videos as $video) {
        $titleMatch = stripos($video['title'], $searchTerm) !== false || empty($searchTerm);
        $genreMatch = $video['genre'] == $genre || $genre == 'All';
        $yearMatch = $video['release_year'] == $releaseYear || $releaseYear == 'All';

        if ($titleMatch && $genreMatch && $yearMatch) {
            $filteredVideos[] = $video;
        }
    }

    return $filteredVideos;
}

$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : '';
$genreFilter = isset($_GET['genre']) ? $_GET['genre'] : 'All';
$releaseYearFilter = isset($_GET['release_year']) ? $_GET['release_year'] : 'All';

// Apply filters
$filteredVideos = filterVideos($videos, $searchTerm, $genreFilter, $releaseYearFilter);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Rental</title>
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
        .search-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .search-card {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            width: 48%; /* Adjust the width for two columns */
            max-width: 400px; /* Max width to ensure it doesn't get too large */
            margin-bottom: 20px;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            width: 48%; /* Adjust the width for two columns */
            max-width: 400px; /* Max width to ensure it doesn't get too large */
            margin-bottom: 20px;
        }
        .footer {
            background-color: rgba(0, 0, 0, 1);
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php">Video Rental</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
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

    <div class="search-container">
        <div class="search-card">
            <h3 class="card-title">Search Videos</h3>
            <form method="GET" action="index.php">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by Title" value="<?php echo $searchTerm; ?>">
                </div>
                <div class="form-group">
                    <select name="genre" class="form-control">
                        <option value="All" <?php if ($genreFilter == 'All') echo 'selected'; ?>>All Genres</option>
                        <option value="Action" <?php if ($genreFilter == 'Action') echo 'selected'; ?>>Action</option>
                        <option value="Comedy" <?php if ($genreFilter == 'Comedy') echo 'selected'; ?>>Comedy</option>
                        <option value="Drama" <?php if ($genreFilter == 'Drama') echo 'selected'; ?>>Drama</option>
                        <!-- Add more genres as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <select name="release_year" class="form-control">
                        <option value="All" <?php if ($releaseYearFilter == 'All') echo 'selected'; ?>>All Release Years</option>
                        <option value="2024" <?php if ($releaseYearFilter == '2024') echo 'selected'; ?>>2024</option>
                        <option value="2023" <?php if ($releaseYearFilter == '2023') echo 'selected'; ?>>2023</option>
                        <!-- Add more release years as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="search-card">
            <h3 class="card-title">Browse Videos</h3>
            <div class="list-group">
                <a href="index.php?format=DVD" class="list-group-item list-group-item-action <?php if ($genreFilter == 'DVD') echo 'active'; ?>">DVD</a>
                <a href="index.php?format=Blu-ray" class="list-group-item list-group-item-action <?php if ($genreFilter == 'Blu-ray') echo 'active'; ?>">Blu-ray</a>
                <a href="index.php?format=Digital" class="list-group-item list-group-item-action <?php if ($genreFilter == 'Digital') echo 'active'; ?>">Digital</a>
            </div>
        </div>
    </div>

    <div class="search-results">
        <?php if (!empty($filteredVideos)): ?>
            <?php foreach ($filteredVideos as $video): ?>
                <div class="card">
                    <img src="<?php echo $video['image']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $video['title']; ?></h5>
                        <p class="card-text">Directed by: <?php echo $video['director']; ?></p>
                        <p class="card-text">Release Year: <?php echo $video['release_year']; ?></p>
                        <p class="card-text">Genre: <?php echo $video['genre']; ?></p>
                        <p class="card-text">Format: <?php echo $video['format']; ?></p>
                        <p class="card-text">Price: ₱<?php echo $video['price']; ?></p>
                        <a href="movie_details.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <p>No videos found.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Video Rental. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
