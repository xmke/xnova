<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  
  new_win.focus();
}
</script>



<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<center>
<div id='menu'>
<br>
<table width="130" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" style="border-top: 1px #545454 solid"><div><center>{{servername}}<br>(<a href="changelog.php" target={{mf}}><font color=red>{{XNovaRelease}}</font></a>)<center></div></td>
</tr><tr>
	<td colspan="2" background="skins/epicblue/img/bg1.gif"><center>{{devlp}}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="overview.php" accesskey="g" target="{{mf}}">{{Overview}}</a></div></td>
</tr><tr>

	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php" accesskey="b" target="{{mf}}">{{Buildings}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=research" accesskey="r" target="{{mf}}">{{Research}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=fleet" accesskey="f" target="{{mf}}">{{Shipyard}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=defense" accesskey="d" target="{{mf}}">{{Defense}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="officier.php" accesskey="o" target="{{mf}}">{{Officiers}}</a></div></td>
</tr>
{{#enable_marchand}}
	<tr><td colspan="2"><div><a href="marchand.php" target="Hauptframe">Marchand</a></div></td></tr>
{{/enable_marchand}}

<tr>
	<td colspan="2" background="skins/epicblue/img/bg1.gif"><center>{{navig}}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="alliance.php" accesskey="a" target="{{mf}}">{{Alliance}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="fleet.php" accesskey="t" target="{{mf}}">{{Fleet}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="messages.php" accesskey="c" target="{{mf}}">{{Messages}}</a></div></td>
</tr><tr>

	<td colspan="2" background="skins/epicblue/img/bg1.gif"><center>{{observ}}</center></td>
</tr><tr>
	<td colspan="2"><div><a href="galaxy.php?mode=0" accesskey="s" target="{{mf}}">{{Galaxy}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="galaxy2.php" accesskey="s" target="{{mf}}">NEWGALAXY</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="imperium.php" accesskey="i" target="{{mf}}">{{Imperium}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="resources.php" accesskey="r" target="{{mf}}">{{Resources}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="techtree.php" accesskey="g" target="{{mf}}">{{Technology}}</a></div></td>
</tr><tr>

	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="records.php" accesskey="3" target="{{mf}}">{{Records}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="stat.php" accesskey="k" target="{{mf}}">{{Statistics}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="search.php" accesskey="b" target="{{mf}}">{{Search}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="banned.php" accesskey="3" target="{{mf}}">{{blocked}}</a></div></td>
</tr><tr>


	<td colspan="2" background="skins/epicblue/img/bg1.gif"><center>{{commun}}</center></td>
	</tr><tr>
	<td colspan="2"><div><a href="#" onClick="f('buddy.php', '');" accesskey="c">{{Buddylist}}</a></div></td>
</tr></tr>



{{#enable_announces}}
	<tr>
			<td colspan="2"><div><a href="annonce.php" target="Hauptframe">Annonces</a></div></td>
		</tr>
{{/enable_announces}}

{{#enable_notes}}
	<tr>
			<td colspan="2"><div><a href="#" onClick="f('notes.php', 'Report');" accesskey="n">Notes</a></div></td>
		</tr>
{{/enable_notes}}


<tr><tr>
	<td colspan="2"><div><a href="{{forum_url}}" accesskey="1" target="{{mf}}">{{Board}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="add_declare.php" accesskey="1" target="{{mf}}">{{multi}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="rules.php"  accesskey="c" target="{{mf}}">{{Rules}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="contact.php" accesskey="3" target="{{mf}}" >{{Contact}}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="options.php" accesskey="o" target="{{mf}}">{{Options}}</a></div></td>
</tr>
{{#userIsAdmin}}
	<tr>
			<td colspan="2"><div><a href="admin/leftmenu.php"><font color="lime">*Admin*</font></a></div></td>
	</tr>
{{/userIsAdmin}}
	
<tr>
</tr>

{{#link_enable}}
	<tr>
			<td colspan="2"><div><a href="{{{link_url}}}" target="_blank">{{link_name}}</a></div></td>
		</tr>
{{/link_enable}}

	{{added_link}}
<tr>
	<td colspan="2"><div><a href="javascript:top.location.href='logout.php'" accesskey="s" style="color:red">{{Logout}}</a></div></td>
</tr><tr>
	<td colspan="2" background="skins/epicblue/img/bg1.gif"><center>{{infog}}</center></td>
</tr>
	<tr>
    <td style="padding-left: 3px">{{lm_ifo_game}}</td>
    <td align="right" style="padding-right: 3px">x {{lm_tx_game}}</td>
</tr>
<tr>
  <td style="padding-left: 3px">{{lm_ifo_fleet}}</td>
  <td align="right" style="padding-right: 3px">x {{lm_tx_fleet}}</td>
</tr>
<tr>
  <td style="padding-left: 3px">{{lm_ifo_serv}}</td>
  <td align="right" style="padding-right: 3px">x {{lm_tx_serv}}</td>
</tr>
<tr>
  <td style="padding-left: 3px">{{lm_ifo_queue}}</td>
  <td align="right" style="padding-right: 3px">{{lm_tx_queue}}</td>
</tr>
</table>
</div>
</center>
</body>
</div>