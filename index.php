<!DOCTYPE html PUBLIC h-//W3C//DTD XHTML 1.0 Transitional//ENh hhttp://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtdh>

<?php 
require_once('config.php');
?>
<link rel="shortcut icon" href="./image/map.png">
<meta property="og:title" content="福井ふるさと100景巡り" >
<meta property="og:type" content="Website" >
<meta property="og:url" content="http://fukui.t-tu.com" >
<meta property="og:image" content="./image/map.png">
<meta property="fb:admins" content="1667345770" >
<meta property="fb:app_id" content="1420328568182173" >
<meta property="og:site_name" content="福井ふるさと100景巡り" />
<meta property="og:description" content="福井県のふるさと100景の写真を場所ごとに閲覧できるWebサイトです。" />
<link rel="apple-touch-icon-precomposed" href="./image/map.png" >
<meta name="apple-mobile-web-app-capable" content="yes" /> 

<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="./bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<script src="./bootstrap/js/bootstrap.min.js"></script>

<html lang="ja">
<head>
  <title>福井ふるさと100景巡り</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel=stylesheet type="text/css" href="style.css">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="jquery.slides.min.js"></script>
  <meta name="apple-mobile-web-app-capable" content="yes" />  

  <script>/*
    //スマフォ判別→場所指定されてないところと統合：PHPへ
    if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
      alert("スマートフォン・タブレットから閲覧する方は画面を横向きにしてご利用ください。");
    }
*/
    //slideJS実行
    $(function(){
      $("#slides").slidesjs({
        width: 100,
        height: 60,  
        navigation:false,
        pagination:false,
        callback: {
          loaded: function(number) {
          //function
          document.getElementsByClassName("photo_title")[0].innerHTML = document.getElementById(number).title;
          },
          start: function(number) {
          },
          complete: function(number) {
            console.log(document.getElementById(number).class);
            //document.getElementById("output").innerHTML = document.getElementById(number).title;
            document.getElementsByClassName("photo_title")[0].innerHTML = document.getElementById(number).title;
            //document.getElementsByClassName("group_title")[0].innerHTML = document.getElementById(number).class;
          }
        }

      });
    });

    function appearBtn(){
           for (i = 0; i < document.getElementsByClassName("buttons").length; i++) {
              document.getElementsByClassName("buttons")[i].style.zIndex = '100'; 
              btn = 0;
            } 
    }   
    var btn=0;

    function hiddenBtn() {

    /*
            for (i = 0; i < document.getElementsByClassName("buttons").length; i++) {
             document.getElementsByClassName("buttons")[i].style.zIndex = '-10'; 
             btn = 1;
            }
*/
    if (document.getElementsByClassName("buttons").length) {
          if(btn == 0){
            for (i = 0; i < document.getElementsByClassName("buttons").length; i++) {
             document.getElementsByClassName("buttons")[i].style.zIndex = '-10'; 
             btn = 1;
            }
          } else {
            for (i = 0; i < document.getElementsByClassName("buttons").length; i++) {
              document.getElementsByClassName("buttons")[i].style.zIndex = '100'; 
              btn = 0;
            } 
       }
     }
//document.getElementsByClassName("buttons")[0].style.zIndex = -1;    

/*      document.getElementsByClassName("group_title")[0].innerHTML = document.getElementsByClassName("buttons").length;

      /*
      .getElementsByClassName("buttons").length;    
      document.getElementsByClassName("photo_title")[0].innerHTML = null;   
      document.getElementsByClassName("group_title")[0].innerHTML = document.getElementsByClassName("buttons")[0].style.zIndex;    

    if (document.all.item("buttons").length) {
        for (i = 0; i < document.all.item("buttons").length; i++) {
         document.all.item("buttons",i).style.zIndex = '-10'; 
       }
     }

      document.all.item("buttons").style.zIndex = '-10'; */
/*      document.getElementsByClassName("photo_title")[0].innerHTML = document.getElementsByClassName("buttons").style.zIndex;      */
/*      //document.getElementById("1").style.z-index = "11"; */
    };

  </script>
</head>

<body>
  <div class="main">

    <?php 
    //DB接続
    // MySQLへ接続する
    $link = mysql_connect($DSN,$DB_USER,$DB_PASSWORD) or die("MySQLへの接続に失敗しました。");
    // データベースを選択する
    $sdb = mysql_select_db($DB_NAME,$link) or die("データベースの選択に失敗しました。");

    $group=$_GET['p']; 
    if($group == null){
        $group = rand(1,100);
        echo <<<EOM
        <script type="text/javascript">
          if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
      alert("スマートフォン・タブレットから閲覧する方は画面を横向きにしてご利用ください。タッチ操作で写真の切り替えが可能です。");
    }
        </script>
EOM;
    }

    mysql_query('SET NAMES utf8', $link );

    $sql = "SELECT * FROM `fukui_group_list` WHERE `no` =".$group;
    $result = mysql_query($sql, $link) or die("cannot send query<br />SQL:".$sql);

    while ($row = mysql_fetch_assoc($result)) {
      echo '<div class="buttons group_title">'.$row['no'].':'.$row['name'].'</div>';
    }

    ?>

    <!--div class="buttons group_title">グループ名</div-->
    <div class="buttons photo_title">写真名</div>

    <a href="#mapModal" data-toggle="modal">    
      <img class="buttons funcBtn mapBtn" src="./image/map.png"/>
    </a>

    <a href="#aboutModal" data-toggle="modal">
      <img class="buttons funcBtn aboutBtn" src="./image/about.png"/>
    </a>

