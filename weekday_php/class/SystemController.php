<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemController
 *
 * @author nagatayorinobu
 */
class SystemController extends BaseController {
    //----------------------------------------------------
    // 管理者用メニュー
    //----------------------------------------------------
    public function run() {
        // セッション開始　認証に利用します。
        $this->auth = new Auth();
        $this->auth->set_authname(_SYSTEM_AUTHINFO);//$this->authname = systeminfo
        $this->auth->set_sessname(_SYSTEM_SESSNAME);//$this->sessname = PHPSESSION_SYSTEM。会員と別の名前を設定することで、誤動作を防ぎます。
        $this->auth->start();

        if (!$this->auth->check() && $this->type != 'authenticate'){//ログイン前の時はtype='login'にして、ログイン前のトップページに遷移
            $this->type = 'login';
        }
        
        //検索ワード有りの時、次ページへ行くとトップページへ戻ってしまう問題を自分で修正した。
            if (strpos($_SERVER["REQUEST_URI"], "pageID") === FALSE){// URLにpageIDという文字が入っていない場合は何も処理無し(screen_topへ遷移)
        }else{
        	// URLにpageIDの文字があり、かつ$_SESSION['search_key']にデータが入っている時はscreen_list();へ移行
        	if(isset($_SESSION['search_key'])){
        		$this->type = 'list';
        	}
        }
        
        $this->is_system = true;// 共用のテンプレートなどをこのis_systemで管理用に切り替えます。

        
        // 会員側の画面を表示するためMemberControllerを利用します。
        $MemberController = new MemberController($this->is_system);
        //$this->is_systemが($auth = "")に入るので、($auth = "")によって$this->is_systemを引き取れるメソッドでは管理者の分岐が可能になる？

        switch ($this->type) {//$this->typeと$this->actionはBaseControllerのview_initializeで設定されている。
            case "login":
                $this->screen_login();//ログイン前
                break;
            case "logout":
                $this->auth->logout();
                $this->screen_login();
                break;
            case "modify"://新規登録をクリックしたとき(type="modify"の時)。管理者権限付きでscreen_modifyの登録画面へ。
                $MemberController->screen_modify($this->auth);
                break;
            case "delete"://削除をクリックしたとき(type="delete"の時)。screen_deleteの削除画面へ。
                $MemberController->screen_delete();
                break;
            case "list":
                $this->screen_list();
                break;
            case "regist":
                $MemberController->screen_regist($this->auth);//新規登録をクリックしたとき(type="regist"の時)。管理者権限付きでMemberControllerの登録画面へ。
                break;
            case "authenticate"://screen_login()のログインボタンを押した直後の状態
                $this->do_authenticate();
                break;
            case "remove":
            	$this->remove();
            	break;
            case "count":
            	$this->count();
            	break;
            case "precount":
            	$this->precount();
            	break;
            case "preremove":
            	$this->preremove();
            	break;
            default:
                $this->screen_top();//「トップページへ」のリンクをクリックしたとき
        }
    }

    //----------------------------------------------------
    // ログイン前の画面表示
    //----------------------------------------------------
    private function screen_login(){
        $this->form->addElement('text', 'username', '管理者名', ['size' => 15, 'maxlength' => 50]);//本来ならname="systemname"とするべきだろうが
		//ユーザーのファイルで使っているものの使い回しなのでusernameで我慢
		
        $this->form->addElement('password', 'password', 'パスワード', ['size' => 15, 'maxlength' => 50]);
        $this->form->addElement('submit','submit','ログイン');
        $this->next_type = 'authenticate';
        $this->title = 'ログイン画面';
        $this->file = "system_login.tpl";
        $this->view_display();
    }
    
    public function do_authenticate(){//ログインボタンを押したときの動作
        // データベースを操作します。
        $SystemModel = new SystemModel();
        $userdata = $SystemModel->get_authinfo($_POST['username']);//systemテーブルを検索
        if(!empty($userdata['password']) && $this->auth->check_password($_POST['password'], $userdata['password'])){
            $this->auth->auth_ok($userdata);
            $this->screen_top();//ログイン後のトップ画面へ遷移
        } else {
            $this->auth_error_mess = $this->auth->auth_no();
            $this->screen_login();
        }
    }

    //----------------------------------------------------
    // ログイン後のトップ画面
    //----------------------------------------------------
    private function screen_top(){
        unset($_SESSION['search_key']);
        unset($_SESSION[_MEMBER_AUTHINFO]);
        unset($_SESSION['pageID']);
        $this->title = '管理 - トップ画面';
        $this->file = 'system_top.tpl';
        $this->view_display();
    }    
    
