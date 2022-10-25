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
  <link rel="stylesheet" href="<?php echo get_public_path('normalize.css'); ?>">
  <link rel="stylesheet" href="<?php echo get_public_path('skeleton.css'); ?>">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="img/favicon.png">

  <!-- lights
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="<?php echo get_public_path('theme.css'); ?>" />
  <?php echo theme_head($page); ?>

</head>


<body class="slug-<?php echo @$_GET['slug']; ?>">
  <header class="container">
    <div class="row">
      <div class="twelve columns">
        <?php foreach ($pages as $p) {
          echo '<a href="' . get_page_link($p) . '">' . $p->stripped_title . '</a>';
        } ?>
      </div>
    </div>
  </header>