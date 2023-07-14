<?php
namespace contact\integration;

require_once(__DIR__."/../domain/Contact.php");
use contact\domain\Contact;

class ContactDataAccessor {

  public function registerContact(Contact &$form, $validContents) : int {
    // TODO スタブ
    error_log($form->name . "さんからの問い合わせを処理しました。");
    return 1;
  }
}