    //----------------------------------------------------
    // 会員一覧画面
    //----------------------------------------------------
    private function screen_list(){
        $disp_search_key = "";//検索用単語格納
        $sql_search_key = "";//SQL検索用単語格納
        
        // セッション変数の処理
        unset($_SESSION[_MEMBER_AUTHINFO]);//$_SESSION[_MEMBER_AUTHINFO]は、init.phpで$_SESSION[userinfo]と定義されています。
        //不要なバグを避けるための一旦リセット？
        
        //-------------------------
        //検索単語ありの場合
        //-------------------------
        if(isset($_POST['search_key']) && $_POST['search_key'] != ""){//$_POST['search_key']に値が格納されているときには検索を実行したいということになるので、
            unset($_SESSION['pageID']);//$_SESSION['pageID']を破棄します。
            $_SESSION['search_key'] = $_POST['search_key'];//入力されたデータを遷移で持ち回るために、$_SESSION['search_key']に格納
            $disp_search_key = htmlspecialchars($_POST['search_key'], ENT_QUOTES);//入力されたデータの、不正文字とかを除去
            $sql_search_key = $_POST['search_key'];//入力されたデータをSQL検索用の変数へ格納
        }else{
        	//-------------------------
        	//検索ボックスが空欄でボタンが押された場合
        	//-------------------------
            if(isset($_POST['submit']) && $_POST['submit'] == "検索する"){
                $_SESSION['search_key'] = "";
            }else{
            	//-------------------------
            	//検索単語ありで１ページ目以外が表示された場合
            	//-------------------------
                if(isset($_SESSION['search_key'])){
                    $disp_search_key = htmlspecialchars($_SESSION['search_key'], ENT_QUOTES); 
                    $sql_search_key = $_SESSION['search_key'];
                }
            }
        }
        // データベースを操作します。
        $MemberModel = new MemberModel();
        
        list($data, $count) = $MemberModel->get_member_list($sql_search_key);//ページに表示するデータと、件数を取得。
        $disp_search_key = "";
        list($data, $links) = $this->make_page_link($data,$disp_search_key);//ページに表示するデータをmake_page_linkへ送り、$dataを10件分表示にして、分割用のリンクを$linksで取得。
        ///本来ならURLがtype=list&action=form&pageID=2となっていなければいけないところを、検索するボタン押した後or検索ワード有りだとURLからtype=listとaction=formが抜けてしまう
        //ログイン画面からの検索機能と共有しているため、コンビ二名の第二引数を、nullである$disp_search_keyとして渡している。

        //listは、配列有りの複数の変数が返ってくるのを受け取るやつらしい。つまり上記で言うなら、$dataのたくさんの配列と、$linksの複数配列を受け取っている。
        
        $this->view->assign('count', $count);
        $this->view->assign('data', $data);
        $this->view->assign('search_key', $disp_search_key);
        $this->view->assign('links', $links['all']);
        $this->title = '管理 - 会員一覧画面';
        $this->file = 'system_list.tpl';
        $this->view_display();
    }
    //----------------------------------------------------
    // 3年間ログイン無しのユーザー削除ボタンを押したときの処理
    //----------------------------------------------------
    private function remove(){
    	if($this->type == "remove" && isset($_POST['submit']) && $_POST['submit'] == '3年ログイン無しのユーザーを削除'){
    		$MemberModel = new MemberModel();
    		$id = $MemberModel->get_no3year();//削除すべき人数を取得
    		$ninzuu = count($id);
    		if ($ninzuu != 0){//削除するべきユーザーがいる時
	    		$i = 0;
	    		while($i < $ninzuu){
	    			$url = $MemberModel->get_member_data_id($id[$i]['id']);//idを元に全データを配列で取得
	    			//unlink("./list/".$url['list_url'].".html");//htmlファイルを削除(たばリストで使用)
	    			$i = $i + 1;
	    		}
    			$MemberModel->remove_no3year($id);//DBからデータを削除
	    		$this->message = "削除が実行されました";
    		}
	    	if ($this->message == ""){
	    		$this->message = "削除すべきユーザーはいませんでした。";
	    	}
    	$this->file = 'message.tpl';
    	$this->view_display();
    	}
    }
    
    //----------------------------------------------------
    // 3年間ログイン無しのユーザー数表示ボタンを押したときの処理
    //----------------------------------------------------
    private function count(){
    	if($this->type == "count" && isset($_POST['submit']) && $_POST['submit'] == '3年ログイン無しのユーザーの数を表示'){
    		$MemberModel = new MemberModel();
    		$id = $MemberModel->get_no3year();
    		$ninzuu = count($id);
    		$this->message = "3年以上ログインしていないユーザーは".$ninzuu ."人です。";

    		$this->file = 'message.tpl';
    		$this->view_display();
    	}
    }
    
    //----------------------------------------------------
    // 3日以上クリック無しのprememberテーブルユーザーの数を表示ボタンを押したときの処理
    //----------------------------------------------------
    private function precount(){
    	if($this->type == "precount" && isset($_POST['submit']) && $_POST['submit'] == '3日以上クリック無しのprememberテーブルユーザーの数を表示'){
    		$MemberModel = new MemberModel();
    		$id = $MemberModel->get_no3days();
    		$ninzuu = count($id);
    		$this->message = "3日以上クリック無しのprememberテーブルユーザーは".$ninzuu ."人です。";
    
    		$this->file = 'message.tpl';
    		$this->view_display();
    	}
    }
    
    //----------------------------------------------------
    // 3日以上クリック無しのprememberテーブルユーザーを削除ボタンを押したときの処理
    //----------------------------------------------------
    private function preremove(){
    	if($this->type == "preremove" && isset($_POST['submit']) && $_POST['submit'] == '3日以上クリック無しのprememberテーブルユーザーを削除'){
    		$MemberModel = new MemberModel();
    		$id = $MemberModel->get_no3days();//削除すべき人数を取得
    		$ninzuu = count($id);
    		if ($ninzuu != 0){//削除するべきユーザーがいる時
    			$MemberModel->preremove_no3days($id);
    			$this->message = "削除が実行されました";
    		}
    		if ($this->message == ""){
    			$this->message = "削除すべきユーザーはいませんでした。";
    		}
    		$this->file = 'message.tpl';
    		$this->view_display();
    	}
    }
}

?>
