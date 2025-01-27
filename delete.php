<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$video_id = $_GET['id'];
$video = getVideoById($video_id);

if (!$video) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $videos = getVideos();
    foreach ($videos as $key => $video) {
        if ($video['id'] === $video_id) {
            unset($videos[$key]);
            break;
        }
    }
    saveVideos($videos);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        .delete-container {
            margin-top: 20px;
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            width: 50%; /* Adjust the width to make the card smaller */
            max-width: 500px; /* Max width to ensure it doesn't get too large */
            margin-bottom: 40px;
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
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
    </style>
</head>
<body>
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

    <div class="delete-container container">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="card-title">Delete Video</h3>
                <p>Are you sure you want to delete the following video?</p>
                <h5><?php echo $video['title']; ?></h5>
                <p>Directed by: <?php echo $video['director']; ?></p>
                <p>Release Year: <?php echo $video['release_year']; ?></p>
                <form action="delete.php?id=<?php echo $video_id; ?>" method="post">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; 2024 Video Rental. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
