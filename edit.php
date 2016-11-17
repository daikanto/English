<?php 
//テキストから単語をクリーニングして表示する
//不必要な単語はチェックを外す
  //セッションの設定  
  session_start();
  require('dbconnect.php');
  //$_SESSION=array();//セッションのデバックでよく使う、セッションの中身を初期化
  //セッションにデータがなければindex.phpへ遷移する
//if (!isset($_SESSION['english'])){
  //  header('Location:index.php');
    //exit();
  //}



 ?>



 <div>テキストから抽出した英単語</div>
 <input type="hidden" name="action" value="submit">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#EE0000"><font color="#FFFFFF">英単語</font></th>
<th bgcolor="#EE0000" width="150"><font color="#FFFFFF">意味</font></th>
<th bgcolor="#EE0000" width="200"><font color="#FFFFFF">追加</th>
</tr>
<tr>
<td bgcolor="#99CC00" align="right" nowrap>apple</td>
<td bgcolor="#FFFFFF" valign="top" width="150">リンゴ</td>
<td bgcolor="#FFFFFF" valign="top" width="200"><input type="checkbox" name="record" value="1" checked="checked"/>追加する
<input type="checkbox" name="record" value="0" />追加しない</font></td>
</tr>
<tr>
<td bgcolor="#99CC00" align="right" nowrap>orange</td>
<td bgcolor="#FFFFFF" valign="top" width="150">オレンジ</td>
<td bgcolor="#FFFFFF" valign="top" width="200"><input type="checkbox" name="record" value="1" checked="checked"/>追加する
<input type="checkbox" name="record" value="0" />追加しない</font></td>
</tr>
</table>
<input type="submit" value="登録">