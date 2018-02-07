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
class MemberController extends BaseController {//BaseControllerオブジェクトを宣言した上でMemberControllerを宣言します
    //----------------------------------------------------
    // 会員用メニュー
    //----------------------------------------------------
    public function run() {
        // ユーザーページアクセス時に最初に実行されるクラス。最初は認証(Authクラス)から始まります。
        
        $this->auth = new Auth();//このクラスでAuthクラスを使う。
        $this->auth->set_authname(_MEMBER_AUTHINFO);//$this->authname = userinfo　またはsysteminfo
        $this->auth->set_sessname(_MEMBER_SESSNAME);//$this->sessname = PHPSESSION_MEMBER　またはPHPSESSION_SYSTEM
        $this->auth->start();//セッション開始。開始済みの場合はここの動作は何もない。
        
        if ($this->auth->check()){//auth_okが実行済みの場合true。do_authenticate内で、パスワードが一致した時にauth_ok実行される。
            
            $this->menu_member();// 認証済み
        }else{
            $this->menu_guest();// 未認証
        }
    }
    
    //----------------------------------------------------
    // 会員用メニュー
    //----------------------------------------------------
    public function menu_member() {
    	$this->web_app_name = "ウィークデーリマインダー";
    	$this->web_app_detail = "祝日や営業日を条件にしてリマインダー通知を受け取れるwebサービスです";
    	
        switch ($this->type) {
            case "logout":
                $this->auth->logout();
                $this->screen_login();
                break;
            case "modify":
                $this->screen_modify();//「会員登録情報の修正」をクリックしたとき。URLにtype=modifyの記述有り
                break;
            case "delete":
                $this->screen_delete();//「退会する」をクリックしたとき。URLにtype=deleteの記述有り
                break;
            case "holiday":
                $this->holiday();//「日にちから設定する」をクリックしたとき。URLにtype=deleteの記述有り
                break;
            case "resist_day_from_day"://「日にちから設定する」画面の、「登録する」ボタンが押された時
                $this->resist_day_from_day();
               	break;
            case "holiday_henkou"://「日にちから設定する」項目の、「変更」ボタンが押された時
               	$this->holiday_henkou();
               	break;
            case "modify_day_from_day"://「日にちから設定する」項目の、「変更」ボタンが押され、なおかつそこで変更が行われたとき
                	$this->modify_day_from_day();
                	break;
            case "holiday_sakujo"://「日にちから設定する」項目の、「削除」ボタンが押された時
                	$this->holiday_sakujo();
                	break;
            case "delete_day_from_day"://「日にちから設定する」項目の、「削除」ボタンが押され、なおかつそこで「はい」が押された時。
                	$this->delete_day_from_day();
                	break;
            case "week"://曜日から設定するボタンを押したとき
            		$this->week();
            		break;
            case "resist_week_from_week"://曜日から設定する」画面の、「登録する」ボタンが押された時
            		$this->resist_week_from_week();
            		break;
            case "week_henkou"://曜日から設定する」項目の、「変更」ボタンが押された時
            		$this->week_henkou();
            		break;
            case "modify_week_from_week"://曜日から設定する」項目の、「変更」ボタンが押され、なおかつそこで変更が行われたとき
            		$this->modify_week_from_week();
            		break;
            case "week_sakujo"://曜日から設定する」項目の、「削除」ボタンが押された時
            		$this->week_sakujo();
            		break;
            case "delete_week_from_week"://曜日から設定する」項目の、「削除」ボタンが押され、なおかつそこで「はい」が押された時。
            		$this->delete_week_from_week();
            		break;
            case "eigyoubi"://営業日から設定するボタンを押したとき。
            	$this->eigyoubi();
            		break;
            case "resist_eigyoubi_from_eigyoubi"://営業日から設定する」画面の、「登録する」ボタンが押された時
            		$this->resist_eigyoubi_from_eigyoubi();
            		break;
            case "eigyoubi_henkou"://営業日から設定する」項目の、「変更」ボタンが押された時
            		$this->eigyoubi_henkou();
            		break;
            case "modify_eigyoubi_from_eigyoubi"://営業日から設定する」項目の、「変更」ボタンが押され、なおかつそこで変更が行われたとき
            		$this->modify_eigyoubi_from_eigyoubi();
            		break;
            case "eigyoubi_sakujo"://営業日から設定する」項目の、「削除」ボタンが押された時
            		$this->eigyoubi_sakujo();
            		break;
            case "delete_eigyoubi_from_eigyoubi"://営業日から設定する」項目の、「削除」ボタンが押され、なおかつそこで「はい」が押された時。
            		$this->delete_eigyoubi_from_eigyoubi();
            		break;
            /*	case ""://
            		$this->();
            		break;
            	case ""://
            		$this->();
            		break;
            		*/
            default:
                $this->screen_top();
        }
    }
    
    //----------------------------------------------------
    // ゲスト用メニュー
    //----------------------------------------------------
    public function menu_guest() {
    	$this->web_app_name = "ウィークデーリマインダー";
    	$this->web_app_detail = "祝日や営業日を条件にしてリマインダー通知を受け取れるwebサービスです";
    	
        switch ($this->type) {
            case "regist":
                $this->screen_regist();// 「新規登録」をクリックしたとき。新規ユーザー登録画面
                break;
            case "authenticate"://ログインボタンが押されたとき、データベースの検索が始まる。
                $this->do_authenticate();
                break;
            case "forget":
                $this->screen_forget();//「パスワードを忘れたかたはこちら」をクリックしたとき。URLにtype=forgetの記述有り
                break;
            default:
                $this->screen_login();//$typeが空の時の表示
        }
    }
    //----------------------------------------------------
    // ログイン前画面表示
    //----------------------------------------------------
    public function screen_login(){
//アクセスしたとき最初に実行されるのがこのファイルのrun()。そこから振り分けられて、ゲストだった場合screen_login()に辿り着いている。    	
        $this->form->addElement('text', 'username', 'メールアドレス', ['size' => 15, 'maxlength' => 50]);
        $this->form->addElement('password', 'password', 'パスワード', ['size' => 15, 'maxlength' => 50]);
        $this->form->addElement('submit','submit','ログイン');
        $this->title = 'ウィークデーリマインダー';
        $this->next_type = 'authenticate';//BaseController.phpのview_displayクラスでtypeの属性に設定している。そこをauthenticateにしている。
									//ログインボタンを押すと<INPUT type="hidden" name="type" value="authenticate">が送られ、menu_guestの判定で使われる

        $disp_search_key = "";//検索用単語格納
        $this->view->assign('search_key', $disp_search_key);
        
        //$this->make_store_form();//コンビ二名のプルダウン削除
        $this->file = "login.tpl";
        $this->view_display();//view_displayクラスへ送ってlogin.tplを表示させる
    }
    
    
	
    //----------------------------------------------------
    // ログイン処理
    //----------------------------------------------------
    public function do_authenticate(){//authenticateは認証という意味。
        $MemberModel = new MemberModel();
        $userdata = $MemberModel->get_authinfo($_POST['username']);//MemberModelクラスのget_authinfoクラス(username欄をユーザー名で検索する処理)に、
		//「ユーザー名:」の欄に入力されたテキストを送り、そのテキストでデータベースが検索される。検索で引っかかれば、そのユーザーの項目欄の名前で
		//$userdataに(データ入りの)配列が作られ、それぞれの配列にそのユーザーの全データが格納される。下記で$userdata['password']が使用できるようになる。
		
		
        if(!empty($userdata['password']) && $this->auth->check_password($_POST['password'], $userdata['password'])){
			//パスワードが合っていれば、ログイン後トップ画面が表示される。
			
            $this->auth->auth_ok($userdata);
            $userdata['last_login_date'] = date("Y-m-d");//今日の日付を取得
            $MemberModel->input_last_login_date($userdata);//上記日付をlast_login_dateカラムへ入れる。
            $this->screen_top();
        } else {//パスワードが合っていなければ、
            $this->auth_error_mess = $this->auth->auth_no();//$this->auth_error_messに「ユーザ名かパスワードが間違っています。」が入った上で
            $this->screen_login();//function screen_login()へ行く
        }
    }

