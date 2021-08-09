
<tr>
	<td class="l">
		<a href="infos.php?gid={{i}}">
		<img border="0" src="skins/epicblue/gebaeude/{{i}}.gif" align="top" width="120" height="120">
		</a>
	</td>
	<td class="l">
		<a href="infos.php?gid={{i}}">{{n}}</a>{{nivel}}<br>
		{{{descriptions}}}<br>
		{{{price}}}
		{{{time}}}
		{{{rest_price}}}
	</td>
	<td class="k">
	{{#BuildStartOK}}
		<a href="?cmd=insert&building={{i}}"><font color=#00FF00>{{BuildClickLabel}}</font></a>
	{{/BuildStartOK}}
	{{^BuildStartOK}}
		<font color=#FF0000>{{BuildClickLabel}}</font>
	{{/BuildStartOK}}
	</td>
</tr>