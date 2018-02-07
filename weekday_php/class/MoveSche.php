<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 送信するべきアドレスを移動するファイル。一時間で一回しか実行しない。一時間に２回以上実行すると、同じデータが重複して移動してしまうので注意。
 * 日付と「時」をもとに抽出、移動するため、実行時間は「時」が変わったあとの毎時間「1分」くらいがいいかも。
 */

/**
 * Description of MemberController
 *
 * @author nagatayorinobu
 */

//----------------------------------------------------
// データベース関連
//----------------------------------------------------

// データベース接続ユーザー名
define("_DB_USER", "---Write here your DB user name---");

// データベース接続パスワード
define("_DB_PASS", "---Write here your DB password---");

// データベースホスト名
define("_DB_HOST", "---Write here your DB host name---");

// データベース名
define("_DB_NAME", "---Write here your DB name---");

// データベースの種類
define("_DB_TYPE", "mysql");

// データソースネーム
define("_DSN", _DB_TYPE . ":host=" . _DB_HOST . ";dbname=" . _DB_NAME. ";charset=utf8");

//----------------------------------------------------
// ファイル設置ディレクトリ
//----------------------------------------------------
// 環境変数
define( "_SCRIPT_NAME", $_SERVER['SCRIPT_NAME']);

//----------------------------------------------------
// クラスファイルの読み込み
//----------------------------------------------------
//require_once( "BaseController.php");
require_once( "BaseModel.php");
require_once( "ScheModel.php");

//----------------------------------------------------
//日付初期設定
//----------------------------------------------------
$ScheModel = new ScheModel;
$day = date("Y-m-d");
$time = date("G");


/*　取得できた日付と時刻を確認するためのecho  
echo $day;
echo "<br>";
echo $time;
echo "<br>";
*/

//ken_messe1データ取得＆移動処理

$get_send_mail_ken_messe1 = $ScheModel->get_send_mail_ken_messe1($day,$time);//本日の日付と、現在の「時」の行を取得
$kensuu = count($get_send_mail_ken_messe1[0]);
$i = 0;
while($i < $kensuu){
	$id = $get_send_mail_ken_messe1[0][$i]["id"];
	$messe_No = $get_send_mail_ken_messe1[0][$i]["messe_No"];
	$text = $get_send_mail_ken_messe1[0][$i]["send_text"];
	$ScheModel->move_text($id,$messe_No,$text);
	
	$i = $i + 1;
}


//ken_messe2データ取得＆移動処理
$get_send_mail_ken_messe2 = $ScheModel->get_send_mail_ken_messe2($day,$time);//本日の日付と、現在の「時」の行を取得
$kensuu = count($get_send_mail_ken_messe2[0]);
$i = 0;
while($i < $kensuu){
	$id = $get_send_mail_ken_messe2[0][$i]["id"];
	$messe_No = $get_send_mail_ken_messe2[0][$i]["messe_No"];
	$text = $get_send_mail_ken_messe2[0][$i]["send_text"];
	$ScheModel->move_text($id,$messe_No,$text);
	
	$i = $i + 1;
}

//ken_messe3データ取得＆移動処理
$get_send_mail_ken_messe3 = $ScheModel->get_send_mail_ken_messe3($day,$time);//本日の日付と、現在の「時」の行を取得
$kensuu = count($get_send_mail_ken_messe3[0]);
$i = 0;
while($i < $kensuu){
	$id = $get_send_mail_ken_messe3[0][$i]["id"];
	$messe_No = $get_send_mail_ken_messe3[0][$i]["messe_No"];
	$text = $get_send_mail_ken_messe3[0][$i]["send_text"];
	$ScheModel->move_text($id,$messe_No,$text);

	$i = $i + 1;
}



?>