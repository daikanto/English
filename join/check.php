<?php 
//セッションの設定
   session_start();
   require('../dbconnect.php');
//$_SESSION['join']がない場合はindex.phpに強制的に遷移
if (!isset($_SESSION['join'])) {
   header('Location:index.php');
   exit();
}
//index.phpで記入した内容を$_SESSTION['join']から表示
//user_name,email,password,
//編集が必要であれば編集ボタンで編集ページ(index.php?action=edit)へ遷移
//編集の必要がなければ登録ボタンでDB登録
  if (!empty($_POST)) {
  	$sql =sprintf('INSERT INTO `member` SET `user_name`="%s",`email`="%s",`password`="%s",`english`="%s",`picture_path`=0,`created`=NOW()',mysqli_real_escape_string($db,$_SESSION['join']['user_name']),mysqli_real_escape_string($db,$_SESSION['join']['email']),mysqli_real_escape_string($db,sha1($_SESSION['join']['password'])),mysqli_real_escape_string($db,$_SESSION['join']['english']));

    mysqli_query($db,$sql) or  die(mysqli_error($db));
    unset($_SESSION['join']);

      exit();

  	
  }
 ?>

<form action='check.php' method="POST">
	<input type="hidden" name="action" value="submit">
	 <div>登録内容をご確認ください</div>
	 <div>user_name:<?php echo $_SESSION['join']['user_name']; ?></div>
	 <div>email:<?php echo $_SESSION['join']['email']; ?></div>
	 <div>password:<?php echo '●●●●●'; ?></div>
	 <div>english:<?php echo $_SESSION['join']['english']; ?></div>
	 <a href="index.php?action=edit">編集</a>
	 <a href="thank.php"  value="登録">登録</a>
</form>
