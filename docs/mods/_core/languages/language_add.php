<?php
/************************************************************************/
/* ATutor																*/
/************************************************************************/
/* Copyright (c) 2002-2008 by Greg Gay, Joel Kronenberg & Heidi Hazelton*/
/* Adaptive Technology Resource Centre / University of Toronto			*/
/* http://atutor.ca														*/
/*																		*/
/* This program is free software. You can redistribute it and/or		*/
/* modify it under the terms of the GNU General Public License			*/
/* as published by the Free Software Foundation.						*/
/************************************************************************/
// $Id: language_add.php 7208 2008-01-09 16:07:24Z greg $

define('AT_INCLUDE_PATH', '../../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_LANGUAGES);
if (!AT_DEVEL_TRANSLATE) { exit; }

if (isset($_POST['cancel'])) {
	$msg->addFeedback('CANCELLED');
	header('Location: language.php');
	exit;
} else if (isset($_POST['submit'])) {
	require_once(AT_INCLUDE_PATH . '../mods/_core/languages/classes/Language/LanguageEditor.class.php'); 
	
	if ($languageManager->exists($_POST['code'], $_POST['locale'])) {
		$msg->addError('LANG_EXISTS');
	} else {
		$state = LanguageEditor::addLanguage($_POST, $db);
	}

	if (!$msg->containsErrors() && $state !== FALSE) {
		$msg->addFeedback('LANG_ADDED');
		header('Location: language.php');
		exit;
	} 
}

require(AT_INCLUDE_PATH.'header.inc.php'); ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="import" value="1" />
<div class="input-form" style="width:95%">
	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="code"><?php echo _AT('lang_code'); ?></label><br />
		<input id="code" name="code" type="text" size="2" maxlength="2" class="formfield" value="<?php echo $_POST['code']; ?>" />
	</div>

	<div class="row">
		<label for="locale"><?php echo _AT('locale'); ?></label><br />
		<input id="locale" name="locale" type="text" size="2" maxlength="2" class="formfield" value="<?php echo $_POST['locale']; ?>" />
	</div>

	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="charset"><?php echo _AT('charset'); ?></label><br />
		<input id="charset" name="charset" type="text" size="31" maxlength="20" class="formfield" value="<?php echo $_POST['charset']; ?>" />
	</div>

	<div class="row">
		<label for="ltr"><?php echo _AT('direction'); ?></label><br />
		<?php 
			if ($_POST['direction'] == 'rtl') { 
				$rtl = 'checked="checked"';  
				$ltr='';  
			} else { 
				$rtl = '';  
				$ltr='checked="checked"'; 
			}
		?>
		<input id="ltr" name="direction" type="radio" value="ltr" <?php echo $ltr; ?> /><label for="ltr"><?php echo _AT('ltr'); ?></label>, <input id="rtl" name="direction" type="radio" value="rtl" <?php echo $rtl; ?> /><label for="rtl"><?php echo _AT('rtl'); ?></label>
	</div>

	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="reg_exp"><?php echo _AT('reg_exp'); ?></label><br />
		<input id="reg_exp" name="reg_exp" type="text" size="31" class="formfield" value="<?php echo $_POST['reg_exp']; ?>" />
	</div>

	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="nname"><?php echo _AT('name_in_language'); ?></label><br />
		<input id="nname" name="native_name" type="text" size="31" maxlength="20" class="formfield" value="<?php echo $_POST['native_name']; ?>" />
	</div>

	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="ename"><?php echo _AT('name_in_english'); ?></label><br />
		<input id="ename" name="english_name" type="text" size="31" maxlength="20" class="formfield" value="<?php echo $_POST['english_name'];?>" />
	</div>


	<div class="row buttons">
		<input type="submit" name="submit" value="<?php echo _AT('submit'); ?>" /> <input type="submit" name="cancel" value="<?php echo _AT('cancel'); ?>" />		
	</div>
</div>
</form>

<?php require(AT_INCLUDE_PATH.'footer.inc.php');  ?>