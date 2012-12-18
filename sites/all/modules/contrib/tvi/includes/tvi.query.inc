<?php
/**
 * TVI Database Interface
 */

/**
 * Return a default setting object.
 */
function tvi_default_settings($type = TVI_TYPE_TERM, $xid = 0) {
  $settings = new stdClass();

  $settings->type = $type;
  $settings->xid  = $xid;

  $settings->view_name = 0;
  $settings->display = TVI_DEFAULT_DISPLAY;
  $settings->status  = 0;
  $settings->inherit = 0;

  $settings->is_default = TRUE;

  return $settings;
}

/**
 * Load a setting from the database or return a default, if the $return_default
 * flag is set.
 */
function tvi_load_settings($xid, $type = TVI_TYPE_TERM, $return_default = TRUE) {
  $xid = _tvi_get_xid($xid, $type);

  $settings = variable_get('tvi_' . $type . '_' . $xid, FALSE);
  $settings = is_array($settings) ? (object) $settings : $settings;

  if (!is_object($settings)) {
    return ($return_default ? tvi_default_settings($type, $xid) : FALSE);
  }

  $settings->is_default = FALSE;
  return $settings;
}

/**
 * Save settings information for a taxonomy vocabulary or term to the database.
 */
function tvi_update_settings($settings) {
  if (is_object($settings)) {
    $settings = (array) $settings;
  }

  variable_set('tvi_' . $settings['type'] . '_' . $settings['xid'], $settings);
}

/**
 * Delete settings information for a taxonomy vocabulary or term in 
 * the database.
 */
function tvi_remove_settings($xid, $type = TVI_TYPE_TERM) {
  $xid = _tvi_get_xid($xid, $type);

  variable_del('tvi_' . $type . '_' . $xid);
}

/**
 * Convert the entity id into its best parameter.
 *
 * Vocabulary's vid converts to machine_name.
 * Term's tid converts to uuid if set.
 */
function _tvi_get_xid($xid, $type = TVI_TYPE_TERM) {
  if ($type == TVI_TYPE_VOCAB) {
    $vocabulary = taxonomy_vocabulary_load($xid);
    if (!empty($vocabulary->machine_name)) {
      $xid = $vocabulary->machine_name;
    }
  }
  elseif ($type == TVI_TYPE_TERM && module_exists('uuid')) {
    $uuid = reset(entity_get_uuid_by_id('taxonomy_term', array($xid)));
    if (!empty($uuid)) {
      $xid = $uuid;
    }
  }
  return $xid;
}

/**
 * Massively convert all settings based on the tid to uuids. 
 */
function _tvi_convert_tids_to_uuids() {
  module_load_include('module', 'uuid');
  uuid_sync_all();

  $variables = db_select('variable', 'v')
    ->fields('v')
    ->condition('v.name', 'tvi_' . TVI_TYPE_TERM . '_%', 'LIKE')
    ->execute()
    ->fetchAll();

  foreach ($variables as $variable) {
    $tid = substr($variable->name, strlen('tvi_' . TVI_TYPE_TERM . '_'));
    $uuid = reset(entity_get_uuid_by_id('taxonomy_term', array($tid)));
    if (!empty($uuid) && $tid != $uuid) {
      db_update('variable')
        ->fields(array('name' => 'tvi_' . TVI_TYPE_TERM . '_' . $uuid))
        ->condition('name', $variable->name)
        ->execute();
    }
  }
}

/**
 * Massively convert all settings based on the uuids to tids.
 *
 * As UUID is disabled we cannot use its functions to retreive the related tid
 * so we have to get the value from the database.
 */
function _tvi_convert_uuids_to_tids() {
  $variables = db_select('variable', 'v')
    ->fields('v')
    ->condition('v.name', 'tvi_' . TVI_TYPE_TERM . '_%', 'LIKE')
    ->execute()
    ->fetchAll();

  foreach ($variables as $variable) {
    $uuid = substr($variable->name, strlen('tvi_' . TVI_TYPE_TERM . '_'));
    $tid = db_select('taxonomy_term_data', 'ttd')
      ->fields('ttd', array('tid'))
      ->condition('ttd.uuid', $uuid)
      ->execute()
      ->fetchColumn();
    if (!empty($tid) && $tid != $uuid) {
      db_update('variable')
        ->fields(array('name' => 'tvi_' . TVI_TYPE_TERM . '_' . $tid))
        ->condition('name', $variable->name)
        ->execute();
    }
  }
}
