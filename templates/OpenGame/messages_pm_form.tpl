<script src="scripts/cntchar.js" type="text/javascript"></script>
<!-- err -->
{{#error_occured}}
	<center><br><font color=#FF0000>{{error_label}}<br></font></center>
{{/error_occured}}
<!-- ok -->
{{#message_sent}}
	<center><br><font color=#00FF00>{{message_sent_label}}<br></font></center>
{{/message_sent}}
<br />
<center>
<form action="messages.php?mode=write&id={{id}}" method="post">
<table width="519">
<tr>
	<td class="c" colspan="2">{{Send_message}}</td>
</tr><tr>
	<th>{{Recipient}}</th>
	<th><input type="text" name="to" size="40" value="{{to}}" /></th>
</tr><tr>
	<th>{{Subject}}</th>
	<th><input type="text" name="subject" size="40" maxlength="40" value="{{subject}}" /></th>
</tr><tr>
	<th>{{Message}}(<span id="cntChars">0</span> / 5000 {{characters}})</th>
	<th><textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)"></textarea></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{{Envoyer}}" /></th>
</tr>
</table>
</form>
</center>