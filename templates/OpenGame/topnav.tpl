<div id="header_top">
<center>
<table class="header">
<tbody>
<tr class="header">
	<td class="header">
		<center>
		<table class="header">
		<tbody>
		<tr class="header">
			<td class="header"><img src="skins/epicblue/planeten/small/s_{{image}}.jpg" height="50" width="50"></td>
			<td  class="header" valign="middle">
				<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
				{{#planetlist}}
					<option {{#currentSelectedPlanet}}selected="selected"{{/currentSelectedPlanet}} value="?cp={{id}}&re=0">{{name}} [{{galaxy}}:{{system}}:{{planet}}]</option>
				{{/planetlist}}

				</select>
			</td>
		</tr>
		</tbody>
		</table>
		</center>
	</td>
	<td class="header">
		<table style="width: 508px;" class="header" id="resources" padding-right="30" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		<tr class="header">
			<td class="header" align="center" width="140"><img src="skins/epicblue/images/metall.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="140"><img src="skins/epicblue/images/kristall.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="140"><img src="skins/epicblue/images/deuterium.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="140"><img src="skins/epicblue/images/energie.gif" border="0" height="22" width="42"></td>
			<td class="header" align="center" width="140"><img src="skins/epicblue/images/message.gif" border="0" height="22" width="42"></td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="140"><i><b><font color="#ffffff">{{Metal}}</font></b></i></td>
			<td class="header" align="center" width="140"><i><b><font color="#ffffff">{{Crystal}}</font></b></i></td>
			<td class="header" align="center" width="140"><i><b><font color="#ffffff">{{Deuterium}}</font></b></i></td>
			<td class="header" align="center" width="140"><i><b><font color="#ffffff">{{Energy}}</font></b></i></td>
			<td class="header" align="center" width="140"><i><b><font color="#ffffff">{{Message}}</font></b></i></td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="140">{{{metal}}}</td>
			<td class="header" align="center" width="140">{{{crystal}}}</td>
			<td class="header" align="center" width="140">{{{deuterium}}}</td>
			<td class="header" align="center" width="140">{{{energy}}}</td>
			<td class="header" align="center" width="140">{{{message}}}</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</center>
</div>