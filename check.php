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
              foreach (array($_SESSION['english']['word']) as $record_words) {
             		  if ($record_words!==null) {
             		  	  $word=$record_words;
			              special_var_dump($word);
			              special_echo('yes');

			              //DBの登録を行う//追加の選択が行われているときのみ
			              $sql = sprintf('INSERT INTO `word` SET `word`="%s",`status`=0,`date`=NOW()',mysqli_real_escape_string($db,$record_words));
			              mysqli_query($db,$sql) or die (mysqli_error($db));
	           		  }      
              unset($_SESSION['english']);
              header('Location:index.php');
              exit();
              }
}
 ?>
 <div>テキストから抽出した英単語</div>
 <form method="post" action="check.php">
 <input type="hidden" name="action" value="submit">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">英単語</font></th>
<th bgcolor="#EE0000" width="150"><font color="#FFFFFF">意味</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">追加</th>
</tr>
<?php foreach ($word as $word): ?>
<tr>
<td bgcolor="#99CC00" align="right" nowrap>	<?php echo '$word'; ?></td>
<td bgcolor="#FFFFFF" valign="top" width="150">リンゴ</td>
<td bgcolor="#FFFFFF" valign="top" width="200"><input type="checkbox" name="record" value="1" checked="checked"/>追加する
<input type="checkbox" name="record" value="0" />追加しない</font></td>
</tr>
<?php endforeach ?>

</table>
<input type="submit" value="登録">
</form>