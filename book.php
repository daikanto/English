<?php 
  require('dbconnect.php');
  require('functions.php');
//画面；テキストと単語を画面に表示
//上にテキスト表示
  //DBのtextのtextを取り出す
		$sql=sprintf('SELECT `text` FROM `text` WHERE `word`="%s"',mysqli_real_escape_string($db,$word));
		$record=mysqli_query($db,$sql) or die(mysqli_error($db));


//取り出したtextのtext_idに紐づいているw_idを取り出す

//下に単語(英語と意味)
  //DBのwordのwordからw_idを使い単語を取り出す&delete_flagを使う

 ?>
<div><p><?php echo 'テキスト内容'; ?></p></div>
<table border="1" width="450" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">英単語</font></th>
<th bgcolor="#EE0000"><font color="#FFFFFF">意味</font></th>
<th bgcolor="#EE0000" width="100"><font color="#FFFFFF">習得度</th>
</tr>
<tr>
<td bgcolor="#99CC00" align="center"  nowrap><?php echo 'apple'; ?></td>
<td bgcolor="#99CC00" align="center"  nowrap><?php echo 'リンゴ'; ?></td>
<td bgcolor="#FFFFFF" valign="top" width="200">
<input type="radio" name="record[<?php echo $i; ?>]" value="1" checked="checked"/>習得した
<input type="radio" name="record[<?php echo $i; ?>]" value="0" />習得していない</font></td>
</tr>
</table>