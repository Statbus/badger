<?php

use App\GitRevision;
use App\JobInfoGenerator;

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../vendor/autoload.php");
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
if (!$_SESSION['pass']) {
    if (PASSWORD && !$password) {
        die("Password is required for this page");
    }
    if (!password_verify($password, password_hash(PASSWORD, PASSWORD_DEFAULT))) {
        die("Password is incorrect");
    }
}

$_SESSION['pass'] = true;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statbus Presents BadgeR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
    </style>
</head>

<body>
    <div class="container">
        <h1>BadgeR Tools Divison</h1>
        <hr>
        <div class="list-group">
            <div class="list-group-item">
                <h4>Git Revision</h4>
                <?php
                $regenRev = filter_input(INPUT_GET, 'regenRev', FILTER_VALIDATE_BOOL); ?>
                <?php echo GitRevision::getString($regenRev); ?>
                <a href="?regenRev=true">Regenerate?</a>
            </div>
            <div class="list-group-item">
                <h4>Job Data</h4>
                <?php
                $regenJobs = filter_input(INPUT_GET, 'regenJobs', FILTER_VALIDATE_BOOL); ?>
                <?php echo JobInfoGenerator::checkForCache($regenJobs); ?>
                <a href="?regenJobs=true">Regenerate?</a>
            </div>
        </div>
        <hr>
        <footer>
            <div class="text-muted d-flex justify-content-between">
                <span>Presented by <a href="https://statbus.space" target="_blank">Statbus</a> | <a href="https://github.com/Statbus/badger" target="_blank">Github</a></span>
                <span>v. <?php echo VERSION; ?></span>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js" integrity="sha256-q6QA5qUPfpeuxzP5D/wCMcvsYDsV6kQi5/tti+lcmlk=" crossorigin="anonymous"></script>
        <script src="resources/js/app.js"></script>
</body>

</html>