<?php

/**
 * Description of PrememberModel
 *
 * @author nagatayorinobu
 */
class PrememberModel extends BaseModel {//データベースに接続した上で使用するクラスである
    //----------------------------------------------------
    // 仮会員登録処理
    //----------------------------------------------------
    public function regist_premember($userdata){//本メンバー登録前の処理。prememberテーブルへ登録する。
        try {
            $this->pdo->beginTransaction();//トランザクション開始。もしエラーが発生した際の、巻き戻し処理の起点になる。復元ポイントのようなもの。
            $sql = "INSERT  INTO premember2 (username, password, link_pass, reg_date )
            VALUES ( :username, :password, :link_pass, now() )";
            
            $stmh = $this->pdo->prepare($sql);//外部から送信された変数を使用するため、プリペアドステートメントを使用します。
            $stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
            $stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
            //$stmh->bindValue(':last_name',  $userdata['last_name'],  PDO::PARAM_STR );
            //$stmh->bindValue(':first_name', $userdata['first_name'], PDO::PARAM_STR );
            //$stmh->bindValue(':birthday',   $userdata['birthday'],   PDO::PARAM_STR );
            //$stmh->bindValue(':ken',        $userdata['ken'],        PDO::PARAM_INT );
            $stmh->bindValue(':link_pass',  $userdata['link_pass'],  PDO::PARAM_STR );
            $stmh->execute();
            $this->pdo->commit();//トランザクション確定
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();//処理に失敗したときは処理を行う前まで巻き戻してエラーメッセージを表示
            print "エラー：" . $Exception->getMessage();
        }
    }

    //----------------------------------------------------
    // 仮登録テーブル内にusernameが1個以上あればtrueが返ります。登録時に必要になるため、会員、管理者、どちら側もこのメソッドを使います。
    //　このメソッドはprememberテーブルを検索するものなので、memberテーブルを検索するメソッドはMemberModel.php内にある。記述は「SELECT * FROM ●●」の所が違うだけ。
    //----------------------------------------------------
    public function check_username($userdata){
        try {
            $sql= "SELECT * FROM premember2 WHERE username = :username ";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',  $userdata['username'], PDO::PARAM_STR );
            $stmh->execute();
            $count = $stmh->rowCount();
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        if($count >= 1){//ヒットした件数が一個以上あるならば、
            return true;
        }else{
            return false;
        }
    }

    //----------------------------------------------------
    // 登録確認のメールで送られたリンクをクリックしてアクセスしたとき、ユーザーネームとlink_passで検索し、２つが合致する行があったとき、その行全てを配列に入れて返す。
    //このメソッドは下記のcheck_premember_newの前のバージョンだが、引数を二つ受け取ってDBを処理している珍しさがあるので、メモがてらとっておくことにした。
    //----------------------------------------------------
    public function check_premember($username, $link_pass){
        $data = [];
        try {
            $sql= "SELECT * FROM premember2 WHERE username = :username AND link_pass = :link_pass limit 1 ";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',  $username,  PDO::PARAM_STR );
            $stmh->bindValue(':link_pass', $link_pass, PDO::PARAM_STR );
            $stmh->execute();
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        return $data;//仮メンバーのユーザー情報、一行全てが配列として返る。検索でヒットが無ければnullが返ると思う
    }
    
    //----------------------------------------------------
    // 登録確認のメールで送られたリンクをクリックしてアクセスしたとき、link_passで検索し、合致する行があったとき、その行全てを配列に入れて返す
    //----------------------------------------------------
    public function check_premember_new($link_pass){
    	$data = [];
    	try {
    		$sql= "SELECT * FROM premember2 WHERE link_pass = :link_pass limit 1 ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':link_pass', $link_pass, PDO::PARAM_STR );
    		$stmh->execute();
    		$data = $stmh->fetch(PDO::FETCH_ASSOC);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;//仮メンバーのユーザー情報、一行全てが配列として返る。検索でヒットが無ければnullが返ると思う
    }

    //----------------------------------------------------
    // 仮登録会員の削除
    //----------------------------------------------------
    public function delete_premember_and_regist_member($userdata){
        try {
            $this->pdo->beginTransaction();
            $sql = "DELETE FROM premember2 WHERE id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id', $userdata['id'], PDO::PARAM_INT );//ここでの$userdata['id']はprememberテーブルでのid。
            $stmh->execute();
            $sql = "INSERT  INTO member2 (username, password, last_name, birthday, ken, reg_date, last_login_date )
            VALUES ( :username, :password, :last_name, :birthday, :ken , now(), now() )";//now()でreg_dateとlast_login_dateカラムに現在時刻を入れている。
            //仮登録URLをクリックして、一回もログインしない人もいると考えられるため、後で削除できるようにクリックした時点でlast_login_dateカラムに日付を入れる。
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
            $stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
            $stmh->bindValue(':last_name',  $userdata['last_name'],  PDO::PARAM_STR );
            $stmh->bindValue(':birthday',   $userdata['birthday'],   PDO::PARAM_STR );//ここのbirthdayは削除禁止
            $stmh->bindValue(':ken',        $userdata['ken'],        PDO::PARAM_INT );
            $stmh->execute();
            $this->pdo->commit();
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー：" . $Exception->getMessage();
        }
    }
}
?>