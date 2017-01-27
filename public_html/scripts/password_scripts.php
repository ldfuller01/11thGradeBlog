<?php
$passFile = fopen(dirname(__DIR__).'/access_pass.txt', 'r');
function encrypt($str) {
	$arr = array();
	for ($i = (strlen($str) - 1); $i >= 0; $i -= 1) {
		$sub = substr($str, $i);
		$newChar = ord($sub) - 2;
		$newStr = chr($newChar);
		array_push($arr, $newStr);
	}
	return implode($arr);
}
$encryptedPass = fread($passFile, filesize(dirname(__DIR__).'/access_pass.txt'));
function translate($str) {
	$arr = array();
	for ($i = (strlen($str) - 1); $i >= 0; $i -= 1) {
		$sub = substr($str, $i);
		$newChar = ord($sub) + 2;
		$newStr = chr($newChar);
		array_push($arr, $newStr);
	}
	return implode($arr);
}
$translatedPass = translate($encryptedPass);
function testPassword($returnURL, $userPassword, $getInfo = array()) {
	global $encryptedPass;
	global $translatedPass;
	$additionalGet = "";
	if (count($getInfo) > 0)
		foreach ($getInfo as $key => $val)
			$additionalGet = $additionalGet."&$key=$val";
	if (empty($userPassword)) {
		header("Location: $returnURL?error=password_empty".$additionalGet);
		exit;
	}
	if (empty($encryptedPass) || is_null($encryptedPass)) {
		header("Location: $returnURL?error=password_error".$additionalGet);
		exit;
	}
	if ($translatedPass !== $userPassword) {
		header("Location: $returnURL?error=password_incorrect".$additionalGet);
		exit;
	}
	return true;
}
fclose($passFile);
?>