<?php 
//テキストから単語をクリーニングして表示する
//不必要な単語はチェックを外す
  //セッションの設定  
  session_start();
  require('dbconnect.php');
  require('functions.php');
  //$_SESSION=array();//セッションのデバックでよく使う、セッションの中身を初期化
  //セッションにデータがなければindex.phpへ遷移する
 //もしm_idパラメーターがなければindex.phpへ強制遷移
 $i=0;
 $count=0;
 $num=0;
 if (empty($_SESSION['id'])) {
   header('Location: login.php');
   exit();
 }
//紐づいている数だけ繰り返す
 //sql文で該当するword=回数だけ繰り返す

	  $sql=sprintf('SELECT COUNT(*) AS cnt FROM `WID_TID` WHERE `m_id`=%d',mysqli_real_escape_string($db,$_SESSION['id']));
	  $record = mysqli_query($db, $sql) or die (mysqli_error($db));
	  $re=mysqli_fetch_assoc($record);
	  $count=$re['cnt'];
	  special_echo('会員ID：');
 	  special_echo($_SESSION['id']);
	  special_echo('該当する単語：');
	  special_echo($count);


//パラメータのm_idに紐づいているtextデータとを全件取得
      $sql=sprintf('SELECT * FROM `WID_TID` WHERE `m_id`=%d', mysqli_real_escape_string($db,$_SESSION['id']));
 	  $tw_id=mysqli_query($db, $sql) or die(mysqli_error($db));
 	  $words=array();
 	   	  while ($id=mysqli_fetch_assoc($tw_id)){
 	  	  special_var_dump($id);
 	  	  $num++;
		//ヒットした英単語とテキストのIDを使ってtextとwordからテキストと英単語を取り出す
		//text
		 	  $sql=sprintf('SELECT `text` FROM `text` WHERE `text_id`=%d', mysqli_real_escape_string($db,$id['t_id']));
		 	  $record=mysqli_query($db, $sql) or die(mysqli_error($db));

		 	  $text=mysqli_fetch_assoc($record);

		      if ($text=='') {
		       special_echo('該当するテキストがありません');
		      }
		      else{
		 	  special_var_dump($text);      	
		      }
		//英単語$word
		 	  $sql=sprintf('SELECT `word` FROM `word` WHERE `word_id`=%d', mysqli_real_escape_string($db,$id['w_id']));
		 	  $record=mysqli_query($db, $sql) or die(mysqli_error($db));

		 	  $word=mysqli_fetch_assoc($record);
		 	  special_var_dump($id['w_id']);
		 	  array_push($words, $word['word']);
  		      if ($word=='') {
		       special_echo('該当する英単語がありません');
		      }
		      else{
		 	  special_var_dump($word);      	
		      }
	
			//編集完了のボタンを押したらdelete_flagの値を更新UPDATE
			//アップデート終了後、indexpageにリターン

					 if (!empty($_POST)){
					 	

						//$test=mysqli_fetch_assoc($_POST['record']);	 	
			         	$sql =sprintf('UPDATE `word` SET `delete_flag`=%d WHERE `word_id`=%d',mysqli_real_escape_string($db,$_POST['record'][$count]),mysqli_real_escape_string($db,$id['w_id']));
					 	  mysqli_query($db, $sql) or die(mysqli_error($db));
					 	  special_echo('OK');
						  special_var_dump($_POST['record']);
						  special_var_dump($id['w_id']);
						  header('Location:index.php');
						  exit();
						  }
					 	  	 	  
			}					
 ?>
<div>編集：英単語</div>
<form method="POST" action="edit.php">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">英単語</font></th>
<th bgcolor="#EE0000" width="150"><font color="#FFFFFF">意味</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">追加</th>
</tr>
<?php foreach ($words as $word): ?>
<?php $i++; ?>
<tr>
<td bgcolor="#99CC00" align="center" nowrap><?php if ($word==''): ?>
<?php echo '該当する英単語がありません'; ?>
<?php else: ?>
<?php echo $word; ?>	
<?php endif ?>
<td bgcolor="#FFFFFF" valign="top" width="150">リンゴ</td>
<td bgcolor="#FFFFFF" valign="top" width="200">
<input type="radio" name="record[<?php echo $i; ?>]" value="0" checked="checked"/>表示する
<input type="radio" name="record[<?php echo $i; ?>]" value="1"/>表示しない</font></td>
</tr>
<!<?php endforeach ?>
</table>
<input type="submit" value="登録">
</form>
