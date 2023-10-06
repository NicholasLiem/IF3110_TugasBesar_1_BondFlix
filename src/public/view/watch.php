<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];
$isAdmin = $_SESSION['is_admin'];
$isSubscribed = $_SESSION['is_subscribed'];

$pageTitle = 'Watch Movie';
include BASE_PATH . "/public/templates/header.php";
?>

<link rel="stylesheet" href="/public/css/dashboard.css">
<link rel="stylesheet" href="/public/css/watch.css">

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Mono&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Roboto:wght@700&display=swap" rel="stylesheet">

<body>
    <div class="container">
        <?php include BASE_PATH . '/public/templates/navbar.php' ?>
        <div class="stream-container">
            <div class="video-wrapper">
                <video controls autoplay>
                    <source src="/uploads/videos/small.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-info">
                    <h1>Title Goes Here</h1>
                    <p>Description goes here. You can add more details about the video here.</p>
                </div>
            </div>
        </div>
    </div>
</body>