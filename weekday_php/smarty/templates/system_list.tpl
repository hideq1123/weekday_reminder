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
	[ <A href="{$SCRIPT_NAME}">トップページへ</A> ]
	<BR>
	<BR>
	{$disp_login_state}
      	</TD>
        <TD width="78%" align="left" valign="top">
        <P>[ <a href="{$SCRIPT_NAME}?type=regist&action=form{$add_pageID}">新規登録</a> ]{*$add_pageIDは、元の検索ページに
戻るための変数という説明書きがp324にあった。後述するとの記載有り。このリンクは最初system.phpへ行き、type=registなので、
そこからmembercontrollerのscreen_registへ振り分けられて表示される*}
<BR>

<FORM {$form.attributes}>{*$form.attributesはHTML_QuickFormの機能。method="" name="" id=""などが付加される*}
名前：<INPUT type="text" name="search_key" value="{$search_key}">
<INPUT type="submit" name="submit" value="検索する">
<INPUT type="hidden" name="type" value="list">
<INPUT type="hidden" name="action" value="form">
</FORM>



検索結果は{$count}件です。<BR>
<BR>
{$links}{*ページを分割するリンクを表示*}

{if ($data) }{*データがある場合のみデータを表示します*}
<TABLE width="100%" border="1"  cellspacing="0" cellpadding="8">
<TBODY>
<TR><TH>番号</TH><TH>アドレス</TH><TH>メッセNo最大値</TH><TH>登録日</TH><TH>　</TH><TH>　</TH></TR>



{foreach item=item from=$data}{*テンプレート内での繰り返し処理も可能です*}
<TR>
<TD align="center">{$item.id}</TD>
<TD>{$item.username}</TD>

{* 気づいたメモ：reg_dateに対して、birthdayは日付の分割がされていない。そのため、うまく%Y%dとかで切り分けられないのでは？？→思った通り、ハイフンを入れたら正しく表示された *}

<TD align="center">{$item.max_messe_no}</TD>
<TD align="center">{$item.reg_date|date_format:"%Y&#24180;%m&#26376;%d&#26085;"}</TD>
<TD align="center">[<a href="{$SCRIPT_NAME}?type=modify&action=form&id={$item.id}{$add_pageID}">更新</a>]</TD>{*$item.idで会員idを指定して次の処理へ渡しています*}
<TD align="center">[<a href="{$SCRIPT_NAME}?type=delete&action=confirm&id={$item.id}{$add_pageID}">削除</a>]</TD></TR>
</tr>
{/foreach}


</TBODY></TABLE>
{/if}

        </P>
          </TD>
      </TR>
    </TABLE>
</CENTER>
{if ($debug_str)}<PRE>{$debug_str}</PRE>{/if}
</BODY>
</HTML>
