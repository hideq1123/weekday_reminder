<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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
// 初期設定
//----------------------------------------------------
$ScheModel = new ScheModel;
$holiday = "---Write here annual holiday ---/2016-12-23/2017-01-01/2017-01-02/2017-01-09/2017-02-11/2017-03-20/2017-04-29/2017-05-03/2017-05-04/2017-05-05/2017-07-17/2017-08-11/2017-09-18/2017-09-23/2017-10-09/2017-11-03/2017-11-23/2017-12-23/";//年間の全ての祝日をここに設定する。「"」の次にある、一文字目の「/」だけは削除してはダメ。月、及び日付は一桁のものは二桁にする。
$year = date("Y");
$day = date("d");
$month = date("m");
$int_day = (int)$day;//日にちが一桁の場合、最初の0を消す
//$int_day = 25;
$int_month = (int)$month;//月が一桁の場合、最初の0を消す


//----------------------------------------------------
// 今月分の日付セット処理開始
//----------------------------------------------------

$get_kongetu_data = $ScheModel->get_kongetu_data(1);//このファイル実行日以降のものしか更新しない場合、ユーザーが、二回目以降設定した日付が実行日以前だったら、一回目のスケジュールが
//set_senddayに残ってしまう。なので、あるものは全て更新するようにする。
$kensuu = count($get_kongetu_data[0]);//取得できた行の数
$i = 0;
while($i < $kensuu){
	switch($get_kongetu_data[0][$i]["sendday_option"]){
		case 0://ユーザーが指定した日付が祝日だったとき
			$toujitsu = $get_kongetu_data[0][$i]["set_sendday"];
			$modify_toujitsu = sprintf("%02d", $toujitsu);
			$check_day = $year."-".$month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
			$modify_month = sprintf("%02d", $month);
			$set_week = $year.$modify_month.$modify_toujitsu;
			$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
			list($Y, $m, $d) = explode('-', $check_day);
			if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
				$date = "ok";
			}else{
				$date = "";
			}
			if(strpos($holiday, $check_day) !== false && $week != 0 && $week != 6 && $date != null){//セットされた日付が実際に祝日であり、且つ土日ではない、且つカレンダー上に存在する日付のときここのカッコへ入る
				switch($get_kongetu_data[0][$i]["send_timing"]){//送信日をセット
					case 0://当日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$sendday = $year."-".$month."-".$num;
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 1://前日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('-1 day', $kijun_day));//前日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 2://前営業日
						if ($get_kongetu_data[0][$i]["set_sendday"] >= 8){//セットされてた日にちが８日以降だった時。７日以前は、来月の処理でセットするようにする。
							$minus_day = 0;
							$kaiten = 15;
							while ($kaiten != 0){
								$minus_day = $minus_day + 1;
								$before_day = $get_kongetu_data[0][$i]["set_sendday"] - $minus_day;
								$num_minus = sprintf("%02d", $before_day);
								$check_day = $year."-".$month."-".$num_minus;//祝日かどうかのチェックをするためのもの
								$kijun_week = $year.$month.$num_minus;
								$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
								if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
									$kaiten = 1;
									$set_minus_day = "-".$minus_day." day";
								}
								$kaiten = $kaiten - 1;
							}
							$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
							$kijun_day = strtotime($year."-".$month."-".$num);
							$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
							$id = $get_kongetu_data[0][$i]["id"];
							$messe_no = $get_kongetu_data[0][$i]["messe_No"];
							$ScheModel->input_sendday($id,$messe_no,$sendday);
						}
						break;
					case 3://翌日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('+1 day', $kijun_day));//翌日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 4://翌営業日
							$plus_day = 0;
							$kaiten = 15;
							while ($kaiten != 0){
								$plus_day = $plus_day + 1;
								$after_day = $get_kongetu_data[0][$i]["set_sendday"] + $plus_day;
								$num_plus = sprintf("%02d", $after_day);
								$check_day = $year."-".$month."-".$num_plus;//祝日かどうかのチェックをするためのもの
								$kijun_week = $year.$month.$num_plus;
								$week = date('w', strtotime($kijun_week));//プラスした日付の曜日
								if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//プラスした日付が祝日じゃなかった時、且つプラスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
									$kaiten = 1;
									$set_plus_day = "+".$plus_day." day";
								}
								$kaiten = $kaiten - 1;
							}
							$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
							$kijun_day = strtotime($year."-".$month."-".$num);
							$sendday = date('Y-m-d',strtotime($set_plus_day, $kijun_day));
							$id = $get_kongetu_data[0][$i]["id"];
							$messe_no = $get_kongetu_data[0][$i]["messe_No"];
							$ScheModel->input_sendday($id,$messe_no,$sendday);
						
						break;
					default:
						break;
				}
			}//sendday_optionが祝日だった時の処理ここまで
			break;
		case 1://ユーザーが指定した日付が土曜だった時
			$toujitsu = $get_kongetu_data[0][$i]["set_sendday"];
			$modify_toujitsu = sprintf("%02d", $toujitsu);
			$check_day = $year."-".$month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
			$modify_month = sprintf("%02d", $month);
			$set_week = $year.$modify_month.$modify_toujitsu;
			$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
			list($Y, $m, $d) = explode('-', $check_day);
			if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
				$date = "ok";
			}else{
				$date = "";
			}
			if($week == 6 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
				switch($get_kongetu_data[0][$i]["send_timing"]){//送信日をセット
					case 0://当日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$sendday = $year."-".$month."-".$num;
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 1://前日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('-1 day', $kijun_day));//前日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 2://前営業日
						if ($get_kongetu_data[0][$i]["set_sendday"] >= 8){//セットされてた日にちが８日以降だった時。７日以前は、来月の処理でセットするようにする。
							$minus_day = 0;
							$kaiten = 15;
							while ($kaiten != 0){
								$minus_day = $minus_day + 1;
								$before_day = $get_kongetu_data[0][$i]["set_sendday"] - $minus_day;
								$num_minus = sprintf("%02d", $before_day);
								$check_day = $year."-".$month."-".$num_minus;//祝日かどうかのチェックをするためのもの
								$kijun_week = $year.$month.$num_minus;
								$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
								if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
									$kaiten = 1;
									$set_minus_day = "-".$minus_day." day";
								}
								$kaiten = $kaiten - 1;
							}
							$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
							$kijun_day = strtotime($year."-".$month."-".$num);
							$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
							$id = $get_kongetu_data[0][$i]["id"];
							$messe_no = $get_kongetu_data[0][$i]["messe_No"];
							$ScheModel->input_sendday($id,$messe_no,$sendday);
						}
						break;
					case 3://翌日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('+1 day', $kijun_day));//翌日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 4://翌営業日
						$plus_day = 0;
						$kaiten = 15;
						while ($kaiten != 0){
							$plus_day = $plus_day + 1;
							$after_day = $get_kongetu_data[0][$i]["set_sendday"] + $plus_day;
							$num_plus = sprintf("%02d", $after_day);
							$check_day = $year."-".$month."-".$num_plus;//祝日かどうかのチェックをするためのもの
							$kijun_week = $year.$month.$num_plus;
							$week = date('w', strtotime($kijun_week));//プラスした日付の曜日
							if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//プラスした日付が祝日じゃなかった時、且つプラスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
								$kaiten = 1;
								$set_plus_day = "+".$plus_day." day";
							}
							$kaiten = $kaiten - 1;
						}
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime($set_plus_day, $kijun_day));
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					default:
						break;
				}
			}
			
			break;
		case 2://ユーザーが指定した日付が日曜だったとき
			$toujitsu = $get_kongetu_data[0][$i]["set_sendday"];
			$modify_toujitsu = sprintf("%02d", $toujitsu);
			$check_day = $year."-".$month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
			$modify_month = sprintf("%02d", $month);
			$set_week = $year.$modify_month.$modify_toujitsu;
			$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
			list($Y, $m, $d) = explode('-', $check_day);
			if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
				$date = "ok";
			}else{
				$date = "";
			}
			if($week == 0 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
				switch($get_kongetu_data[0][$i]["send_timing"]){//送信日をセット
					case 0://当日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$sendday = $year."-".$month."-".$num;
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 1://前日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('-1 day', $kijun_day));//前日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 2://前営業日
						if ($get_kongetu_data[0][$i]["set_sendday"] >= 8){//セットされてた日にちが８日以降だった時。７日以前は、来月の処理でセットするようにする。
							$minus_day = 0;
							$kaiten = 15;
							while ($kaiten != 0){
								$minus_day = $minus_day + 1;
								$before_day = $get_kongetu_data[0][$i]["set_sendday"] - $minus_day;
								$num_minus = sprintf("%02d", $before_day);
								$check_day = $year."-".$month."-".$num_minus;//祝日かどうかのチェックをするためのもの
								$kijun_week = $year.$month.$num_minus;
								$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
								if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
									$kaiten = 1;
									$set_minus_day = "-".$minus_day." day";
								}
								$kaiten = $kaiten - 1;
							}
							$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
							$kijun_day = strtotime($year."-".$month."-".$num);
							$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
							$id = $get_kongetu_data[0][$i]["id"];
							$messe_no = $get_kongetu_data[0][$i]["messe_No"];
							$ScheModel->input_sendday($id,$messe_no,$sendday);
						}
						break;
					case 3://翌日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('+1 day', $kijun_day));//翌日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 4://翌営業日
						$plus_day = 0;
						$kaiten = 15;
						while ($kaiten != 0){
							$plus_day = $plus_day + 1;
							$after_day = $get_kongetu_data[0][$i]["set_sendday"] + $plus_day;
							$num_plus = sprintf("%02d", $after_day);
							$check_day = $year."-".$month."-".$num_plus;//祝日かどうかのチェックをするためのもの
							$kijun_week = $year.$month.$num_plus;
							$week = date('w', strtotime($kijun_week));//プラスした日付の曜日
							if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//プラスした日付が祝日じゃなかった時、且つプラスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
								$kaiten = 1;
								$set_plus_day = "+".$plus_day." day";
							}
							$kaiten = $kaiten - 1;
						}
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime($set_plus_day, $kijun_day));
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					default:
						break;
				}
			}
			break;
		case 3://ユーザーが指定した日付が土日祝だったとき
			$toujitsu = $get_kongetu_data[0][$i]["set_sendday"];
			$modify_toujitsu = sprintf("%02d", $toujitsu);
			$check_day = $year."-".$month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
			$modify_month = sprintf("%02d", $month);
			$set_week = $year.$modify_month.$modify_toujitsu;
			$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
			list($Y, $m, $d) = explode('-', $check_day);
			if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
				$date = "ok";
			}else{
				$date = "";
			}
			if(strpos($holiday, $check_day) !== false || $week == 0 || $week == 6 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
				switch($get_kongetu_data[0][$i]["send_timing"]){//送信日をセット
					case 0://当日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$sendday = $year."-".$month."-".$num;
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 1://前日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('-1 day', $kijun_day));//前日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 2://前営業日
						if ($get_kongetu_data[0][$i]["set_sendday"] >= 8){//セットされてた日にちが８日以降だった時。７日以前は、来月の処理でセットするようにする。
							$minus_day = 0;
							$kaiten = 15;
							while ($kaiten != 0){
								$minus_day = $minus_day + 1;
								$before_day = $get_kongetu_data[0][$i]["set_sendday"] - $minus_day;
								$num_minus = sprintf("%02d", $before_day);
								$check_day = $year."-".$month."-".$num_minus;//祝日かどうかのチェックをするためのもの
								$kijun_week = $year.$month.$num_minus;
								$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
								if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
									$kaiten = 1;
									$set_minus_day = "-".$minus_day." day";
								}
								$kaiten = $kaiten - 1;
							}
							$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
							$kijun_day = strtotime($year."-".$month."-".$num);
							$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
							$id = $get_kongetu_data[0][$i]["id"];
							$messe_no = $get_kongetu_data[0][$i]["messe_No"];
							$ScheModel->input_sendday($id,$messe_no,$sendday);
						}
						break;
					case 3://翌日
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime('+1 day', $kijun_day));//翌日に設定
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					case 4://翌営業日
						$plus_day = 0;
						$kaiten = 15;
						while ($kaiten != 0){
							$plus_day = $plus_day + 1;
							$after_day = $get_kongetu_data[0][$i]["set_sendday"] + $plus_day;
							$num_plus = sprintf("%02d", $after_day);
							$check_day = $year."-".$month."-".$num_plus;//祝日かどうかのチェックをするためのもの
							$kijun_week = $year.$month.$num_plus;
							$week = date('w', strtotime($kijun_week));//プラスした日付の曜日
							if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//プラスした日付が祝日じゃなかった時、且つプラスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
								$kaiten = 1;
								$set_plus_day = "+".$plus_day." day";
							}
							$kaiten = $kaiten - 1;
						}
						$num = sprintf("%02d", $get_kongetu_data[0][$i]["set_sendday"]);
						$kijun_day = strtotime($year."-".$month."-".$num);
						$sendday = date('Y-m-d',strtotime($set_plus_day, $kijun_day));
						$id = $get_kongetu_data[0][$i]["id"];
						$messe_no = $get_kongetu_data[0][$i]["messe_No"];
						$ScheModel->input_sendday($id,$messe_no,$sendday);
						break;
					default:
						break;
				}
			}
			break;
		default:
			break;
	}
	
	$i = $i + 1;
}//今月分の日付セット処理終了

