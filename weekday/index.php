<?php
/*************************************************
 * ������s�X�N���v�g
 * 
 */

ini_set("include_path", "---Write here your PEAR directory---");
define('_ROOT_DIR',"---Write here your Root directory---");

require_once _ROOT_DIR . 'init.php';//init.php�ǂݍ���
$controller = new MemberController();//MemberController�N���X���g���Ƃ����錾
$controller->run();//���s

exit;


?>
