<?php
if(isset($_GET["url"]) && preg_match("/^https?:/",$_GET["url"])){
    echo file_get_contents($_GET["url"]);
}else{
    echo "error ";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>デ辞蔵 REST版API を使ってみる</title>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#container').on('click', '#btn_wikipedia', function() {
        var txt = $('#input_keyword').val();
        if (txt != '') {
            getList('wpedia',txt);
        }
    });
    $('#container').on('click', '#btn_ej', function() {
        var txt = $('#input_keyword').val();
        if (txt != '') {
            getList('EJdict',txt);
        }
    });
    $('#container').on('click', '#btn_je', function() {
        var txt = $('#input_keyword').val();
        if (txt != '') {
            getList('EdictJE',txt);
        }
    });
});

var nowdic = '';

function getList(_dic,_txt){
    nowdic = _dic;
    var reqPath = "http://public.dejizo.jp/NetDicV09.asmx/SearchDicItemLite?Dic="+nowdic+"&Word="+encodeURI(_txt)+"&Scope=HEADWORD&Match=CONTAIN&Merge=AND&Prof=XHTML&PageSize=20&PageIndex=0";
    console.log(reqPath);
    $('#result2').html('');
    $.ajax({
        type: "get",
        url: "ajax.php",
        data:{
            url:reqPath
        },
        dataType: 'xml',
        cache: false,
        timeout: 5000,
        success: function(xml) {
            console.log(xml);
            var htmlstr = '<ul>';
            $(xml).find("DicItemTitle").each(function() {
                var id = $(this).find("ItemID").text();
                var title = $(this).find("Title").text();
                htmlstr += '<li><a href="javascript:getWord(\''+id+'\');">'+title+'</li>';
            });
            htmlstr += '</ul>';
            $('#result1').html(htmlstr);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('error');
        }
    });
}

function getWord(_id){
    var reqPath = "http://public.dejizo.jp/NetDicV09.asmx/GetDicItemLite?Dic="+nowdic+"&Item="+_id+"&Loc=&Prof=XHTML";
    console.log(reqPath);
    $.ajax({
        type: "get",
        url: "ajax.php",
        data:{
            url:reqPath
        },
        dataType: 'xml',
        cache: false,
        timeout: 5000,
        success: function(xml) {
            console.log(xml);
            var htmlstr = '';
            var data = $(xml).find("Body").get(0);
            var serializer = new XMLSerializer(); 
            htmlstr += serializer.serializeToString(data);
            $('#result2').html(htmlstr);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('error');
        }
    });
}
</script>
</head>
<body>
<h1>デ辞蔵 REST版API を使ってみる</h1>
<p>ドキュメント：<a href="https://dejizo.jp/dev/rest.html" target="_blank">https://dejizo.jp/dev/rest.html</a></p>
<hr>
<div id="container">
    <input type="text" id="input_keyword">
    <button type="button" id="btn_wikipedia">ウィキペディア日本語版</button>
    <button type="button" id="btn_ej">EJDict英和辞典</button>
    <button type="button" id="btn_je">Edict和英辞典</button>
    <hr>
    <div id="result1"></div>
    <hr>
    <div id="result2"></div>
</div>
</body>
</html>