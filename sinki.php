<?php
 // フォームからの値をそれぞれの変数に代入
$name = $_POST [ '名前' ];
$mail = $_POST [ 'id' ];
$pass = $_POST [ 'password' ];
$lotteryflg = 0;

$dsn = 'mysql:host=localhost;dbname=pbl;charset=utf8';
    $user = 'root'; 
    $password = '';

 try {
   $dbh = new PDO($dsn, $user, $password); 
} catch (PDOException $e) {
   $msg = $e->getMessage();
   echo "<h1>$msg</h1>";
   exit;
}

// フォームに入力されたidがすでに登録されていないかチェック
$sql = "SELECT * FROM membertb2 WHERE name = :name";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':name', $name);
$stmt->execute();
$member = $stmt->fetch();

if ($member && $member['name'] === $name) {
   $msg = '同じIDが存在します。';
   $link = '<a href="sinki.html">戻る</a>';
} else {
   // 登録されていなければinsert 
   $sql = "INSERT INTO membertb2(name,mail,password,lotteryflg) VALUES (:name, :mail, :password, :lotteryflg)";
   $stmt = $dbh->prepare($sql);
   $stmt->bindValue(':name', $name);
   $stmt->bindValue(':mail', $mail);
   $stmt->bindValue(':password', $pass); 
   $stmt->bindValue(':lotteryflg', $lotteryflg); 
   $stmt->execute();
   $msg = '会員登録が完了しました';
   $link = '<a href="rog.html">ログインページ</a>';
}
?>
<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>
