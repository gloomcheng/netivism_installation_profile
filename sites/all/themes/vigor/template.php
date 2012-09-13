<?php
/**
 * @file
 * Contains functions to alter Drupal's markup for the Vigor theme.
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('clear_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

// Add Zen Tabs styles.
if (theme_get_setting('vigor_zen_tabs')) {
  drupal_add_css(drupal_get_path('theme', 'vigor') . '/css/tabs.css');
}

/**
 * Override or insert variables into the html template.
 *
 * @param (array) $variables
 *   An array of variables to pass to the theme template.
 * @param (string) $hook
 *   The name of the template being rendered. This is usually "html".
 */
function vigor_preprocess_html(&$variables, $hook) {
  if (theme_get_setting('formalize_mode')) {
    drupal_add_js(drupal_get_path('theme', 'vigor') . '/js/jquery.formalize.js', array('group' => JS_THEME));
    drupal_add_css(drupal_get_path('theme', 'vigor') . '/css/formalize.css', array(
      'group'      => CSS_THEME,
      'every_page' => TRUE,
      'weight'     => -1));
  }

  // Adding classes wether #navigation is here or not.
  if (!empty($variables['main_menu']) or !empty($vars['sub_menu'])) {
    $variables['classes_array'][] = 'with-navigation';
  }
  if (!empty($variables['secondary_menu'])) {
    $variables['classes_array'][] = 'with-subnav';
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$variables['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section,) = explode('/', $path, 2);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node' && isset($arg[1])) {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $variables['classes_array'][] = drupal_html_class('section-' . $section);
  }
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param (array) $variables
 *   An array of variables to pass to the theme template.
 * @param (string) $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function vigor_preprocess_page(&$variables, $hook) {
  $path = drupal_get_path_alias($_GET['q']);
  $path_array = explode('/', $path);

  // Return early, we don't wanted that not have subsection.
  if (count($path_array) == 1) {
    return;
  }

  // Add unique class for each website subsection.
  list(, $subsection,) = $path_array;
  $arg = explode('/', $_GET['q']);
  if ($arg[0] != $path_array[0]) {
    $variables['classes_array'][] = drupal_html_class('subsection-' . $subsection);
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param (array) $variables
 *   An array of variables to pass to the theme template.
 * @param (string) $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function vigor_preprocess_node(&$variables, $hook) {
  // Add a striping class.
  $variables['classes_array'][] = 'node-' . $variables['zebra'];
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param (array) $variables
 *   An array of variables to pass to the theme template.
 * @param (string) $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function vigor_preprocess_comment(&$variables, $hook) {
  // dpm($variables);
}

/**
 * Override or insert variables into the block templates.
 *
 * @param (array) $variables
 *   An array of variables to pass to the theme template.
 * @param (string) $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function vigor_preprocess_block(&$variables, $hook) {
  // Add a striping class.
  $variables['classes_array'][] = 'block-' . $variables['block_zebra'];
}

/**
 * Generate the HTML output for a menu link and submenu.
 *
 * @param (array) $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return (string)
 *   A themed HTML string.
 *
 * @ingroup themeable
 */
function vigor_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  // Adding a class depending on the TITLE of the link (not constant).
  $element['#attributes']['class'][] = vigor_id_safe($element['#title']);
  // Adding a class depending on the ID of the link (constant).
  $element['#attributes']['class'][] = 'mid-' . $element['#original_link']['mlid'];
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}


/**
 * Override or insert variables into theme_menu_local_task().
 */
function vigor_preprocess_menu_local_task(&$variables) {
  $link = &$variables['element']['#link'];

  // If the link does not contain HTML already, check_plain() it now.
  // After we set 'html'=TRUE the link will not be sanitized by l().
  if (empty($link['localized_options']['html'])) {
    $link['title'] = check_plain($link['title']);
  }
  $link['localized_options']['html'] = TRUE;
  $link['title'] = '<span class="tab">' . $link['title'] . '</span>';
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function vigor_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Converts a string to a suitable html ID attribute.
 *
 * http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 * valid ID attribute in HTML. This function:
 *
 * - Ensure an ID starts with an alpha character by optionally adding an 'n'.
 * - Replaces any character except A-Z, numbers, and underscores with dashes.
 * - Converts entire string to lowercase.
 *
 * http://www.w3.org/TR/CSS21/syndata.html#characters
 * In CSS, identifiers (including element names, classes, and IDs in selectors)
 * can contain only the characters [a-zA-Z0-9] and ISO 10646 characters U+00A1
 * and higher, plus the hyphen (-) and the underscore (_); they cannot start
 * with a digit, or a hyphen followed by a digit. Identifiers can also contain
 * escaped characters and any ISO 10646 character as a numeric code (see next
 * item).
 * For instance, the identifier "B&W?" may be written as "B\&W\?" or "B\26 W\3F"
 * .
 *
 * @param (string) $string
 *   The string
 *
 * @return (string)
 *   The converted string
 */
function vigor_id_safe($string) {
  // Replace with id- start with a digit or dot or sharp.
  $string = preg_replace('/^-/', '', $string);
  $string = preg_replace('/^[0-9.#]/', 'id-', $string);
  // Replace with hyphen that contain dot or sharp or space.
  $string = preg_replace('/[.#\s]/', '-', $string);
  return strtolower($string);
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param (array) $variables
 *   An array containing the breadcrumb links.
 *
 * @return (string)
 *   A string containing the breadcrumb output.
 */
function vigor_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('vigor_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('vigor_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('vigor_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('vigor_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $title = check_plain($item['title']);
        }
        else {
          $title = drupal_get_title();
        }
        if ($title) {
          $trailing_separator = $breadcrumb_separator;
        }
      }
      elseif (theme_get_setting('vigor_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users. Make the heading invisible with .element-invisible
      $heading = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

      return $heading . '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . $trailing_separator . $title . '</div>';
    }
  }
  // Otherwise, return an empty string.
  return '';
}
