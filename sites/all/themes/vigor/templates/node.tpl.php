<?php
/**
 * @file
 * Vigor theme's implementation to display a node.
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
  <div class="node-inner">

    <?php if (!$page && $title): ?>
      <?php print render($title_prefix); ?>
      <h2 class="node-title"<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php print render($title_suffix); ?>
    <?php endif; ?>

    <?php print $user_picture; ?>

    <?php if ($display_submitted): ?>
      <span class="submitted"><?php print $submitted; ?></span>
    <?php endif; ?>

    <div class="content">
      <?php 
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print render($content);
       ?>
    </div>

    <?php if (!empty($content['links'])): ?>
      <div class="node-links"><?php print render($content['links']); ?></div>
    <?php endif; ?>

  </div> <!-- /node-inner -->
</div> <!-- /node-->

<?php print render($content['comments']); ?>
