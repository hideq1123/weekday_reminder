<?php
/**
 * Description of MemberModel
 *
 * @author nagatayorinobu
 */
class MemberModel extends BaseModel {
    //----------------------------------------------------
    // 会員登録処理
    //----------------------------------------------------
    public function regist_member($userdata){
        try {
            $this->pdo->beginTransaction();
            $sql = "INSERT  INTO member2 (username, password, last_name, ken, reg_date, last_login_date )
            VALUES ( :username, :password, :last_name, :ken , now(),now() )";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
            $stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
            $stmh->bindValue(':last_name',  $userdata['last_name'],  PDO::PARAM_STR );
            //$stmh->bindValue(':first_name', $userdata['first_name'], PDO::PARAM_STR );
            //$stmh->bindValue(':birthday',   $userdata['birthday'],   PDO::PARAM_STR );
            $stmh->bindValue(':ken',        $userdata['ken'],        PDO::PARAM_INT );
            $stmh->execute();
            $this->pdo->commit();
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー：" . $Exception->getMessage();
        }
    }

    //----------------------------------------------------
    // 会員のユーザ名（メールアドレス）と同じものがないか調べ、有か無かだけを返す。
    //　prememberテーブルに対して検索をかけるメソッドは、PrememberModel.php内にある。
    //----------------------------------------------------
    public function check_username($userdata){
        try {
            $sql= "SELECT * FROM member2 WHERE username = :username ";
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
    // 会員のユーザ名（メールアドレス）とchange_nameカラムに同じものがないか調べ、有か無かだけを返す。
    //----------------------------------------------------
    public function check_change_name($userdata){
    	try {
    		$sql= "SELECT * FROM member2 WHERE change_name = :change_name ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':change_name',  $userdata['username'], PDO::PARAM_STR );
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
    // 仮登録用のURLをクリックしたとき、仮登録に使用したユーザ名（メールアドレス）と同じものがmemberテーブルのusernameカラムにあるか無いか調べ、有か無かだけを返す。
    //----------------------------------------------------
    public function check_username_from_mail($userdata){
    	try {
    		$sql= "SELECT * FROM member2 WHERE username = :username ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':username',  $userdata, PDO::PARAM_STR );
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
    // 仮登録用のURLをクリックしたとき、仮登録に使用したユーザ名（メールアドレス）と同じものがmemberテーブルのchange_nameカラムにあるか無いか調べ、有か無かだけを返す。
    //----------------------------------------------------
    public function check_change_name_from_mail($userdata){
    	try {
    		$sql= "SELECT * FROM member2 WHERE change_name = :change_name ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':change_name',  $userdata, PDO::PARAM_STR );
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
    // 会員情報をユーザー名（メールアドレス）で検索し、ヒットした場合、一行のデータ全てを配列で返す。
    //----------------------------------------------------
    public function get_authinfo($username){
        $data = [];
        try {
            $sql= "SELECT * FROM member2 WHERE username = :username limit 1";//limit 1は、検索結果から1件だけ取得するという指定です
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',  $username,  PDO::PARAM_STR );
            $stmh->execute();
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        return $data;
    }



    //----------------------------------------------------
    // 会員情報をidで検索し、ヒットした場合、一行のデータ全てを配列で返す。
    //----------------------------------------------------
    public function get_member_data_id($id){
        $data = [];
        try {
            $sql= "SELECT * FROM member2 WHERE id = :id limit 1";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id', $id, PDO::PARAM_INT );
            $stmh->execute();
            $data = $stmh->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        return $data;
    }
    
    //----------------------------------------------------
    // ken_messe1をidとmesse_Noで検索し、ヒットした場合、一行のデータ全てを配列で返す。
    //----------------------------------------------------
    public function get_ken_messe1_sche($id,$messe_No){
    	$data = [];
    	try {
    		$sql= "SELECT * FROM ken_messe1 WHERE id = :id AND messe_No = :messe_No limit 1";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_No, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetch(PDO::FETCH_ASSOC);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;
    }
    
    //----------------------------------------------------
    // ken_messe2をidとmesse_Noで検索し、ヒットした場合、一行のデータ全てを配列で返す。
    //----------------------------------------------------
    public function get_ken_messe2_sche($id,$messe_No){
    	$data = [];
    	try {
    		$sql= "SELECT * FROM ken_messe2 WHERE id = :id AND messe_No = :messe_No limit 1";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_No, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetch(PDO::FETCH_ASSOC);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;
    }
    
    //----------------------------------------------------
    // ken_messe3をidとmesse_Noで検索し、ヒットした場合、一行のデータ全てを配列で返す。
    //----------------------------------------------------
    public function get_ken_messe3_sche($id,$messe_No){
    	$data = [];
    	try {
    		$sql= "SELECT * FROM ken_messe3 WHERE id = :id AND messe_No = :messe_No limit 1";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_No, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetch(PDO::FETCH_ASSOC);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;
    }
    
    
    
    //----------------------------------------------------
    // 会員情報をusernameで検索し、ヒットした場合、id番号だけを返す。
    //----------------------------------------------------
    public function get_member_data_id_only($username){
    	$data = [];
    	try {
    		$sql= "SELECT * FROM member2 WHERE username = :username limit 1";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':username', $username, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetch(PDO::FETCH_ASSOC);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data['id'];
    }

    
    //----------------------------------------------------
    // id指定でpasswordの更新処理
    //----------------------------------------------------
    public function modify_password($userdata){//ここでの引数$userdataは、更新画面から送信されたデータです。idの指定が必須。
            try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE  member2
                      SET 
                        username   = :username,
                        password   = :password
                      WHERE id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
            $stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
            $stmh->bindValue(':id',         $userdata['id'],         PDO::PARAM_INT );
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー：" . $Exception->getMessage();
        }
    }
    
    //----------------------------------------------------
    // id指定でchange_nameに変更しようとするアドレスを登録する処理
    //----------------------------------------------------
    public function resist_change_name($userdata){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  member2
                      SET
                        change_name   = :change_name
                      WHERE id = :id";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':change_name',   $userdata['username'],   PDO::PARAM_STR );
    		$stmh->bindValue(':id',         $userdata['id'],         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    
    //----------------------------------------------------
    // id指定でmax_messe_noの更新処理
    //----------------------------------------------------
    public function modify_max_messe_no($id,$messe_No){//ここでの引数$userdataは、更新画面から送信されたデータです。idの指定が必須。
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  member2
                      SET
                        max_messe_no   = :max_messe_no
                      WHERE id = :id";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':max_messe_no',   $messe_No,   PDO::PARAM_INT );
    		$stmh->bindValue(':id',         $id,         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    
    //----------------------------------------------------
    // username指定でpasswordの更新処理。PrememberControllerで使用
    //----------------------------------------------------
    public function reflesh_password($userdata){//ここでの引数$userdataは、usenameの指定が必須。
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  member2
                      SET
                        password   = :password
                      WHERE username = :username";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
    		$stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // 新しいusername指定でusernameの上書き処理。PrememberControllerで使用
    //----------------------------------------------------
    public function reflesh_username($userdata){//ここでの引数$userdataは、usenameの指定が必須。
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  member2
                      SET
                        username   = :username
                      WHERE change_name = :change_name";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':username',   $userdata,   PDO::PARAM_STR );
    		$stmh->bindValue(':change_name',   $userdata,   PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // last_login_dateの更新処理
    //----------------------------------------------------
      public function input_last_login_date($userdata){//ここでの引数$userdataは、更新画面から送信されたデータです。idの指定が必須。
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  member2
                      SET
                        last_login_date   = :last_login_date
                      WHERE id = :id";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':last_login_date',   $userdata['last_login_date'],   PDO::PARAM_STR );
    		$stmh->bindValue(':id',         $userdata['id'],         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    
    

    //----------------------------------------------------
    // 会員情報の更新処理
    //----------------------------------------------------
    public function modify_member($userdata){//ここでの引数$userdataは、更新画面から送信された全データです
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE  member2
                      SET 
                        username   = :username,
                        password   = :password
                      WHERE id = :id";//←ken=:kenを抜いた。
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':username',   $userdata['username'],   PDO::PARAM_STR );
            $stmh->bindValue(':password',   $userdata['password'],   PDO::PARAM_STR );
            //$stmh->bindValue(':ken',        $userdata['ken'],        PDO::PARAM_INT );
            $stmh->bindValue(':id',         $userdata['id'],         PDO::PARAM_INT );
            $stmh->execute();
            $this->pdo->commit();
            
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー：" . $Exception->getMessage();
        }
    }


    //----------------------------------------------------
    // idをキーにして会員情報を全て削除する
    //----------------------------------------------------
    public function delete_member($id){
        try {
            $this->pdo->beginTransaction();
            $sql = "DELETE FROM member2 WHERE id = :id";
            $stmh = $this->pdo->prepare($sql);
            $stmh->bindValue(':id', $id, PDO::PARAM_INT );
            $stmh->execute();
            $this->pdo->commit();
            //print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
        } catch (PDOException $Exception) {
            $this->pdo->rollBack();
            print "エラー：" . $Exception->getMessage();
        }
    }
    
    //----------------------------------------------------
    // usernameをキーにして会員情報を全て削除する
    //----------------------------------------------------
    public function delete_member_username($username){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "DELETE FROM member2 WHERE username = :username";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':username', $username, PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    		//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // usernameをキーにしてprememberの会員情報を全て削除する
    //----------------------------------------------------
    public function delete_premember_username($username){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "DELETE FROM premember2 WHERE username = :username";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':username', $username, PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    		//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }

    //----------------------------------------------------
    // 3年以上ログインしていないユーザーのid番号を配列で返す。
    //----------------------------------------------------
    public function get_no3year(){
    	$data = [];
    	try {
    		$sql= "SELECT id FROM member2 WHERE last_login_date < DATE_SUB( CURDATE(),INTERVAL 1095 DAY );";
    		$stmh = $this->pdo->prepare($sql);
    		//$stmh->bindValue(':username', $username, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetchAll(PDO::FETCH_ASSOC);//検索結果が２行以上ある場合は、fetchAllで結果を取得する必要があるらしい。
    		//$data = mysql_fetch_row($stmh);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;
    }
    
    //----------------------------------------------------
    // 3年以上ログインしていないユーザーを、IDを元に削除する
    //----------------------------------------------------
    public function remove_no3year($id){//上記get_no365()で取得したデータが渡ってくるので、受け取るデータは(例え１個でも)配列の形式となる
    	$count = count($id);//削除すべき人数
    	$i = 0;
    	while($i < $count){//配列の数だけ繰り返す
	    	try {
				$this->pdo->beginTransaction();
				$sql = "DELETE FROM member2 WHERE id = :id";
				$stmh = $this->pdo->prepare($sql);
				
				$stmh->bindValue(':id', $id[$i]['id'], PDO::PARAM_INT );//配列の番号は、真ん中にくる事に注意！
				
				$stmh->execute();
				$this->pdo->commit();
	            //print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
	        }catch (PDOException $Exception) {
	            $this->pdo->rollBack();
	            print "エラー：" . $Exception->getMessage();
	        }
	    $i = $i + 1;
    	}
    }
    
    //----------------------------------------------------
    // アカウントを削除するボタンを押したユーザーのスケジュールを、ken_messe1,2,3から削除する
    //----------------------------------------------------
    public function remove_all_ken_messe_sche($id){////配列の数だけ繰り返す
    		try {
    			$this->pdo->beginTransaction();
    			$sql = "DELETE FROM ken_messe1 WHERE id = :id";
    			$stmh = $this->pdo->prepare($sql);
    			$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    			$stmh->execute();
    			$this->pdo->commit();
    			//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    		}catch (PDOException $Exception) {
    			$this->pdo->rollBack();
    			print "エラー：" . $Exception->getMessage();
    		}
    		
    		try {
    			$this->pdo->beginTransaction();
    			$sql = "DELETE FROM ken_messe2 WHERE id = :id";
    			$stmh = $this->pdo->prepare($sql);
    			$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    			$stmh->execute();
    			$this->pdo->commit();
    			//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    		}catch (PDOException $Exception) {
    			$this->pdo->rollBack();
    			print "エラー：" . $Exception->getMessage();
    		}
    		
    		try {
    			$this->pdo->beginTransaction();
    			$sql = "DELETE FROM ken_messe3 WHERE id = :id";
    			$stmh = $this->pdo->prepare($sql);
    			$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    			$stmh->execute();
    			$this->pdo->commit();
    			//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    		}catch (PDOException $Exception) {
    			$this->pdo->rollBack();
    			print "エラー：" . $Exception->getMessage();
    		}
    }
    
    //----------------------------------------------------
    // 3日以上クリックのないprememberテーブルユーザーのid番号を配列で返す。
    //----------------------------------------------------
    public function get_no3days(){
    	$data = [];
    	try {
    		$sql= "SELECT id FROM premember2 WHERE reg_date < DATE_SUB( CURDATE(),INTERVAL 3 DAY );";
    		$stmh = $this->pdo->prepare($sql);
    		//$stmh->bindValue(':username', $username, PDO::PARAM_INT );
    		$stmh->execute();
    		$data = $stmh->fetchAll(PDO::FETCH_ASSOC);//検索結果が２行以上ある場合は、fetchAllで結果を取得する必要があるらしい。
    		//$data = mysql_fetch_row($stmh);
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return $data;
    }
    
    //----------------------------------------------------
    // 3日以上ロクリックのないユーザーを、IDを元にprememberテーブルから削除する
    //----------------------------------------------------
    public function preremove_no3days($id){//上記get_no3days()で取得したデータが渡ってくるので、受け取るデータは(例え１個でも)配列の形式となる
    	$count = count($id);//削除すべき人数
    	$i = 0;
    	while($i < $count){//配列の数だけ繰り返す
    		try {
    			$this->pdo->beginTransaction();
    			$sql = "DELETE FROM premember2 WHERE id = :id";
    			$stmh = $this->pdo->prepare($sql);
    
    			$stmh->bindValue(':id', $id[$i]['id'], PDO::PARAM_INT );//配列の番号は、真ん中にくる事に注意！
    
    			$stmh->execute();
    			$this->pdo->commit();
    			//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    		}catch (PDOException $Exception) {
    			$this->pdo->rollBack();
    			print "エラー：" . $Exception->getMessage();
    		}
    		$i = $i + 1;
    	}
    }

    //----------------------------------------------------
    // 会員一覧取得処理
    //----------------------------------------------------
    public function get_member_list($search_key){
        $sql = <<<EOS
SELECT
        m.id as id,
        m.username    as username,
        m.max_messe_no    as max_messe_no,
        m.last_name   as last_name,
        m.reg_date    as reg_date
FROM
        member2 m
WHERE
        m.id

EOS;
        /*元々の命令文↓　memberのkenに情報が入っていないと一覧が取得できなくなる  
        SELECT
        m.id as id,
        m.username    as username,
        m.password    as password,
        m.last_name   as last_name,
        k.ken         as ken,
        m.reg_date    as reg_date
        FROM
        member m
        WHERE
        m.ken = k.id
        */
        
        //member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
        //m.ken = k.idでは、memberテーブルのkenの番号でkenテーブルのken欄を抜き出している。この部分を消したら、一人の人物に対して47都道府県全てが適用されてしまった。
        
        
        if($search_key != ""){//検索ワードが空欄ではない時、
            $sql .= " AND ( m.last_name  like :last_name ) ";//氏名欄に限定して検索する
        }

        try {
            $stmh = $this->pdo->prepare($sql);
            if($search_key != ""){
                $search_key = '%' . $search_key . '%'; 
                $stmh->bindValue(':last_name',  $search_key, PDO::PARAM_STR );
            }
            $stmh->execute();
            // 検索件数を取得
            $count = $stmh->rowCount();
            // 検索結果を多次元配列で受け取る
            $i=0;
            $data = [];
            while ($row = $stmh->fetch(PDO::FETCH_ASSOC)){//データが取得できる限り回し、while内でデータの配列を修正する
                foreach( $row as $key => $value){
                        $data[$i][$key] = $value;
                }
                $i++;
            }
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        return [$data, $count];
    }
    
    //----------------------------------------------------
    // ken_messe1のデータ取得処理
    //----------------------------------------------------
    public function get_ken_messe1_data($id){
    	$sql = <<<EOS
SELECT
        k.set_sendday   as set_sendday,
		k.messe_No as messe_No, 
		k.send_timing as send_timing
FROM
        ken_messe1 k
WHERE
        k.id  like :id
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    		//$sql .= " AND ( k.id  like :id ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    	$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    	$stmh->execute();
    	// 検索件数を取得
    	// 検索結果を多次元配列で受け取る
    		$i=0;
    		$data = [];
    		while ($row = $stmh->fetch(PDO::FETCH_ASSOC)){//データが取得できる限り回し、while内でデータの配列を修正する
		    		foreach( $row as $key => $value){
		    				$data[$i][$key] = $value;
		    			}
    				$i++;
    			}
    		} catch (PDOException $Exception) {
    			print "エラー：" . $Exception->getMessage();
    		}
    		return [$data];//データを配列で返す際は[]の中に入れる必要がある？？
    }
    
    
    //----------------------------------------------------
    // ken_messe2のデータ取得処理
    //----------------------------------------------------
    public function get_ken_messe2_data($id){
    	$sql = <<<EOS
SELECT
        k.set_sendday   as set_sendday,
		k.messe_No as messe_No,
		k.send_timing as send_timing
FROM
        ken_messe2 k
WHERE
        k.id  like :id
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    	//$sql .= " AND ( k.id  like :id ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    		$stmh->execute();
    		// 検索件数を取得
    		// 検索結果を多次元配列で受け取る
    		$i=0;
    		$data = [];
    		while ($row = $stmh->fetch(PDO::FETCH_ASSOC)){//データが取得できる限り回し、while内でデータの配列を修正する
    		foreach( $row as $key => $value){
    			$data[$i][$key] = $value;
    		}
    		$i++;
    		}
    		} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    }
    return [$data];//データを配列で返す際は[]の中に入れる必要がある？？
    }
    
    //----------------------------------------------------
    // ken_messe3のデータ取得処理
    //----------------------------------------------------
    public function get_ken_messe3_data($id){
    	$sql = <<<EOS
SELECT
        k.set_sendday   as set_sendday,
		k.messe_No as messe_No,
		k.send_timing as send_timing
FROM
        ken_messe3 k
WHERE
        k.id  like :id
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    	//$sql .= " AND ( k.id  like :id ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    		$stmh->execute();
    		// 検索件数を取得
    		// 検索結果を多次元配列で受け取る
    		$i=0;
    		$data = [];
    		while ($row = $stmh->fetch(PDO::FETCH_ASSOC)){//データが取得できる限り回し、while内でデータの配列を修正する
    		foreach( $row as $key => $value){
    			$data[$i][$key] = $value;
    		}
    		$i++;
    		}
    		} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	return [$data];//データを配列で返す際は[]の中に入れる必要がある？？
    	}
    
    
    //----------------------------------------------------
    // 指定したidとmesse_Noがken_messe1にあるかどうかの確認
    //----------------------------------------------------
    public function check_ken_messe1_messe_no($id,$messe_No){
    	$sql = <<<EOS
SELECT
        *
FROM
        ken_messe1 k
WHERE
        k.id  like :id AND k.messe_No like :messe_No
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    	//$sql .= " AND ( k.id  like :id AND k.messe_No like :messe_No ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    	$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    	$stmh->bindValue(':messe_No',  $messe_No, PDO::PARAM_INT );
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
    // 指定したidとmesse_Noがken_messe2にあるかどうかの確認
    //----------------------------------------------------
    public function check_ken_messe2_messe_no($id,$messe_No){
    	$sql = <<<EOS
SELECT
        *
FROM
        ken_messe2 k
WHERE
        k.id  like :id AND k.messe_No like :messe_No
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    	//$sql .= " AND ( k.id  like :id AND k.messe_No like :messe_No ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No',  $messe_No, PDO::PARAM_INT );
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
    // 指定したidとmesse_Noがken_messe3にあるかどうかの確認
    //----------------------------------------------------
    public function check_ken_messe3_messe_no($id,$messe_No){
    	$sql = <<<EOS
SELECT
        *
FROM
        ken_messe3 k
WHERE
        k.id  like :id AND k.messe_No like :messe_No
    
EOS;
    	//member m,ken kは、mをmemberとする、kをkenとするという、ある意味変数への代入のようなもの。
    	//複数行の時はコロンの有無に注意。list_url IS NOT NULLは、list_urlカラムがnullになっていない部分だけを検索対象にするというもの。
    	//取得するデータはSELECTの部分のカラム
    
    	//if($search_key != ""){//検索ワードが空欄ではない時、
    	//$sql .= " AND ( k.id  like :id AND k.messe_No like :messe_No ) ";//ここで検索するカラムを指定する
    	//}
    
    	try {
    	$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No',  $messe_No, PDO::PARAM_INT );
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



}

?>
