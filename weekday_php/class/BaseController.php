<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * コントローラの基本クラス
 */

/**
 * Description of BaseController
 *
 * @author nagatayorinobu
 */
class BaseController {
    protected $type;//継承先で使用する変数
    protected $action;//継承先で使用する変数
    protected $next_type;//次の処理を設定する変数
    protected $next_action;//次の処理を設定する変数
    protected $file;
    protected $form;
    protected $renderer;
    protected $auth;
    protected $is_system = false;
    protected $view;
    protected $title;
    protected $message;
    protected $message2;
    protected $message3;
    protected $modoru;
	protected $cancel;
    protected $auth_error_mess;
    protected $login_state;
    protected $web_app_name;
    protected $web_app_detail;
    private   $debug_str;
    
    public function __construct($flag=false){//このオブジェクト生成時(newの時)に実行される処理
        $this->set_system($flag);// 管理者かユーザーかを識別する
        
        $this->view_initialize();// VIEWの準備
    }
    

    public function set_system($flag){// 管理者かユーザーかを識別する
        $this->is_system = $flag;
    }
    
    private function view_initialize(){// 画面表示クラス。smartyの準備を整える
        $this->view = new Smarty;
        // Smarty関連ディレクトリの設定
        $this->view->template_dir = _SMARTY_TEMPLATES_DIR;
        $this->view->compile_dir  = _SMARTY_TEMPLATES_C_DIR;
        $this->view->config_dir   = _SMARTY_CONFIG_DIR;
        $this->view->cache_dir    = _SMARTY_CACHE_DIR;

        
        $this->form    = new HTML_QuickForm();// 入力チェック用クラス
        
        $this->form->setJsWarnings("入力エラーです。", "上記項目を修正してください。");// JavaScriptのメッセージを日本語に修正
        
        $this->renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->view);// HTML_QickFormとSmartyを使うためのクラス

        
        // リクエスト変数 typeとactionでページ遷移の動作を決めます。
        //スーパーグローバル変数の$_REQUESTは、POSTで送られたものでもGETで送られたものでも両方の値を参照することが出来る変数です。
        if(isset($_REQUEST['type'])){
        	$this->type   = $_REQUEST['type'];
        }
        if(isset($_REQUEST['action'])){
        	$this->action = $_REQUEST['action'];
        }

