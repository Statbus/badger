<?php 

require_once(__DIR__."/../config.php");

if($iconfile = filter_input(INPUT_GET,'icon', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)){
  header('Content-Type: application/json');
  if(strpos($iconfile, '..') !== FALSE || strpos($iconfile, ICON_DIR) === FALSE || !is_file($iconfile)){
    die(json_encode(['msg'=>'Invalid icon file']));
  }
  require_once(__DIR__."/../src/PNGMetaDataExtractor.php");
  $png = new PNGMetaDataExtractor();
  $dest = str_replace(ICON_DIR, OUTPUT_DIR, explode('.', $iconfile)[0]);
  if(!is_dir($dest)) {
    mkdir($dest, 0777, true);
  }
  try{ 
    $img = $png->loadImage($iconfile);
    foreach($img as $icon) {
      $icons[] = $icon['state'];
      $count++;
      // echo "<img src='data:image/png;base64, ".$icon['base64']."' />";
      foreach($icon['dir'] as $dir => $i){
        $file = fopen("$dest/".$icon['state']."-$dir.png", 'w');
        fwrite($file, base64_decode($i));
        fclose($file);
      }
      unset($img);
    }
    $jsonfile = end(explode('/',$dest));
    $file = fopen("$dest/$jsonfile.json",'w');
    fwrite($file, json_encode($icons));
    fclose($file);
    unset($icons);
  }
  catch (Exception $e) {
    echo ($e->getMessage());
  }
  echo json_encode(['msg'=>"Rendered $count icons from $iconfile to $dest",'success'=>true]);
  return;
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS only -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <!-- JS, Popper.js, and jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.css" integrity="sha256-N5LjnCD3sm17vjUaBNSBY/NCdnsUZpSrLurmlYiQgRI=" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js" integrity="sha256-q6QA5qUPfpeuxzP5D/wCMcvsYDsV6kQi5/tti+lcmlk=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" integrity="sha256-f83N12sqX/GO43Y7vXNt9MjrHkPc4yi9Uq9cLy1wGIU=" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js" integrity="sha256-ZdnRjhC/+YiBbXTHIuJdpf7u6Jh5D2wD5y0SNRWDREQ=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
</head>
<body>
  <div class="container">
  <h1 class="d-flex justify-content-between">Icon Files <a href="all" class="btn-danger btn-lg mt-2">Render All</a></h1> 
  <hr>
    <div class="list-group">
    <?php
    $fileinfos = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator(ICON_DIR."/mob"));
    foreach($fileinfos as $pathname => $fileinfo) :
      if (strpos($pathname,'.dmi')) : ?>
      <div class="list-group-item d-flex justify-content-between align-items-center"><?php echo $pathname;?><a href="?icon=<?php echo $pathname;?>" class="btn btn-primary render">Render</a></div>
      <?php endif;
endforeach;?>
    </div>
  </div>
  <script>
    $('.render').click(function(e){
      e.preventDefault()
      $(this).html('<i class="fas fa-sync fa-spin"></i> Rendering...').addClass('disabled').addClass('btn-warning').attr('disabled', true)
      const btn = $(this)
      const url = $(this).attr('href')
      $.ajax({
        url: url
      })
      .done(function(data){
        console.log(data)
        if(true == data.success){
          btn.removeClass('btn-warning').addClass('btn-success')
          btn.html('<i class="fas fa-check"></i> Rendered')
        }
      })
    })
    $('[href=all]').click(function(e){
      e.preventDefault();
      $('.render').click();
    })
  </script>
</body>
