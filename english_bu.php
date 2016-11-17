<?php 
  //セッションの設定  
  session_start();
  require('dbconnect.php');

  //DB_text tableに入力したテキストがDBにtext,date,登録される
  //ボタンを押されたか判断

  //$error[]がblankであること
  //エラー:英語じゃない文字が入力される
  //エラー：テキストが.で終わっていない
  //エラー：
  if (!empty($_POST)) {
  //エラーがblank判定
  	 if ($_POST['text_english']==' ') {
  	 		$error['text_english']='blank';
  	 		echo "空欄でーす";
  	 }	
  //エラー:英語じゃない文字が入力される '.'判別されてしまう。
  	 if ((ctype_alnum($_POST['text_english']))) {
   	 		$error['text_english']='not_english';
  	 		echo "英語じゃない文字が入力されている";
  	 }
  //エラー：テキストが.で終わっていない かつ　テキストの最後の'.'の後にスペースが入る場合(未実装)//&& (substr($_POST['text_english'],-1)!==' ')
  	 if ((substr($_POST['text_english'],-1)!=='.')){
  	 		$error['text_english']='not_dot';
  	 		echo "'.'で終わっていないテキストです";
  	 }


  	 if (empty($error['text_english'])){

  	 		//$sql = sprintf('INSERT INTO `text` SET `text`="%s",`number_vocabulary`=0,`date`=NOW()',mysqli_real_escape_string($db,$_POST['text_english']));
  	 	    //$record=mysqli_query($db,$sql) or die(mysqli_error($db));
  	 	    echo "DBにテキスト登録成功";
  	
//テキストから一文の選択
      $number_sentence=array();
//'.'でテキストから文章を取り出し配列に格納
      $number_sentence=explode('.',$_POST['text_english']);
      $count_sentence=count($number_sentence);
        echo '</br>'; 
        //var_dump($number_sentence);
        echo '</br>'; 
        //echo $count_sentence;
        //echo 'sentence</br>';
//各配列にある一文を単語に分ける
      foreach ($number_sentence as $sentence ) {
      $number_words=array();
      $number_words=explode(' ',$sentence);
		  $count_words=count($number_words);
		  	echo '</br>'; 
		  	var_dump($number_words);
		  	echo '</br>'; 
		  	echo $count_words;
		  	echo 'words</br>';
      
      

		 }





        
//英単語ではないものを取り除く
//数字
//重複


	}  	
	//var_dump($error);

  }




 ?>


 <form method="post" action="">
 	<textarea name="text_english"></textarea><br>
 	<input type="submit" value="登録される">
 </form>