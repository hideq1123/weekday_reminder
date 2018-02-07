<?php
/* Smarty version 3.1.29, created on 2017-07-28 13:31:37
  from "/home/users/2/main.jp-mossgreen/web/weekday_php/smarty/templates/holiday_set.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_597abe293ebbb1_46163016',
  'file_dependency' => 
  array (
    'd5cd82edb52a5e1b27c194f89b4b50afac2d4772' => 
    array (
      0 => '/home/users/2/main.jp-mossgreen/web/weekday_php/smarty/templates/holiday_set.tpl',
      1 => 1501130486,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_597abe293ebbb1_46163016 ($_smarty_tpl) {
?>
<HTML>
<HEAD>
<TITLE><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</TITLE>
<meta name="viewport" content="width=device-width"><!-- モバイル端末の幅で表示する。-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/share-button.css" rel="stylesheet"><!-- シェアボタンのcss -->
  <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
  <![endif]-->
  <meta charset="UTF-8"> 
</HEAD>
<BODY>
<div class="container"> 
    <div class="jumbotron" style="color:#FFF; background:url(img/top_tmp.jpg); background-size:cover;text-shadow: black 1px 1px 0px, black -1px 1px 0px,black 1px -1px 0px, black -1px -1px 0px;">
      <A href="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
"><font color="#FFFFFF"><h1><?php echo $_smarty_tpl->tpl_vars['web_app_name']->value;?>
</h1></a></font>
      <p><?php echo $_smarty_tpl->tpl_vars['web_app_detail']->value;?>
</p>
    </div>
<HR size="1" noshade>
<B><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</B>
<HR size="1" noshade>
<CENTER>
<FORM <?php echo $_smarty_tpl->tpl_vars['form']->value['attributes'];?>
>
	<?php echo $_smarty_tpl->tpl_vars['message']->value;?>

	<font size="3" color="red"><?php echo $_smarty_tpl->tpl_vars['message2']->value;?>
</font>
	<BR></CENTER><?php if (($_smarty_tpl->tpl_vars['day']->value)) {?><div style="background:#F0FFFF;border-radius: 10px;"><?php }?>
	<BR>
    <?php if (($_smarty_tpl->tpl_vars['day']->value)) {?>
    <div class="form-group">
    <B><?php echo $_smarty_tpl->tpl_vars['form']->value['day']['label'];?>
</B><?php echo $_smarty_tpl->tpl_vars['form']->value['day']['html'];?>
<BR>
    </div>
    <?php }?>
    <?php if (($_smarty_tpl->tpl_vars['option']->value)) {?>
    <div class="form-group">
    <B><?php echo $_smarty_tpl->tpl_vars['form']->value['option']['label'];?>
</B><?php echo $_smarty_tpl->tpl_vars['form']->value['option']['html'];?>
<BR>
    </div>
    <?php }?>
    <?php if (($_smarty_tpl->tpl_vars['timing']->value)) {?>
     <div class="form-group">
    <B><?php echo $_smarty_tpl->tpl_vars['form']->value['timing']['label'];?>
</B><?php echo $_smarty_tpl->tpl_vars['form']->value['timing']['html'];?>
<BR>
    </div>
    <?php }?>
    <?php if (($_smarty_tpl->tpl_vars['time']->value)) {?>
    <div class="form-group">
    <B><?php echo $_smarty_tpl->tpl_vars['form']->value['time']['label'];?>
</B><?php echo $_smarty_tpl->tpl_vars['form']->value['time']['html'];?>
<BR>
    </div>
    <?php }?>
    
    <?php if (($_smarty_tpl->tpl_vars['rem_title']->value)) {?>
    <div class="form-group">
    <B><?php echo $_smarty_tpl->tpl_vars['form']->value['rem_title']['label'];?>
</B><?php echo $_smarty_tpl->tpl_vars['form']->value['rem_title']['html'];?>
<BR>
    </div>
    <?php }?>
    <?php if (($_smarty_tpl->tpl_vars['day']->value)) {?></div><?php }?>
    <CENTER>
		<?php if (!isset($_smarty_tpl->tpl_vars['form']) || !is_array($_smarty_tpl->tpl_vars['form']->value)) $_smarty_tpl->smarty->ext->_var->createLocalArrayVariable($_smarty_tpl, 'form');
if ($_smarty_tpl->tpl_vars['form']->value['cancel']['value'] = "キャンセル") {?>
		<A href="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cancel']->value;?>
</A>
		<?php }?>
		<?php if (($_smarty_tpl->tpl_vars['form']->value['submit2']['value'] != '')) {?>
		<A href="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
" class="btn btn-default">いいえ</A>
		<?php }?>
		<?php if (($_smarty_tpl->tpl_vars['form']->value['submit']['value'] != '')) {?>
		<?php echo $_smarty_tpl->tpl_vars['form']->value['submit']['html'];?>

		<?php }?>

		<INPUT type="hidden" name="type"   value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
		<INPUT type="hidden" name="action" value="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
		<INPUT type="hidden" name="messe_No" value="<?php echo $_smarty_tpl->tpl_vars['messe_no']->value;?>
">

        </FORM>
        <BR>
        <BR>
	<?php if (($_smarty_tpl->tpl_vars['modoru']->value != '')) {?>
	<A href="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
" class="btn btn-success btn-block"><?php echo $_smarty_tpl->tpl_vars['modoru']->value;?>
</A>
	<?php }?>
</CENTER>
</div><!-- コンテナの終了 -->

<!-- 中型イメージ -->
<CENTER><BR>
<?php echo '<script'; ?>
 async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><?php echo '</script'; ?>
>
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-3488380837004066"
     data-ad-slot="2569774754"></ins>
<?php echo '<script'; ?>
>
(adsbygoogle = window.adsbygoogle || []).push({});
<?php echo '</script'; ?>
>
</CENTER>

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


<?php if (($_smarty_tpl->tpl_vars['debug_str']->value)) {?><PRE><?php echo $_smarty_tpl->tpl_vars['debug_str']->value;?>
</PRE><?php }
echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php if (($_smarty_tpl->tpl_vars['debug_str']->value)) {?><PRE><?php echo $_smarty_tpl->tpl_vars['debug_str']->value;?>
</PRE><?php }?>
</BODY>
</HTML><?php }
}
