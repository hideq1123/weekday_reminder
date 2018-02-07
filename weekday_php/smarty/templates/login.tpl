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
</HEAD>
<BODY>
<div class="container"> 
    <div class="jumbotron" style="color:#FFF; background:url(img/top_tmp.jpg); background-size:cover;text-shadow: black 1px 1px 0px, black -1px 1px 0px,black 1px -1px 0px, black -1px -1px 0px;">
      <A href="{$SCRIPT_NAME}"><font color="#FFFFFF"><h1>{$web_app_name}</h1></a></font>
      <p>{$web_app_detail}</p>
    </div>
<div class="row">

  <div class="col-sm-12" style="background:#F0FFFF;height:280px;">
  <BR><p>ログインはこちらから</p>
      <form class="form-inline text-right" method="post">
  <div class="form-group">
    <label class="sr-only" for="uID">ユーザー名</label>
    <input class="form-control" type="text" name="username" placeholder={$form.username.label} autocomplete="on" size="16">
  </div>
  <div class="form-group">
    <label class="sr-only" for="pass">パスワード</label>
    <input class="form-control" type="password" name="password" placeholder={$form.password.label} autocomplete="on" size="16">
  </div>
  <button class="btn btn-success">ログイン</button><INPUT type="hidden" name="type" value="{$type}">
</form><FONT size="2" color="red"> {$auth_error_mess} </FONT>

	<div class="col-xs-12 col-sm-12">
    <a href="{$SCRIPT_NAME}?type=regist&action=form" class="btn btn-success btn-block">新規作成</a>
    <a href="{$SCRIPT_NAME}?type=forget&action=form" class="btn btn-success btn-block">パスワード再登録</a>
  	</div>
   </div>
</div>

<BR>
<ul class="media-list">
  <li class="media">
    <spam class="media-left">
      <img src="img/calendar.jpg" class="img-rounded" class="img-responsive">
    </spam>
    <div class="media-body">
      <h3 class="media-heading">ウィークデーリマインダーとは</h3>
祝日を元に数えたり平日の営業日からのカウントが可能な新しいタイプのリマインダーです。GoogleカレンダーやYahooカレンダー等、これまでの<A href="http://iphone.f-tools.net/App/reminders-HowTo.html" Target="_blank">リマインダー</a>には無かった機能を詰め込みました。
    </div>
  </li>
<BR>自動的に指定日の前営業日や翌営業日に通知する、日付ずらし機能を搭載しています。具体的には下記のようなシーンでお役立て頂けます。<BR><BR>
<div style="background:#FDF5E6;">・毎月の25日にお金をATMでおろしているのに、今月の25日は日曜だったせいで手数料がかかってしまった。←自動で金曜日に通知できます。<BR><BR>・毎週火曜日がゴミの日なのに、たまたま祝日だったから回収日は前日だった←自動で月曜日に通知できます。<BR><BR>・いつも通り電車に乗ろうとしたら、祝日ダイヤだった←祝日のみの通知ができます<BR><BR>・月の最終日から数えて5営業日前といった繰り返し処理がしたい←20営業日まで可能です</div><BR>
  <li class="media">
    <div class="media-body">
これまでのリマインダーは祝日の概念が薄かったため、こういったものを作ってみました。
    </div>
        <spam class="media-right">
      <img src="img/calendar2.jpg" class="img-rounded">
    </spam>
  </li>

<BR>通知自体は登録したEメールに届きますが、<A href="http://mythings.yahoo.co.jp/" Target="_blank">Yahoo! mythings</a>と組み合わせて使うことで、SNS経由の通知も可能になります。また、Yahoo!カレンダー等、既存のリマインダーと併用することでもさらに便利にお使い頂けます。バグや機能の追加依頼等あれば<a href="http://form1.fc2.com/form/?id=822425">フォーム</a>からご連絡下さい。
</ul>

<br>・リマインダー設定画面<hr>
<center>
<img src="img/gamen.jpg" class="img-responsive img-thumbnail">
</center>

<!-- シェアボタン [ここから] -->
<?php
	$share_url_syncer = "http://first.main.jp/matome/matome-gen";//シェア対象のURLアドレスを指定する (HTML部分は変更不要)
?>

<div class="social-area-syncer" style="margin-top: 20px;">
	<ul class="social-button-syncer">
		<!-- Twitter -->
		<li class="sc-tw"><a data-url="<?php echo $share_url_syncer ; ?>" href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-count="vertical" data-dnt="true">ツイート</a></li>

		<!-- Facebook -->
		<li class="sc-fb"><div class="fb-like" data-href="<?php echo $share_url_syncer ; ?>" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div></li>

		<!-- Google+ -->
		<li><div data-href="<?php echo $share_url_syncer ; ?>" class="g-plusone" data-size="tall"></div></li>

		<!-- はてなブックマーク -->
		<li><a href="http://b.hatena.ne.jp/entry/<?php echo $share_url_syncer ; ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="vertical-balloon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border:none;" /></a></li>

		<!-- pocket -->
		<li><a data-save-url="<?php echo $share_url_syncer ; ?>" data-pocket-label="pocket" data-pocket-count="vertical" class="pocket-btn" data-lang="en"></a></li>

		<!-- LINE [画像は公式ウェブサイトからダウンロードして下さい] -->
		<li class="sc-li"><a href="http://line.me/R/msg/text/?<?php echo rawurlencode($share_url_syncer); ?>"><img src="img/36x60.png" width="36" height="60" alt="LINEに送る" class="sc-li-img"></a></li>
	</ul>

<!-- Facebook用 -->
<div id="fb-root"></div>

</div><!-- シェアボタン [ここまで] -->

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
<script src="js/share-button.js"></script><!-- シェアボタンのjs -->
</BODY>
</HTML>
