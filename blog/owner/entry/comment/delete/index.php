<?php
define('ROOT', '../../../../..');
$IV = array(
	'POST' => array(
		'targets' => array('list')
	)
);
require ROOT . '/lib/includeForOwner.php';
requireStrictRoute();
foreach(explode(',', $_POST['targets']) as $target)
	trashCommentInOwner($owner, $target, false);
respondResultPage(0);
?>
