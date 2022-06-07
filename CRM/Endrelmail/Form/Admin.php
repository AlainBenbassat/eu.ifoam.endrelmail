<?php

use CRM_Endrelmail_ExtensionUtil as E;

class CRM_Endrelmail_Form_Admin extends CRM_Core_Form {
  public function buildQuickForm() {

    $this->setTitle('Send mail to someone when an Employee Of relationship is ended.');
    CRM_Core_Session::setStatus('When somone disables an "Employee of" relationship, a notification will be sent to the address below.', '', 'no-popup');

    $this->add(
      'text',
      'target_email',
      'Send mail to',
      [],
      TRUE
    );
    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ],
    ]);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();

    \Civi::settings()->set('ifoam_endrelmail', $values['target_email']);
    CRM_Core_Session::setStatus('The email address has been stored.', 'Success', 'success');
    parent::postProcess();
  }

  public function getRenderableElementNames() {
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
