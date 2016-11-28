<?php 
include_once("dBug.php");
require("functions.php");

  //セッションの設定  //テキスト、英単語
  session_start();
  require('dbconnect.php');

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

  //DB_text tableに入力したテキストがDBにtext,date,登録される
  //ボタンを押されたか判断
  if (!empty($_POST)){
      //エラーがblank判定
     if ($_POST['text']==' ') {
        $error['text']='blank';
        echo "空欄でーす";
     }  
  //エラー:英語じゃない文字が入力される 問題点'.'判別されてしまう。s
     if ((ctype_alnum($_POST['text']))==true) {//FALSE
        $error['text']='not_english';
        echo "英語じゃない文字が入力されている";
     }
  //エラー：テキストが.で終わっていない かつ　テキストの最後の'.'の後にスペースが入る場合(未実装)//&& (substr($_POST['text'],-1)!==' ')
     if ((substr($_POST['text'],-1)!=='.')){
        $error['text']='not_dot';
        echo "'.'で終わっていないテキストです";
     }
     if (empty($error['text'])){
      //$_sesstion[]でテキストの値を保存する
      //保存はcheck.phpで行う
      $_SESSION['text']=$_POST['text'];

          echo "DBにテキスト登録成功";
          echo '<br>';

    
//テキストから一文の選択
      $number_sentence=array();
//テキストをすべて小文字に変換
      $_POST['text']=strtolower($_POST['text']);
//'.'でテキストから文章を取り出し配列に格納
      $english['text']=explode('.',$_POST['text']);
      $count_sentence=count($english['text']);
        //echo '</br>'; 
      //var_dump($english['text']);
        //echo '</br>'; 
        //echo $count_sentence;
        //echo 'sentence</br>';
//各配列にある一文を単語に分ける
      $number_words=array();
      $english['book']=array();
      foreach ($english['text'] as $english['sentence'] ) {
          //文章から単語を取り出す
                $english['word']=explode(' ',$english['sentence']);
                $count_words=count($english['word']);
          //""を取り除く
                $english['word']=str_replace('"', '', $english['word']);
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
          //配列内で重複している文字列をs駆除
                $english['word']=array_unique($english['word']);
          //配列のkey要素をリセットし、再カウント
                $english['book']=array_merge($english['word'],$english['book']);

             }
  }


          $sql=sprintf('SELECT * FROM `WID_TID` WHERE `m_id`=%d', mysqli_real_escape_string($db,$_SESSION['id']));
          $tw_id=mysqli_query($db, $sql) or die(mysqli_error($db));
          $words=array();
          while ($id=mysqli_fetch_assoc($tw_id)){
              special_var_dump($id);
          //ヒットした英単語とテキストのIDを使ってwordからテキストと英単語を取り出す
          //英単語
              $sql=sprintf('SELECT `word` FROM `word` WHERE `word_id`=%d', mysqli_real_escape_string($db,$id['w_id']));
              $record=mysqli_query($db, $sql) or die(mysqli_error($db));

              $word=mysqli_fetch_assoc($record);
                array_push($words, $word['word']);
                  if ($word=='') {
                 special_echo('該当する英単語がありません');
                }
                else{
                 special_var_dump($word);        
                }
          }




         //DBから英単語を取り出す→→→m_idに紐づいた単語を取り出す。
        //$sql='SELECT `word_id`,`word` FROM `word` WHERE `delete_flag`=1';
        //$record=mysqli_query($db,$sql) or die(mysqli_error($db));
        $check=array();
        $check_words=array();
        $result=array();
        $overlaps=array();
        $check_book=array();
        $final_book=array();
        $_SESSION['english_word']=array();
       foreach($english['book'] as $check_words){
                special_echo('入力した文字列');
                special_var_dump($check_words);
                special_echo('DBにある単語');

               //fetchしてarray型に変換する
               while ($check['db_english']=mysqli_fetch_assoc($record)) {

                      if($check['db_english']['word']==$check_words){
                        echo '同じやつ';
                        echo '<br>';
                        //同じやつだった場合の処理
                         $result[]=$check_words;
                       }           
                //special_var_dump($english['book']);
                special_var_dump($check['db_english']['word']);               
              }
              //mysqlのカウントをリセット
                mysqli_data_seek($record,0);
                  special_echo('重複文字');
                  foreach($result as $overlap){
                    //special_echo($overlap);
                  //選択した文字列を削除するアルゴリズム
                  //文字列を配列に代入
                  $overlaps=$overlap;
                  special_var_dump($overlaps);
                  special_echo('-----------------------------------------------------------------------');
                  }

        }
         special_echo('重複していない');
              foreach ($english['book'] as $check_books) {
                          $count=0;
                 //重複する文字を入力した文字配列
                 foreach ($result as $over) {
                          if ($check_books==$over) {
                                $count++;                    
                            }
                  }

                if ($count==0) {
                      $final_book=$check_books;
                      special_var_dump($final_book);
                      array_push($_SESSION['english_word'], $check_books);

                      foreach(array($_SESSION['english_word']) as $w){
                      special_var_dump($w);
                      }
                  }
                  //special_echo('$_SESSION[english_word]');
                  //special_var_dump($_SESSION['english_word']);
                //  if (empty($_SESSION['englsih'])) {
                //header('Location:index.php');
                //exit();
                  //}
                }
                header('Location:check.php');
                exit();
}



//セッションに処理後の配列を挿入する
 ?>
 <p>user name:<?php echo $member['user_name']; ?></p>
 <form method="post">
 	<textarea name="text" style="font-size: 50px"></textarea><br>
 	<input type="submit" value="単語を検索">
 </form>
 <a href="edit.php?m_id=<?php echo $_SESSION['id']; ?>">編集</a>|
 <a href="show.php?m_id=<?php echo $_SESSION['id']; ?>">単語一覧へ</a>|
 <a href="text.php?m_id=<?php echo $_SESSION['id']; ?>">テキスト一覧へ</a>
