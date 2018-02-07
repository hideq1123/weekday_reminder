<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * scheテーブルにあるデータに対してメールを送り、送信済みのデータは削除していく処理を実行するファイル。
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
require_once("Mail.php");

//----------------------------------------------------
// メール送信設定
//----------------------------------------------------
//日本語メールを送る際に必要
mb_language("Japanese");
mb_internal_encoding("UTF-8");
// GmailのSMTPサーバーの情報を連想配列にセット
    	$params = array(
    			"host" => "---Write here your SMTP server name ---",   // SMTPサーバー名
    			"port" => ,//---Write here port number ---              // ポート番号
    			"auth" => true,            // SMTP認証を使用する
    			"username" => "---Write here your SMTP user name ---",  // SMTPのユーザー名
    			"password" => "---Write here your SMTP password ---",   // SMTPのパスワード
    			"debug" => false,
    			"protocol"=>"SMTP_AUTH"
    	);
// PEAR::Mailのオブジェクトを作成
// ※バックエンドとしてSMTPを指定
$mailObject = Mail::factory("smtp", $params);
//----------------------------------------------------
//日付初期設定
//----------------------------------------------------
$ScheModel = new ScheModel;


//shceからのデータ取得＆送信処理
$check_sche = $ScheModel->check_sche();
if($check_sche == true){
	$get_sche = $ScheModel->get_sche();//scheから最大で５件まで取得。メールを１件送信する処理には時間がかかり、取得件数が多いと動作時間が30秒を超えてしまうため５件とした。
	
	$kensuu = count($get_sche[0]);
	$i = 0;
	while($i < $kensuu){
		$get_mail_address = $ScheModel->get_mail_address($get_sche[0][$i]["id"]);//get_scheのidとmemberのアドレスを関連させる
		$mail = $get_mail_address;
	
		$subject = $get_sche[0][$i]["send_text"];
		$subject_nagasa = mb_strlen($get_sche[0][$i]["send_text"]);
		if($subject_nagasa >= 8){//設定されたテキストを件名にするため、長い場合は切る
			$subject = mb_substr($subject, 0, 8)."・・・";
		}
		if($get_sche[0][$i]["send_text"] == null){//設定されたテキストが無い場合はこっち側で設定
			$subject = "リマインダーが送信されました";
			$get_sche[0][$i]["send_text"] = "このリマインダーの内容は入力されていません。";
		}else{
			$subject = $subject."のリマインダーです";
		}
	
		//----------------------------------------------------
		// メール送信処理
		//----------------------------------------------------
		$message =<<<EOM
ウィークデーリマインダーから、あなたが設定したリマインダーが届きました。
リマインダーの内容は以下の通りです。

「{$get_sche[0][$i]["send_text"]}」

リマインダーを修正、編集するにはトップページよりログインして下さい。

-----
ウィークデーリマインダー
http://mossgreen.main.jp/weekday/
		
EOM;
// メールヘッダ情報を連想配列としてセット
		$headers = array(
				"To" => $mail,         // →ここで指定したアドレスには送信されない
				"From" => "---Write here your mail adress ---",
				"Subject" => mb_encode_mimeheader($subject) //日本語の件名を指定する場合、mb_encode_mimeheaderでエンコード
		);
		// 日本語なのでエンコード
		$message = mb_convert_encoding($message, "ISO-2022-JP", "UTF-8");
		// sendメソッドでメールを送信
		$mailObject->send($mail, $headers, $message);
	
		//送信したデータの削除処理
		$id = $get_sche[0][$i]["id"];
		$messe_No = $get_sche[0][$i]["messe_No"];
		$ScheModel->delete_sche($id,$messe_No);
	
		echo "<br>";
		echo $mail;
		echo "<br>";
		echo $subject;
		$i = $i + 1;
		}
		
}


	
	
	


?>