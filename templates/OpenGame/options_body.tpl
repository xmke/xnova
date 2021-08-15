<center>
<br><br>
<form action="{{PHP_SELF}}?mode=change" method="post">
<table width="519">
<tbody>
{{opt_adm_frame}}
<tr>
	<td class="c" colspan="2">{{userdata}}</td>
</tr><tr>
	<th>{{username}}</th>
	<th><input name="db_character" size="20" value="{{opt_usern_data}}" type="text"></th>
</tr><tr>
	<th>{{lastpassword}}</th>
	<th><input name="db_password" size="20" value="" type="password" autocomplete="off"></th>
</tr><tr>
	<th>{{newpassword}}</th>
	<th><input name="newpass1"    size="20" maxlength="40" type="password"></th>
</tr><tr>
	<th>{{newpasswordagain}}</th>
	<th><input name="newpass2"    size="20" maxlength="40" type="password"></th>
</tr><tr>
	<th><a title="{{emaildir_tip}}">{{emaildir}}</a></th>
	<th><input name="db_email" maxlength="100" size="20" value="{{opt_mail1_data}}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{{general_settings}}</td>
</tr><tr>
	<th>{{opt_lst_ord}}</th>
	<th>
		<select name="settings_sort">
			<option value="sort_id" {{planetsort_id}}>Tri par ancienneté</option>
			<option value="sort_name" {{planetsort_name}}>Tri par Nom</option>
			<option value="sort_coord" {{planetsort_coords}}>Tri par Coordonnées</option>
		</select>
	</th>
</tr><tr>
	<th>{{opt_lst_cla}}</th>
	<th>
		<select name="settings_order">
			<option value="DESC" {{planetsortorder_desc}}>Descendant</option>
			<option value="ASC" {{planetsortorder_asc}}>Ascendant</option>
		</select>
	</th>
</tr><tr>
	<td class="c" colspan="2">{{galaxyvision_options}}</td>
</tr><tr>
	<th><a title="{{spy_cant_tip}}">{{spy_cant}}</a></th>
	<th><input name="spio_anz" maxlength="2" size="2" value="{{opt_probe_data}}" type="text"></th>
</tr><tr>
	<th>{{tooltip_time}}</th>
	<th><input name="settings_tooltiptime" maxlength="2" size="2" value="{{opt_toolt_data}}" type="text"> {{seconds}}</th>
</tr><tr>
	<th>{{mess_ammount_max}}</th>
	<th><input name="settings_fleetactions" maxlength="2" size="2" value="{{opt_fleet_data}}" type="text"></th>
</tr><tr>
	<th>{{show_ally_logo}}</th>
	<th><input name="settings_allylogo"{{opt_allyl_data}} type="checkbox" /></th>
</tr><tr>
	<th>{{shortcut}}</th>
	<th>{{show}}</th>
</tr><tr>
	<th><img src="skins/epicblue/img/e.gif" alt="">   {{spy}}</th>
	<th><input name="settings_esp"{{user_settings_esp}} type="checkbox" /></th>
</tr><tr>
	<th><img src="skins/epicblue/img/m.gif" alt="">   {{write_a_messege}}</th>
	<th><input name="settings_wri"{{user_settings_wri}} type="checkbox" /></th>
</tr><tr>
	<th><img src="skins/epicblue/img/b.gif" alt="">   {{add_to_buddylist}}</th>
	<th><input name="settings_bud"{{user_settings_bud}} type="checkbox" /></th>
</tr><tr>
	<th><img src="skins/epicblue/img/r.gif" alt="">   {{attack_with_missile}}</th>
	<th><input name="settings_mis"{{user_settings_mis}} type="checkbox" /></th>
</tr><tr>
	<td class="c" colspan="2">{{delete_vacations}}</td>
</tr><tr>
	<th><a title="{{vacations_tip}}">{{mode_vacations}}</a></th>
	<th><input name="urlaubs_modus"{{opt_modev_data}} type="checkbox" /></th>
</tr><tr>
	<th><a title="{{deleteaccount_tip}}">{{deleteaccount}}</a></th>
	<th><input name="db_deaktjava"{{opt_delac_data}} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><input value="{{save_settings}}" type="submit"></th>
</tr>
</tbody>
</table>
</form>
</center>