<?php
/**
 * Description of Auth
 *
 * @author nagatayorinobu
 */
class Auth {
    // セッションに関する処理
    private $authname; // 認証情報の格納先名(このクラス内でしか使えない変数)
    private $sessname; // セッション名(このクラス内でしか使えない変数)
    public function __construct() {
    }//コンストラクタには特に何も設定しません。(new ○○のコマンドで実行される処理)

    public function set_authname($name){
        $this->authname = $name;//$this->authname = userinfo。または$this->authname = systeminfo
    }
    
    public function get_authname(){
        return $this->authname;
    }

    public function set_sessname($name){
        $this->sessname = $name;//$this->sessname = PHPSESSION_MEMBERまたはPHPSESSION_SYSTEM
    }
	/* セッション名は初期設定として、PHPSESSIDと決められていますが、会員側と管理側でセッション名を変えておくと安全性が高められます */
	
    
    public function get_sessname(){
        return $this->sessname;
    }

    public function start(){
        if(session_status() ===  PHP_SESSION_ACTIVE){// セッションが既に開始している場合は何もしない。
			/*  session_status() を使うと、現在のセッションの状態を取得できます。 
			    セッションが無効な場合は PHP_SESSION_DISABLED
    			セッションが有効だけれどもセッションが存在しない場合は PHP_SESSION_NONE
    			セッションが有効で、かつセッションが存在する場合は PHP_SESSION_ACTIVE
			*/
			return;
        }
        if($this->sessname != ""){//セッションの名前を決定する。
            session_name($this->sessname);
			//session_name() は、現在のセッション名を返します。 引数を渡すと、session_name()はセッション名を上書きして引数の名前で
			//セッション名を返します。セッション名を変更する場合は、セッションスタートの前に変更する必要があります。
        }
        session_start();// セッション開始
    }
    
    // 認証情報の確認。section92で上書きされるためコメントアウト。
    /*  public function check(){
        if(!empty($_SESSION[$this->get_authname()]) && $_SESSION[$this->get_authname()]['id'] >= 1){
		//$_SESSION[$this->get_authname()]があり、かつそこに１以上の数字(id番号)が入っている時trueを返す。
		//auth_okにより$_SESSION[$this->get_authname()]は$userdataに変化している。
		//つまり$userdata[id]を判定条件としている。memberテーブル作成時のidは1からスタートしていた。
			
            return true;
        }
    }*/
    public function check(){//自動ログアウト機能
    	if(!empty($_SESSION[$this->get_authname()]) && $_SESSION[$this->get_authname()]['id'] >= 1){//$_SESSION[userinfo]があり、かつ$_SESSION[userinfo][id]に１以上の数字(id番号)が入っている時
    		if( time() >= $_SESSION[$this->get_authname()]['logintime'] + 60 * 60){// 現在時刻 >= ログイン時間 + 操作が無い時間の時はログアウトさせる。●●*60の部分を修正。単位は分。
    			$this->logout();
    			//ページ遷移の度にcheckメソッドが実行されているので、ここに現在の時刻とログイン時の時刻を比較するする処理を入れる
    			
    			return false;
    		}
    		return true;
    	}
    }
    
    
    
    
	//パスワード暗号化。パスワードを引数として受け取り、受け取ったパスワードを暗号化(ハッシュ値に)して返す。
	//クラスの中身の動きそのものは複雑なので、詳細はP283を参照
    public function get_hashed_password($password) {
        // コストパラメーター
        // 04 から 31 までの範囲 大きくなれば堅牢になりますが、システムに負荷がかかります。
        $cost = 10;

        // ランダムな文字列を生成します。
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // ソルトを生成します。
        $salt = sprintf("$2y$%02d$", $cost) . $salt;

        $hash = crypt($password, $salt);
        
        return $hash;
    }
    
    
    //パスワードチェック。パスワードが一致したらtrueを返します
    public function check_password($password, $hashed_password){
        if ( crypt($password, $hashed_password) == $hashed_password ) {
            return true;
        }
    }
    
    // 認証情報の取得
    public function auth_ok($userdata){//セッションハイジャックという攻撃を防止するための処理です
        session_regenerate_id(true);//セッションIDを再発行し、ここまで使っていたセッションIDは削除されます。
        $_SESSION[$this->get_authname()] = $userdata;//$_SESSION[$this->get_authname()]にログインしたユーザーの全データを持つ$userdataの配列群が入る
        $_SESSION[$this->get_authname()]['logintime'] = time();//section92で追加。ログインした時間を保存。check()で使う

    }   

    public function auth_no(){
        return 'ユーザ名かパスワードが間違っています。'."\n";
    }
    

    // 認証情報を破棄
    public function logout(){
        
		$_SESSION = [];// セッション変数を空にする

        // クッキーを削除
        if (ini_get("session.use_cookies")) {//ini_getとは、設定オプションの値を得る。
											//session.use_cookiesによりクライアント側にセッションIDを保存する際にクッキーを使用するかどうかを指定します。
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,//過去の時間をセットすることでクッキーを削除
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();// セッションを破壊
    }

// 


}

?>
