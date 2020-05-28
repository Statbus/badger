<?php
require_once(__DIR__."/../config.php");
$password = filter_input(INPUT_GET,'password',FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
if(!$_SESSION['pass']){
  if(PASSWORD && !$password) die("Password is required for this page");
  if(!password_verify($password,password_hash(PASSWORD, PASSWORD_DEFAULT))) die("Password is incorrect");
}

$_SESSION['pass'] = TRUE;

echo "Merging json files for /mob/clothing/under...";
$icons = [];
$fileinfos = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator(OUTPUT_DIR."/mob/clothing/under"));
foreach($fileinfos as $pathname => $fileinfo) {
  if (strpos($pathname,'.json')) {
    $path = explode('/',$pathname);
    array_pop($path);
    $path = implode('/',$path);
    $path = str_replace(OUTPUT_DIR."/mob/clothing/under",'', $path);
    foreach (json_decode(file_get_contents($pathname)) as $icon){
      $icons[] = "$path/$icon";
    } 
  }
}
$file = fopen(OUTPUT_DIR."/mob/clothing/under/under.json", 'w');
fwrite($file, json_encode($icons));
fclose($file);
echo "Done!<br>";
echo "Merging json files for /mob/inhands...";
$icons = [];
$fileinfos = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator(OUTPUT_DIR."/mob/inhands"));
foreach($fileinfos as $pathname => $fileinfo) {
  if (strpos($pathname,'.json')) {
    $path = explode('/',$pathname);
    array_pop($path);
    $path = implode('/',$path);
    $path = str_replace(OUTPUT_DIR."/mob/inhands",'', $path);
    foreach (json_decode(file_get_contents($pathname)) as $icon){
      $icons[] = "$path/$icon";
    } 
  }
}
$file = fopen(OUTPUT_DIR."/mob/inhands/inhands.json", 'w');
fwrite($file, json_encode($icons));
fclose($file);
echo "Done!<br>";