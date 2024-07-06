<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'functions.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $format = $_POST['format'];
    $copies = $_POST['copies'];

    // Add video using the addVideo function
    $result = addVideo($title, $director, $release_year, $image, $price, $genre, $format, $copies);

    // Check result and set appropriate messages
    if ($result) {
        $success_message = 'Video added successfully.';
    } else {
        $error_message = 'Failed to add video. Please check your input.';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Video</title>
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

        .add-container {
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
            width: 80%;
            /* Adjust the width of the card */
            max-width: 800px;
            /* Max width to ensure it doesn't get too large */
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
                    <a class="nav-link" href="filter_movies.php">Filter Movies</a>
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

    <div class="add-container container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Add Video</h3>
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6">
                        <form action="add.php" method="post">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" name="director" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" name="release_year" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image URL</label>
                                <input type="text" name="image" class="form-control" required>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <select class="form-control" id="genre" name="genre" required>
                                <option value="drama">Drama</option>
                                <option value="action">Action</option>
                                <option value="fantasy">Fantasy</option>
                                <option value="horror">Horror</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="format">Format</label>
                            <select name="format" class="form-control" required>
                                <option value="DVD">DVD</option>
                                <option value="Blu-ray">Blu-ray</option>
                                <option value="Digital">Digital</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="copies">Number of Copies Available</label>
                            <input type="number" name="copies" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Video</button>
                        </form>
                    </div>
                </div>
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
