<?php
/*************************************************
 * 初期設定ファイル
 *
 */

//----------------------------------------------------
// デバッグ表示 true / デバッグ表示オフfalse
//----------------------------------------------------

// define("_DEBUG_MODE", true);
// trueにすると、smartyのデバッグ画面が別画面として表示され、通常画面の下に
// セッション変数の内容が表示されます。

define("_DEBUG_MODE", false); 

//----------------------------------------------------
// エラー表示
//----------------------------------------------------
// php.iniやhtaccessで設定していない場合ここで設定
// ini_set( "display_errors", "On");

// HTML_QuickFormでStrictエラーがでるため以下の設定を使用しています。
ini_set( "error_reporting", E_ALL & ~E_STRICT & ~E_DEPRECATED); 
        
        


//----------------------------------------------------
// データベース関連
//----------------------------------------------------

// データベース接続ユーザー名
define("_DB_USER", "---Write here your DB user name---");

// データベース接続パスワード
define("_DB_PASS", "---Write here your DB password---");

// データベースホスト名
define("_DB_HOST", "---Write here your DB host name ---");

// データベース名
define("_DB_NAME", "---Write here your DB name---");

// データベースの種類
define("_DB_TYPE", "mysql");

// データソースネーム
define("_DSN", _DB_TYPE . ":host=" . _DB_HOST . ";dbname=" . _DB_NAME. ";charset=utf8");


//----------------------------------------------------
// セッション名
//----------------------------------------------------

// 会員用セッション名
define("_MEMBER_SESSNAME", "PHPSESSION_MEMBER");

// 管理者用セッション名
define("_SYSTEM_SESSNAME", "PHPSESSION_SYSTEM");

// 会員用認証情報 保管変数名
define("_MEMBER_AUTHINFO", "userinfo");

// 管理者用認証情報 保管変数名
define("_SYSTEM_AUTHINFO", "systeminfo");


//----------------------------------------------------
// 会員・管理者　処理分岐用
//----------------------------------------------------

// 会員用フラッグ。会員用または管理者用機能を設定するためのフラグです
define("_MEMBER_FLG", false);
// 管理者フラッグ。会員用または管理者用機能を設定するためのフラグです
define("_SYSTEM_FLG", true);


//----------------------------------------------------
// ファイル設置ディレクトリ
//----------------------------------------------------

// 関連ファイルを設置するディレクトリ
define( "_PHP_LIBS_DIR", _ROOT_DIR . "weekday_php/");

//↑ここで定義されているのは「G:/xampp/php_libs」となる。セキュリティのため、
//機能などに関するファイルは極力htdocs配下には置かない。



// クラスファイル
define( "_CLASS_DIR", _PHP_LIBS_DIR . "class/");

// 環境変数 
define( "_SCRIPT_NAME", $_SERVER['SCRIPT_NAME']);

//----------------------------------------------------
// Smarty関連設定
//----------------------------------------------------

//  Smartyのlibsディレクトリ
define( "_SMARTY_LIBS_DIR",         _PHP_LIBS_DIR . "smarty/libs/");

//  Smartyのテンプレートファイルを保存したディレクトリ
define( "_SMARTY_TEMPLATES_DIR",    _PHP_LIBS_DIR . "smarty/templates/");

//  Smartyのlibsディレクトリ Webサーバから書き込めるようにします。、
define( "_SMARTY_TEMPLATES_C_DIR",  _PHP_LIBS_DIR . "smarty/templates_c/");

//  Smartyのlibsディレクトリ
define( "_SMARTY_CONFIG_DIR",       _PHP_LIBS_DIR . "smarty/configs/");

//  Smartyのlibsディレクトリ Webサーバから書き込めるようにします。、
define( "_SMARTY_CACHE_DIR",        _PHP_LIBS_DIR . "smarty/cache/");


//----------------------------------------------------
// 必要なファイルの読み込み
//----------------------------------------------------
require_once("HTML/QuickForm.php");//送信フォームを制御
require_once("HTML/QuickForm/Renderer/ArraySmarty.php");//HTML_QuickFormとsamrtyを関連づける
require_once( _SMARTY_LIBS_DIR. "Smarty.class.php");//smarty本体
require_once("---Write here Mail.php file of PEAR ---");

//----------------------------------------------------
// クラスファイルの読み込み
//----------------------------------------------------
// 読み込みの順番を変えると動作しません。
require_once( _CLASS_DIR      . "BaseController.php");
require_once( _CLASS_DIR      . "BaseModel.php");
require_once( _CLASS_DIR      . "Auth.php");
require_once( _CLASS_DIR      . "KenController.php");
require_once( _CLASS_DIR      . "KenModel.php");
require_once( _CLASS_DIR      . "MemberController.php");
require_once( _CLASS_DIR      . "MemberModel.php");
require_once( _CLASS_DIR      . "PrememberController.php");
require_once( _CLASS_DIR      . "PrememberModel.php");
require_once( _CLASS_DIR      . "SystemController.php");
require_once( _CLASS_DIR      . "SystemModel.php");
?> 
