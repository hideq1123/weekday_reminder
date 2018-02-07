<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseDbModel
 *
 * @author nagatayorinobu
 */
class BaseModel {
    
    protected $pdo;
            
    public function __construct() {
        $this->db_connect();
    }

    //----------------------------------------------------
    // データベース接続処理。PHPの場合、スクリプトの実行が終わると自動的に接続を切断するため、接続処理は記述していません。
    //----------------------------------------------------
    private function db_connect(){
        try {
          $this->pdo = new PDO(_DSN, _DB_USER, _DB_PASS);
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $Exception) {
          die('エラー :' . $Exception->getMessage());
        }
    }


    
    
}

?>
