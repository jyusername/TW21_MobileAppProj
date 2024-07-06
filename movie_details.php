<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$movie_id = $_GET['id'];
$movie = getVideoById($movie_id);

if (!$movie) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Details</title>
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
        .movie-container {
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
        }
        .btn-primary, .btn-danger, .btn-warning, .btn-success {
            margin-right: 10px;
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

    <div class="movie-container container">
        <div class="card">
            <img src="<?php echo $movie['image']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $movie['title']; ?></h5>
                <p class="card-text">Directed by: <?php echo $movie['director']; ?></p>
                <p class="card-text">Release Year: <?php echo $movie['release_year']; ?></p>
                <p class="card-text">Price: ₱<?php echo $movie['price']; ?></p>
                <p class="card-text">Genre: <?php echo $movie['genre']; ?></p>
                <p class="card-text">Format: <?php echo $movie['format']; ?></p><!-- Added format -->
                <a href="edit.php?id=<?php echo $movie['id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo $movie['id']; ?>" class="btn btn-danger">Delete</a>
                <a href="view_single.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary">View</a>
                <a href="rent.php?id=<?php echo $movie['id']; ?>" class="btn btn-success">Rent</a>
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
