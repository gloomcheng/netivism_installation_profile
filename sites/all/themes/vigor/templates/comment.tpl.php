<?php
/**
 * @file
 * Vigor theme's implementation for comments.
 */
?>
<div class="<?php print $classes . ' ' . $zebra; ?> clearfix">
  <div class="comment-inner">

    <?php if ($title): ?>
      <h3 class="comment-title"><?php print $title ?></h3>
    <?php endif; ?>

    <?php if ($new) : ?>
      <span class="new"><?php print drupal_ucfirst($new); ?></span>
    <?php endif; ?>

    <?php print $picture; ?>

    <div class="submitted">
      <?php print $submitted; ?>
    </div>

    <div class="content">
      <?php 
        hide($content['links']);
        print render($content);
      ?>
      <?php if ($signature): ?>
        <div class="user-signature clearfix">
          <?php print $signature; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($content['links'])): ?>
	    <div class="links"><?php print render($content['links']); ?></div>
    <?php endif; ?>  

  </div> <!-- /.comment-inner -->
</div> <!-- /.comment -->
