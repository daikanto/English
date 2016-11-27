<?php 
	
//登録する英単語を表示、編集、削除ができる
//check.phpで閲覧後、DBに登録を行う
//セッションの設定  
  session_start();
  require('dbconnect.php');
  require('functions.php');
  //ログイン状態か判定条件
  //session has id
  // the last actibait is within 1 hour.
  if (isset($_SESSION['id'])&&$_SESSION['time']+3600>time()) {
      $_SESSION['time']=time();
  //while login get longin user information by using id
      $sql=sprintf('SELECT * FROM `member` WHERE `member_id`=%d', mysqli_real_escape_string($db,$_SESSION['id']));
      $record=mysqli_query($db,$sql) or die(mysqli_error($db));
      $member=mysqli_fetch_assoc($record);      
  }
  //else: we judge on logout, move index.php
  else{
    header('Location:login.php');
  }

  //$_SESSION=array();//セッションのデバックでよく使う、セッションの中身を初期化
  //セッションにデータがなければindex.phpへ遷移する
//if (!isset($_SESSION['english'])){
  //  header('Location:index.php');
    //exit();
  //}
  $word=array();
  $i=0;
  $count=0;

if (!empty($_POST)) {
						//テキストをDB登録
			  	 		$sql = sprintf('INSERT INTO `text` SET `text`="%s",`number_vocabulary`=0,`m_id`=%d,`date`=NOW()',mysqli_real_escape_string($db,$_SESSION['text']),mysqli_real_escape_string($db,$_SESSION['id']));
			  	 	    mysqli_query($db,$sql) or die(mysqli_error($db));

			  	 	    //textテーブルからtext_idを取り出す
						$sql = sprintf('SELECT `text_id` FROM `text` WHERE `text`="%s" AND `m_id`=%d',mysqli_real_escape_string($db,$_SESSION['text']),mysqli_real_escape_string($db,$_SESSION['id']));
			    		$record=mysqli_query($db,$sql) or die(mysqli_error($db));
			    		$t_id=mysqli_fetch_assoc($record);
			    			special_var_dump($t_id['text_id']);




			//DBhへの単語単語登録
              foreach ($_SESSION['english_word'] as $words) {
              	foreach (array($words) as $word) {
              		$count++;
						 //if ($_POST['record']=='1') {
             		  	 //special_echo('add');
             		  	//}
			              special_echo($words);
			              //special_var_dump($_POST['record'][$count]);
			             //DBの登録を行う//追加の選択が行われているときのみ
			            $sql = sprintf('INSERT INTO `word` SET `word`="%s",`status`=0,`t_id`=%d,`detele_flag`="%d",`date`=NOW()',mysqli_real_escape_string($db,$word),mysqli_real_escape_string($db,$t_id['text_id']),mysqli_real_escape_string($db,$_POST['record'][$count]));
			            mysqli_query($db,$sql) or die (mysqli_error($db));

						//wordをword_idを取り出す
			    		$sql = sprintf('SELECT `word_id` FROM `word` WHERE `word`="%s"',mysqli_real_escape_string($db,$word));
			    		$record=mysqli_query($db,$sql) or die(mysqli_error($db));
			    		$w_id=mysqli_fetch_assoc($record);
			    		    special_var_dump($w_id['word_id']);
					              
						//WID_TIDテーブルにtext_idとword_idを登録する
			    		$sql = sprintf('INSERT INTO `WID_TID` SET `w_id`=%d,`t_id`=%d,`m_id`=%d',mysqli_real_escape_string($db,$w_id['word_id']),mysqli_real_escape_string($db,$t_id['text_id']),mysqli_real_escape_string($db,$_SESSION['id']));
			   			mysqli_query($db,$sql) or die (mysqli_error($db));

			   			//unset($_SESSION['english']);
			            //header('Location:index.php');
			            //exit();

   			}
			    }
}
 ?>
 <div>テキストから抽出した英単語</div>
 <form method="POST" action="check.php">
<table border="1" width="450" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">英単語</font></th>
<th bgcolor="#EE0000" width="100"><font color="#FFFFFF">追加</th>
</tr>
<?php foreach ($_SESSION['english_word'] as $word): ?>
<?php $i++; ?>
<tr>
<td bgcolor="#99CC00" align="center"  nowrap><?php echo $word; ?></td>
<td bgcolor="#FFFFFF" valign="top" width="200">
<input type="radio" name="record[<?php echo $i; ?>]" value="1" checked="checked"/>追加する
<input type="radio" name="record[<?php echo $i; ?>]" value="0" />追加しない</font></td>
</tr>
<!<?php endforeach ?>

</table>
<input type="submit" value="登録完了">
</form>