<?php
    $sql = "SELECT count(*) FROM `fukui_photo_list` WHERE `group_no` =".$group;
    $result = mysql_query($sql, $link) or die("cannot send query<br />SQL:".$sql);
//    var_dump((mysql_fetch_assoc($result))['count(*)']);
//    var_dump((mysql_fetch_assoc($result))['count(*)']);
     $tablecount = mysql_fetch_assoc($result);
    if( $tablecount['count(*)'] == 1){

      $sql = "SELECT * FROM `fukui_photo_list` WHERE `group_no` =".$group;
      $result = mysql_query($sql, $link) or die("cannot send query<br />SQL:".$sql);
      $row = mysql_fetch_assoc($result);

      echo '<img class="full" src="photo/image_'.$row['photo_no'].'.jpg" title="'.$row['name'].'" ONCLICK="hiddenBtn();" />';
      echo  '<div class="buttons photo_title">'.$row['name'].'</div>';

    } else {
?>
    <div id="slides">
      <a href="#" class="buttons slidesjs-previous slidesjs-navigation">
        <i class="xicon-chevron-left xicon-large">
          <img class="arrows" src="./image/back.gif" />
        </i>
      </a>
      
      <a href="#" class="buttons slidesjs-next slidesjs-navigation">
        <i class="xicon-chevron-right xicon-large">
          <img class="arrows" src="./image/forward.gif" />
        </i>
      </a>

    <?php

    $sql = "SELECT * FROM `fukui_photo_list` WHERE `group_no` =".$group;
    $result = mysql_query($sql, $link) or die("cannot send query<br />SQL:".$sql);

    $n=0;
    while ($row = mysql_fetch_assoc($result)) {
      $n=$n+1;
      echo '<img id="'.$n.'" src="photo/image_'.$row['photo_no'].'.jpg" title="'.$row['name'].'" ONCLICK="hiddenBtn();" />';
    }

    ?>
      <!--img id="1" src="photo/image_1.jpg" title="義経や親ランも通った　加越国境の旧北陸道" ONCLICK="hiddenBtn();" >
      <img id="2" src="photo/image_2.jpg" title="test" ONCLICK="hiddenBtn();" >
      <img src="photo/image_3.jpg" ONCLICK="hiddenBtn();" >
      <img src="photo/image_4.jpg" ONCLICK="hiddenBtn();" >
      <img src="photo/image_5.jpg" ONCLICK="hiddenBtn();" -->

    </div>
      <div class="loading">現在写真を読み込み中です。</div>

    <?php } ?>

      <!--div id="output">1</div>
      <div id="title_out"></div>
      <div id="subtitle_out"></div-->
  </div>

<noscript>
  <div class="error">本WebサイトはブラウザのJavascriptをONにしてお楽しみください。</div> 
</noscript>

<div id="aboutModal" class="modal hide fade large">
<div class="modal-header">
    <a href="#" class="close" data-dismiss="modal">&times;</a>
    <h1>このサイトについて</h1>
</div>
<div class="modal-body">
<p>福井ふるさと100景巡りへようこそ</p>
<p>こちらのサイトは<a href="http://www.pref.fukui.lg.jp/doc/toukei-jouhou/opendata/index.html">福井県のオープンデータ</a>での福井ふるさと百景を利用し、福井の様々な景観を紹介するWebサイトです。</p><br>
<p>写真を切り替えたい場合は左右の矢印をクリックして下さい。<br>(スマートフォン・タブレットからは写真をスライドする事で切り替えが可能です。)</p><br>
<p>写真上部には場所を、下部には写真の詳細な名称が表示されます。</p><br>
<p>右側の福井県マークをクリックすると場所の一覧が表示され、表示したい場所の切り替えが行えます。ブラウザを全画面表示にする事でより楽しめます。</p>

<!--facebook-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=1418090295105097";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--tweet-->
  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://fukui.t-tu.com/" data-text="福井ふるさと100景巡り|福井県の様々な景観を写真で紹介するWebサイト" data-via="tatsuaki_w">Tweet</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!--tweet end-->
<div class="fb-like" data-href="http://fukui.t-tu.com" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
<!--facebook end-->
<p>作者：<a href="http://t-tu.com">渡辺タツアキ</a></p>
</div>
</div><!--about modal end-->

<div id="mapModal" class="modal hide fade large">
<div class="modal-header" style="backgroundcolor:black;">
    <a href="#" class="close" data-dismiss="modal">&times;</a>
    <h1>福井ふるさと100景巡り</h1>
</div>
<div class="modal-body">
  <h3>一覧から閲覧したい場所を選んで下さい。</h3>
  <table class="group_list">
<?php
    $sql = "SELECT * FROM `fukui_group_list` WHERE 1 ORDER BY `fukui_group_list`.`no`";
    $result = mysql_query($sql, $link) or die("cannot send query<br />SQL:".$sql);

    while ($row = mysql_fetch_assoc($result)) {
      if($group == $row['no']){
        echo "<tr class='nowgroup'><td class='no'>".$row['no']."</td>";
        echo "<td class='group_name'>".$row['name']."</td></tr>"; 
      } else {
        echo "<tr><td class='no'>".$row['no']."</td>";
        echo "<td class='group_name'><a href='.?p=".$row['no']."'>".$row['name']."</a></td></tr>"; 
      }
    }
?>
  </table>

</div>
</div><!--map modal end-->


<!--twitter bootstrapのやつ-->
<script src="./bootstrap/js/bootstrap.min.js"></script>

</body>
</html>