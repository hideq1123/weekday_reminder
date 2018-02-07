<HTML>
<HEAD>
<TITLE>{$title}</TITLE>
</HEAD>
<BODY>
<CENTER>
<HR size="1" noshade>
<B>{$title}</B>
<HR size="1" noshade>
    <TABLE width="100%" border="0" cellspacing="5" cellpadding="5">
      <TR>
        
      <TD width="22%" align="left" valign="top">
      	[ <A href="{$SCRIPT_NAME}?type=logout">ログアウト</A> ]
	<BR>
	<BR>
	{$disp_login_state}
      </TD>
      
      <TD width="78%" align="left" valign="top">
[ <A href="{$SCRIPT_NAME}?type=list&action=form">会員一覧</A> ]   会員の検索・更新・削除を行います。<BR><BR>

<FORM {$form.attributes}>{*$form.attributesはHTML_QuickFormの機能。method="" name="" id=""などが付加される*}
<INPUT type="submit" name="submit" value="3年ログイン無しのユーザーの数を表示">
<INPUT type="hidden" name="type" value="count">
</FORM>
<BR>
<FORM {$form.attributes}>
<INPUT type="submit" name="submit" value="3年ログイン無しのユーザーを削除">
<INPUT type="hidden" name="type" value="remove">
</FORM>
<BR><BR>

<FORM {$form.attributes}>
<INPUT type="submit" name="submit" value="3日以上クリック無しのprememberテーブルユーザーの数を表示">
<INPUT type="hidden" name="type" value="precount">
</FORM>
<BR>

<FORM {$form.attributes}>
<INPUT type="submit" name="submit" value="3日以上クリック無しのprememberテーブルユーザーを削除">
<INPUT type="hidden" name="type" value="preremove">
</FORM>
<BR>
         </TD>
      </TR>
    </TABLE>
</CENTER>
{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}
</BODY>
</HTML>
