<?php
session_start();

if (isset($_SESSION['id'])){ 
    //セッションにユーザIDがある＝ログインしている 
    //ログイン済みならトップページに連移する
    header('Location: kamekame.html'); 
    } else if (isset($_POST['name']) && isset ($_POST['pass'])){
    //ログインしていないがユーザ名とパスワードが送信された時
    //DBに接続 
    $dsn = 'mysql:host=localhost;dbname=pbl;charset=utf8';
    $user = 'root'; 
    $password = '';
    
    try{   
    $db = new PDO($dsn, $user, $password) ; 
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
    // プリベアドステートメントを作成 
    $stmt = $db->prepare("SELECT * FROM membertb2 WHERE name=:name AND password=:pass"); 
    // パラメータ割り当て 
    $stmt -> bindParam(':name',$_POST['name'],PDO::PARAM_STR);
    $stmt -> bindParam(':pass',$_POST['pass'],PDO::PARAM_STR);
    // クエリ実行 
    $stmt->execute();
    
    
    if($row=$stmt->fetch()){
    //ユーザが存在していたら、セッションにユーザIDをセット 
    $_SESSION['id'] = $row['id']; 
    header ('Location: kamekame.html'); 
    exit(); 
    } else {
    // 1レコードも取得できなかったとき 
    //ユーザ名・パスワードが間違っている可能性あり 
    // もう一度ログインフォームを表示 
    header ('Location: rog.html'); 
    exit();
    }
  } catch (PDOException $e){
   exit ('エラー：'. $e->getMessage());
  } 
}
   //ログインしていない場合は以降のログインフォームを表示する 
?> 
   
    <!-- 本文ここまで -->
   </main>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    </body>
