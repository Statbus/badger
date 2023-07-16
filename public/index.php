<?php

use App\GitRevision;

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../vendor/autoload.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statbus Presents BadgeR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        img {
            -ms-interpolation-mode: nearest-neighbor;
            image-rendering: pixelated;
        }

        .skintone-sel {
            padding: 10px;
        }

        input[name=skinTone] {
            display: none;
        }

        input[name=skinTone]+label {
            border: 3px solid grey;
            border-radius: 4px;
            padding: 10px;
            margin: 0 2px 0 0;
        }

        input[name=skinTone]:checked+label {
            border-color: black;
        }

        input[name=skinTone]:disabled+label {
            opacity: .75;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.css" integrity="sha256-N5LjnCD3sm17vjUaBNSBY/NCdnsUZpSrLurmlYiQgRI=" crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <h1>Nanotrasen Employee ID Card Generator Interface</h1>
        <hr>
        <div class="row">
            <div class="col-2">
                <div class="card">
                    <h3 class="card-header">
                        Mugshot
                    </h3>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img id="mugshot" src="" />
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <h3 class="card-header">
                        Corporate ID Card
                    </h3>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img id="corp" src="" />
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <h3 class="card-header">
                        Station Identification Card
                    </h3>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img id="idcard" src="" />
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <form class="row" id="generator">
            <div class="col-6">
                <h3>Biometric Data</h3>
                <hr>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="species" class="form-label">Species</label>
                        <select name="species" class="form-control field species disabled" disabled>
                            <option value="human">Human</option>
                            <option value="lizard">Lizard</option>
                            <option value="digitrade">Lizard (Digitigrade)</option>
                            <option value="pod">Podperson</option>
                            <option value="jelly">Jellyperson</option>
                            <option value="slime">Slimeperson</option>
                            <option value="golem">Golem</option>
                            <option value="snail">Snail</option>
                            <option value="plant">Plant</option>
                            <option value="mush">Mushroom</option>
                            <option value="ethereal">Ethereal</option>
                            <option value="stargazer">Stargazer</option>
                            <option value="moth">Moth</option>
                            <option value="fly">Fly</option>
                            <option value="plasmaman">Plasmaman</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dir" class="form-label">Facing</label>
                        <select name="dir" class="form-control field bg">
                            <option value="0">South</option>
                            <option value="1">North</option>
                            <option value="2">East</option>
                            <option value="3">West</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dir" class="form-label">Gender</label>
                        <select name="gender" class="form-control field bg">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="bg" class="form-label">Eye Color</label>
                        <input type='color' class='form-control field c  form-control-color' name='eyeColor' id='eyeColor' value="#6aa84f">
                    </div>
                    <div class="col-md-6">
                        <label for="skintone" class="form-label">Skintone</label>
                        <div class="col-md-8" id="skintone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="bg" class="form-label">Corporate ID Background</label>
                        <select name="bg" class="form-control field bg">
                            <option value="default">Default</option>
                            <option value="lava">Lava</option>
                            <option value="ocean">Ocean</option>
                            <option value="old">Old</option>
                            <option value="ice">Ice</option>
                            <option value="head">Head of Staff</option>
                            <option value="captain">Captain</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="text3" class="form-label">Identification</label>
                        <input type="text" class="form-control" id="text3" name="text3" placeholder="Employee of Nanotrasen">
                    </div>
                    <div class="col-md-6">
                        <label for="text1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="text1" name="text1" placeholder="A. Spaceman">
                    </div>
                    <div class="col-md-6">
                        <label for="text1" class="form-label">Title</label>
                        <input type="text" class="form-control" id="text2" name="text2" placeholder="Bottom Text">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Equipment</h3>
                <hr>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="hairStyle" id='hairStyle' type="search" placeholder="Hair style" autocomplete="off" class='form-control field c'>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type='color' class='form-control field c  form-control-color' name='hairColor' id='hairColor' value="#994500">
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="facial" id='facial' type="search" placeholder="Facial Hair" autocomplete="off" class='form-control field c'>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type='color' class='form-control field c  form-control-color' name='facialColor' id='facialColor' value="#000000">
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="eyeWear" id='eyeWear' type="search" placeholder="Eye Wear" autocomplete="off" class='form-control field c'>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mask" class="form-label d-none">Mask</label>
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="mask" id='mask' type="search" placeholder="Mask" autocomplete="off" class='form-control field c'>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="uniform" id='uniform' type="search" placeholder="Uniform" autocomplete="off" class='form-control field c'>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="suit" id='suit' type="search" placeholder="Suit" autocomplete="off" class='form-control field c'>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="head" id='head' type="search" placeholder="Headgear" autocomplete="off" class='form-control field c'>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="belt" id='belt' type="search" placeholder="Belt" autocomplete="off" class='form-control field c'>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="gloves" class="form-label d-none">Gloves</label>
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="gloves" id='gloves' type="search" placeholder="Gloves" autocomplete="off" class='form-control field c'>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="shoes" class="form-label d-none">Shoes</label>
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <span class="typeahead__query">
                                    <input name="shoes" id='shoes' type="search" placeholder="Shoes" autocomplete="off" class='form-control field c'>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Generator Code <span class="text-muted">Save this to re-generate your sprite later on!</span></label>
            <?php require_once(__DIR__."/../src/JsonCodeTextarea.php");?>
        </div>
        <hr>
        <footer class="mb-4">
            <div class="text-muted d-flex justify-content-between">
                <span>Presented by <a href="https://statbus.space" target="_blank">Statbus</a> | <a href="https://github.com/Statbus/badger" target="_blank">Github</a></span>

                <span>Sprites and Icons generated from <?php echo GitRevision::getString(); ?> | v. <?php echo VERSION; ?></span>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js" integrity="sha256-q6QA5qUPfpeuxzP5D/wCMcvsYDsV6kQi5/tti+lcmlk=" crossorigin="anonymous"></script>
        <script src="resources/js/app.js"></script>
</body>

</html>