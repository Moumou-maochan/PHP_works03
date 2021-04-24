<?php

session_start();
include("functions.php");
check_session_id();

if(
  !isset($_POST['date']) || $_POST['date']=='' ||
  !isset($_POST['start_time']) || $_POST['start_time']==''||
  !isset($_POST['end_time']) || $_POST['end_time']==''||
  !isset($_POST['break_time']) || $_POST['break_time']==''||
  !isset($_POST['comment']) || $_POST['comment']==''
){
   // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
   echo json_encode(["error_msg" => "no input"]);
   exit();
}
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$break_time = $_POST['break_time'];
$comment = $_POST['comment'];
// DB接続情報
$dbn = 'mysql:dbname=gsacs_d02_05;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';
// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
$sql = 'INSERT INTO works(id, date, start_time, end_time, break_time, comment) VALUES(NULL, :date, :start_time, :end_time, :break_time, :comment)';
$stmt = $pdo->prepare($sql);



// バインド変数に格納（セキュリティ）
$stmt->bindValue(':date', $date, PDO::PARAM_STR); 
$stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR); 
$stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR); 
$stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR); 
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); 
$status = $stmt->execute(); // SQLを実行


if ($status==false) {
$error = $stmt->errorInfo(); // データ登録失敗次にエラーを表示 exit('sqlError:'.$error[2]);
echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();  
} else {
  // 登録ページへ移動
    header('Location:todo_input.php');
  }