<?php
namespace contact;
require_once(__DIR__."/domain/ContactManager.php");
require_once(__DIR__."/presentation/ContactContext.php");
use contact\domain\ContactManager;
use contact\presentation\ContactContext;

$referer = $_SERVER['HTTP_REFERER'];
if (!strstr($referer, "contact-input.php") && !strstr($referer, "contact-confirm.php")){
  header("Location:contact-input.php");
  return;
}

$context = ContactContext::get();
$form = $context->getForm();
$errors = array();
$location = "contact-input.php";

$operation = $_POST['operation'];
if ($operation == 'reset'){

  // [リセット]ボタン押下時

  $form->init();

} else if ($operation == 'validate'){

  // [確認]ボタン押下時

  $form->name = $_POST['name'];
  $form->mail = $_POST['mail'];
  $form->contents = $_POST['contents'];

  $manager = ContactManager::getInstance();
  $state = $manager->isValidContact($form, $errors);
  if ($state){
    $location = "contact-confirm.php";
  }

} else if ($operation == 'register'){

  // [送信]ボタン押下時

  $manager = ContactManager::getInstance();
  $cnt = $manager->registerContact($form, $errors);
  if ($cnt > 0){
    $form->init();
    $location = "contact-complete.php";
  }
}
$context->setErrors($errors);
header("Location:" . $location);
?>
