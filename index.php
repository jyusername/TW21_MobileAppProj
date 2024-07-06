<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';
$videos = getVideos();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Video Rental</title>
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


        .hero-section {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 70px 0;
            text-align: center;
            color: #fff;
        }

        .video-container {
            margin-top: 20px;
            flex: 1;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 40px;
            height: 450px;
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

        .btn-primary,
        .btn-danger,
        .btn-warning,
        .btn-success {
            margin-right: 10px;
        }

        .no-videos {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
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

    <div class="hero-section">
        <h1>Welcome to Video Rental</h1>
        <p>Your one-stop destination for renting your favorite movies</p>
    </div>

    <div class="video-container container">
        <?php if (!empty($videos)): ?>
            <div class="row justify-content-center">
                <?php foreach ($videos as $video): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?php echo $video['image']; ?>" class="card-img-top" alt="..."
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $video['title']; ?></h5>
                                <p class="card-text">Directed by: <?php echo $video['director']; ?></p>
                                <p class="card-text">Release Year: <?php echo $video['release_year']; ?></p>
                                <a href="movie_details.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-videos">
                <p>No videos available. Please add some videos.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; 2024 Video Rental. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></