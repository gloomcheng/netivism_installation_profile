<?php 
/**
 * @file
 * Vigor's theme implementation to display a single Drupal page.
 */
?>
<div id="page-outer-wrapper" class="<?php print $classes; ?>">

  <div id="branding">
    <div id="header" class="clearfix">

      <div id="logo-title">
        <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
        <?php endif; ?>

        <div id="name-and-slogan">
          <?php if ($site_name): ?>
            <span id="site-name">
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
            </span>
          <?php endif; ?>
          <?php if ($site_slogan): ?>
            <span id="site-slogan"><?php print $site_slogan; ?></span>
          <?php endif; ?>
        </div> <!-- /#name-and-slogan -->

      </div> <!-- /#logo-title -->

      <?php if ($page['header']): ?>
        <div id="header-region">
          <?php print render($page['header']); ?>
        </div> <!-- /#header-region -->
      <?php endif; ?>

    </div> <!-- /#header -->
  </div> <!-- /#branding -->

  <?php if ($main_menu || $secondary_menu): ?>
  <div id="navigation-wrapper" class="clearfix">
    <div id="navigation" class="menu <?php if (!empty($main_menu)): print "with-main-menu"; endif; if (!empty($secondary_menu)): print " with-sub-menu"; endif; ?>">
      <?php if (!empty($main_menu)): ?>
        <div class="primary-menu-wrapper">
        <?php print theme('links', array(
          'links' => $main_menu,
          'attributes' => array(
            'id' => 'primary-menu',
            'class' => array('links', 'clearfix', 'main-menu'),
          ))); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($secondary_menu)): ?>
        <div class="secondary-menu-wrapper">
        <?php print theme('links', array(
          'links' => $secondary_menu,
          'attributes' => array(
            'id' => 'secondary-menu',
            'class' => array('links', 'clearfix', 'sub-menu'),
          ))); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <?php if ($page['preface']): ?>
  <div id="preface" class="clearfix limiter">
    <?php print render($page['preface']); ?>
  </div>
  <?php endif; ?>

  <div id="page-wrapper">
  <div id="page">
  <div id="main-content" class="clearfix">
  
    <div id="content">
      <div class="content-inner center">

        <?php if ($breadcrumb || $title|| $messages || $page['help'] || $tabs || $action_links): ?>
          <div id="content-header">

            <?php print $breadcrumb; ?>

            <?php if ($page['highlighted']): ?>
              <div id="highlighted"><?php print render($page['highlighted']) ?></div>
            <?php endif; ?>

            <?php if ($title): ?>
              <h1 class="page-title"><?php print $title; ?></h1>
            <?php endif; ?>

            <?php if ($messages): ?>
              <div id="console" class="clearfix"><?php print $messages; ?></div>
            <?php endif; ?>

            <?php if ($tabs): ?>
              <div class="tabs"><?php print render($tabs); ?></div>
            <?php endif; ?>

            <?php if ($page['help']): ?>
              <div id="help">
                <?php print render($page['help']); ?>
              </div>
            <?php endif; ?>

            <?php if ($action_links): ?>
              <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>

          </div> <!-- /#content-header -->
        <?php endif; ?>

        <div id="content-area">
          <?php print render($page['content']); ?>
        </div> <!-- /#content-area -->

        <?php print $feed_icons; ?>

      </div> <!-- /.content-inner -->
    </div> <!-- /#content -->

    <?php if ($page['sidebar_first']): ?>
      <div id="sidebar-first" class="sidebar first">
        <div class="sidebar-first-inner">
          <?php print render($page['sidebar_first']); ?>
        </div>
      </div> <!-- /#sidebar-first -->
    <?php endif; ?>

    <?php if ($page['sidebar_second']): ?>
      <div id="sidebar-second" class="sidebar second">
        <div class="sidebar-second-inner">
          <?php print render($page['sidebar_second']); ?>
        </div>
      </div> <!-- /#sidebar-second -->
    <?php endif; ?>

  </div> <!-- /#main-content -->
  </div> <!-- /#page -->
  </div> <!-- /#page-wrapper -->

  <?php if ($page['postscript']): ?>
    <div id="postscript-wrapper">
      <div id="postscript" class="limiter">
        <?php print render($page['postscript']); ?>
      </div>
    </div> <!-- /#postscript-wrapper -->
  <?php endif; ?>

  <?php if ($page['footer']): ?>
    <div id="page-footer-wrapper">
      <div id="page-footer" class="limiter">
        <?php print render($page['footer']); ?>
      </div>
    </div> <!-- /#page-footer-wrapper -->
  <?php endif; ?>

</div> <!-- /#page-outer-wrapper -->
