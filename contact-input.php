<?php
namespace contact;
require_once(__DIR__."/domain/Contact.php");
require_once(__DIR__."/presentation/ContactContext.php");
use contact\presentation\ContactContext;

$context = ContactContext::get();
$referer = $_SERVER['HTTP_REFERER'];
if (!strstr($referer, "contact-input.php") && !strstr($referer, "contact-confirm.php")){
  $context->setForm();
  $context->setErrors();
}
$form = $context->getForm();
?>
<script type="text/javascript">
  function doReset(form){
    form.operation.value = "reset";
    form.submit();
    return false;
  }
</script>
<div>
  <p>問い合わせの内容を入力し、[確認]してください。</p>
  <p><?= $context->getErrorMessage() ?></p>
  <form action="contact-actions.php" method="post">
	<input type="hidden" name="operation" value="validate"/>
    <div>
      お名前：<br><input type="text" name="name" value="<?= $form->name ?>" placeholder="山田太郎" >
      <?= $context->getErrorMessage('name') ?>
    </div>
    <div>
      メールアドレス：<br><input type="text" name="mail" value="<?= $form->mail ?>" placeholder="yamada@xxx.com">
      <?= $context->getErrorMessage('mail') ?>
    </div>
  	<div>
      問い合わせの内容：<br><textarea name="contents" rows="3" cols="30"><?= $form->contents ?></textarea>
      <?= $context->getErrorMessage('contents') ?>
  	</div>
  	<div>
  	  <br>
  	  <input type="submit" value="キャンセル" formaction="index.php" >
  	  <input type="submit" value="リセット" onclick="return doReset(this.form)" >
  	  <input type="submit" value="確認" style="background-color:lightpink;" >
  	</div>
  </form>
</div>
<?= $context->setErrors(); ?>
