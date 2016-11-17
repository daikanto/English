<?php 
//セッションの設定
   session_start();
   require('../dbconnect.php');

//初期化
   $user_name='';
   $email='';
   $password='';
   $english='';

  if(!empty($_POST)){
  	$user_name=$_POST['user_name'];
  	$email=$_POST['email'];
  	$password=$_POST['password'];
  	$english=$_POST['english'];

//入力項目のチェック
//$user_name
  	//未入力==''
  	if($_POST['user_name']==''){
  		$error['user_name']='blank';
  	}
//$email
  	//未==''入力
    if($_POST['email']==''){
    	$error['email']='blank';
    } 
  	//重複チェック
  	if(empty($error)){
  		//重複カウント
  		$sql=sprintf('SELECT COUNT(*) AS cnt FROM `member` WHERE `email`="%s"',mysqli_real_escape_string($db,$email));
        $record=mysqli_query($db,$sql) or die(mysqli_error($db));
        $table=mysqli_fetch_assoc($record);
        if($table['cnt']>0)
        {
          $error['email']='duplicate';
        }
  	}
//$password
  	//未入力
    if($_POST['password']==''){
    	$error['password']='blank';
    }
//$english
    if($_POST['english']==''){
    	$error['english']='blank';
    }

//エラーがない場合
    //sesstionに$_POSTのdataに代入
    if (empty($error)) {
    	$_SESSION['join']=$_POST;

    //check.phpに移動
      header('Location:check.php');
      exit();
    }

  }
  	if(isset($_REQUEST['action'])&&$_REQUEST['action']=='edit'){
  	  $_POST=$_SESSION['join'];
      $user_name=$_POST['user_name'];
      $email=$_POST['email'];
      $password=$_POST['password'];
      $english=$_POST['english'];
	
  	}

 ?>
 <!--form タグでの送信-->
<form method="post" action="index.php">
	<input type="text" name="user_name" value="<?php echo $user_name; ?>"><br>
	<?php if (isset($error['user_name'])&&$error['user_name']=='blank'): ?>
	<p style="color: red">*ユーザー名が未入力です、再入力してください</p>	
	<?php endif ?>
	<input type="email" name="email" value="<?php echo $email; ?>"><br>
	<?php if (isset($error['email'])&&$error['email']='blank'): ?>
	<p style="color: red">*アドレスが未入力です、再入力してください</p>	
	<?php endif ?>
	<?php if (isset($error['email'])&&$error['email']='duplicate'): ?>
	<p style="color: red">*指定したアドレスは登録済みです。再入力してください<br></p>	
	<?php endif ?>


	<input type="password" name="password" value="<?php echo $password; ?>"><br>
	<?php if (isset($error['password'])&&$error['password']=='blank'): ?>
	<p style="color: red">*パスワードが未入力です、再入力してください<br></p>	
	<?php endif ?>

	<input type="text" name="english" value="<?php echo $english; ?>"><br>
	<?php if (isset($error['english'])&&$error['english']=='blank'): ?>
	<p style="color: red">*一言英語が未入力です、再入力してください<br></p>	
	<?php endif ?>
	<input type="submit" value="確認画面"><br>
</form>