<?php
namespace contact\presentation;
require_once(__DIR__."/../domain/Contact.php");
use contact\domain\Contact;

class ContactContext {

  const THIS_CONTEXT = "contact-context";
  private $form;
  private $errors;

  public function __construct() {
    $this->setForm();
    $this->setErrors();
  }

  public static function get(): ContactContext {
    if (!isset($_SESSION)){
      session_start();
    }
    $context = null;
    if (isset($_SESSION[self::THIS_CONTEXT])){
      $context = $_SESSION[self::THIS_CONTEXT];
    }
    if ($context == null || !($context instanceof ContactContext)){
      $context = new ContactContext();
      $_SESSION[self::THIS_CONTEXT] = $context;
    }
    return $context;
  }

  public function getForm(): Contact {
    if (empty($this->form)){
      $this->form = new Contact();
    }
    return $this->form;
  }

  public function setForm(Contact $form = null): void {
    $this->form = $form;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function setErrors(array $errors = null): void {
    if ($errors == null){
      $this->errors = array();
    } else {
      $this->errors = $errors;
    }
  }

  public function getErrorMessage(string $key = '_default'): string {
    foreach ($this->errors as $k => $v) {
      if ($key == $k){
        return '<font color="red">' . $v . '</font>';
      }
    }
    return '<br>';
  }
}
