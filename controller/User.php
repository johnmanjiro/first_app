<?php

namespace MyApp;

class User {
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
  
  //user情報を取得
  public function getUser($twUserId) {
    $sql = sprintf("select * from users where tw_user_id=%d", $twUserId);
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
  }
  
  //userの存在を確認
  private function _exists($twUserId) {
    $sql = sprintf("select count(*) from users where tw_user_id=%d", $twUserId);
    $res = $this->_db->query($sql);
    return $res->fetchColumn() === '1';
  }
  
  //データベースに情報を保存
  public function saveTokens($tokens) {
    if ($this->_exists($tokens['user_id'])) {
      $this->_update($tokens);
    } else {
      $this->_insert($tokens);
    }
  }

  private function _insert($tokens) {
    $sql = "insert into users (
      tw_user_id,
      tw_screen_name,
      tw_access_token,
      tw_access_token_secret,
      created,
      modified
      ) values (
      :tw_user_id,
      :tw_screen_name,
      :tw_access_token,
      :tw_access_token_secret,
      now(),
      now()
      )";
    $stmt = $this->_db->prepare($sql);

    $stmt->bindValue(':tw_user_id', (int)$tokens['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(':tw_screen_name', $tokens['screen_name'], \PDO::PARAM_STR);
    $stmt->bindValue(':tw_access_token', $tokens['oauth_token'], \PDO::PARAM_STR);
    $stmt->bindValue(':tw_access_token_secret', $tokens['oauth_token_secret'], \PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to insert user!');
    }
  }

  private function _update($tokens) {
    $sql = "update users set
    tw_screen_name = :tw_screen_name,
    tw_access_token = :tw_access_token,
    tw_access_token_secret = :tw_access_token_secret,
    modified = now()
    where tw_user_id = :tw_user_id";

    $stmt = $this->_db->prepare($sql);

    $stmt->bindValue(':tw_screen_name', $tokens['screen_name'], \PDO::PARAM_STR);
    $stmt->bindValue(':tw_access_token', $tokens['oauth_token'], \PDO::PARAM_STR);
    $stmt->bindValue(':tw_access_token_secret', $tokens['oauth_token_secret'], \PDO::PARAM_STR);
    $stmt->bindValue(':tw_user_id', (int)$tokens['user_id'], \PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to update user!');
    }
  }
  
  public function findAll($user_id) {
    $stmt = sprintf("select * from loveres where user_id = :user_id"); 
    $res = $this->_db->prepare($stmt);
    $res->bindValue(':user_id',$user_id,\PDO::PARAM_STR);
    $res->execute();
    return $res->fetchAll();
  }
  
  public function count_lover($user_id) {
    $count = sprintf("select count(*) from loveres where user_id = :user_id");
    $res = $this->_db->prepare($count);
    $res->bindValue(':user_id',$user_id,\PDO::PARAM_STR);
    $res->execute();   
    return $res->fetchColumn();
  }
  
}