        // 共通の変数
        $this->view->assign('is_system',   $this->is_system );
        $this->view->assign('SCRIPT_NAME', _SCRIPT_NAME);
        $this->view->assign('add_pageID',  $this->add_pageID());

    }


    //----------------------------------------------------
    // フォームと変数を読み込んでテンプレートに組み込んで表示します。
    //----------------------------------------------------
    protected function view_display(){// セッション変数などの内容の表示
        $this->debug_display();

        // ログイン状況の表示
        $this->disp_login_state();
        
        $this->view->assign('title', $this->title);
        $this->view->assign('auth_error_mess', $this->auth_error_mess);
        $this->view->assign('message', $this->message);
        $this->view->assign('message2', $this->message2);
        $this->view->assign('message3', $this->message3);
        $this->view->assign('modoru', $this->modoru);
		$this->view->assign('cancel', $this->cancel);
        $this->view->assign('disp_login_state', $this->login_state);
        $this->view->assign('type',    $this->next_type);//次の画面へ遷移する際のタイプをここで設定
        $this->view->assign('action',  $this->next_action);//次の画面へ遷移する際のタイプをここで設定
        $this->view->assign('web_app_name', $this->web_app_name);
        $this->view->assign('web_app_detail', $this->web_app_detail);
        
        $this->view->assign('debug_str', $this->debug_str);
        $this->form->accept($this->renderer);
        $this->view->assign('form', $this->renderer->toArray());
        $this->view->display($this->file);
    }
    
    //----------------------------------------------------
    // ログイン者ステータスの表示
    //----------------------------------------------------
    private function disp_login_state(){
        if(is_object($this->auth) && $this->auth->check()){
            $this->login_state = ($this->is_system)? '管理者ログイン中' : '会員ログイン中';
        }
    }
    
    
    //----------------------------------------------------
    // 会員情報入力項目と入力ルールの設定
    //----------------------------------------------------
    public function make_form_controle(){
        //$KenModel = new KenModel;
        $ken_array = "";//$KenModel->get_ken_data();コンビニの全データをDBから取得
        /*  $options = [
            'format'    => 'Ymd',
            'minYear'   => 1950,
            'maxYear'   => date("Y"),];//誕生日入力欄、日付のプルダウンメニューを形成するためのテンプレ。*/

        $this->form->addElement('text',   'username',     'メールアドレス','class=form-control',['size' => 30]);//$this->formにはHTML_QuickFromクラスのオブジェクトが格納されています。ラベルの次に続く引数でclassを設定できるようだ
        $this->form->addElement('text',   'password',     'パスワード','class=form-control',['size' => 30]);

        $this->form->addRule('username',  'メールアドレスを入力してください。','required', null, 'server');
        $this->form->addRule('username',  'メールアドレスの形式が不正です。',   'email', null, 'server');
        $this->form->addRule('password',  'パスワードを入力してください。',     'required', null, 'server');
        $this->form->addRule('password',  'パスワードは5〜16文字の範囲で入力してください。','rangelength', [5,50], 'server');
        $this->form->addRule('password',  'パスワードは半角の英数字を使ってください。記号も可（ _ - ! ? # $ % & ）','regex', '/^[a-zA-z0-9_\-!?#$%&]*$/', 'server');
        //$this->form->addRule('first_name','名を入力してください。', 'required', null, 'server');
        //addRuleメソッドは入力チェック時のルールを入力欄毎に設定します。addRule(name属性,エラーメッセージ,ルール,オプション,チェックする場所)。設定方法はp294を参照するか、ネットで調べて。
		//バリデートでエラーがあった場合は、テンプレート内にある{$form.●●.error}の箇所にエラーメッセージが表示される
        
        $this->form->applyFilter('__ALL__', 'trim');//全ての要素にtrim関数を実行するように指定しています。 trim関数を通すことによって空白のみの入力や不要な値を防ぐことができます。
        //個々の要素にフィルタを指定することも可能です
    }
    
    
    public function make_store_form(){
    	$KenModel = new KenModel;
    	$ken_array = $KenModel->get_ken_data();
    	$this->form->addElement('select', 'ken','コンビ二名',$ken_array);
    }
    
    public function make_day_form(){
    	$day_array = array("毎月の1日","2日","3日","4日","5日","6日","7日","8日","9日","10日","11日","12日","13日","14日","15日","16日","17日","18日","19日","20日","21日","22日","23日","24日","25日","26日","27日","28日","29日","30日","31日");
    	$this->form->addElement('select', 'day','対象となる日にち：',$day_array,'class="form-control"');
    }
    
    public function make_sendday_option_form(){
    	$option_array = array("祝日だった時","土曜だった時","日曜だった時","土日祝だった時");
    	$this->form->addElement('select', 'option','上記の日にちが：',$option_array,'class="form-control"');
    }
    
    public function make_send_timing_form(){
    	$timing_array = array("当日","前日","前営業日","翌日","翌営業日");
    	$this->form->addElement('select', 'timing','リマインダーを送信するタイミング：',$timing_array,'class="form-control"');
    }
    
    public function make_send_time_form(){
    	$time_array = array("1時","2時","3時","4時","5時","6時","7時","8時","9時","10時","11時","12時","13時","14時","15時","16時","17時","18時","19時","20時","21時","22時","23時",);
    	$this->form->addElement('select', 'time','リマインダーを送信する時間：',$time_array,'class="form-control"');
    }
    
    public function make_week_form(){
    	$week_array = array("日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日","何曜日かに関わらず");
    	$this->form->addElement('select', 'week','対象となる曜日：',$week_array,'class="form-control"');
    }
    
    public function make_start_form(){
    	$start_array = array("月初から数えて","月末から数えて");
    	$this->form->addElement('select', 'start','数え始める日：',$start_array,'class="form-control"');
    }
    
    public function make_eigyoubi_form(){
    	$eigyoubi_array = array("最終営業日","最初営業日","第2営業日","第3営業日","第4営業日","第5営業日","6営業日","7営業日","8営業日","9営業日","10営業日","11営業日","12営業日","13営業日","14営業日","15営業日","16営業日","17営業日","18営業日","19営業日","20営業日");
    	$this->form->addElement('select', 'eigyoubi','営業日：',$eigyoubi_array,'class="form-control"');
    }
    
    
    public function tabalist_reg(){
    	$main = array();
    	$secondary = array();
    	
    	$main[0] = "ウィンストン";//$_POST['tabacco'][0]の群
    	$main[1] = "キャスター";
    	$main[2] = "キャビン";
    	$secondary[0]["001"] = "XS・キャスター・エフアール・ワン・ボックス";//$_POST['tabacco'][1]の群
    	$secondary[0]["002"] = "XS・10・ボックス";
    	$secondary[0]["003"] = "XS・3・100s・ボックス";
    	$secondary[1]["028"] = "ゴールドシルク・6・ボックス";
    	$secondary[2]["029"] = "ゴールドワイルド・8・ボックス";
    	$secondary[3]["030"] = "セブンスター";
    	$secondary[3]["031"] = "セブンスター・1";
    	$secondary[3]["032"] = "セブンスター・10";
    	//後でもし登録するタバコが増えたとしても、""の中の数字と、tabaccoテーブルの番号さえ合わせれば問題無いはず。
    	
    	$sel =& $this->form->addElement('hierselect', 'tabacco', 'タバコの種類');//addElementの1つめがパーツのタイプ。2つ目がsmartyテンプレに記述するものらしい。
    	$sel->setMainOptions($main);
    	$sel->setSecOptions($secondary);
    	$this->form->addElement('text', 'tabako_num', '設定する番号','class=form-control placeholder="ここに数字を入力して下さい"', ['size' => 15, 'maxlength' => 50]);
    	$this->form->addElement('submit', 'btnSubmit', '登録','button class="btn btn-danger"');
    }
    
    
    
    //----------------------------------------------------
    // パスワード再設定項目と入力ルールの設定
    //----------------------------------------------------
    public function make_form_forget(){
    
    	$this->form->addElement('text',   'username',     '登録したメールアドレス','class=form-control', ['size' => 30]);//$this->formにはHTML_QuickFromクラスのオブジェクトが格納されています。
    	$this->form->addElement('text',   'password',     '新しいパスワード','class=form-control',['size' => 30]);

    
    	$this->form->addRule('username',  'メールアドレスを入力してください。','required', null, 'server');
    	$this->form->addRule('username',  'メールアドレスの形式が不正です。',   'email', null, 'server');
    	$this->form->addRule('password',  'パスワードを入力してください。',     'required', null, 'server');
    	$this->form->addRule('password',  'パスワードは5～16文字の範囲で入力してください。','rangelength', [5, 50], 'server');
    	$this->form->addRule('password',  'パスワードは半角の英数字、記号（ _ - ! ? # $ % & ）を使ってください。','regex', '/^[a-zA-z0-9_\-!?#$%&]*$/', 'server');
    	//addRuleメソッドは入力チェック時のルールを入力欄毎に設定します。addRule(name属性,エラーメッセージ,ルール,オプション,チェックする場所)。設定方法はp294を参照するか、ネットで調べて。
    	//バリデートでエラーがあった場合は、テンプレート内にある{$form.●●.error}の箇所にエラーメッセージが表示される
    
    	$this->form->applyFilter('__ALL__', 'trim');//全ての要素にtrim関数を実行するように指定しています。 trim関数を通すことによって空白のみの入力や不要な値を防ぐことができます。
    	//個々の要素にフィルタを指定することも可能です
    }
    
    //----------------------------------------------------
    // リマインダータイトル項目と入力ルールの設定
    //----------------------------------------------------
    public function make_form_reminder_title(){
    
    	$this->form->addElement('text',   'rem_title',     'リマインダーで送る文章(200文字まで)：','class=form-control placeholder="リマインダーで送信するテキストを入力して下さい"', ['size' => 30]);//$this->formにはHTML_QuickFromクラスのオブジェクトが格納されています。
    
    	$this->form->applyFilter('__ALL__', 'trim');//全ての要素にtrim関数を実行するように指定しています。 trim関数を通すことによって空白のみの入力や不要な値を防ぐことができます。
    	//個々の要素にフィルタを指定することも可能です
    }
    
    
    
    //----------------------------------------------------
    // 検索処理関係
    //----------------------------------------------------
    //
    // pageIDをURLに追加。
    //
    public function add_pageID(){
        if( !($this->is_system && $this->type == 'list') ){
			return;
			}

        $add_pageID = "";
        if(isset($_GET['pageID']) && $_GET['pageID'] != ""){
            $add_pageID = '&pageID=' . $_GET['pageID'];
            $_SESSION['pageID'] = $_GET['pageID'];
        }else if(isset($_SESSION['pageID']) && $_SESSION['pageID'] != ""){
            $add_pageID = '&pageID=' . $_SESSION['pageID'];
        }
        return $add_pageID;
    }

    //----------------------------------------------------
    // ページ分割処理
    //----------------------------------------------------
    public function make_page_link($data,$disp_search_key){
        // Slindingを使用する場合
        //require_once 'Pager/Sliding.php';

        // Pagerを使用する場合
        require_once 'Pager/Jumping.php';

        $params = [
            'mode'      => 'Jumping',
            'perPage'   => 10,
            'delta'     => 10,
            'itemData'  => $data,
			'importQuery' => false,
  			'extraVars' => array('type' => 'list',
								'query' => $disp_search_key)
        ];
		//詳しくはhttp://dqn.sakusakutto.jp/2011/07/pearpagerurl.html

        // PHP5でSlindingを使用する場合
        //$pager = new Pager_Sliding($params);

        // PHP5でPagerを使用する場合
        $pager = new Pager_Jumping($params);

        $data  = $pager->getPageData();
        $links = $pager->getLinks();
        
        return [$data, $links];
    }    

    //----------------------------------------------------
    // デバッグ用表示処理
    //----------------------------------------------------
    public function debug_display(){
        if(_DEBUG_MODE){
            $this->debug_str = "";
            if(isset($_SESSION)){
                $this->debug_str .= '<BR><BR>$_SESSION<BR>'; 
                $this->debug_str .= var_export($_SESSION, TRUE);
            }
            if(isset($_POST)){
                $this->debug_str .= '<BR><BR>$_POST<BR>'; 
                $this->debug_str .= var_export($_POST, TRUE);
            }
            if(isset($_GET)){
                $this->debug_str .= '<BR><BR>$_GET<BR>'; 
                $this->debug_str .= var_export($_GET, TRUE);
            }
            // smartyのデバッグモード設定 ポップアップウィンドウにテンプレート内の変数を
            // 表示します。
            $this->view->debugging = _DEBUG_MODE;
        }
    }
}

?>
