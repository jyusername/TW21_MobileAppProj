<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

// Check if user is logged in as a customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$videos = getVideos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
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

        .container {
            margin-top: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 900px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 0;
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
                    <a class="nav-link" href="profile_customer.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php foreach ($videos as $video): ?>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $video['title']; ?></h3>
                    <p><strong>Director:</strong> <?php echo $video['director']; ?></p>
                    <p><strong>Release Year:</strong> <?php echo $video['release_year']; ?></p>
                    <p><strong>Genre:</strong> <?php echo $video['genre']; ?></p>
                    <p><strong>Format:</strong> <?php echo $video['format']; ?></p>
                    <p><strong>Price:</strong> <?php echo $video['price']; ?></p>
                    <p><strong>Copies Available:</strong> <?php echo $video['copies']; ?></p>
                    <?php if (!$video['rented']): ?>
                        <form action="rent.php" method="post">
                            <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
                            <button type="submit" class="btn btn-primary">Rent</button>
                        </form>
                    <?php else: ?>
                        <p><em>This video is currently rented out.</em></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
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
