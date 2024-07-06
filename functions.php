<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize the videos array if it does not exist
if (!isset($_SESSION['videos'])) {
    $_SESSION['videos'] = [];
}

// Add a video
function addVideo($title, $director, $release_year, $image, $price, $genre, $format) {
    if (empty($title) || empty($director) || empty($release_year) || empty($image) || empty($price) || empty($genre) || empty($format)) {
        return false;
    }

    $title = htmlspecialchars($title, ENT_QUOTES);
    $director = htmlspecialchars($director, ENT_QUOTES);
    $release_year = htmlspecialchars($release_year, ENT_QUOTES);
    $image = htmlspecialchars($image, ENT_QUOTES);
    $price = htmlspecialchars($price, ENT_QUOTES);
    $genre = htmlspecialchars($genre, ENT_QUOTES);
    $format = htmlspecialchars($format, ENT_QUOTES);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['videos'])) {
        $_SESSION['videos'] = [];
    }

    $video = [
        'id' => uniqid(),
        'title' => $title,
        'director' => $director,
        'release_year' => $release_year,
        'image' => $image,
        'price' => $price,
        'genre' => $genre,
        'format' => $format // Added format field
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


/// Function to mark a video as rented
function rentVideo($id) {
    if (isset($_SESSION['videos'])) {
        foreach ($_SESSION['videos'] as &$video) {
            if ($video['id'] == $id) {
                $video['rented'] = true;
                return true;
            }
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
                'format' => $format // Updated format field
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