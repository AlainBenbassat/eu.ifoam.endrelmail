<?php

class CRM_Endrelmail_SendMail {
  public const EMPLOYEE_OF_CIVI_RELATYPE_ID = 5;

  public static function send($relationshipId) {
    $rel = self::getRelationshipById($relationshipId);

    if (self::isEmployeeRelationship($rel) && self::isRelationshipEnded($rel)) {
      $mailParams = self::getMailParams($rel);
      CRM_Utils_Mail::send($mailParams);
    }
  }

  private static function getRelationshipById($relationshipId) {
    $relationships = \Civi\Api4\Relationship::get()
      ->addSelect('*')
      ->addWhere('id', '=', $relationshipId)
      ->execute();
    if ($relationships->count() > 0) {
      return $relationships->first();
    }
    else {
      return FALSE;
    }
  }

  private static function isEmployeeRelationship($rel) {
    if ($rel['relationship_type_id'] == self::EMPLOYEE_OF_CIVI_RELATYPE_ID) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  private static function isRelationshipEnded($rel) {
    if ($rel['is_active']) {
      return FALSE;
    }

    if ($rel['end_date'] > date('Y-m-d')) {
      return FALSE;
    }

    return TRUE;
  }

  private static function getMailParams($rel) {
    $msg = self::getMailBodyText($rel);

    $mailParams = [
      'from' => self::getDefaultFromEmail(),
      'toName' => \Civi::settings()->get('ifoam_endrelmail'),
      'toEmail' => \Civi::settings()->get('ifoam_endrelmail'),
      'subject' => 'Employee-of changed: update the extranet?',
      'text' => $msg,
      'html' => "<p>$msg</p>",
      'replyTo' => CRM_Core_BAO_Domain::getNoReplyEmailAddress(),
      'returnPath' => CRM_Core_BAO_Domain::getNoReplyEmailAddress(),
    ];

    return $mailParams;
  }

  private static function getMailBodyText($rel) {
    $contactName1 = self::getContactName($rel['contact_id_a']);
    $contactName2 = self::getContactName($rel['contact_id_b']);

    return "The employee relationship between $contactName1 and $contactName2 has been disabled or deleted. Do you need to update the extranet?";
  }

  private static function getDefaultFromEmail() {
    $listofEmails = CRM_Core_OptionGroup::values('from_email_address', NULL, NULL, NULL, ' AND is_default = 1');
    return reset($listofEmails);
  }

 private static function  getContactName($contactId) {
    $contacts = \Civi\Api4\Contact::get()
      ->addSelect('display_name')
      ->addWhere('id', '=', $contactId)
      ->execute();
    $c = $contacts->first();
    if ($c) {
      return $c['display_name'] . " (Contact ID = $contactId)";
    }
    else {
      return "??? (Contact ID = $contactId)";
    }
 }
}
