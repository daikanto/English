<?php 
  //セッションの設定  
  session_start();
  require('dbconnect.php');
  require("functions.php");

  //初期化
  	$email='';
  	$password='';

  //ログインクリック
    //login processing
  	//if success
  	//else false
  //input error
  if(!empty($_POST)){
  	$email=$_POST['email'];
  	$password=$_POST['password'];
  	if ($email!==''&&$password!=='') {
  	//DBからmemberデータを持ってくる
  		$sql=sprintf('SELECT * FROM `member` WHERE `email`="%s" AND `password`="%s"',mysqli_real_escape_string($db,$email),mysqli_real_escape_string($db,sha1($password)));
        $record=mysqli_query($db,$sql) or die(mysqli_error($db));

  		//取り出したデータと入力データが一致する場合
  		if ($tb=mysqli_fetch_assoc($record)) {
  	    //login success
              $_SESSION['id']=$tb['member_id'];
              $_SESSION['time']=time();
              special_echo('ログイン成功');
              header('Location: index.php');
              exit();
  		}
  		//login false
  		else{
              special_echo('ログイン失敗');
              $error['login']='failed';
  		}
  	}
  	//入力エラー
  	else{
              special_echo('入力エラー');
              $error['login']='blank';
  	}
  }

  else special_echo('転送失敗');

  //login processing
  	//if success
  	//else false
  //input error
 ?>


<div><p>ログイン</p>
<form method="POST" action="">
<p>メールアドレス</p>
<input type="email" name="email" placeholder="例： english@gmail.com" value="<?php echo htmlspecialchars($email,ENT_QUOTES,'UTF-8');  ?>">
<?php if (isset($error['login'])&&$error['login']=='blank'): ?>
  <p class="error">メールアドレスとパスワードを入力してください</p>  
<?php endif ?>
<?php if (isset($error['login'])&&$error['login']=='failed'): ?>
  <p class="error">ログインが失敗しました。再度ログインしてください</p>
<?php endif ?>
<p>パスワード</p>
<input type="password" name="password" value="<?php echo htmlspecialchars($password,ENT_QUOTES,'UTF-8');  ?>">
<!--自動ログイン機能追加実装-->


<!--自動ログイン機能追加実装-->
<input type="submit" name="ログイン">|<a href="join/index.php" class="btn btn-success">会員登録</a>
</form>
</div>
