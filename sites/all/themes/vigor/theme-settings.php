<?php
/**
 * @file
 * Vigor theme settings.
 */

/**
 * Form override fo theme settings
 */
function vigor_form_system_theme_settings_alter(&$form, $form_state) {

  $form['options_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Theme Specific Settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

  $form['options_settings']['vigor_zen_tabs'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Use The Zen Tabs'),
    '#default_value' => theme_get_setting('vigor_zen_tabs'),
    '#description'   => t('Replace the default tabs by the Zen Tabs.'),
  );

  $form['options_settings']['vigor_breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
    '#attributes'    => array('id' => 'vigor-breadcrumb'),
  );

  $form['options_settings']['vigor_breadcrumb']['vigor_breadcrumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => theme_get_setting('vigor_breadcrumb'),
    '#options'       => array(
      'yes'   => t('Yes'),
      'admin' => t('Only in admin section'),
      'no'    => t('No'),
    ),
  );

  $form['options_settings']['vigor_breadcrumb']['vigor_breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => t('Text only. Don’t forget to include spaces.'),
    '#default_value' => theme_get_setting('vigor_breadcrumb_separator'),
    '#size'          => 5,
    '#maxlength'     => 10,
  );

  $form['options_settings']['vigor_breadcrumb']['vigor_breadcrumb_home'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => theme_get_setting('vigor_breadcrumb_home'),
  );

  $form['options_settings']['vigor_breadcrumb']['vigor_breadcrumb_trailing'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('vigor_breadcrumb_trailing'),
    '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
  );

  $form['options_settings']['vigor_breadcrumb']['vigor_breadcrumb_title'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append the content title to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('vigor_breadcrumb_title'),
    '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
  );

  $form['options_settings']['formalize_mode'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Using Formalize.'),
    '#default_value' => theme_get_setting('formalize_mode'),
    '#description'   => t('!cargo_cult_url adherents say that styling form elements is evil, so !formalize live with browser oddities. It does not have to be this way. It can be much better…', array(
      '!cargo_cult_url' => l(t('Cargo cult'), 'http://en.wikipedia.org/wiki/Cargo_cult_programming'),
      '!formalize' => l(t('we'), 'http://formalize.me/'))
    ),
  );

  $form['options_settings']['clear_registry'] = array(
    '#type' => 'checkbox',
    '#title' =>  t('Rebuild theme registry on every page.'),
    '#description'   =>t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'http://drupal.org/node/173880#theme-registry')),
    '#default_value' => theme_get_setting('clear_registry'),
  );
}


/**
 * A simple debug function.
 */
function vdebugs($arg) {
  $args = func_get_args();
  echo '<pre>';
  foreach ($args as $arg) {
    echo '(', gettype($arg), ') ', check_plain(print_r($arg, TRUE)) . "<br/>\n";
  }
  echo '</pre>';
}
