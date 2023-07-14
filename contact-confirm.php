<?php
namespace contact;
require_once(__DIR__."/domain/Contact.php");
require_once(__DIR__."/presentation/ContactContext.php");
use contact\presentation\ContactContext;

$referer = $_SERVER['HTTP_REFERER'];
if (!strstr($referer, "contact-input.php")){
  header("Location:contact-input.php");
  return;
}
$context = ContactContext::get();
$form = $context->getForm();
?>
<div>
  <p>問い合わせの内容を確認し、[送信]してください。</p>
  <p><br></p>
  <form action="contact-actions.php" method="post">
    <input type="hidden" name="operation" value="register"/>
    <div>
      お名前：<br><input type="text" value="<?= $form->name ?>" disabled="disabled" /><br>
    </div>
    <div>
      メールアドレス：<br><input type="text" value="<?= $form->mail ?>" disabled="disabled" /><br>
    </div>
    <div>
      問い合わせの内容：<br/><textarea rows="3" cols="30" disabled="disabled"><?= $form->contents ?></textarea><br>
    </div>
    <div>
      <br>
      <input type="submit" value="入力に戻る" formaction="contact-input.php">
      <input type="submit" value="送信" style="background-color:lightpink;" >
    </div>
  </form>
</div>
