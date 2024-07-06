<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize the videos array if it does not exist
if (!isset($_SESSION['videos'])) {
    $_SESSION['videos'] = [];
}

// Add a video with copies parameter
function addVideo($title, $director, $release_year, $image, $price, $genre, $format, $copies) {
    if (empty($title) || empty($director) || empty($release_year) || empty($image) || empty($price) || empty($genre) || empty($format) || $copies < 1) {
        return false;
    }

    $title = htmlspecialchars($title, ENT_QUOTES);
    $director = htmlspecialchars($director, ENT_QUOTES);
    $release_year = htmlspecialchars($release_year, ENT_QUOTES);
    $image = htmlspecialchars($image, ENT_QUOTES);
    $price = htmlspecialchars($price, ENT_QUOTES);
    $genre = htmlspecialchars($genre, ENT_QUOTES);
    $format = htmlspecialchars($format, ENT_QUOTES);

    $video = [
        'id' => uniqid(),
        'title' => $title,
        'director' => $director,
        'release_year' => $release_year,
        'image' => $image,
        'price' => $price,
        'genre' => $genre,
        'format' => $format,
        'copies' => $copies, // Store the number of copies available
        'rented' => false // Initialize rented status
    ];

    $_SESSION['videos'][] = $video;

    return true;
}

// Get all videos
function getVideos() {
    return isset($_SESSION['videos']) ? $_SESSION['videos'] : [];
}

function getVideoById($id) {
    $videos = getVideos();
    foreach ($videos as $video) {
        if ($video['id'] === $id) {
            return $video;
        }
    }
    return null;
}

function saveVideos($videos) {
    $_SESSION['videos'] = $videos;
}

function updateVideo($id, $title, $director, $release_year, $image, $price, $genre, $format) {
    $videos = getVideos();
    foreach ($videos as &$video) {
        if ($video['id'] === $id) {
            $video['title'] = $title;
            $video['director'] = $director;
            $video['release_year'] = $release_year;
            $video['image'] = $image;
            $video['price'] = $price;
            $video['genre'] = $genre;
            $video['format'] = $format; // Updated format field
            break;
        }
    }
    saveVideos($videos);
}


// Rent a video (decrement copies)
function rentVideo($id, $rental_copies = 1) {
    $videos = $_SESSION['videos'];
    foreach ($videos as &$video) {
        if ($video['id'] == $id && $video['copies'] >= $rental_copies) {
            $video['copies'] -= $rental_copies;
            $video['rented'] = true;
            $_SESSION['videos'] = $videos;
            return true;
        }
    }
    return false;
}

// Update a video
function editVideo($id, $title, $director, $release_year, $image, $price, $genre, $format) {
    foreach ($_SESSION['videos'] as $key => $video) {
        if ($video['id'] == $id) {
            $_SESSION['videos'][$key] = [
                'id' => $id,
                'title' => $title,
                'director' => $director,
                'release_year' => $release_year,
                'image' => $image,
                'price' => $price,
                'genre' => $genre,
                'format' => $format,
                'copies' => $video['copies'], // Retain copies
                'rented' => $video['rented'] // Retain rented status
            ];
            break;
        }
    }
}

function deleteVideo($id) {
    foreach ($_SESSION['videos'] as $key => $video) {
        if ($video['id'] == $id) {
            unset($_SESSION['videos'][$key]);
            $_SESSION['videos'] = array_values($_SESSION['videos']);
            return true;
        }
    }
    return false;
}
?>