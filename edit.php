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

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $format = $_POST['format']; // Added format

    editVideo($video_id, $title, $director, $release_year, $image, $price, $genre, $format); // Updated to include format

    header("Location: movie_details.php?id=" . $video_id);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Video</title>
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
        .edit-container {
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
            width: 100%; /* Adjusted to full width */
            max-width: 900px; /* Max width to ensure it doesn't get too large */
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
        .btn-primary {
            background-color: #007bff;
            border: none;
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

    <div class="edit-container container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Edit Video</h3>
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
                        <form action="edit.php?id=<?php echo $video_id; ?>" method="post">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $video['title']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" name="director" class="form-control" value="<?php echo $video['director']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" name="release_year" class="form-control" value="<?php echo $video['release_year']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image URL</label>
                                <input type="text" name="image" class="form-control" value="<?php echo $video['image']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control" value="<?php echo $video['price']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <select class="form-control" id="genre" name="genre" required>
                                    <option value="drama" <?php echo ($video['genre'] === 'drama') ? 'selected' : ''; ?>>Drama</option>
                                    <option value="action" <?php echo ($video['genre'] === 'action') ? 'selected' : ''; ?>>Action</option>
                                    <option value="fantasy" <?php echo ($video['genre'] === 'fantasy') ? 'selected' : ''; ?>>Fantasy</option>
                                    <option value="horror" <?php echo ($video['genre'] === 'horror') ? 'selected' : ''; ?>>Horror</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select class="form-control" id="format" name="format" required>
                                    <option value="DVD" <?php echo ($video['format'] === 'DVD') ? 'selected' : ''; ?>>DVD</option>
                                    <option value="Blu-ray" <?php echo ($video['format'] === 'Blu-ray') ? 'selected' : ''; ?>>Blu-ray</option>
                                    <option value="Digital" <?php echo ($video['format'] === 'Digital') ? 'selected' : ''; ?>>Digital</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
