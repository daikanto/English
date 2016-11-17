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
  //エラー:英語じゃない文字が入力される 問題点'.'判別されてしまう。s
  	 if ((ctype_alnum($_POST['text_english']))==true) {//FALSE
   	 		$error['text_english']='not_english';
  	 		echo "英語じゃない文字が入力されている";
  	 }
  //エラー：テキストが.で終わっていない かつ　テキストの最後の'.'の後にスペースが入る場合(未実装)//&& (substr($_POST['text_english'],-1)!==' ')
  	 if ((substr($_POST['text_english'],-1)!=='.')){
  	 		$error['text_english']='not_dot';
  	 		echo "'.'で終わっていないテキストです";
  	 }
  	 if (empty($error['text_english'])){

  	 		//$sql = sprintf('INSERT INTO `text` SET `text`="%s",`number_vocabulary`=0,`date`=NOW()',mysqli_real_escape_array($db,$_POST['text_english']));
  	 	  //mysqli_query($db,$sql) or die(mysqli_error($db));
  	 	    echo "DBにテキスト登録成功";
  	
//テキストから一文の選択
      $number_sentence=array();
//テキストをすべて小文字に変換
      $_POST['text_english']=strtolower($_POST['text_english']);
//'.'でテキストから文章を取り出し配列に格納
      $english['text_english']=explode('.',$_POST['text_english']);
      $count_sentence=count($english['text_english']);
        //echo '</br>'; 
      //var_dump($english['text_english']);
        //echo '</br>'; 
        //echo $count_sentence;
        //echo 'sentence</br>';
//各配列にある一文を単語に分ける
      $number_words=array();
      $english['book']=array();
      foreach ($english['text_english'] as $english['sentence'] ) {
      $number_words=explode(' ',$english['sentence']);

		  $count_words=count($number_words);
//""を取り除く
      $english['word']=str_replace('"', '', $number_words);
//,を取り除く
      $english['word']=str_replace(',','', $english['word']);
//()を取り除く
      $english['word']=str_replace('(','', $english['word']);
      $english['word']=str_replace(')','', $english['word']);
//-を取り除く
      $english['word']=str_replace('-','', $english['word']);
//冠詞をのぞくを取り除く the a an 
//前置詞の削除 in out by for on at with to exc
//be動詞の削除 be
//助動詞の削除 can may would will could might must should  
//代名詞の削除


//○○'sの's削除　
//数字の削除
      $english['word']=preg_replace('/[0-9]/','',$english['word']);
//文字列が入ってんいない配列の削除
      $english['word']=array_filter($english['word']);
//配列のkey要素をリセットし、再カウント
      $english['book']=array_merge($english['word'],$english['book']);
//連想配列を連結させる

//配列内での重複したものを検証
//英単語だけの配列完成

     foreach ($english['word'] as $words) {
       //$word['words']=var_export($words);
       //echo $word['words'];
       //echo '<br>'; 
       //$wordと$word['words']の違い
       //配列全体が$word,$word['word']は配列$word[]のwordの場所
//単語の保存 
//重複した単語は保存しない　DB登録OK
  //DBの接続をなるべく減らす
  //重複した単語がある場合//DBでの単語の重複検索を行うのがいいのか、テキストである程度重複を減らしたほうがいいのか→極力DBの接続の回数は減らす
    //DBの登録はしない

  //重複しない場合
    //DBの登録を行う
      //$sql = sprintf('INSERT INTO `word` SET `word`="%s",`status`=0,`date`=NOW()',mysqli_real_escape_string($db,$words));
      //mysqli_query($db,$sql) or die (mysqli_error($db));
//重複した単語はDBに登録しない
       //配列内で重複したものを削除
       //DBから取り出す
       //DBから取り出した英単語とphp上の配列で重複チェック
    }
   }
  }

}
   //DBから英単語を取り出す
  $sql='SELECT `word_id`,`word` FROM `word` WHERE 1';
  $record=mysqli_query($db,$sql) or die(mysqli_error($db));
    //fetchしてarray型に変換する
    //echo '<pre>';
    //var_dump($record);
    //echo '<pre>';

  $checks['db_english']=mysqli_fetch_assoc($record);
 
    //echo '<pre>';
    //var_dump($checks['english']);
    //echo '<pre>';
     //echo '<pre>'; 
     //var_dump($english['book']);
     //echo '<pre>';

  $check=array();
foreach ($english['book'] as $check_words){
  //echo 'yeah';
  //echo '<br>';
  var_dump($check_words);

while ($check['db_english']=mysqli_fetch_assoc($record)) {
    $check=$check['db_english'];
    if($check==$check_words){//'is'の場所に入力した配列$english['book'];
      echo 'かぶっとる';
      echo '<br>';
    }
    echo '<pre>';
    //DBからの重複チェック用の配列
    var_dump($check);
    echo '<pre>';
  }
}

	  	
  
 ?>
 <form method="post" action="">
 	<textarea name="text_english"></textarea><br>
 	<input type="submit" value="登録される">
 </form>