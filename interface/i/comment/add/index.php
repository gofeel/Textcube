<?php
/// Copyright (c) 2004-2014, Needlworks  / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/documents/LICENSE, /documents/COPYRIGHT)
define('__TEXTCUBE_IPHONE__', true);
require ROOT . '/library/preprocessor.php';
requireView('iphoneView');
requireStrictRoute();
$entryId = $suri['id'];
$IV = array(
	'POST' => array(
		"name_$entryId" => array('string', 'default' => null),
		"password_$entryId" => array('string', 'default' => ''),
		"secret_$entryId" => array('string', 'default' => null),
		"homepage_$entryId" => array('string', 'default' => 'http://'),
		"comment_$entryId" => array('string', 'default' => '')
	)
);
if(!Validator::validate($IV))
	Respond::NotFoundPage();
if (!doesHaveOwnership() && empty($_POST["name_$entryId"])) {
	printMobileErrorPage(_text('댓글 작성 오류.'), _text('이름을 입력해 주세요.'), "$blogURL/comment/$entryId");
} else if (!doesHaveOwnership() && empty($_POST["comment_$entryId"])) {
	printMobileErrorPage(_text('댓글 작성 오류.'), _text('내용을 입력해 주세요.'), "$blogURL/comment/$entryId");
} else {
	$comment = array();
	$comment['entry'] = $entryId;
	$comment['parent'] = null;
	$comment['name'] = empty($_POST["name_$entryId"]) ? '' : $_POST["name_$entryId"];
	$comment['password'] = empty($_POST["password_$entryId"]) ? '' : $_POST["password_$entryId"];
	$comment['homepage'] = empty($_POST["homepage_$entryId"]) || ($_POST["homepage_$entryId"] == 'http://') ? '' : $_POST["homepage_$entryId"];
	$comment['secret'] = empty($_POST["secret_$entryId"]) ? 0 : 1;
	$comment['comment'] = $_POST["comment_$entryId"];
	$comment['ip'] = $_SERVER['REMOTE_ADDR'];
	$result = addComment($blogid, $comment);
	if (in_array($result, array('ip', 'name', 'homepage', 'comment', 'openidonly', 'etc'))) {
		if ($result == 'openidonly') {
			$blockMessage = _text('You have to log in with and OpenID to leave a comment.');
		} else {
			$blockMessage = _textf('Blocked %1', $result);
		}
		printMobileErrorPage(_text('댓글 작성이 차단되었습니다.'), $blockMessage, "$blogURL/comment/$entryId");
	} else if ($result === false) {
		printMobileErrorPage(_text('댓글 작성 오류.'), _text('댓글을 작성할 수 없었습니다.'), "$blogURL/comment/$entryId");
	} else {
		setcookie('guestName', $comment['name'], time() + 2592000, $blogURL);
		setcookie('guestHomepage', $comment['homepage'], time() + 2592000, $blogURL);
		printMobileSimpleMessage(_text('댓글이 등록되었습니다.'), _text('댓글 페이지로 이동'), "$blogURL/comment/$entryId");
	}
}
?>