//----------------------------------------------------
// 来月分の日付セット処理開始(タイミングが前営業日（２）のやつのみセット)、このファイルを実行するのが、24日～31日のときのみ動作
//----------------------------------------------------
if($int_day >= 24){//このファイルを実行するのが、24日～31日のとき
	$get_raigetu_data = $ScheModel->get_raigetu_data(7,2);//ユーザーがセットした日付が7日以前、かつタイミングが前営業日のもののみ取得
	$kensuu = count($get_raigetu_data[0]);//取得できた行の数
	$i = 0;
	while($i < $kensuu){
		switch($get_raigetu_data[0][$i]["sendday_option"]){
			case 0://ユーザーが指定した日付が祝日だったとき
				$toujitsu = $get_raigetu_data[0][$i]["set_sendday"];
				$modify_toujitsu = sprintf("%02d", $toujitsu);
				$month = $month + 1;//来月分の曜日を確認するため、月を来月にする
				$modify_month = sprintf("%02d", $month);
				$check_day = $year."-".$modify_month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
				$set_week = $year.$modify_month.$modify_toujitsu;
				$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
				list($Y, $m, $d) = explode('-', $check_day);
				if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
					$date = "ok";
				}else{
					$date = "";
				}
				if(strpos($holiday, $check_day) !== false && $week != 0 && $week != 6 && $date != null){//セットされた日付が実際に祝日であり、且つ土日ではない、且つカレンダー上に存在する日付のときここのカッコへ入る
								$minus_day = 0;
								$kaiten = 15;
								while ($kaiten != 0){
									$minus_day = $minus_day + 1;
									$before_day = $get_raigetu_data[0][$i]["set_sendday"] - $minus_day;
									$num_minus = sprintf("%02d", $before_day);
									$check_day = $year."-".$modify_month."-".$num_minus;//祝日かどうかのチェックをするためのもの
									$kijun_week = $year.$month.$num_minus;
									$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
									if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
										$kaiten = 1;
										$set_minus_day = "-".$minus_day." day";
									}
									$kaiten = $kaiten - 1;
								}
								$num = sprintf("%02d", $get_raigetu_data[0][$i]["set_sendday"]);
								$kijun_day = strtotime($year."-".$month."-".$num);
								$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
								$id = $get_raigetu_data[0][$i]["id"];
								$messe_no = $get_raigetu_data[0][$i]["messe_No"];
								$ScheModel->input_sendday($id,$messe_no,$sendday);
				}//sendday_optionが祝日だった時の処理ここまで
				$month = $month - 1;//来月分にしたやつを一旦戻さないと、行があるごとに月がどんどん進んでしまうため、戻す。
				break;
			case 1://ユーザーが指定した日付が土曜だった時
				$toujitsu = $get_raigetu_data[0][$i]["set_sendday"];
				$modify_toujitsu = sprintf("%02d", $toujitsu);
				$month = $month + 1;//来月分の曜日を確認するため、月を来月にする
				$modify_month = sprintf("%02d", $month);
				$check_day = $year."-".$modify_month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
				$set_week = $year.$modify_month.$modify_toujitsu;
				$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
				list($Y, $m, $d) = explode('-', $check_day);
				if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
					$date = "ok";
				}else{
					$date = "";
				}
				if($week == 6 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
								$minus_day = 0;
								$kaiten = 15;
								while ($kaiten != 0){
									$minus_day = $minus_day + 1;
									$before_day = $get_raigetu_data[0][$i]["set_sendday"] - $minus_day;
									$num_minus = sprintf("%02d", $before_day);
									$check_day = $year."-".$modify_month."-".$num_minus;//祝日かどうかのチェックをするためのもの
									$kijun_week = $year.$month.$num_minus;
									$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
									if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
										$kaiten = 1;
										$set_minus_day = "-".$minus_day." day";
									}
									$kaiten = $kaiten - 1;
								}
								$num = sprintf("%02d", $get_raigetu_data[0][$i]["set_sendday"]);
								$kijun_day = strtotime($year."-".$month."-".$num);
								$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
								$id = $get_raigetu_data[0][$i]["id"];
								$messe_no = $get_raigetu_data[0][$i]["messe_No"];
								$ScheModel->input_sendday($id,$messe_no,$sendday);

				}
				$month = $month - 1;//来月分にしたやつを一旦戻さないと、行があるごとに月がどんどん進んでしまうため、戻す。
				break;
			case 2://ユーザーが指定した日付が日曜だったとき
				$toujitsu = $get_raigetu_data[0][$i]["set_sendday"];
				$modify_toujitsu = sprintf("%02d", $toujitsu);
				$month = $month + 1;//来月分の曜日を確認するため、月を来月にする
				$modify_month = sprintf("%02d", $month);
				$check_day = $year."-".$modify_month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
				$set_week = $year.$modify_month.$modify_toujitsu;
				$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
				list($Y, $m, $d) = explode('-', $check_day);
				if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
					$date = "ok";
				}else{
					$date = "";
				}
				if($week == 0 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
								$minus_day = 0;
								$kaiten = 15;
								while ($kaiten != 0){
									$minus_day = $minus_day + 1;
									$before_day = $get_raigetu_data[0][$i]["set_sendday"] - $minus_day;
									$num_minus = sprintf("%02d", $before_day);
									$check_day = $year."-".$modify_month."-".$num_minus;//祝日かどうかのチェックをするためのもの
									$kijun_week = $year.$month.$num_minus;
									$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
									if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
										$kaiten = 1;
										$set_minus_day = "-".$minus_day." day";
									}
									$kaiten = $kaiten - 1;
								}
								$num = sprintf("%02d", $get_raigetu_data[0][$i]["set_sendday"]);
								$kijun_day = strtotime($year."-".$month."-".$num);
								$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
								$id = $get_raigetu_data[0][$i]["id"];
								$messe_no = $get_raigetu_data[0][$i]["messe_No"];
								$ScheModel->input_sendday($id,$messe_no,$sendday);
				}
				$month = $month - 1;
				break;
			case 3://ユーザーが指定した日付が土日祝だったとき
				$toujitsu = $get_raigetu_data[0][$i]["set_sendday"];
				$modify_toujitsu = sprintf("%02d", $toujitsu);
				$month = $month + 1;//来月分の曜日を確認するため、月を来月にする
				$modify_month = sprintf("%02d", $month);
				$check_day = $year."-".$modify_month."-".$modify_toujitsu;//祝日かどうかのチェックをするためのもの
				$set_week = $year.$modify_month.$modify_toujitsu;
				$week = date('w', strtotime($set_week));//セットされた日付の曜日を取得
				list($Y, $m, $d) = explode('-', $check_day);
				if (checkdate($m, $d, $Y) === true){//カレンダー上に存在する日付かどうかをチェック。例えば毎月31日に設定してる人がいたとして、31日が無い月に、このcheckdateを通さないと、$kijun_dayが翌月の1日になってしまう。
					$date = "ok";
				}else{
					$date = "";
				}
				if(strpos($holiday, $check_day) !== false || $week == 0 || $week == 6 && $date != null){//セットされた日付が実際に土曜であり、且つカレンダー上に存在する日付のときここのカッコへ入る
								$minus_day = 0;
								$kaiten = 15;
								while ($kaiten != 0){
									$minus_day = $minus_day + 1;
									$before_day = $get_raigetu_data[0][$i]["set_sendday"] - $minus_day;
									$num_minus = sprintf("%02d", $before_day);
									$check_day = $year."-".$modify_month."-".$num_minus;//祝日かどうかのチェックをするためのもの
									$kijun_week = $year.$month.$num_minus;
									$week = date('w', strtotime($kijun_week));//マイナスした日付の曜日
									if(strpos($holiday,$check_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
										$kaiten = 1;
										$set_minus_day = "-".$minus_day." day";
									}
									$kaiten = $kaiten - 1;
								}
								$num = sprintf("%02d", $get_raigetu_data[0][$i]["set_sendday"]);
								$kijun_day = strtotime($year."-".$month."-".$num);
								$sendday = date('Y-m-d',strtotime($set_minus_day, $kijun_day));
								$id = $get_raigetu_data[0][$i]["id"];
								$messe_no = $get_raigetu_data[0][$i]["messe_No"];
								$ScheModel->input_sendday($id,$messe_no,$sendday);
				}
				$month = $month - 1;
				break;
			default:
				break;
		}
		
		$i = $i + 1;
	}

}//来月分の日付セット処理終了