    //----------------------------------------------------
    // ログイン後トップ画面
    //----------------------------------------------------
    public function screen_top(){
    	$data = "";
    	$this->title = 'ログイントップ画面';
    	$KenModel = new KenModel;
    	$schedule_count_messe1 = $KenModel->schedule_count1($_SESSION[_MEMBER_AUTHINFO]['id']);//スケジュールの有無を確認し、無かったら無い旨表示
    	$schedule_count_messe2 = $KenModel->schedule_count2($_SESSION[_MEMBER_AUTHINFO]['id']);
    	$schedule_count_messe3 = $KenModel->schedule_count3($_SESSION[_MEMBER_AUTHINFO]['id']);    	
        if($schedule_count_messe1 == false){
        	$this->view->assign('no_sche_messe1', "日にちからのリマインダーはまだ設定されていません");
        }else{
        	$this->view->assign('no_sche_messe1', "");
        }
        if($schedule_count_messe2 == false){
        	$this->view->assign('no_sche_messe2', "曜日からのリマインダーはまだ設定されていません");
        }else{
        	$this->view->assign('no_sche_messe2', "");
        }
        if($schedule_count_messe3 == false){
        	$this->view->assign('no_sche_messe3', "営業日からのリマインダーはまだ設定されていません");
        }else{
        	$this->view->assign('no_sche_messe3', "");
        }
        
        $MemberModel = new MemberModel;
        if($schedule_count_messe1 == true){//Ken_messe1に設定したデータがあるときは取得して表を作成
        	list($ken_messe1_data) = $MemberModel->get_ken_messe1_data($_SESSION[_MEMBER_AUTHINFO]['id']);
        	$this->view->assign('ken_messe1_data', $ken_messe1_data);
        }else{
        	$this->view->assign('ken_messe1_data', "");
        }
        
        if($schedule_count_messe2 == true){//Ken_messe2に設定したデータがあるときは取得して表を作成
        	list($ken_messe2_data) = $MemberModel->get_ken_messe2_data($_SESSION[_MEMBER_AUTHINFO]['id']);
        	$this->view->assign('ken_messe2_data', $ken_messe2_data);
        }else{
        	$this->view->assign('ken_messe2_data', "");
        }
        if($schedule_count_messe3 == true){//Ken_messe3に設定したデータがあるときは取得して表を作成
        	list($ken_messe3_data) = $MemberModel->get_ken_messe3_data($_SESSION[_MEMBER_AUTHINFO]['id']);
        	$this->view->assign('ken_messe3_data', $ken_messe3_data);
        }else{
        	$this->view->assign('ken_messe3_data', "");
        }
        
        $mail_check = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);//メールアドレス変更直後でトップページを表示した場合、$_SESSION[_MEMBER_AUTHINFO]['username']が古いままとなるため、それを新しくするための処理
        if(($_SESSION[_MEMBER_AUTHINFO]['username'] != $mail_check['username'])){
        	$_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);
        	$_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();
        }

        
        
        //$this->tabalist_reg();//hierselect(連動プルダウン)の読み込み
        //$this->next_type    = "tabacco_regist_yesno";
        //$this->next_action  = 'tabacco_regist';
        $this->file = 'member_top.tpl';
        $this->view_display();
    }
    
    
    
    //----------------------------------------------------
    // 日にちからの新規設定画面
    //----------------------------------------------------
    public function holiday(){
    	$this->title = 'スケジュール新規登録画面';
    	$KenModel = new KenModel;
    	$schedule_max_count = $KenModel->schedule_max_count1($_SESSION[_MEMBER_AUTHINFO]['id']);//登録してあるスケジュールのが5未満ならfalse,５以上ならtrue
    	if ($schedule_max_count == false ){
    		$this->message = "プルダウンメニューから送信する日時を選択して、登録ボタンを押して下さい。";
    		$this->view->assign('day', "あ");
	    	$this->make_day_form();
	    	$this->view->assign('option', "あ");
	    	$this->make_sendday_option_form();
	    	$this->view->assign('timing', "あ");
	    	$this->make_send_timing_form();
	    	$this->view->assign('time', "あ");
	    	$this->make_send_time_form();
	    	$this->view->assign('rem_title', "あ");
	    	$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
	    	
	    	$this->next_action  = "resist";
	    	$this->next_type    = "resist_day_from_day";
	    	$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
	    	$this->form->addElement('submit','submit2', "");
	    	//$this->view->assign('data', $_POST['tabacco'][1]);//画像を挿入

    	}else{
    		$this->message2 = "スケジュールの登録が既に５件あります。この項目は５件以上は登録できません。";
    		$this->view->assign('day', "");
    		$this->view->assign('option', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    	
    	$this->modoru = "トップへ戻る";
    	$this->file = 'holiday_set.tpl';
    	$this->view_display();
    }
    //----------------------------------------------------
    // 日にちから新規設定登録、完了画面
    //----------------------------------------------------
    public function resist_day_from_day(){
    	$this->title = 'スケジュール新規登録画面';
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	if($this->action == "resist" && isset($_POST['submit']) && $_POST['submit'] == '登録する' && $text_count <= 200){
    		$this->message = "登録が完了しました。";
    		$set_sendday = $_POST["day"] + 1;
    		$sendday_option = $_POST["option"];
    		$send_timing = $_POST["timing"];
    		$send_time = $_POST["time"] + 1;
    		$messe_No = $_SESSION[_MEMBER_AUTHINFO]['max_messe_no'] + 1;
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$KenModel = new KenModel;
    		$KenModel->regist_ken_messe1($set_sendday,$sendday_option,$send_timing,$send_time,$messe_No,$id,$send_text);//ken_messe1に挿入
    		
    		$MemberModel = new MemberModel;
    		$MemberModel->modify_max_messe_no($id,$messe_No);//memberテーブルのmax_messe_noを更新
    		
    		$_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);//セッション配列更新処理
    		$_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();//セッション配列更新処理
    		
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 日にちから設定変更画面
    //----------------------------------------------------
    public function holiday_henkou(){
    	
    	$this->title = 'スケジュール変更画面';
    	if($this->action == "modify" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe1_messe_no = $MemberModel->check_ken_messe1_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字がken_messe1にあるか否かをチェック
    		if($ken_messe1_messe_no == true){//ken_messe1にある場合
	    		$this->message = "プルダウンメニューから送信する日時を選択して、登録ボタンを押せば更新が完了します。";
	    		$this->view->assign('day', "あ");
	    		$this->make_day_form();
	    		$this->view->assign('option', "あ");
	    		$this->make_sendday_option_form();
	    		$this->view->assign('timing', "あ");
	    		$this->make_send_timing_form();
	    		$this->view->assign('time', "あ");
	    		$this->make_send_time_form();
	    		$this->view->assign('rem_title', "あ");
	    		$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
	    		$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ更新できるように、POSTに組み込む。
	    		
	    		$this->next_action  = "resist";
	    		$this->next_type    = "modify_day_from_day";
	    		$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
	    		$this->form->addElement('submit','submit2', "");
	    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
	    		$ken_messe1_sche = $MemberModel->get_ken_messe1_sche($id,$messe_No);
	    		$tmp1 = $ken_messe1_sche["set_sendday"] - 1;//取得する日にちと、フォームを形成する番号に、マイナス１のずれがあるため、それを修正する
	    		$tmp2 = $ken_messe1_sche["send_time"] - 1;
	    		$this->form->setDefaults(//setDefaultsは初期値をセットするPHP関数。空欄のテキスト欄に設定済みの番号を表示させる
	    				[
	    						'day'      => $tmp1,
	    						'option'      => $ken_messe1_sche["sendday_option"],
	    						'timing'      => $ken_messe1_sche["send_timing"],
	    						'time'      => $tmp2,
	    						'rem_title'      => $ken_messe1_sche["send_text"],
	    				]
	    		);
    		}else{//ken_messe1に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('day', "");
    			$this->view->assign('option', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('day', "");
    		$this->view->assign('option', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    	
    	
    	$this->modoru = "トップへ戻る";
    	$this->file = 'holiday_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 日にちから設定変更画面後の変更完了画面
    //----------------------------------------------------
    public function modify_day_from_day(){
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	$this->title = 'スケジュール登録画面';
    	if($this->action == "resist" && isset($_POST['messe_No']) && $text_count <= 200){
    		$this->message = "登録が完了しました。";
    		$set_sendday = $_POST["day"] + 1;
    		$sendday_option = $_POST["option"];
    		$send_timing = $_POST["timing"];
    		$send_time = $_POST["time"] + 1;
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$messe_no = $_POST['messe_No'];
    		$KenModel = new KenModel;
    		$KenModel->reflesh_ken_messe1($set_sendday,$sendday_option,$send_timing,$send_time,$id,$send_text,$messe_no);//ken_messe1をidとmesse_Noを元にして１行更新
    		
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    	
    	
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    
    //----------------------------------------------------
    // 日にちから設定削除画面
    //----------------------------------------------------
    public function holiday_sakujo(){
    	$this->title = 'スケジュール削除画面';
    	if($this->action == "delete" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe1_messe_no = $MemberModel->check_ken_messe1_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字と自分のIDがken_messe1にあるか否かをチェック
    		if($ken_messe1_messe_no == true){//ken_messe1に該当する番号のスケジュールがある場合
    			$this->message = "下記のスケジュールを削除しますか？<br><br><br>";
    			$this->view->assign('day', "");
    			$this->view->assign('option', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ削除できるように、POSTに組み込む。
    	   
    			$this->next_action  = "delete";
    			$this->next_type    = "delete_day_from_day";
    			$this->form->addElement('submit','submit',  "はい",'class="btn btn-danger"');
    			$this->form->addElement('submit','submit2', "いいえ",'class="btn btn-default"');
    			$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    			$ken_messe1_sche = $MemberModel->get_ken_messe1_sche($id,$messe_No);
    			switch ($ken_messe1_sche["sendday_option"]) {
    				case "0":
    					$a = "祝日";
    					break;
    				case "1":
    					$a = "土曜";
    					break;
    				case "2":
    					$a = "日曜";
    					break;
    				case "3":
    					$a = "土日祝";
    					break;
    				default:
    					$a = "";
    				
    			}
    			switch ($ken_messe1_sche["send_timing"]) {
    				case "0":
    					$b = "当日";
    					break;
    				case "1":
    					$b = "前日";
    					break;
    				case "2":
    					$b = "前営業日";
    					break;
    				case "3":
    					$b = "翌日";
    					break;
    				case "4":
    					$b = "翌営業日";
    					break;
    				default:
    					$b = "";
    			
    			}
    			$this->message2 = "「毎月の".$ken_messe1_sche["set_sendday"]."日が".$a."だった時、".$b."にリマインダーを送る。」";
    		}else{//ken_messe1に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('day', "");
    			$this->view->assign('option', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('day', "");
    		$this->view->assign('option', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    	 
    	 
    	$this->modoru = "トップへ戻る";
    	$this->file = 'holiday_set.tpl';
    	$this->view_display();
    }
    
    
    //----------------------------------------------------
    // 日にちから削除画面後の削除完了画面
    //----------------------------------------------------
    public function delete_day_from_day(){
    	$this->title = 'スケジュール削除完了画面';
    	if($this->action == "delete" && isset($_POST['messe_No'])){
    		$this->message = "１件の削除が完了しました。";
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$messe_no = $_POST['messe_No'];
    		$KenModel = new KenModel;
    		$KenModel->delete_ken_messe1_sche($id,$messe_no);//ken_messe1にあるスケジュールををidとmesse_Noを元にして１行削除
    
    	}else{
    		$this->message = "エラー。もう一度はじめから行ってみて下さい。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 曜日からの新規設定画面
    //----------------------------------------------------
    public function week(){
    	$this->title = 'スケジュール新規登録画面';
    	$KenModel = new KenModel;
    	$schedule_max_count = $KenModel->schedule_max_count2($_SESSION[_MEMBER_AUTHINFO]['id']);//登録してあるスケジュールのが4未満ならfalse,4以上ならtrue
    	if ($schedule_max_count == false ){
    		$this->message = "プルダウンメニューから送信する曜日を選択して、登録ボタンを押して下さい。";
    		$this->view->assign('week', "あ");
    		$this->make_week_form();
    		$this->view->assign('timing', "あ");
    		$this->make_send_timing_form();
    		$this->view->assign('time', "あ");
    		$this->make_send_time_form();
    		$this->view->assign('rem_title', "あ");
    		$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
    
    		$this->next_action  = "resist";
    		$this->next_type    = "resist_week_from_week";
    		$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
    		$this->form->addElement('submit','submit2', "");
    
    	}else{
    		$this->message2 = "スケジュールの登録が既に３件あります。この項目は３件以上は登録できません。";
    		$this->view->assign('week', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    	 
    	$this->modoru = "トップへ戻る";
    	$this->file = 'week_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 曜日から新規設定登録、完了画面
    //----------------------------------------------------
    public function resist_week_from_week(){
    	$this->title = 'スケジュール新規登録画面';
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	if($this->action == "resist" && isset($_POST['submit']) && $_POST['submit'] == '登録する' && $text_count <= 200){
    		$this->message = "登録が完了しました。";
    		$set_sendday = $_POST["week"];
    		$send_timing = $_POST["timing"];
    		$send_time = $_POST["time"] + 1;
    		$messe_No = $_SESSION[_MEMBER_AUTHINFO]['max_messe_no'] + 1;
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$KenModel = new KenModel;
    		$KenModel->regist_ken_messe2($set_sendday,$send_timing,$send_time,$messe_No,$id,$send_text);//ken_messe2に挿入
    
    		$MemberModel = new MemberModel;
    		$MemberModel->modify_max_messe_no($id,$messe_No);//memberテーブルのmax_messe_noを更新
    
    		$_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);//セッション配列更新処理
    		$_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();//セッション配列更新処理
    
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    
    //----------------------------------------------------
    // 曜日から設定変更画面
    //----------------------------------------------------
    public function week_henkou(){
    	$this->title = 'スケジュール変更画面';
    	if($this->action == "modify" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe2_messe_no = $MemberModel->check_ken_messe2_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字がken_messe2にあるか否かをチェック
    		if($ken_messe2_messe_no == true){//ken_messe2にある場合
    			$this->message = "プルダウンメニューから送信する日時を選択して、登録ボタンを押せば更新が完了します。";
    			$this->view->assign('week', "あ");
    			$this->make_week_form();
    			$this->view->assign('timing', "あ");
    			$this->make_send_timing_form();
    			$this->view->assign('time', "あ");
    			$this->make_send_time_form();
    			$this->view->assign('rem_title', "あ");
    			$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
    			$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ更新できるように、POSTに組み込む。
    	   
    			$this->next_action  = "resist";
    			$this->next_type    = "modify_week_from_week";
    			$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
    			$this->form->addElement('submit','submit2', "");
    			$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    			$ken_messe2_sche = $MemberModel->get_ken_messe2_sche($id,$messe_No);
    			$tmp2 = $ken_messe2_sche["send_time"] - 1;//取得する時間と、フォームを形成する番号に、マイナス１のずれがあるため、それを修正する
    			$this->form->setDefaults(//setDefaultsは初期値をセットするPHP関数。空欄のテキスト欄に設定済みの番号を表示させる
    					[
    							'week'      => $ken_messe2_sche["set_sendday"],
    							'timing'      => $ken_messe2_sche["send_timing"],
    							'time'      => $tmp2,
    							'rem_title'      => $ken_messe2_sche["send_text"],
    					]
    			);
    		}else{//ken_messe2に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('week', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('week', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    	 
    	 
    	$this->modoru = "トップへ戻る";
    	$this->file = 'week_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 曜日から設定変更画面後の変更完了画面
    //----------------------------------------------------
    public function modify_week_from_week(){
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	$this->title = 'スケジュール登録画面';
    	if($this->action == "resist" && isset($_POST['messe_No']) && $text_count <= 200){
    		$this->message = "登録が完了しました。";
    		$set_sendday = $_POST["week"];
    		$send_timing = $_POST["timing"];
    		$send_time = $_POST["time"] + 1;
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$messe_no = $_POST['messe_No'];
    		$KenModel = new KenModel;
    		$KenModel->reflesh_ken_messe2($set_sendday,$send_timing,$send_time,$id,$send_text,$messe_no);//ken_messe2をidとmesse_Noを元にして１行更新
    
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    	 
    	 
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 曜日からスケジュール削除画面
    //----------------------------------------------------
    public function week_sakujo(){
    	$this->title = 'スケジュール削除画面';
    	if($this->action == "delete" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe2_messe_no = $MemberModel->check_ken_messe2_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字と自分のIDがken_messe1にあるか否かをチェック
    		if($ken_messe2_messe_no == true){//ken_messe1に該当する番号のスケジュールがある場合
    			$this->message = "下記のスケジュールを削除しますか？<br><br><br>";
    			$this->view->assign('week', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ削除できるように、POSTに組み込む。
    
    			$this->next_action  = "delete";
    			$this->next_type    = "delete_week_from_week";
    			$this->form->addElement('submit','submit',  "はい",'class="btn btn-danger"');
    			$this->form->addElement('submit','submit2', "いいえ",'class="btn btn-default"');
    			$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    			$ken_messe2_sche = $MemberModel->get_ken_messe2_sche($id,$messe_No);
    			switch ($ken_messe2_sche["set_sendday"]) {
    				case "0":
    					$a = "日曜日が";
    					break;
    				case "1":
    					$a = "月曜日が";
    					break;
    				case "2":
    					$a = "火曜日が";
    					break;
    				case "3":
    					$a = "水曜日が";
    					break;
    				case "4":
    					$a = "木曜日が";
    					break;
    				case "5":
    					$a = "金曜日が";
    					break;
    				case "6":
    					$a = "土曜日が";
    					break;
    				case "7":
    					$a = "何曜日かに関わらず、";
    					break;
    				default:
    					$a = "";
    
    			}
    			switch ($ken_messe2_sche["send_timing"]) {
    				case "0":
    					$b = "当日";
    					break;
    				case "1":
    					$b = "前日";
    					break;
    				case "2":
    					$b = "前営業日";
    					break;
    				case "3":
    					$b = "翌日";
    					break;
    				case "4":
    					$b = "翌営業日";
    					break;
    				default:
    					$b = "";
    			}
    			$this->message2 = "「".$a."祝日だった場合、".$b."にリマインダーを送る。」";
    		}else{//ken_messe1に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('week', "");
    			$this->view->assign('timing', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('week', "");
    		$this->view->assign('timing', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    
    
    	$this->modoru = "トップへ戻る";
    	$this->file = 'week_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 曜日から削除画面後の1行削除完了画面
    //----------------------------------------------------
    public function delete_week_from_week(){
    	$this->title = 'スケジュール削除完了画面';
    	if($this->action == "delete" && isset($_POST['messe_No'])){
    		$this->message = "１件の削除が完了しました。";
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$messe_no = $_POST['messe_No'];
    		$KenModel = new KenModel;
    		$KenModel->delete_ken_messe2_sche($id,$messe_no);//ken_messe2にあるスケジュールををidとmesse_Noを元にして１行削除
    
    	}else{
    		$this->message = "エラー。もう一度はじめから行ってみて下さい。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日からの新規設定画面
    //----------------------------------------------------
    public function eigyoubi(){
    	$this->title = 'スケジュール新規登録画面';
    	$KenModel = new KenModel;
    	$schedule_max_count = $KenModel->schedule_max_count3($_SESSION[_MEMBER_AUTHINFO]['id']);//登録してあるスケジュールのが4未満ならfalse,4以上ならtrue
    	if ($schedule_max_count == false ){
    		$this->message = "プルダウンメニューから送信する営業日を選択して、登録ボタンを押して下さい。";
    		$this->view->assign('start', "あ");
    		$this->make_start_form();
    		$this->view->assign('eigyoubi', "あ");
    		$this->make_eigyoubi_form();
    		$this->view->assign('time', "あ");
    		$this->make_send_time_form();
    		$this->view->assign('rem_title', "あ");
    		$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
    
    		$this->next_action  = "resist";
    		$this->next_type    = "resist_eigyoubi_from_eigyoubi";
    		$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
    		$this->form->addElement('submit','submit2', "");
    
    	}else{
    		$this->message2 = "営業日を条件にして送るスケジュールの登録が既に３件あります。この項目は３件以上は登録できません。";
    		$this->view->assign('start', "");
    		$this->view->assign('eigyoubi', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    
    	$this->modoru = "トップへ戻る";
    	$this->file = 'eigyoubi_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日から新規設定登録、完了画面
    //----------------------------------------------------
    public function resist_eigyoubi_from_eigyoubi(){
    	$this->title = 'スケジュール新規登録画面';
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	if($this->action == "resist" && isset($_POST['submit']) && $_POST['submit'] == '登録する' && $text_count <= 200){
    		if($_POST["start"] != 1 || $_POST["eigyoubi"] != 1){//「月末から数える」、「最初営業日」の組み合わせで入力されると、ScheControllerのget_send_timing_from_back部分が上手く計算できないので、それを避けるようにした
	    		$this->message = "登録が完了しました。";
	    		$set_sendday = $_POST["start"];//最初営業日から数えるか、最終から数えるか。
	    		$send_timing = $_POST["eigyoubi"];
	    		$send_time = $_POST["time"] + 1;
	    		$messe_No = $_SESSION[_MEMBER_AUTHINFO]['max_messe_no'] + 1;
	    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
	    		$KenModel = new KenModel;
	    		$KenModel->regist_ken_messe3($set_sendday,$send_timing,$send_time,$messe_No,$id,$send_text);//ken_messe2に挿入
	    
	    		$MemberModel = new MemberModel;
	    		$MemberModel->modify_max_messe_no($id,$messe_No);//memberテーブルのmax_messe_noを更新
	    
	    		$_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);//セッション配列更新処理
	    		$_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();//セッション配列更新処理
    		}else{
    			$this->message = "登録できませんでした。最初営業日を送信日に設定する場合は、「月末から数える」を選択して下さい。";
    		}
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日から設定変更画面
    //----------------------------------------------------
    public function eigyoubi_henkou(){
    	$this->title = 'スケジュール変更画面';
    	if($this->action == "modify" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe3_messe_no = $MemberModel->check_ken_messe3_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字がken_messe3にあるか否かをチェック
    		if($ken_messe3_messe_no == true){//ken_messe3にある場合
    			$this->message = "プルダウンメニューから送信する日時を選択して、登録ボタンを押せば更新が完了します。";
    			$this->view->assign('start', "あ");
    			$this->make_start_form();
    			$this->view->assign('eigyoubi', "あ");
    			$this->make_eigyoubi_form();
    			$this->view->assign('time', "あ");
    			$this->make_send_time_form();
    			$this->view->assign('rem_title', "あ");
    			$this->make_form_reminder_title();//リマインダーで送る文章欄の生成
    			$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ更新できるように、POSTに組み込む。
    
    			$this->next_action  = "resist";
    			$this->next_type    = "modify_eigyoubi_from_eigyoubi";
    			$this->form->addElement('submit','submit',  "登録する",'class="btn btn-danger"');
    			$this->form->addElement('submit','submit2', "");
    			$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    			$ken_messe3_sche = $MemberModel->get_ken_messe3_sche($id,$messe_No);
    			$tmp2 = $ken_messe3_sche["send_time"] - 1;//取得する時間と、フォームを形成する番号に、マイナス１のずれがあるため、それを修正する
    			$this->form->setDefaults(//setDefaultsは初期値をセットするPHP関数。空欄のテキスト欄に設定済みの番号を表示させる
    					[
    							'start'      => $ken_messe3_sche["set_sendday"],
    							'eigyoubi'      => $ken_messe3_sche["send_timing"],
    							'time'      => $tmp2,
    							'rem_title'      => $ken_messe3_sche["send_text"],
    					]
    			);
    		}else{//ken_messe2に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('start', "");
    			$this->view->assign('eigyoubi', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('start', "");
    		$this->view->assign('eigyoubi', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    
    
    	$this->modoru = "トップへ戻る";
    	$this->file = 'eigyoubi_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日から設定変更画面後の変更完了画面
    //----------------------------------------------------
    public function modify_eigyoubi_from_eigyoubi(){
    	$send_text = htmlspecialchars($_POST["rem_title"]);
    	$text_count = mb_strlen( $send_text );
    	$this->title = 'スケジュール登録画面';
    	if($this->action == "resist" && isset($_POST['messe_No']) && $text_count <= 200){
    		if($_POST["start"] != 1 || $_POST["eigyoubi"] != 1){//「月末から数える」、「最初営業日」の組み合わせで入力されると、ScheControllerのget_send_timing_from_back部分が上手く計算できないので、それを避けるようにした
	    		$this->message = "登録が完了しました。";
	    		$set_sendday = $_POST["start"];
	    		$send_timing = $_POST["eigyoubi"];
	    		$send_time = $_POST["time"] + 1;
	    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
	    		$messe_no = $_POST['messe_No'];
	    		$KenModel = new KenModel;
	    		$KenModel->reflesh_ken_messe3($set_sendday,$send_timing,$send_time,$id,$send_text,$messe_no);//ken_messe3をidとmesse_Noを元にして１行更新
    		}else{
    			$this->message = "登録できませんでした。最初営業日を送信日に設定する場合は、「月末から数える」を選択して下さい。";
    		}
    	}else{
    		$this->message = "登録できませんでした。リマインダーで送る文章が長すぎます。200文字までにしてください。";
    	}
    
    
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日からスケジュール削除画面
    //----------------------------------------------------
    public function eigyoubi_sakujo(){
    	$this->title = 'スケジュール削除画面';
    	if($this->action == "delete" && isset($_GET['messe_no'])){
    		$messe_No = htmlspecialchars($_GET['messe_no']);
    		$MemberModel = new MemberModel;
    		$ken_messe3_messe_no = $MemberModel->check_ken_messe3_messe_no($_SESSION[_MEMBER_AUTHINFO]['id'],$messe_No);//$_GET['messe_no']で渡ってきた数字と自分のIDがken_messe1にあるか否かをチェック
    		if($ken_messe3_messe_no == true){//ken_messe3に該当する番号のスケジュールがある場合
    			$this->message = "下記のスケジュールを削除しますか？<br><br><br>";
    			$this->view->assign('start', "");
    			$this->view->assign('eigyoubi', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->view->assign('messe_no', $messe_No);//渡ってきたmesse_Noの部分のみ削除できるように、POSTに組み込む。
    
    			$this->next_action  = "delete";
    			$this->next_type    = "delete_eigyoubi_from_eigyoubi";
    			$this->form->addElement('submit','submit',  "はい",'class="btn btn-danger"');
    			$this->form->addElement('submit','submit2', "いいえ",'class="btn btn-default"');
    			$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    			$ken_messe3_sche = $MemberModel->get_ken_messe3_sche($id,$messe_No);
    			switch ($ken_messe3_sche["set_sendday"]) {
    				case "0":
    					$a = "月初から数えて";
    					break;
    				case "1":
    					$a = "月末から数えて";
    					break;
    				default:
    					$a = "";
    			}
    			switch ($ken_messe3_sche["send_timing"]) {
    				case "0":
    					$b = "最終営業日";
    					break;
    				default:
    					$b = "第".$ken_messe3_sche["send_timing"]."営業日";
    			}
    			$this->message2 = "「".$a."、".$b."にリマインダーを送る。」";
    		}else{//ken_messe1に渡ってきたmesse_Noが無い場合(適当なmesse_noをURLに打ち込まれた場合)
    			$this->message2 = "無効な操作です。";
    			$this->view->assign('start', "");
    			$this->view->assign('eigyoubi', "");
    			$this->view->assign('time', "");
    			$this->view->assign('rem_title', "");
    			$this->form->addElement('submit','submit', "");
    			$this->form->addElement('submit','submit2', "");
    		}
    	}else{//明らかに変更ボタンからの遷移ではない場合
    		$this->message2 = "無効な操作です。";
    		$this->view->assign('start', "");
    		$this->view->assign('eigyoubi', "");
    		$this->view->assign('time', "");
    		$this->view->assign('rem_title', "");
    		$this->form->addElement('submit','submit', "");
    		$this->form->addElement('submit','submit2', "");
    	}
    
    
    	$this->modoru = "トップへ戻る";
    	$this->file = 'eigyoubi_set.tpl';
    	$this->view_display();
    }
    
    //----------------------------------------------------
    // 営業日から削除画面後の1行削除完了画面
    //----------------------------------------------------
    public function delete_eigyoubi_from_eigyoubi(){
    	$this->title = 'スケジュール削除完了画面';
    	if($this->action == "delete" && isset($_POST['messe_No'])){
    		$this->message = "１件の削除が完了しました。";
    		$id = $_SESSION[_MEMBER_AUTHINFO]['id'];
    		$messe_no = $_POST['messe_No'];
    		$KenModel = new KenModel;
    		$KenModel->delete_ken_messe3_sche($id,$messe_no);//ken_messe3にあるスケジュールををidとmesse_Noを元にして１行削除
    
    	}else{
    		$this->message = "エラー。もう一度はじめから行ってみて下さい。";
    	}
    	$this->modoru = "トップへ戻る";
    	$this->file = 'message.tpl';
    	$this->view_display();
    }
    


    //----------------------------------------------------
    // 新規ユーザー登録関連画面
    //----------------------------------------------------
    public function screen_regist($auth = ""){//ここの引数$authは、SystemControllerからのnew Auth();を受け取っている。このメソッド内で「オブジェクト型であるか否か」の判定に使うので、何か具体的なデータがあるわけではない
    	//このメソッドには４パターンのactionがあるので、処理によって$this->fileに埋め込むパーツを適切な名前で上書きしなければならない。
    	//このメソッド内では$this->fileは、memberinfo_form.tplと、message.tplの２つのうちどちらかを使用する
    	
        $btn = "";
        $btn2 = "";//ボタン表示名を格納する変数を用意
        $this->view->assign('coution', "");
        $this->file = "memberinfo_form.tpl"; // 入力フォームのテンプレート

        // フォーム要素のデフォルト表示を今日に設定
        /*  $date_defaults = [
            'Y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
        ];

        $this->form->setDefaults(['birthday' => $date_defaults]);*///setDefaultsは初期値をセットするPHP関数。
        $this->make_form_controle();//各入力欄の生成と、チェック用ルールを定義しています。

        // フォーム内の情報が妥当かどうか検証
        if (!$this->form->validate()){//validate()実行前ならaction = "form"となり、入力フォームが表示される。
        							//validate()は多分HTML_QuickFormクラス内にあるメソッド。「確認画面へ」のボタンを押した後、バリデートが上手くいかなかった場合は、action = "form"のままとなり、
        							//再度「確認画面へ」のボタンを押す前の表示になる。バリデートがOKなら$this->action = "confirm"へ遷移
            $this->action = "form";
        }

        if($this->action == "form"){//「確認画面へ」のボタンを押す前の表示
            $this->title  = '新規アカウント作成';
            $this->next_type    = 'regist';//押す前はフォームのvalueが{next_type}。押したらtype　= 'regist'
            $this->next_action  = 'confirm';//押す前はフォームのvalueが{next_action}。押したらaction = 'confirm'
            $btn = '確認画面へ';
            
        }else if($this->action == "confirm"){//「確認画面へ」のボタンを押した後の表示
            $this->title  = '確認画面';
            $this->next_type    = 'regist';//「登録する」を押す前はフォームのvalueが{next_type}。押したらtype　= 'regist'
            $this->next_action  = 'complete';//「登録する」を押す前はフォームのvalueが{next_action}。押したらtype　= 'complete'
            $this->form->freeze();//freeze()メソッドは、入力欄が消え、入力された値だけがブラウザ上に表示されます。
            $btn = '上記アドレスに登録メールを送る';
            $btn2= '戻る';
            if($this->is_system){
            	$this->message2 = "管理者画面から登録する場合は、メールは送信されません。";
            }
            
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == '戻る'){//登録するボタンの隣にある「戻る」ボタンが押された時の表示。
        	//条件はaction == "complete"かつ$btn2がポストされた時。この場合はif($this->action == "form")の時の表示と同じ表示となる
        	
            $this->title  = '新規アカウント作成';
            $this->next_type    = 'regist';
            $this->next_action  = 'confirm';
            $btn = '確認画面へ';
            
        }else if($this->action == "complete" && isset($_POST['submit']) && $_POST['submit'] == '上記アドレスに登録メールを送る'){//登録するボタンが押された時
        	//action == "complete"かつ$btnがポストされた時
        	
            // データベースを操作処理開始。
            $PrememberModel = new PrememberModel();
            $MemberModel = new MemberModel();
            $userdata = $this->form->getSubmitValues();//フォームに入力された全てのデータが、$userdataに配列で格納される
            //$userdata['last_name'] = mb_strtolower($userdata['last_name']);//文字列を小文字にする。last_nameはもう使っていないのでコメントアウト
            if( $MemberModel->check_username($userdata) || $MemberModel->check_change_name($userdata) || $PrememberModel->check_username($userdata) ){
            	//$userdata['username']がusername欄にあるかを、member、prememberの両方のテーブルで検索
            	
                $this->title = '新規アカウント作成';
                $this->message = "そのメールアドレスは既に使用されているため登録できません。";//あった場合は最初の画面プラス、エラーメッセージ付きで表示。
                $this->next_type    = 'regist';
                $this->next_action  = 'confirm';
                $btn = '確認画面へ';
            }else{
                // システム側から利用するときに利用
                if($this->is_system && is_object($auth)){//is_objectは与えられた変数がオブジェクトかどうかを調べます。 
                	//SystemControllerからこのメソッドが呼び出された場合、new Auth()を$auth = ""で受け取っている。
                	//$authにはデータは何も入っていないが、データ形式がオブジェクトであるのでis_object($auth)はtrueになる
                    $userdata['password'] = $auth->get_hashed_password($userdata['password']);
                
                //ユーザーが入力したデータを整形
                }else{
                    $userdata['password'] = $this->auth->get_hashed_password($userdata['password']);//パスワ暗号化
                }
                /*  $userdata['birthday'] = sprintf("%04d-%02d-%02d",
                                                $userdata['birthday']['Y'],
                                                $userdata['birthday']['m'],
                                                $userdata['birthday']['d']);*///sprintf関数は引数に指定したデータをあらかじめ作っておいた文字形式に変換します。詳しくはP292。
                //system_list.tplで日付が正しく取得できるように、「-」を追加した。
                
                
                // システム側から利用するときに利用
                if($this->is_system){
                    $MemberModel->regist_member($userdata);//regist_memberメソッドは、prememberテーブルを経由しないで、直でmemberテーブルに書き込む奴なので、管理者しか使わないメソッド。
                    $this->title   = '登録完了画面';
                    $this->message = "登録を完了しました。";
                
                //prememberテーブル登録＆仮登録メール送信処理
                }else{
                    $userdata['link_pass'] = hash('sha256', uniqid(rand(),1));//クリックするurlに付けるランダムな文字列を生成
                    $PrememberModel->regist_premember($userdata);//prememberテーブルにデータ登録
                    $this->mail_to_premember($userdata);//メル送信
                    $this->title    = '仮登録メール送信完了';
                    $this->message  = "登録されたメールアドレスへ確認のためのメールを送信しました。<BR>";
                    $this->message .= 'メール本文に記載されているURLにアクセスして登録を完了してください。<BR><BR>もしメールが届かない場合は、迷惑メールフォルダを確認して下さい。<BR>';
                }
                $this->file = "message.tpl";//premember登録完了時のテンプレート
            }
        }

        $this->form->addElement('submit','submit',  $btn ,'button class="btn btn-danger"');
        $this->form->addElement('submit','submit2', $btn2,'button class="btn btn-default"');
        $this->form->addElement('reset', 'reset',   '取り消し','button class="btn btn-default"');
        $this->view_display();
    }

    //----------------------------------------------------
    // 会員情報の修正
    //----------------------------------------------------
    public function screen_modify($auth = ""){//引数についてはscreen_registの引数の説明を参照
        $btn          = "";
        $btn2         = "";
        $this->view->assign('coution', "あ");
        $this->file = "memberinfo_form.tpl";

        $MemberModel = new MemberModel();
        $PrememberModel = new PrememberModel();
        $_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);//DBとセッションが合っていない可能性を払拭するため、念のためセッションを全て更新
        $_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();
        
        if($this->is_system && $this->action == "form"){//システム側(SystemController)から利用する場合、$_SESSION[_MEMBER_AUTHINFO]が定まっていないため、
        	//$_SESSION[_MEMBER_AUTHINFO]をGETで送られてきたidの数字とする
            $_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_GET['id']);
        }
        // フォーム要素のデフォルト値を設定
        /*  $date_defaults = [
            'Y' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'], 0, 4),
            'm' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'], 5, 2),
            'd' => substr($_SESSION[_MEMBER_AUTHINFO]['birthday'], 8, 2),        
        ];*/
		
        $this->form->setDefaults(//setDefaultsは初期値をセットするPHP関数。
            [
                'username'      => $_SESSION[_MEMBER_AUTHINFO]['username'],
            ]
        );

        $this->make_form_controle();//フォームを形成

        // フォームの妥当性検証
        if (!$this->form->validate()){//送信したフォームがバリデートOKならこのif文には入らない。
        							//「確認画面へ」のボタンを押した後、バリデートが上手くいかなかった場合は、action = "form"のままとなり、
        							//再度、データ送信前の表示になる。
            $this->action = "form";
        }

        if($this->action == "form"){//データ送信前の表示
            $this->title  = '登録情報の更新';
            $this->next_type    = 'modify';
            $this->next_action  = 'confirm';
            $btn = '確認画面へ';
            
        }else if($this->action == "confirm"){//「確認画面へ」を押したときの表示
            $this->title  = '確認画面';
            $this->next_type    = 'modify';
            $this->next_action  = 'complete';
            $this->form->freeze();//freeze()メソッドは、入力欄が消え、入力された値だけがブラウザ上に表示されます。
            $userdata = $this->form->getSubmitValues();//getSubmitValuesはHTML_QuickFormのクラスです。入力されたデータを$userdataに配列で格納します
            if($_SESSION[_MEMBER_AUTHINFO]['username'] != $userdata['username']){
            	$this->message3 = "<BR>アドレスの変更を行う場合、下記の「更新する」ボタンを押すと、新しいアドレスへ確認のためのメールが送られます。<BR>";
            }
            $btn = '更新する';
            $btn2= '戻る';
            
        }else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == '戻る'){//「戻る」ボタンが押された時、最初の表示に戻る。
            $this->title  = '更新画面';
            $this->next_type    = 'modify';
            $this->next_action  = 'confirm';
            $btn = '確認画面へ';
            
        }else if($this->action == "complete" && isset($_POST['submit']) && $_POST['submit'] == '更新する'){//更新するボタンが押された時
            $userdata = $this->form->getSubmitValues();//getSubmitValuesはHTML_QuickFormのクラスです。入力されたデータを$userdataに配列で格納します
            
            if( ($MemberModel->check_username($userdata) || $MemberModel->check_change_name($userdata) || $PrememberModel->check_username($userdata))
                    && ($_SESSION[_MEMBER_AUTHINFO]['username'] != $userdata['username']) ){
            	//member,prememberテーブルどちらかに入力したアドレスがある、かつログインしたアドレスと入力したアドレスが異なる時。
            	//なぜログインしたアドレスと入力したアドレスを比べる必要がある？？ユーザーはアドレスを変更したいだけかもしれないから、両方のテーブルに登録されているかどうかを確認すれば良いだけでは？
            	//解決→アドレス以外の修正を行ったとき、アドレス入力欄に変化が無いと既にデータベースに登録済みとなってしまって修正した情報が登録できなくなる。それを避けるために
            	//ログインしたアドレスと入力したアドレスが同じ場合はelseに飛ぶようにしている。
            	
                $this->next_type    = 'modify';
                $this->next_action  = 'confirm';
                $this->title  = '更新画面';
                $this->message = "このメールアドレスは既に登録者がいるため登録できません。";
                $btn = '確認画面へ';
            }else{
                $this->title = '更新完了画面';
                $userdata['id'] = $_SESSION[_MEMBER_AUTHINFO]['id'];
                //更新画面からの送信データにはidが無いので、セッション変数に格納していた会員idを$userdata['id']に入れます。管理者側の時だったら$userdata['id']=$_SESSION[5][id]という具合か。
                //てか元々idは変わらないんだから、この処理って必要あるのか？→getSubmitValues()ではidという名の箱が作られないから、下記のmodify_member()で利用するためにここで別途作成している訳だ。
                
                if($this->is_system && is_object($auth)){//管理者かユーザーかで分岐。メソッドの呼び出し方法が若干異なる。
                    $userdata['password'] = $auth->get_hashed_password($userdata['password']);
                }else{
                    $userdata['password'] = $this->auth->get_hashed_password($userdata['password']);//パスワード暗号化処理
                }
				
					if($_SESSION[_MEMBER_AUTHINFO]['username'] == $userdata['username']){//パスワードの変更なのか、アドレスの変更なのかを判断。パスワのみの変更の場合、メルの送信は無し
						$MemberModel->modify_member($userdata);//更新処理
						$this->message = "パスワードを変更しました。";
					}else{//メル変更の場合
						$MemberModel->resist_change_name($userdata);//memberテーブルのchange_nameカラムに変更しようとするアドレスを挿入。
						$userdata['link_pass'] = hash('sha256', uniqid(rand(),1));//urlに付けるランダムな文字列を生成
						$PrememberModel->regist_premember($userdata);//prememberテーブルにデータ登録
						$this->change_mail($userdata);//メル送信
						$this->message = "新しいアドレスが本人のものかチェックするためのメールを送信しました。<BR>メール本文内にあるリンクをクリックして、本人のものである事を確認して下さい。";
					}
                

                $this->file = "message.tpl";
                if($this->is_system){
                    unset($_SESSION[_MEMBER_AUTHINFO]);//管理者の時は修正したユーザーのidを破棄。これ以降はもう使わないので。
                }else{
                    $_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_SESSION[_MEMBER_AUTHINFO]['id']);
                    //ユーザーの時は登録した情報で$_SESSION[userinfo]を更新する(idは変更できないのでキーはidになる)。
                    //管理者側とは違い、もう一度「会員登録情報の修正」がクリックされるかもしれないから、ユーザー情報は$_SESSIONで保持しとかないとならない。
                    $_SESSION[_MEMBER_AUTHINFO]['logintime'] = time();
                    //上記の更新で$_SESSION[userinfo]['logintime']の配列が消えてしまうので、作り直す。
                }
            }
        }

        $this->form->addElement('submit','submit',  $btn,'button class="btn btn-danger"');//「更新する」ボタン
        $this->form->addElement('submit','submit2', $btn2,'button class="btn btn-default"');//「戻る」ボタン
        $this->form->addElement('reset', 'reset',   '取り消し','button class="btn btn-default"');
        $this->view_display();
    }


    //----------------------------------------------------
    // アカウント削除画面
    //----------------------------------------------------
    public function screen_delete(){
        // データベースを操作します。
        $MemberModel = new MemberModel();
        if($this->action == "confirm"){//会員トップ画面の「退会する」のURLはaction=confirmなので、まずはここのifに入る。
        	
            if($this->is_system){//管理者側表示
                $_SESSION[_MEMBER_AUTHINFO] = $MemberModel->get_member_data_id($_GET['id']);//SystemControllerから呼び出された場合は、削除対象者のidは
                //GETで受け取ることになるので、受け取ったid番号の全てのユーザー情報を$_SESSION[userinfo]へ入れる。
                //$_GET[id]をそのまま使用しないのは、下記のdelete_memberメソッドでの形に合わせるため。
                
                $this->message  = "[削除する]をクリックすると　";
                $this->message .= htmlspecialchars($_SESSION[_MEMBER_AUTHINFO]['last_name'], ENT_QUOTES);
                //$this->message .= htmlspecialchars($_SESSION[_MEMBER_AUTHINFO]['first_name'], ENT_QUOTES);
                $this->message .= "さん　の会員情報を削除します。";
                $this->form->addElement('submit','submit', "削除する");
            }else{//ユーザー用表示
                $this->message = "「アカウントを削除する」を押すと、あなたのアカウント情報とリマインダースケジュールが削除されます。<br><br>よろしいですか？";
                $this->form->addElement('submit','submit', "アカウントを削除する",'class="btn btn-default"');
            }
            
            //postで送る属性は管理者側、ユーザー側共に同じ。
            $this->next_type  = 'delete';
            $this->next_action  = 'complete';
            $this->title = 'アカウント削除確認画面';
            $this->file = 'delete_form.tpl';
            
        }else if($this->action == "complete"){//「退会する」ボタンを押したとき、$this->action == "complete"となるのでここに入る。
        	//削除画面のactionは、confirmかcompleteの２パターンしかないのでelse ifを使っているのかも。
        	
            $MemberModel->delete_member($_SESSION[_MEMBER_AUTHINFO]['id']);//idをキーにして削除処理を実行
            if($this->is_system){
            	if($_SESSION[_MEMBER_AUTHINFO]['list_url'] != null){
            		unlink("./list/".$_SESSION[_MEMBER_AUTHINFO]['list_url'].".html");//htmlファイルがあれば削除
            	}
                unset($_SESSION[_MEMBER_AUTHINFO]);//管理者の場合は$_SESSION[_MEMBER_AUTHINFO][id]を破棄
            }else{
            	$MemberModel->remove_all_ken_messe_sche($_SESSION[_MEMBER_AUTHINFO]['id']);
                $this->auth->logout();//クッキーやセッション変数を破棄し、ログアウト。
            }
            $this->message = "アカウント情報を全て削除しました。ご利用ありがとうございました。";
            $this->title = '削除完了画面';
            $this->file = 'message.tpl';
        }
        $this->view_display();
    }
    
    //----------------------------------------------------
    // パスワード再設定
    //----------------------------------------------------
    public function screen_forget(){
    	$btn          = "";
    	$btn2         = "";
    	$this->file = "forget.tpl";
    	
    	// データベースを操作します。
    	$MemberModel = new MemberModel();
    	$PrememberModel = new PrememberModel();
    	
    	
    	$this->make_form_forget();//各入力欄の生成と、チェック用ルールを定義しています。
    	
    	if (!$this->form->validate()){//validate()実行前ならaction = "form"となり、入力フォームが表示される。
    		//validate()は多分HTML_QuickFormクラス内にあるメソッド。「確認画面へ」のボタンを押した後、バリデートが上手くいかなかった場合は、action = "form"のままとなり、
    		//再度「確認画面へ」のボタンを押す前の表示になる。バリデートがOKなら$this->action = "confirm"へ遷移
    		$this->action = "form";
    	}
    	
    	if($this->action == "form"){//「確認画面へ」のボタンを押す前の表示
    		$this->title  = 'パスワード再設定画面';
    		$this->next_type    = 'forget';//押す前はフォームのvalueが{next_type}。押したらtype　= 'forget'
    		$this->next_action  = 'confirm';//押す前はフォームのvalueが{next_action}。押したらaction = 'confirm'
    		$btn = '確認画面へ';
    	
    	}else if($this->action == "confirm"){//「確認画面へ」のボタンを押した後の表示
    		$this->title  = 'メール送信確認画面';
    		$this->next_type    = 'forget';//「登録する」を押す前はフォームのvalueが{next_type}。押したらtype　= 'forget'
    		$this->next_action  = 'complete';//「登録する」を押す前はフォームのvalueが{next_action}。押したらtype　= 'complete'
    		$this->form->freeze();//freeze()メソッドは、入力欄が消え、入力された値だけがブラウザ上に表示されます。
    		$btn = 'パスワード確認メールを送信する';
    		$btn2= '戻る';
    	
    	}else if($this->action == "complete" && isset($_POST['submit2']) && $_POST['submit2'] == '戻る'){//登録するボタンの隣にある「戻る」ボタンが押された時の表示。
    		//条件はaction == "complete"かつ$btn2がポストされた時。この場合はif($this->action == "form")の時の表示と同じ表示となる
    		 
    		$this->title  = 'パスワード再設定画面';
    		$this->next_type    = 'forget';
    		$this->next_action  = 'confirm';
    		$btn = '確認画面へ';
    	
    	}else if($this->action == "complete" && isset($_POST['submit']) && $_POST['submit'] == 'パスワード確認メールを送信する'){//登録するボタンが押された時
    		//action == "complete"かつ$btnがポストされた時
    		 
    		// データベースを操作処理開始。
    		$PrememberModel = new PrememberModel();
    		$MemberModel = new MemberModel();
    		
    		$userdata = $this->form->getSubmitValues();//フォームに入力された２つのデータが、$userdataに配列で格納される
    		if( $MemberModel->check_username($userdata) || $PrememberModel->check_username($userdata) ){
    			//$userdata['username']がusername欄にあるかを、member、prememberの両方のテーブルで検索。あった場合このカッコに入る。
    				$userdata['password'] = $this->auth->get_hashed_password($userdata['password']);//新しいパスワを暗号化
    				$userdata['id'] = $MemberModel->get_member_data_id_only($userdata['username']);//usernameからid番号を取得
    				$MemberModel->modify_password($userdata);//下記のget_authinfoはmemberテーブルから、全ての$userdata[]を更新するため、get_authinfoの前に
    				//新しいパスワードをmemberテーブルに入れる必要がある。modify_passwordはid番号が必要。
    				$userdata = $MemberModel->get_authinfo($userdata['username']);
				
    				$userdata['link_pass'] = hash('sha256', uniqid(rand(),1));//urlに付けるランダムな文字列を生成
    				$PrememberModel->regist_premember($userdata);//prememberテーブルにデータ登録
    				$this->reminder($userdata);//メル送信
    				$this->title    = 'メール送信完了画面';
    				$this->message  = "<p>登録されたメールアドレスへパスワード再設定のメールを送信しました。</p>";
    				$this->message .= '<p>メール本文に記載されているURLにアクセスして再登録を完了してください。</p>';
    			
    				//$this->file = "forget_message.tpl";
    				$this->file = "message.tpl";//premember登録完了時のテンプレート
    				
    		}else{
    			$this->title = 'パスワード再設定画面';
    			$this->message = "入力されたメールアドレスは登録されていません。";//登録が無かった場合は最初の画面プラス、エラーメッセージ付きで表示。
    			$this->next_type    = 'forget';
    			$this->next_action  = 'confirm';
    			$btn = '確認画面へ';
    		}
    	}
    	
    	$this->form->addElement('submit','submit',  $btn, 'button class="btn btn-danger"');
    	$this->form->addElement('submit','submit2', $btn2,'button class="btn btn-default"');
    	$this->form->addElement('reset', 'reset','取り消し','button class="btn btn-default"');
    	$this->view_display();    	
    }

    
    //----------------------------------------------------
    // メール関係
    //----------------------------------------------------
    //
    // 仮登録者へメール送信
    //
    public function mail_to_premember($userdata){
    	
    	require_once("Mail.php");
    	mb_language("Japanese");
    	mb_internal_encoding("UTF-8");
    	// GmailのSMTPサーバーの情報を連想配列にセット
    	$params = array(
    			"host" => "---Write here your SMTP server name ---",   // SMTPサーバー名
    			"port" => ,//---Write here port number ---              // ポート番号
    			"auth" => true,            // SMTP認証を使用する
    			"username" => "---Write here your SMTP user name ---",  // SMTPのユーザー名
    			"password" => "---Write here your SMTP password ---"   // SMTPのパスワード
    	);
    	// PEAR::Mailのオブジェクトを作成
    	// ※バックエンドとしてSMTPを指定
    	$mailObject = Mail::factory("smtp", $params);
		
		$path = pathinfo(_SCRIPT_NAME)['dirname'] ;
        
        $mail      = $userdata['username'];
        $subject = "会員登録の確認";
        $message =<<<EOM
{$userdata['username']}様

会員登録ありがとうございます。
下のリンクにアクセスして会員登録を完了してください。

http://{$_SERVER['SERVER_NAME']}{$path}/premember.php?link_pass={$userdata['link_pass']}


このメールに覚えがない場合はメールを削除してください。


------
ウィークデーリマインダー
http://mossgreen.main.jp/weekday/

EOM;

    $headers = array(
    		"To" => $mail,         // →ここで指定したアドレスには送信されない
    		"From" => "---Write here your mail adress ---",
    		"Subject" => mb_encode_mimeheader($subject) //日本語の件名を指定する場合、mb_encode_mimeheaderでエンコード
    );
    // 日本語なのでエンコード
    $message = mb_convert_encoding($message, "ISO-2022-JP", "UTF-8");
    // sendメソッドでメールを送信
    $mailObject->send($mail, $headers, $message);

    }
    
    
    //----------------------------------------------------
    // パスワード再設定をした人へメール送信。
    //----------------------------------------------------
    public function reminder($userdata){
    	
    	require_once("Mail.php");
    	mb_language("Japanese");
    	mb_internal_encoding("UTF-8");
    	// GmailのSMTPサーバーの情報を連想配列にセット
    	$params = array(
    			"host" => "---Write here your SMTP server name ---",   // SMTPサーバー名
    			"port" => ,//---Write here port number ---              // ポート番号
    			"auth" => true,            // SMTP認証を使用する
    			"username" => "---Write here your SMPT user name ---",  // SMTPのユーザー名
    			"password" => "---Write here your SMTP password ---",   // SMTPのパスワード
    			"protocol"=>"SMTP_AUTH"
    	);
    	// PEAR::Mailのオブジェクトを作成
    	// ※バックエンドとしてSMTPを指定
    	$mailObject = Mail::factory("smtp", $params);
		
$path = pathinfo(_SCRIPT_NAME)['dirname'] ;
    
    	$mail      = $userdata['username'];
    	$subject = "登録パスワード再設定の確認";
    	$message =<<<EOM
{$userdata['username']}様

パスワードの再設定を受け付けました。
下のリンクにアクセスしてパスワードの再設定を完了してください。

http://{$_SERVER['SERVER_NAME']}{$path}/premember.php?username={$userdata['username']}&link_pass={$userdata['link_pass']}

このメールに覚えがない場合はメールを削除してください。
    
    
------
ウィークデーリマインダー
http://mossgreen.main.jp/weekday/
    
EOM;

    $headers = array(
    		"To" => $mail,         // →ここで指定したアドレスには送信されない
    		"From" => "---Write here your mail adress ---",
    		"Subject" => mb_encode_mimeheader($subject) //日本語の件名を指定する場合、mb_encode_mimeheaderでエンコード
    );
    // 日本語なのでエンコード
    $message = mb_convert_encoding($message, "ISO-2022-JP", "UTF-8");
    // sendメソッドでメールを送信
    $mailObject->send($mail, $headers, $message);
    }
    
    //----------------------------------------------------
    // メールの変更をした人へメール送信。
    //----------------------------------------------------
    public function change_mail($userdata){
    
    	require_once("Mail.php");
    	mb_language("Japanese");
    	mb_internal_encoding("UTF-8");
    	// GmailのSMTPサーバーの情報を連想配列にセット
    	$params = array(
    			"host" => "---Write here your SMTP server name ---",   // SMTPサーバー名
    			"port" => ,//---Write here port number ---,              // ポート番号
    			"auth" => true,            // SMTP認証を使用する
    			"username" => "//---Write here your SMTP user name ---,",  // SMTPのユーザー名
    			"password" => "---Write here your SMTP password ---"   // SMTPのパスワード
    	);
    	// PEAR::Mailのオブジェクトを作成
    	// ※バックエンドとしてSMTPを指定
    	$mailObject = Mail::factory("smtp", $params);
    	
    
    	$mail      = $userdata['username'];
    	$subject = "登録メールアドレス再設定の確認";
    	$message =<<<EOM
{$userdata['username']}様

メールアドレスの変更を受け付けました。
下のリンクにアクセスしてメールアドレスの変更を完了してください。

http://{$_SERVER['SERVER_NAME']}/weekday/premember.php?username={$userdata['username']}&link_pass={$userdata['link_pass']}

このメールに覚えがない場合はメールを削除してください。
    
    
------
ウィークデーリマインダー
http://mossgreen.main.jp/weekday/
    
EOM;

    $headers = array(
    		"To" => $mail,         // →ここで指定したアドレスには送信されない
    		"From" => "---Write here your mail adress ---",
    		"Subject" => mb_encode_mimeheader($subject) //日本語の件名を指定する場合、mb_encode_mimeheaderでエンコード
    );
    // 日本語なのでエンコード
    $message = mb_convert_encoding($message, "ISO-2022-JP", "UTF-8");
    // sendメソッドでメールを送信
    $mailObject->send($mail, $headers, $message);
    }
    
}
?>