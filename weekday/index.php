<?php
/*************************************************
 * 会員実行スクリプト
 * 
 */

ini_set("include_path", "---Write here your PEAR directory---");
define('_ROOT_DIR',"---Write here your Root directory---");

require_once _ROOT_DIR . 'init.php';//init.php読み込み
$controller = new MemberController();//MemberControllerクラスを使うという宣言
$controller->run();//実行

exit;


?>
