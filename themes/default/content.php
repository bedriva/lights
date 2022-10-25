<?php require_once 'header.php'; ?>

<main class="container">
  <div class="row">
    <div class="eight columns">
      <?php echo get_region_from_page('order', $page, 'div'); ?>
      <?php echo get_region_from_page('slug', $page, 'div'); ?>
      <?php echo get_region_from_page('page_title', $page, 'h1'); ?>
      <?php echo get_region_from_page('page_content', $page); ?>
    </div>
    <div class="one columns">
      &nbsp;
    </div>
    <div class="three columns">
      <?php echo get_shared_region('shared_widget_1'); ?>
      <?php echo get_region_from_page('page_widget_1', $page); ?>
      <?php echo get_shared_region('shared_widget_2'); ?>
      <?php echo get_region_from_page('page_widget_2', $page); ?>
    </div>
  </div>
</main>

<?php require_once 'footer.php'; ?>