<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

$videos = getVideos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];
    $format = $_POST['format'];

    // Filter videos based on search criteria
    $filteredVideos = [];
    foreach ($videos as $video) {
        $match = true;

        if (!empty($title) && stripos($video['title'], $title) === false) {
            $match = false;
        }

        if (!empty($genre) && stripos($video['genre'], $genre) === false) {
            $match = false;
        }

        if (!empty($release_year) && $video['release_year'] != $release_year) {
            $match = false;
        }

        if (!empty($format) && $video['format'] != $format) {
            $match = false;
        }

        if ($match) {
            $filteredVideos[] = $video;
        }
    }

    // Display filtered results
    $videos = $filteredVideos;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Videos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <!-- Your search form -->
    <div class="container mt-4">
        <h2>Search Videos</h2>
        <form method="POST" action="search.php">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Enter genre">
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="number" class="form-control" id="release_year" name="release_year" placeholder="Enter release year">
            </div>
            <div class="form-group">
                <label for="format">Format/Category</label>
                <select class="form-control" id="format" name="format">
                    <option value="">Select format</option>
                    <option value="DVD">DVD</option>
                    <option value="Blu-ray">Blu-ray</option>
                    <option value="Digital">Digital</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Display search results -->
    <div class="container mt-4">
        <h2>Search Results</h2>
        <div class="row">
            <?php foreach ($videos as $video): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?php echo $video['image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $video['title']; ?></h5>
                            <p class="card-text">Directed by: <?php echo $video['director']; ?></p>
                            <p class="card-text">Release Year: <?php echo $video['release_year']; ?></p>
                            <p class="card-text">Genre: <?php echo $video['genre']; ?></p>
                            <p class="card-text">Format: <?php echo $video['format']; ?></p>
                            <p class="card-text">Price: ₱<?php echo $video['price']; ?></p>
                            <a href="view_single.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">View</a>
                            <!-- Add more actions as needed (edit, delete, rent) -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
