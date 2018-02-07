<HTML>
<HEAD>
<TITLE>{$title}</TITLE>
<meta name="viewport" content="width=device-width"><!-- モバイル端末の幅で表示する。-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/share-button.css" rel="stylesheet"><!-- シェアボタンのcss -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <meta charset="UTF-8"> 
  <script>
  $(document).ready(function() {
  var pagetop = $('.pagetop');
    $(window).scroll(function () {
       if ($(this).scrollTop() > 100) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});</script>
</HEAD>
<BODY bgcolor="#FFFFFF">
<div class="container"> 
    <div class="jumbotron" style="color:#FFF; background:url(img/top_tmp.jpg); background-size:cover;text-shadow: black 1px 1px 0px, black -1px 1px 0px,black 1px -1px 0px, black -1px -1px 0px;">
      <A href="{$SCRIPT_NAME}"><font color="#FFFFFF"><h1>{$web_app_name}</h1></a></font>
      <p>{$web_app_detail}</p>
    </div>
<HR size="1" noshade>
<B><spam id="top">{$title}</spam></B>
<HR size="1" noshade>
<div class="btn-group btn-group btn-group-justified">
		<A href="{$SCRIPT_NAME}?type=modify&action=form" class="btn btn-success">送信先＆パスワード</A>
      	<A href="{$SCRIPT_NAME}?type=logout" class="btn btn-warning">ログアウト</A>
</div>
<BR>下記の青いボタンを押して、リマインダーを設定してください。<BR><BR><BR>
    <BR><A href="{$SCRIPT_NAME}?type=holiday&action=set" class="btn btn-primary btn-block">日にちから設定する</A>
    {if ($no_sche_messe1) }<BR>
    <CENTER>{$no_sche_messe1}</CENTER><BR><BR>
    {/if}
    
{if ($ken_messe1_data) }{*$ken_messe1_dataがある場合のみデータを表示します*}
<table class="table table-striped">
  <thead>
    <tr><th>日にち</th><th>送信日</th></tr>
  </thead>
  <tbody>
{foreach item=item from=$ken_messe1_data}{*テンプレート内での繰り返し処理も可能です*}
<TR><TD>毎月{$item.set_sendday}日</TD><TD>{if ( $item.send_timing == "0" ) }当日{/if}{if ( $item.send_timing == "1" ) }前日{/if}{if ( $item.send_timing == "2" ) }前営業日{/if}{if ( $item.send_timing == "3" ) }翌日{/if}{if ( $item.send_timing == "4" ) }翌営業日{/if}</TD><TD><a href="{$SCRIPT_NAME}?type=holiday_henkou&action=modify&messe_no={$item.messe_No}" class="btn btn-primary btn-xs">変更</a><a href="{$SCRIPT_NAME}?type=holiday_sakujo&action=delete&messe_no={$item.messe_No}" class="btn btn-default btn-xs">削除</a></TD></TR></TR>
{/foreach}
</tbody>
</table>
<BR>
{/if}
    
    <A href="{$SCRIPT_NAME}?type=week&action=set" class="btn btn-primary btn-block">曜日から設定する</A>
    {if ($no_sche_messe2) }<BR>
    <CENTER>{$no_sche_messe2}</CENTER><BR><BR>
    {/if}
    {if ($ken_messe2_data) }{*$ken_messe2_dataがある場合のみデータを表示します*}
<table class="table table-striped">
  <thead>
    <tr><th>曜日</th><th>送信日</th></tr>
  </thead>
  <tbody>
{foreach item=item from=$ken_messe2_data}{*テンプレート内での繰り返し処理も可能です*}
<TR><TD>{if ( $item.set_sendday == "0" ) }日曜日{/if}{if ( $item.set_sendday == "1" ) }月曜日{/if}{if ( $item.set_sendday == "2" ) }火曜日{/if}{if ( $item.set_sendday == "3" ) }水曜日{/if}{if ( $item.set_sendday == "4" ) }木曜日{/if}{if ( $item.set_sendday == "5" ) }金曜日{/if}{if ( $item.set_sendday == "6" ) }土曜日{/if}{if ( $item.set_sendday == "7" ) }曜日指定無し{/if}</TD><TD>{if ( $item.send_timing == "0" ) }当日{/if}{if ( $item.send_timing == "1" ) }前日{/if}{if ( $item.send_timing == "2" ) }前営業日{/if}{if ( $item.send_timing == "3" ) }翌日{/if}{if ( $item.send_timing == "4" ) }翌営業日{/if}</TD><TD><a href="{$SCRIPT_NAME}?type=week_henkou&action=modify&messe_no={$item.messe_No}" class="btn btn-primary btn-xs">変更</a><a href="{$SCRIPT_NAME}?type=week_sakujo&action=delete&messe_no={$item.messe_No}" class="btn btn-default btn-xs">削除</a></TD></TR></TR>
{/foreach}
</tbody>
</table>
<BR>
{/if}

    <A href="{$SCRIPT_NAME}?type=eigyoubi&action=set" class="btn btn-primary btn-block">営業日から設定する</A>
	{if ($no_sche_messe3) }<BR>
    <CENTER>{$no_sche_messe3}</CENTER><BR>
    {/if}
    {if ($ken_messe3_data) }{*$ken_messe3_dataがある場合のみデータを表示します*}
<table class="table table-striped">
  <thead>
    <tr><th>数え始め</th><th>送信日</th></tr>
  </thead>
  <tbody>
{foreach item=item from=$ken_messe3_data}
<TR><TD>{if ( $item.set_sendday == "0" ) }月初から{/if}{if ( $item.set_sendday == "1" ) }月末から{/if}</TD><TD>{if ( $item.send_timing == "0" ) }最終営業日{/if}{if ( $item.send_timing != "0" ) }第{$item.send_timing}営業日{/if}</TD><TD><a href="{$SCRIPT_NAME}?type=eigyoubi_henkou&action=modify&messe_no={$item.messe_No}" class="btn btn-primary btn-xs">変更</a><a href="{$SCRIPT_NAME}?type=eigyoubi_sakujo&action=delete&messe_no={$item.messe_No}" class="btn btn-default btn-xs">削除</a></TD></TR></TR>
{/foreach}
</tbody>
</table>
<BR>
{/if}

<font size="4" color="green">{$message2}</font><BR>


<div class="btn-group btn-group btn-group-justified">
		<a href="#top" class="btn btn-success"><spam id="pagetop"><font color="#FFF">ページトップへ</font></a></spam>
      	<A href="{$SCRIPT_NAME}?type=logout" class="btn btn-warning">ログアウト</A>
</div>
	<P>
	  <BR><A href="{$SCRIPT_NAME}?type=delete&action=confirm" class="btn btn-default btn-block">アカウントを削除する</A>
        </P>
        <center><font size="1">3年以上ログインのないアカウントは、自動削除となる場合があります。</font></center>
</div><!-- コンテナ終了 -->
<!-- 中型イメージ -->
<CENTER><BR>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-3488380837004066"
     data-ad-slot="2569774754"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</CENTER>
</div><!-- コンテナの終了 -->

<div span style="height:90px; background-image: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(0.43, rgb(255, 255, 255)),
	color-stop(1, rgb(152, 203, 0)),
	color-stop(1, rgb(183, 244, 27))
);
background-image: -o-linear-gradient(bottom, rgb(255, 255, 255) 43%, rgb(152, 203, 0) 100%, rgb(183, 244, 27) 100%);
background-image: -moz-linear-gradient(bottom, rgb(255, 255, 255) 43%, rgb(152, 203, 0) 100%, rgb(183, 244, 27) 100%);
background-image: -webkit-linear-gradient(bottom, rgb(255, 255, 255) 43%, rgb(152, 203, 0) 100%, rgb(183, 244, 27) 100%);
background-image: -ms-linear-gradient(bottom, rgb(255, 255, 255) 43%, rgb(152, 203, 0) 100%, rgb(183, 244, 27) 100%);
background-image: linear-gradient(to bottom, rgb(255, 255, 255) 43%, rgb(152, 203, 0) 100%, rgb(183, 244, 27) 100%);">
</div>

<footer style="color:#8b4513; background-color:#9c0; padding-top:14px; padding-bottom:14px;">
	<div class="container"><!-- 中央にそろえるためにコンテナクラスを適用 -->
	<!--起業速報経由でツイッタがばれるのを防ぐため、コメントアウトすることにした。<a href="https://twitter.com/nodoame_15" style="color:#331907;">&copy;制作者： しも・Dのページ</a> -->
	<div>
</footer>


{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}{* デバッグ出力用の文字に置き換わります。$debug_strの内容はBaseControllerのdebug_displayメソッド内に格納されています *}
</BODY>
</HTML>