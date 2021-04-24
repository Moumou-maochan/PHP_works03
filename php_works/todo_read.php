<?php



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

 // 参照はSELECT文!
$sql = 'SELECT * FROM works';
$stmt = $pdo->prepare($sql); 
$status = $stmt->execute();

if ($status==false) {
  $error = $stmt->errorInfo(); exit('sqlError:'.$error[2]);
  // 失敗時􏰂エラー出力
   
   } else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC); $output = "";
  foreach ($result as $record) {
  $output .= "<tr>";
  $output .= "<td>{$record["date"]}</td>"; $output .= "<td>{$record["start_time"]}</td>"; $output.= "<td>{$record["end_time"]}</td>"; $output.= "<td>{$record["break_time"]}</td>"; $output.= "<td>{$record["comment"]}</td>"; $output .= "</tr>";
  } }

  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["date"]}</td>";
    $output .= "<td>{$record["start_time"]}</td>";
    $output.= "<td>{$record["end_time"]}</td>"; 
    $output.= "<td>{$record["break_time"]}</td>";
    $output.= "<td>{$record["comment"]}</td>";
    $output .= "<td>
    
    <a href='todo_edit.php?id={$record["id"]}'>edit</a>
    </td>";
    $output .= "<td>
    
    <a href='todo_delete.php?id={$record["id"]}'>delete</a>
    </td>";
    $output .= "</tr>";
    }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>勤怠管理リスト（一覧画面）</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>日にち</th>
          <th>始業時刻</th>
          <th>終業時刻</th>
          <th>休憩</th>
          <th>コメント</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>