<?php
/**
 * Description of PrememberController
 *
 * @author nagatayorinobu
 * 仮登録者がリンクをクリックしてアクセスするページ。
 */
class PrememberController extends BaseController {
    public function run(){
    	$this->web_app_name = "ウィークデーリマインダー";
    	$this->web_app_detail = "祝日や営業日を条件にしてリマインダー通知を受け取れるwebサービスです";
        if (isset($_GET['link_pass'])){//URLの中に、link_passを示すものがあるかどうか。
        // 必要なパラメータがある
            // パラメータ２つをもとにデータベース(prememberテーブル)を検索します。
            $PrememberModel = new PrememberModel();
            $userdata = $PrememberModel->check_premember_new($_GET['link_pass']);
            
            if(!empty($userdata) && count($userdata) >= 1){//$userdataの中にデータが存在する、且つ$userdataの配列が１個以上ある。($_GET['link_pass']が正しい事になる)
            	//上記のcheck_premember_newで、$userdataには配列が1列分returnしてくる。
            	
            	
            	
            	$MemberModel = new MemberModel();
            	if (isset($_GET['username'])){//usernameをGETで受け取れたとき。(パスワ再設定の時)
	            	if($MemberModel->check_username_from_mail($_GET['username'])){//メンバーテーブルのusernameカラムに$_GET['username']がある場合
	            		$MemberModel->reflesh_password($userdata);//prememerのパスワをmemberのパスワに移動            		
	            		$MemberModel->delete_premember_username($userdata['username']);//prememerのusernameの列を全て削除
	            		$this->title = '登録完了画面';
	            		$this->message = '登録を完了しました。トップページよりログインしてください。';
	            		}else{//memberテーブルのusernameカラムに、$_GET['username']が無かった時
	            			if($MemberModel->check_change_name_from_mail($_GET['username'])){//memberテーブルのchange_nameカラムに$_GET['username']があったとき(メールアドレス変更時の時のクリック)
	            				$MemberModel->reflesh_username($_GET['username']);//クリックされた新しいアドレスをusernameカラムに上書き
	            				$MemberModel->delete_premember_username($userdata['username']);//prememerのusernameの列を全て削除
	            				$this->title = '登録完了画面';
	            				$this->message = 'メールアドレスを変更しました';
	            				
	            				
	            				
	            			}else{
	            				$this->title = 'エラー画面';
	            				$this->message = 'クリックしたURLは無効です';
	            			}
	            		}
            	}else{//クリックしたURLに$_GET['username']が無かった時
                	$PrememberModel->delete_premember_and_regist_member($userdata);//新規登録の時の処理。prememberテーブルから削除して、memberテーブルへデータを挿入する
                	$this->title = '登録完了画面';
                	$this->message = '登録を完了しました。トップページよりログインしてください。';
            	}
                
            }else{
            // パラメータがprememberテーブルのものと合致しない
                $this->title = 'エラー画面';
                $this->message = 'クリックしたURLは無効です。';
            }
        }else{
        // 必要なパラメータがない
            $this->title = 'エラー画面';
            $this->message = 'クリックしたURLは無効です。';
        }
        $this->file = 'premember.tpl'; 
        $this->view_display();
    }    
    

}

?>
