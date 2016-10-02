<?php
session_start();
include("functions.php");

//パラメータをチェック
if(
    !isset($_POST["lid"]) || $_POST["lid"] ||
    !isset($_POST["lpw"]) || $_POST["lpw"]
    )
    {
        header("location: login.php");
        exit();
    }

//1.接続
$pdo = db_con();

//3.データ登録SQL作成
$sql = "SELECT * FROM gs_gp_user WHERE lid=:lid AND lpw=:lpw AND life_flag=0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $_POST["lid"]);
$stmt->bindValue(':lpw', $_POST["lpw"]);
$res = $stmt->execute();

//SQL実行時にエラーがある場合
if($res==false){
    queryError($stmt);
}

//5.抽出データ数を取得
$val = $stmt->fetch();

//6.該当レコードがあればSESSIONに値を代入
if ($val["id"] !=""){
    $_SESSION["schk"] = session_id();
    $_SESSION["name"] = $val["name"];
    $_SESSION[kanri_flg] = $val["kanri_flg"];
    header("Location: select.php");
}else{
    //logout処理を経由して前画面へ
    header("Location: login.php");
}

exit();
?>