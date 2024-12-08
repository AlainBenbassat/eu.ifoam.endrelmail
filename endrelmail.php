<?php

require_once 'endrelmail.civix.php';
// phpcs:disable
use CRM_Endrelmail_ExtensionUtil as E;
// phpcs:enable

function endrelmail_civicrm_postCommit($op, $objectName, $objectId, &$objectRef) {
  if ($objectName == 'Relationship' && ($op == 'edit' || $op == 'delete')) {
    CRM_Endrelmail_SendMail::send($objectId);
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function endrelmail_civicrm_config(&$config) {
  _endrelmail_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function endrelmail_civicrm_install() {
  _endrelmail_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function endrelmail_civicrm_enable() {
  _endrelmail_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function endrelmail_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function endrelmail_civicrm_navigationMenu(&$menu) {
//  _endrelmail_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _endrelmail_civix_navigationMenu($menu);
//}
