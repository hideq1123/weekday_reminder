<?php

/**
 * Description of KenModel
 *
 * @author nagatayorinobu
 *
 * ４７都道府県をデータベースから取得する
 */
class KenModel extends BaseModel {
    //----------------------------------------------------
    // 全ての県名の取得
    //----------------------------------------------------
    public function get_ken_data(){
        $key_array = [];
        try {
            $sql= "SELECT * FROM ken  ";
            $stmh = $this->pdo->query($sql);
            while ($row = $stmh->fetch(PDO::FETCH_ASSOC)){//データが取得できる限り回す。この時点で、受け取ったデータは$row[id]=1、$row[ken]=北海道という形式なので、このwhile内で修正する
                $key_array[$row['id']] = $row['ken'];//$key_array[1]=北海道、$key_array[2]=青森、という形式に直す。
            }
        } catch (PDOException $Exception) {
            print "エラー：" . $Exception->getMessage();
        }
        return $key_array;
    }
    
    //----------------------------------------------------
    // ken_messe1に設定しているリマインダーが１個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_count1($id){
    	try {
    		$sql= "SELECT * FROM ken_messe1 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
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
    // ken_messe1に設定しているリマインダーが5個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_max_count1($id){
    	try {
    		$sql= "SELECT * FROM ken_messe1 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
    		$stmh->execute();
    		$count = $stmh->rowCount();
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	if($count >= 5){//ヒットした件数が５個以上あるならば、
    		return true;
    	}else{
    		return false;
    	}
    }
    
    //----------------------------------------------------
    // ken_messe2に設定しているリマインダーが１個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_count2($id){
    	try {
    		$sql= "SELECT * FROM ken_messe2 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
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
    // ken_messe2に設定しているリマインダーが3個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_max_count2($id){
    	try {
    		$sql= "SELECT * FROM ken_messe2 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
    		$stmh->execute();
    		$count = $stmh->rowCount();
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	if($count >= 3){//ヒットした件数が3個以上あるならば、
    		return true;
    	}else{
    		return false;
    	}
    }
    
    //----------------------------------------------------
    // ken_messe3に設定しているリマインダーが3個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_max_count3($id){
    	try {
    		$sql= "SELECT * FROM ken_messe3 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
    		$stmh->execute();
    		$count = $stmh->rowCount();
    	} catch (PDOException $Exception) {
    		print "エラー：" . $Exception->getMessage();
    	}
    	if($count >= 3){//ヒットした件数が3個以上あるならば、
    		return true;
    	}else{
    		return false;
    	}
    }
    
    
    //----------------------------------------------------
    // ken_messe3に設定しているリマインダーが１個以上あるかないかを返す
    //----------------------------------------------------
    public function schedule_count3($id){
    	try {
    		$sql= "SELECT * FROM ken_messe3 WHERE id = :id ";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id',  $id, PDO::PARAM_STR );
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
    // ken_messe1への登録処理
    //----------------------------------------------------
    public function regist_ken_messe1($set_sendday,$sendday_option,$send_timing,$send_time,$messe_No,$id,$send_text){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "INSERT  INTO ken_messe1 (messe_No, set_sendday, sendday_option, send_timing, send_time, id,send_text)
            VALUES ( :messe_No, :set_sendday, :sendday_option, :send_timing, :send_time, :id,:send_text)";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':messe_No',   $messe_No,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':sendday_option',  $sendday_option,  PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_time',        $send_time,        PDO::PARAM_INT );
    		$stmh->bindValue(':id',        $id,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',        $send_text,        PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // ken_messe1への更新処理
    //----------------------------------------------------
    public function reflesh_ken_messe1($set_sendday,$sendday_option,$send_timing,$send_time,$id,$send_text,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  ken_messe1
                      SET
                        send_time   = :send_time,
                        set_sendday   = :set_sendday,
    					sendday_option = :sendday_option,
    					send_timing = :send_timing,
                        send_text  = :send_text
    				WHERE id = :id AND messe_No = :messe_No";//渡された$idと$messe_noの２つが存在する行を更新する。
    		
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':send_time',   $send_time,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':sendday_option',  $sendday_option,  PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',         $send_text,         PDO::PARAM_STR );
    		$stmh->bindValue(':id',         $id,         PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No',         $messe_no,         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // ken_messe2への更新処理
    //----------------------------------------------------
    public function reflesh_ken_messe2($set_sendday,$send_timing,$send_time,$id,$send_text,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  ken_messe2
                      SET
                        send_time   = :send_time,
                        set_sendday   = :set_sendday,
    					send_timing = :send_timing,
                        send_text  = :send_text
    				WHERE id = :id AND messe_No = :messe_No";//渡された$idと$messe_noの２つが存在する行を更新する。
    
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':send_time',   $send_time,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',         $send_text,         PDO::PARAM_STR );
    		$stmh->bindValue(':id',         $id,         PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No',         $messe_no,         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // ken_messe3への更新処理
    //----------------------------------------------------
    public function reflesh_ken_messe3($set_sendday,$send_timing,$send_time,$id,$send_text,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "UPDATE  ken_messe3
                      SET
                        send_time   = :send_time,
                        set_sendday   = :set_sendday,
    					send_timing = :send_timing,
                        send_text  = :send_text
    				WHERE id = :id AND messe_No = :messe_No";//渡された$idと$messe_noの２つが存在する行を更新する。
    
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':send_time',   $send_time,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',         $send_text,         PDO::PARAM_STR );
    		$stmh->bindValue(':id',         $id,         PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No',         $messe_no,         PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    
    //----------------------------------------------------
    // idとmesse_Noをキーにしてken_messe1のスケジュールを1行全て削除する
    //----------------------------------------------------
    public function delete_ken_messe1_sche($id,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "DELETE FROM ken_messe1 WHERE id = :id AND messe_No = :messe_No";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_no, PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    		//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // idとmesse_Noをキーにしてken_messe2のスケジュールを1行全て削除する
    //----------------------------------------------------
    public function delete_ken_messe2_sche($id,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "DELETE FROM ken_messe2 WHERE id = :id AND messe_No = :messe_No";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_no, PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    		//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // idとmesse_Noをキーにしてken_messe3のスケジュールを1行全て削除する
    //----------------------------------------------------
    public function delete_ken_messe3_sche($id,$messe_no){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "DELETE FROM ken_messe3 WHERE id = :id AND messe_No = :messe_No";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':id', $id, PDO::PARAM_INT );
    		$stmh->bindValue(':messe_No', $messe_no, PDO::PARAM_INT );
    		$stmh->execute();
    		$this->pdo->commit();
    		//print "データを" . $stmh->rowCount() . "件、削除しました。<br>";
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // ken_messe2への登録処理
    //----------------------------------------------------
    public function regist_ken_messe2($set_sendday,$send_timing,$send_time,$messe_No,$id,$send_text){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "INSERT  INTO ken_messe2 (messe_No, set_sendday, send_timing, send_time, id,send_text)
            VALUES ( :messe_No, :set_sendday, :send_timing, :send_time, :id,:send_text)";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':messe_No',   $messe_No,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_time',        $send_time,        PDO::PARAM_INT );
    		$stmh->bindValue(':id',        $id,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',        $send_text,        PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    //----------------------------------------------------
    // ken_messe3への登録処理
    //----------------------------------------------------
    public function regist_ken_messe3($set_sendday,$send_timing,$send_time,$messe_No,$id,$send_text){
    	try {
    		$this->pdo->beginTransaction();
    		$sql = "INSERT  INTO ken_messe3 (messe_No, set_sendday, send_timing, send_time, id,send_text)
            VALUES ( :messe_No, :set_sendday, :send_timing, :send_time, :id,:send_text)";
    		$stmh = $this->pdo->prepare($sql);
    		$stmh->bindValue(':messe_No',   $messe_No,   PDO::PARAM_INT );
    		$stmh->bindValue(':set_sendday',   $set_sendday,   PDO::PARAM_INT );
    		$stmh->bindValue(':send_timing',        $send_timing,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_time',        $send_time,        PDO::PARAM_INT );
    		$stmh->bindValue(':id',        $id,        PDO::PARAM_INT );
    		$stmh->bindValue(':send_text',        $send_text,        PDO::PARAM_STR );
    		$stmh->execute();
    		$this->pdo->commit();
    	} catch (PDOException $Exception) {
    		$this->pdo->rollBack();
    		print "エラー：" . $Exception->getMessage();
    	}
    }
    
    
}

?>
