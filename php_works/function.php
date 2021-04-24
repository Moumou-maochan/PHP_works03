<?php

function connect_to_db(){ 
    $dbn='mysql:dbname=gsacs_d02_05;charset=utf8;
    port=3306;host=localhost';
    $user = 'root';
    $pwd = '';
    try {
    return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
    exit('dbError:'.$e->getMessage());
    }
    }

include('functions.php'); // 関数を記述したファイルの読み込み
$pdo = connect_to_db();

// ログイン状態のチェック関数
function check_session_id()
{
  // var_dump($_SESSION['session_id']);
  // exit(); 

  if (!isset($_SESSION['session_id']) || // session_idがない
  $_SESSION['session_id'] != session_id()// idが一致しない 
){
  header('Location: todo_login.php'); // ログイン画面へ移動 
} else {
  session_regenerate_id(true); // セッションidの再生成
  $_SESSION['session_id'] = session_id(); // セッション変数上書き 
  }
}
