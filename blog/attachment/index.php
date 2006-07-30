<?php
define('ROOT', '../..');
require ROOT . '/lib/include.php';
if (empty($suri['value']))
	respondNotFoundPage();
if (!$attachment = getAttachmentByOnlyName($owner, $suri['value']))
	respondNotFoundPage();
$fp = fopen(ROOT . "/attach/$owner/{$attachment['name']}", 'rb');
if (!$fp)
	respondNotFoundPage();
$fstat = fstat($fp);
if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
	$modifiedSince = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
	if ($modifiedSince && ($modifiedSince >= $fstat['mtime'])) {
		fclose($fp);
		header('HTTP/1.1 304 Not Modified');
		header('Connection: close');
		exit;
	}
}

ini_set('zlib.output_compression', 'off');
header('Content-Disposition: attachment; filename="' . UTF8::convert($attachment['label']) . '"');
header('Content-Transfer-Encoding: binary');
header('Last-Modified: ' . Timestamp::getRFC1123GMT($fstat['mtime']));
header('Content-Length: ' . $fstat['size']);
header('Content-Type: ' . $attachment['mime']);
header('Connection: close');
fpassthru($fp);
fclose($fp);
downloadAttachment($attachment['name']);
?>