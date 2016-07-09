<?php

namespace MyApp;

class Delete {
  private $_db;

  public function __construct() {
    $this->_connectDB();
  }
  
  //データベースに接続
  private function _connectDB() {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      throw new \Exception('Failed to connect DB!');
    }
  }
  
  //あの子のidを削除する
  function delete_id($user_id,$connection){
      //あの子のIDをツイッター上で探す
      $lover_id = $_POST['lover_id'];
      $lover_id = h($lover_id, ENT_QUOTES, 'UTF-8'); 
      global $error;
      if(!empty($lover_id)){
      $search_lover = $connection->get("users/search", array("q" => $lover_id));
      $lover_twitter_id = $search_lover[0]->screen_name;
      if(isset($lover_twitter_id)){
        if($this->check_registered($user_id,$lover_twitter_id) == 0){
           $error['id'] = 'そのIDはすでに削除されています。';
         }else{
           $this->love_delete($user_id,$lover_twitter_id);
           session_start();
           $_SESSION['search_lover'] = $search_lover;
           header('Location: http://' . $_SERVER['HTTP_HOST'].'/devAid-v1.2/edit.php');
           exit;
         }
       }else {
         $error['id'] = 'twitter上にそのIDは存在しません。';
       }
      }else{
        $error['id'] =  '入力されていません。';
      }
  }
  
  //すでに登録しているかチェック
  private function check_registered($user_id,$lover_twitter_id){
    $stmt = sprintf("select count(*) from loveres where user_id = :user_id AND lover_twitter_id = :lover_twitter_id"); 
    $res = $this->_db->prepare($stmt);
    $res->bindValue(':user_id', $user_id, \PDO::PARAM_STR);
    $res->bindValue(':lover_twitter_id', $lover_twitter_id, \PDO::PARAM_STR);
    $res->execute();
    return $res->fetchColumn();
  }
  
  //あの子のIDをデータベースから削除する
  private function love_delete($user_id,$lover_twitter_id){
     $sql = "delete from loveres where user_id = '$user_id' AND lover_twitter_id = :lover_twitter_id";
     $stmt = $this->_db-> prepare($sql);
    $stmt->bindValue(':lover_twitter_id', $lover_twitter_id, \PDO::PARAM_STR);
    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('登録に失敗しました');
    }
  }


  //登録が完了を表示
  
  //登録した相手の画像と名前を表示

}