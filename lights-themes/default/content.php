<?php require_once 'header.php'; ?>

<div>
  <article>
    <?php echo get_region_from_page('slug', $page, 'div'); ?>
    <?php echo get_region_from_page('page_title', $page, 'h1'); ?>
    <?php echo get_region_from_page('page_content', $page); ?>
  </article>
  <sidebar>
    <?php echo get_shared_region('shared_widget_1'); ?>
    <?php echo get_region_from_page('page_widget_1', $page); ?>
    <?php echo get_shared_region('shared_widget_2'); ?>
    <?php echo get_region_from_page('page_widget_2', $page); ?>
  </sidebar>
  <div class="clr"></div>
</div>

<?php require_once 'footer.php'; ?>
