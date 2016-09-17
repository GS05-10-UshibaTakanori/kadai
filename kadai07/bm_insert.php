<?php
//1. POSTデータ取得
$book_name   = $_POST["book_name"];
$book_url  = $_POST["book_url"];
$book_cmt = $_POST["book_cmt"];

//var_dump($_POST);
//exit;
//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table_02(id, book_name, book_url, book_cmt,
date)VALUES(NULL, :a1, :a2, :a3, sysdate())");
//$stmt = $pdo->prepare("INSERT INTO gs_an_table(id, name, email, naiyou,
//indate )VALUES(NULL, 'a1', 'a2', 'a3', sysdate())");
$stmt->bindValue(':a1', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) :a1にnameが入る　セキュリティホールに対して安全にする工夫→危険な文字列を一旦無効化する　bind変数という　bindはつながりの意味
$stmt->bindValue(':a2', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)　数字のみの場合はINTでOK
$stmt->bindValue(':a3', $book_cmt, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();　//実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: bm_insert_view.php");
  exit;
}
?>

