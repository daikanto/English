<?php 
	
//登録する英単語を表示、編集、削除ができる
//check.phpで閲覧後、DBに登録を行う
//セッションの設定  
  session_start();
  require('dbconnect.php');
  require('functions.php');

  //$_SESSION=array();//セッションのデバックでよく使う、セッションの中身を初期化
  //セッションにデータがなければindex.phpへ遷移する
//if (!isset($_SESSION['english'])){
  //  header('Location:index.php');
    //exit();
  //}

  $word=array();

if (!empty($_POST)) {
              foreach ($_SESSION['english_word'] as $words) {
              	foreach (array($words) as $word) {
              		# code...
              	
             		  //if ($record_words=='red') {
             		  	  //special_var_dump($_SESSION['english_word']);

			              special_echo($words);
			              special_var_dump($_POST);

			              //DBの登録を行う//追加の選択が行われているときのみ
			              //$sql = sprintf('INSERT INTO `word` SET `word`="%s",`status`=0,`date`=NOW() WhERE $_post['record']==1',mysqli_real_escape_string($db,$word));
			              //mysqli_query($db,$sql) or die (mysqli_error($db));
	           		        
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
<tr>
<td bgcolor="#99CC00" align="left"  nowrap>	<?php echo $word; ?></td>
<td bgcolor="#FFFFFF" valign="top" width="200"><input type="checkbox" name="record" value="1" checked="checked"/>追加する
<input type="checkbox" name="record" value="0" />追加しない</font></td>
</tr>
<?php endforeach ?>

</table>
<input type="submit" value="登録">
</form>