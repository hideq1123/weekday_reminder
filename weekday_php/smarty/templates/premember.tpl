<HTML>
<!-- 注意！

このファイル内のトップページへのリンクは、"{$SCRIPT_NAME}"では設定できないので、手動で設定する必要がある！戻るボタンのところと、タイトル文字をクリックしたところの二カ所を修正する必要あり

 -->
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
</HEAD>
<BODY>
<div class="container"> 
    <div class="jumbotron" style="color:#FFF; background:url(img/top_tmp.jpg); background-size:cover;text-shadow: black 1px 1px 0px, black -1px 1px 0px,black 1px -1px 0px, black -1px -1px 0px;">
      <A href="---Write here your top page website ---"><font color="#FFFFFF"><h1>{$web_app_name}</h1></a></font>
      <p>{$web_app_detail}</p>
    </div>
  		{$message}

<BR><BR><a href="---Write here your top page website ---" class="btn btn-success btn-block">トップへ戻る</a>{*このテンプレートでは$SCRIPT_NAMEは使えない。なぜなら呼び出し元のファイルがindex.phpではなくpremember.phpだから*}
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


</div><!-- コンテナ終了 -->
{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}{* デバッグ出力用の文字に置き換わります。$debug_strの内容はBaseControllerのdebug_displayメソッド内に格納されています *}
</BODY>
</HTML>