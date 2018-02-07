<?php
/*************************************************
 * 会員本登録用スクリプト
 * メールで送信されたURLは、http://localhost/premember.php?～～となっているため、このファイルに最初アクセスされる。
 */

define('_ROOT_DIR', '---Write here your Root directory---');
require_once _ROOT_DIR . 'init.php';
$controller = new PrememberController();
$controller->run();

exit;


?>
