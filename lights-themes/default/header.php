<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title><?php echo strip_and_trim($page->page_title); ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="<?php echo get_base_url($page->slug); ?>lights-themes/<?php echo THEME; ?>/normalize.css">
  <link rel="stylesheet" href="<?php echo get_base_url($page->slug); ?>lights-themes/<?php echo THEME; ?>/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="img/favicon.png">

  <!-- lights
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="<?php echo get_base_url($page->slug); ?>lights-themes/<?php echo THEME; ?>/theme.css" />
  <script>_LIGHTS={slug:"<?php echo $_GET['slug']; ?>", baseurl: "<?php echo get_base_url($page->slug); ?>"};</script>
  <script src="<?php echo get_base_url($page->slug); ?>lights-public/lights.js"></script>

</head>
<body class="slug-<?php echo $_GET['slug']; ?>">
  <header class="container">
    <div class="row">
      <div class="twelve columns">
        <?php foreach($pages as $p) {
          echo '<a href="' . get_base_url($page->slug) . $p->slug . '">' . $p->stripped_title . '</a>';
        } ?>
      </div>
    </div>
  </header>
