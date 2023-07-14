<?php
namespace contact\domain;

require_once(__DIR__."/../integration/ContactDataAccessor.php");
use contact\integration\ContactDataAccessor;

class ContactManager {

  private static $instance;
  private $cda;

  public static function getInstance(): ContactManager {
    if (empty(self::$instance)) {
      self::$instance = new ContactManager();
    }
    return self::$instance;
  }

  private function __construct() {
    $this->cda = new ContactDataAccessor();
  }

  private function isValidName(string $name) : bool {
    if (empty($name) || strlen($name) > 20) return false;
    return true;
  }

  private function isValidMail(string $mail) : bool {
    if (empty($mail) || strlen($mail) > 50) return false;
    $pattern = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
    return preg_match($pattern, $mail);
  }

  private function isValidContents(string $contents) : bool {
    if (empty($contents) || strlen($contents) > 2000) return false;
    return true;
  }

  /**
   * 問い合わせの入力値をチェックする。
   * @param Contact $form 問い合わせフォーム
   * @param array $errors エラーコンテナ
   * @return bool 全ての入力値が適正ならtrue
   */
  public function isValidContact(Contact &$form, array &$errors): bool {
    if (!$this->isValidName($form->name)){
      $errors['name'] = '※20文字以内';
    }
    if (!$this->isValidMail($form->mail)){
      $errors['mail'] = '※50文字以内で@を含む';
    }
    if (!$this->isValidContents($form->contents)){
      $errors['contents'] = '※2,000文字以内';
    }
    $b = empty($errors);
    if (!$b){
      $errors['_default'] = '入力値を修正ください。';
    }
    return $b;
  }

  /**
   * 問い合わせ情報を登録または送信する。
   * @param Contact $form 問い合わせフォーム
   * @param array $errors エラーコンテナ
   * @return int 処理した件数またはエラーステータス
   */
  public function registerContact(Contact &$form, array &$errors) : int {
    if ($this->isValidContact($form, $errors) == false){
      // 入力値にエラーがある
      return -1;
    }

    // 問い合わせ内容のみ参照表現に対応
    $validContents = nl2br(htmlspecialchars($form->contents, ENT_QUOTES, 'UTF-8'));

    return $this->cda->registerContact($form, $validContents);
  }
}
