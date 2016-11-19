<?php 
 //$debug=true;
define('DEBUG', false);

	//echoの独自関数化
	//1:UIに必要な表示をするため
	//2:デバック用に変数の内容を表示するため
function special_echo($val){
	if (DEBUG) {
	echo $val;
	echo '<br>';
	}
}
//var_dumpの独自化
function special_var_dump($var){
	if (DEBUG) {
		echo '<pre>';
		echo var_dump($var);
		echo '<pre>';
	}
}?>