unset($get_kongetu_data[0]);//変数の内容を解放する
if(isset($get_raigetu_data)){
	unset($get_raigetu_data[0]);//変数の内容を解放する
}
//print var_dump($get_raigetu_data);

//----------------------------------------------------
// 曜日をもとに、祝日をトリガーとして送信する日を決定、インプットする処理(set_senddayが７のもの以外)
//----------------------------------------------------
$i = 0;
while($i <= 6){
	$modify_month = sprintf("%02d", $month);
	$kijun_day = strtotime($year."-".$modify_month."-".$day);//今日の日付
	$set_plus_day = "+".$i." day";
	$shukujitu = date('Y-m-d',strtotime($set_plus_day, $kijun_day));//このファイルを実行する日から、一週間分先の日付を取得。日本の祝日は６日以上連続するものはまず無いため、これでよしとする
	if(strpos($holiday, $shukujitu) !== false){//一週間以内に祝日がある場合
		$set_shukujitu[] = $shukujitu;
		$youbi_get = date('w', strtotime($shukujitu));
		$youbi2 = (int)$youbi_get;//日付型はそのままだと配列のデータにならない？(int)で整数データに変換するらしい。(string)とかでも可
		$youbi[] = $youbi2;
	}
$i = $i + 1;
}

if (isset($set_shukujitu)) {//一週間以内に祝日がある時の処理
	$holiday_count = count($youbi);
	$i = 0;
	while($i < $holiday_count){//一週間以内にある祝日の数の分、繰り返す処理
		$get_ken_messe2_week = $ScheModel->get_ken_messe2_week($youbi[$i]);//７以外の祝日となる曜日を抽出。複数日ある場合は複数回繰り返される
		$kensuu = $ScheModel->count_ken_messe2_week($youbi[$i]);
		$ii = 0;
			while($ii < $kensuu){//曜日一個の検索でヒットした行全てに対しての繰り返し処理
				switch($get_ken_messe2_week[0][$ii]["send_timing"]){
					case 0://当日に送信する
						$id = $get_ken_messe2_week[0][$ii]["id"];
						$messe_no = $get_ken_messe2_week[0][$ii]["messe_No"];
						$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$set_shukujitu[$i]);//$set_shukujituは、$holiday_countと連動しているので$iである
						break;
					case 1://前日に送信する
						$day_tmp = date('Y-m-d',strtotime($set_shukujitu[$i]." - 1 day"));
						$id = $get_ken_messe2_week[0][$ii]["id"];
						$messe_no = $get_ken_messe2_week[0][$ii]["messe_No"];
						$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
						break;
					case 2://前営業日に送信する
						$minus_day = 0;
						$kaiten = 10;
						while ($kaiten != 0){
							$minus_day = $minus_day + 1;
							$str = " - ".$minus_day." day";
							$before_day = date('Y-m-d',strtotime($set_shukujitu[$i].$str));
							$week = date('w', strtotime($before_day));//マイナスした日付の曜日
							if(strpos($holiday,$before_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
								$kaiten = 1;
								$set_minus_day = " -".$minus_day." day";
							}
							$kaiten = $kaiten - 1;
						}
						$day_tmp = date('Y-m-d',strtotime($set_shukujitu[$i] .$set_minus_day));
						$id = $get_ken_messe2_week[0][$ii]["id"];
						$messe_no = $get_ken_messe2_week[0][$ii]["messe_No"];
						$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
						break;
					case 3://翌日に送信する
						$day_tmp = date('Y-m-d',strtotime($set_shukujitu[$i]." + 1 day"));
						$id = $get_ken_messe2_week[0][$ii]["id"];
						$messe_no = $get_ken_messe2_week[0][$ii]["messe_No"];
						$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
						break;
					case 4://翌営業日に送信する
						$plus_day = 0;
						$kaiten = 10;
						while ($kaiten != 0){
							$plus_day = $plus_day + 1;
							$str = " + ".$plus_day." day";
							$before_day = date('Y-m-d',strtotime($set_shukujitu[$i].$str));
							$week = date('w', strtotime($before_day));//プラスした日付の曜日
							if(strpos($holiday,$before_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
								$kaiten = 1;
								$set_plus_day = " +".$plus_day." day";
							}
							$kaiten = $kaiten - 1;
						}
						$day_tmp = date('Y-m-d',strtotime($set_shukujitu[$i] .$set_plus_day));
						$id = $get_ken_messe2_week[0][$ii]["id"];
						$messe_no = $get_ken_messe2_week[0][$ii]["messe_No"];
						$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
						break;
					default:
						break;
				}
				$ii = $ii + 1;
			}
	unset($get_ken_messe2_week[0]);//変数の内容を解放する
	$i = $i + 1;
	}
	
	// ここからはset_senddayが７のものだけ取り出して送信日を決定、インプットする処理
	
	$get_ken_messe2_week = $ScheModel->get_ken_messe2_week(7);//set_sendday部の７のみを抽出。
	$kensuu = $ScheModel->count_ken_messe2_week(7);
	$ii7 = 0;
	while($ii7 < $kensuu){//曜日一個の検索でヒットした行全てに対しての繰り返し処理
		switch($get_ken_messe2_week[0][$ii7]["send_timing"]){
			case 0://当日に送信する
				$id = $get_ken_messe2_week[0][$ii7]["id"];
				$messe_no = $get_ken_messe2_week[0][$ii7]["messe_No"];
				$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$set_shukujitu[0]);
				//set_senddayが７以外のものは、一週間以内に複数の祝日があっても、セットすべき日にちは１個だけである。(一週間のうち同じ曜日は無いので)
				//対して、set_senddayが７の場合は、一週間以内にある複数の祝日が全て対象となる。そのため、$set_shukujitu[]に入った一番最初の日にちである、$set_shukujitu[0]をセットする事になる。
				break;
			case 1://前日に送信する
				$day_tmp = date('Y-m-d',strtotime($set_shukujitu[0]." - 1 day"));
				$id = $get_ken_messe2_week[0][$ii7]["id"];
				$messe_no = $get_ken_messe2_week[0][$ii7]["messe_No"];
				$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
				break;
			case 2://前営業日に送信する
				$minus_day = 0;
				$kaiten = 10;
				while ($kaiten != 0){
					$minus_day = $minus_day + 1;
					$str = " - ".$minus_day." day";
					$before_day = date('Y-m-d',strtotime($set_shukujitu[0].$str));
					$week = date('w', strtotime($before_day));//マイナスした日付の曜日
					if(strpos($holiday,$before_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
						$kaiten = 1;
						$set_minus_day = " -".$minus_day." day";
					}
					$kaiten = $kaiten - 1;
				}
				$day_tmp = date('Y-m-d',strtotime($set_shukujitu[0] .$set_minus_day));
				$id = $get_ken_messe2_week[0][$ii7]["id"];
				$messe_no = $get_ken_messe2_week[0][$ii7]["messe_No"];
				$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
				break;
			case 3://翌日に送信する
				$day_tmp = date('Y-m-d',strtotime($set_shukujitu[0]." + 1 day"));
				$id = $get_ken_messe2_week[0][$ii7]["id"];
				$messe_no = $get_ken_messe2_week[0][$ii7]["messe_No"];
				$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
				break;
			case 4://翌営業日に送信する
				$plus_day = 0;
				$kaiten = 10;
				while ($kaiten != 0){
					$plus_day = $plus_day + 1;
					$str = " + ".$plus_day." day";
					$before_day = date('Y-m-d',strtotime($set_shukujitu[0].$str));
					$week = date('w', strtotime($before_day));//プラスした日付の曜日
					if(strpos($holiday,$before_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
						$kaiten = 1;
						$set_plus_day = " +".$plus_day." day";
					}
					$kaiten = $kaiten - 1;
				}
				$day_tmp = date('Y-m-d',strtotime($set_shukujitu[0] .$set_plus_day));
				$id = $get_ken_messe2_week[0][$ii7]["id"];
				$messe_no = $get_ken_messe2_week[0][$ii7]["messe_No"];
				$ScheModel->input_sendday_to_ken_messe2($id,$messe_no,$day_tmp);
				break;
			default:
				break;
		}
		$ii7 = $ii7 + 1;
	}
	unset($get_ken_messe2_week[0]);//変数の内容を解放する
}
unset($set_shukujitu);
unset($youbi);


//----------------------------------------------------
// 営業日をトリガーとして送信する日を決定、インプットする処理
//----------------------------------------------------

//まずは最終営業日をセットする処理
$get_final_eigyoubi = $ScheModel->get_final_eigyoubi(0);//最終営業日に設定してある行のデータを取得
$final_day = date('Y-m-t');//今月の最終日(最終営業日ではない)
$kensuu = count($get_final_eigyoubi[0]);
$final_day_youbi = date('w', strtotime($final_day));//最終日の曜日
$i = 0;
while($i < $kensuu){//取得できた行の数だけ回す処理
	if(strpos($holiday,$final_day) == false && $final_day_youbi != 0 && $final_day_youbi != 6){//最終日が祝日ではない、且つ土日ではない時は取得した最終日をそのまま挿入
		$id = $get_final_eigyoubi[0][$i]["id"];
		$messe_no = $get_final_eigyoubi[0][$i]["messe_No"];
		$ScheModel->input_sendday_to_ken_messe3($id,$messe_no,$final_day);
	}else{//最終日が祝日、または土日の時は、営業日になるまで日数を引いて日付を挿入
		$minus_day = 0;
		$kaiten = 10;
		while ($kaiten != 0){
			$minus_day = $minus_day + 1;
			$str = " - ".$minus_day." day";
			$before_day = date('Y-m-d',strtotime($final_day.$str));
			$week = date('w', strtotime($before_day));//マイナスした日付の曜日
			if(strpos($holiday,$before_day) == false && $week != 0 && $week != 6){//マイナスした日付が祝日じゃなかった時、且つマイナスした日付が土日ではない時ここのカッコへ入り、whileが止まる。
				$kaiten = 1;
				$set_minus_day = " - ".$minus_day." day";
			}
			$kaiten = $kaiten - 1;
		}
		$day_tmp = date('Y-m-d',strtotime($final_day .$set_minus_day));
		$id = $get_final_eigyoubi[0][$i]["id"];
		$messe_no = $get_final_eigyoubi[0][$i]["messe_No"];
		$ScheModel->input_sendday_to_ken_messe3($id,$messe_no,$day_tmp);
	}
	$i = $i + 1;
}
unset($get_final_eigyoubi[0]);//変数の内容を解放する
//最終営業日をセットする処理終了


//ここからは、月初から数える営業日をセットする処理

$start_day = date("Y-m-01");//今月の一日
//$start_day = date("2026-09-01");
$get_send_timing = $ScheModel->get_send_timing();//set_senddayが０のもの、つまり月初から数える設定のものだけを取得
$kensuu = count($get_send_timing[0]);
$i = 0;
while($i < $kensuu){//一行ずつ実行していく
	$set_eigyoubi = $get_send_timing[0][$i]["send_timing"];
	$modify_send_timing = sprintf("%02d", $get_send_timing[0][$i]["send_timing"]);
	$count_holiday = 0;
	$find_holiday = -1;
	$set_eigyoubi = $set_eigyoubi - 1;
	while($find_holiday != $set_eigyoubi){
		$find_holiday = $find_holiday + 1;
		$set_plus_day = " + ".$find_holiday." day";
		$check_day = date('Y-m-d',strtotime($start_day.$set_plus_day));
		$week = date('w', strtotime($check_day));
		if(strpos($holiday,$check_day) !== false){//祝日に含まれる
			if($week != 0 && $week != 6){//土曜でもなければ日曜でもない
				$count_holiday = $count_holiday + 1;
			}
		}
		if($week == 0 || $week == 6){//土曜または日曜だったとき。祝日と重なってもカウントは１プラスされるだけだから問題はない
			$count_holiday = $count_holiday + 1;
		}
	}
	$shift_day = $count_holiday + $set_eigyoubi;//$set_eigyoubiは、元々-1になってるからそのまま足す。カレンダー的な計算。
	$check_day = date('Y-m-d',strtotime($start_day." + ".$shift_day." day"));//指定の日付に土日祝が足された日付ができあがる

	
	//↓ここからは、指定した日付までにあった「土日祝の日数分、移動した間にあった土日祝の数をカウントして足している」
	$set_eigyoubi = $set_eigyoubi + 1;
	$shift_count = 0;
	while($shift_count < $count_holiday){
		$plus = $shift_count + $set_eigyoubi;
		$check_day = date('Y-m-d',strtotime($start_day." + ".$plus." day"));
		$check_week = date('w', strtotime($check_day));
		if(strpos($holiday,$check_day) !== false){//祝日に含まれる
			if($check_week != 0 && $check_week != 6){//土曜でもなければ日曜でもない
				$count_holiday = $count_holiday + 1;
			}
		}
		if($check_week == 0 || $check_week == 6){//土曜または日曜が祝日と重なってもカウントは１プラスされるだけだから問題はない
			$count_holiday = $count_holiday + 1;
		}
		
		$shift_count = $shift_count + 1;
	}
	
	//決定した送信日付が、翌月になってしまった場合は、過去の日付を設定して、メールを送信しないようにする
	$check_month = date('m',strtotime($check_day));
	$check_year = date('Y',strtotime($check_day));
	if($year == $check_year){
		if($month < $check_month){
			$check_day = date('Y-m-d',strtotime($start_day." - 30 day"));
		}
	}else{
		$check_day = date('Y-m-d',strtotime($start_day." - 30 day"));
	}
	
	$id = $get_send_timing[0][$i]["id"];
	$messe_no = $get_send_timing[0][$i]["messe_No"];
	$ScheModel->input_sendday_to_ken_messe3($id,$messe_no,$check_day);
	
$i = $i + 1;
}
unset($get_send_timing[0]);//変数の内容を解放する



//ここからは、月末から数える営業日をセットする処理


$get_send_timing_from_back = $ScheModel->get_send_timing_from_back();//set_senddayが０のもの、つまり月初から数える設定のものだけを取得
$kensuu = count($get_send_timing_from_back[0]);
$i = 0;
while($i < $kensuu){//一行ずつ実行していく
	$set_eigyoubi = $get_send_timing_from_back[0][$i]["send_timing"];
	$modify_send_timing = sprintf("%02d", $get_send_timing_from_back[0][$i]["send_timing"]);
	$count_holiday = 0;
	$find_holiday = 1;
	$set_eigyoubi = $set_eigyoubi - 1;
	while($find_holiday != $set_eigyoubi){
		$find_holiday = $find_holiday + 1;
		$set_plus_day = " - ".$find_holiday." day";
		$check_day = date('Y-m-d',strtotime($final_day.$set_plus_day));
		$week = date('w', strtotime($check_day));
		if(strpos($holiday,$check_day) !== false){//祝日に含まれる
			if($week != 0 && $week != 6){//土曜でもなければ日曜でもない
				$count_holiday = $count_holiday + 1;
			}
		}
		if($week == 0 || $week == 6){//土曜または日曜だったとき。祝日と重なってもカウントは１プラスされるだけだから問題はない
			$count_holiday = $count_holiday + 1;
		}
	}
	$shift_day = $count_holiday + $set_eigyoubi;//$set_eigyoubiは、元々-1になってるからそのまま足す。カレンダー的な計算。
	$check_day = date('Y-m-d',strtotime($final_day." - ".$shift_day." day"));//指定の日付に土日祝が足された日付ができあがる

	//↓ここからは、指定した日付までにあった「土日祝の日数分、移動した間にあった土日祝の数をカウントして足している」
	$set_eigyoubi = $set_eigyoubi + 2;
	$shift_count = -1;
	$count_holiday = $count_holiday - 1;
	while($shift_count < $count_holiday){
		$plus = $shift_count + $set_eigyoubi;
		$check_day = date('Y-m-d',strtotime($final_day." - ".$plus." day"));
		$check_week = date('w', strtotime($check_day));
		if(strpos($holiday,$check_day) !== false){//祝日に含まれる
			if($check_week != 0 && $check_week != 6){//土曜でもなければ日曜でもない
				$count_holiday = $count_holiday + 1;
			}
		}
		if($check_week == 0 || $check_week == 6){//土曜または日曜が祝日と重なってもカウントは１プラスされるだけだから問題はない
			$count_holiday = $count_holiday + 1;
		}

		$shift_count = $shift_count + 1;
	}

	//決定した送信日付が、翌月になってしまった場合は、過去の日付を設定して、メールを送信しないようにする
	$check_month = date('m',strtotime($check_day));
	$check_year = date('Y',strtotime($check_day));
	if($year == $check_year){
		if($month > $check_month){
			$check_day = date('Y-m-d',strtotime($final_day." + 30 day"));
		}
	}else{
		$check_day = date('Y-m-d',strtotime($final_day." + 30 day"));
	}

	$id = $get_send_timing_from_back[0][$i]["id"];
	$messe_no = $get_send_timing_from_back[0][$i]["messe_No"];
	$ScheModel->input_sendday_to_ken_messe3($id,$messe_no,$check_day);

	$i = $i + 1;
}
unset($get_send_timing_from_back[0]);//変数の内容を解放する










/*
print $count_holiday;
$count_holiday = $count_holiday + $set_eigyoubi; 
$set_plus_day = " + ".$count_holiday." day";//$set_eigyoubiは、元々-1になってるからこのままでいい
$u = date('Y-m-d',strtotime($start_day.$set_plus_day));
*/
//print $check_day;
print "<br><br>";
//print $count_holiday;
print "<br><br>";
//print $check_day;

?>