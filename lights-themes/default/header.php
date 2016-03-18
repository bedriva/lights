<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>Lights Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <script>_LIGHTS={slug:"<?php echo $_GET['slug']; ?>"};</script>
    <link rel="stylesheet" href="lights-themes/<?php echo THEME; ?>/theme.css" />
  </head>
  <body>
    <header>
      <div>
        <?php foreach($pages as $p) {
          echo '<a href="' . $p->slug . '">' . $p->stripped_title . '</a>';
        } ?>
      </div>
    </header>
