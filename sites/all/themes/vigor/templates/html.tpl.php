<?php
/**
 * @file
 * Vigor theme's implementation to display the basic html structure of a single
 * Drupal page.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>>
<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<!--[if lt IE 7 ]><body class="ie6 <?php print $classes; ?>"><![endif]-->
<!--[if IE 7 ]><body class="ie7 <?php print $classes; ?>"><![endif]-->
<!--[if IE 8 ]><body class="ie8 <?php print $classes; ?>"><![endif]-->
<!--[if IE 9 ]><body class="ie9 <?php print $classes; ?>"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><body class="<?php print $classes; ?>" <?php print $attributes;?>><!--<![endif]-->
  <p id="skip-link">
    <a class="element-invisible element-focusable" href="#navigation"><?php print t('Jump to Navigation'); ?></a>
    <a class="element-invisible element-focusable" href="#main-content"><?php print t('Jump to Main content'); ?></a>
  </p>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
