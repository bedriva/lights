<?php require_once 'header.php'; ?>

<div class="section get-help">
  <div class="container">
    <?php echo get_shared_region('shared_index_hero_header_1_1'); ?>
    <?php echo get_shared_region('shared_index_hero_header_2_1'); ?>
    <?php echo get_shared_region('shared_index_hero_description_1', 'div', array('class' => 'button button-primary')); ?>
  </div>
</div>

<div class="section values">
  <div class="container">
    <div class="row">
      <div class="one-third column value">
        <?php echo get_shared_region('shared_index_header_1_1'); ?>
        <?php echo get_shared_region('shared_index_header_2_1'); ?>
        <?php echo get_shared_region('shared_index_description_1'); ?>
      </div>
      <div class="one-third column value">
        <?php echo get_shared_region('shared_index_header_1_2'); ?>
        <?php echo get_shared_region('shared_index_header_2_2'); ?>
        <?php echo get_shared_region('shared_index_description_2'); ?>
      </div>
      <div class="one-third column value">
        <?php echo get_shared_region('shared_index_header_1_3'); ?>
        <?php echo get_shared_region('shared_index_header_2_3'); ?>
        <?php echo get_shared_region('shared_index_description_3'); ?>
      </div>
    </div>
  </div>
</div>

<main class="container">
  <div class="row">
    <div class="two columns">
      &nbsp;
    </div>
    <div class="eight columns">
      <?php echo get_region_from_page('order', $page, 'div'); ?>
      <?php echo get_region_from_page('slug', $page, 'div'); ?>
      <?php echo get_region_from_page('page_title', $page, 'h1'); ?>
      <?php echo get_region_from_page('page_content', $page); ?>
    </div>
  </div>
</main>

<?php require_once 'footer.php'; ?>
