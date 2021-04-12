<div style="top: 10px;" id="content">

<body>
<br><br>
<center>

<form action="" method="post" id="galaxy_form">
<input id="auto" value="dr" type="hidden">
<table border="0"> 
  <tr>
    <td>
      <table>
        <tbody><tr>
         <td class="c" colspan="3">{{Galaxy}}</td>
        </tr>
        <tr>
          <td class="l"><input name="galaxyLeft" value="&lt;-" type="button"></td>
          <td class="l"><input name="galaxy" value="{{ViewGalaxy}}" size="5" maxlength="3" tabindex="1" type="text">
          </td><td class="l"><input name="galaxyRight" value="-&gt;" type="button"></td>
        </tr>
       </tbody></table>
      </td>
      <td>
       <table>
        <tbody><tr>
         <td class="c" colspan="3">{{Solar_system}}</td>
        </tr>
         <tr>
         <td class="l"><input name="systemLeft" value="&lt;-" onClick="galaxy_submit('systemLeft')" type="button"></td>
          <td class="l"><input name="system" value="{{ViewSystem}}" size="5" maxlength="3" tabindex="2" type="text">
          </td><td class="l"><input name="systemRight" value="-&gt;" onClick="galaxy_submit('systemRight')" type="button"></td>
         </tr>
        </tbody></table>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> <input value="{{Show}}" type="submit"></td>
      </tr>
     </tbody></table>
</form>
   <table width="569">
<tbody><tr>
	<td class="c" colspan="8">{{Solar_system_at}} {{ViewGalaxy}}:{{ViewSystem}}</td>
	</tr>
	<tr>
	  <td class="c">{{Pos}}</td>
	  <td class="c">{{Planet}}</td>
	  <td class="c">{{Name}}</td>
	  <td class="c">{{Moon}}</td>
	  <td class="c">{{Debris}}</td>
	  <td class="c">{{Player}}</td>
	  <td class="c">{{Alliance}}</td>
	  <td class="c">{{Actions}}</td>
	</tr>
    {{#ViewData}}
    <!-- coucou -->
        {{#existant}}
        <tr>
            <th width="30">{{planet}}</th>
            <th width="30"><img src="skins/epicblue/planeten/small/s_{{image}}.jpg" height="30" width="30" /></th>
            <th style="white-space: nowrap;" width="130">{{name}}</th>
            {{#hasMoon}}
            <th style="white-space: nowrap;" width=30>
              <a style="cursor: pointer;" 
                 onmouseover='return overlib("<table width=240><tr><td class=c colspan=2>*Lune:* {{moon_name}} [{{ViewGalaxy}}:{{ViewSystem}}:{{planet}}]</td></tr><tr><th width=80><img src=skins/epicblue/planeten/mond.jpg height=75 width=75 /></th><th><table><tr><td class=c colspan=2>*Caractéristiques*</td></tr><tr><th>*Diamètre*</th><th>{{moon_diameter}}</th></tr><tr><th>*Températures*</th><th>{{moon_temp_min}}/{{moon_temp_max}}</th></tr><tr><td class=c colspan=2>*Actions*</td></tr><tr><th colspan=2 align=center><a href=fleet.php?galaxy=1&system=1&planet=1&planettype=3&target_mission=3>*Transporter*</a><br /><a href=fleet.php?galaxy=1&system=1&planet=1&planettype=3&target_mission=4>*Stationner*</a><br /></tr></table></th></tr></table>",
                 STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' 
                 onmouseout='return nd();'>
                  <img src=skins/epicblue/planeten/small/s_mond.jpg height=22 width=22>
                </a>
            </th>

            {{/hasMoon}}
            {{^hasMoon}}
              <th></th>
            {{/hasMoon}}
            {{#hasDebrisField}}
            <th style="background-image: none;" width=30>
              <a style="cursor: pointer;" 
                 onmouseover='return overlib("<table width=240><tr><td class=c colspan=2>*Débris* [{{ViewGalaxy}}:{{ViewSystem}}:{{planet}}]</td></tr><tr><th width=80><img src=skins/epicblue/planeten/debris.jpg height=75 width=75 /></th><th><table><tr><td class=c colspan=2>*Ressources*</td></tr><tr><th>*Métal* </th><th>{{metal_debris}}</th></tr><tr><th>*Cristal* </th><th>{{cristal_debris}}</th></tr><tr><td class=c colspan=2>*Action*</td></tr><tr><th colspan=2 align=left><a href= # onclick=&#039javascript:doit (8, 1, 1, 1, 2, 1);&#039 >*Recycler*</a></tr></table></th></tr></table>",
                 STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );' 
                 onmouseout='return nd();'>
                  <img src=skins/epicblue/planeten/debris.jpg height=22 width=22>
              </a>
            </th>
            {{/hasDebrisField}}
            {{^hasDebrisField}}
              <th></th>
            {{/hasDebrisField}}
            <th width="150">{{username}}</th>
            <th width="80">{{ally_tag}}</th>
            <th style="white-space: nowrap;" width="125">*</th>
	    </tr>
        {{/existant}}
        {{^existant}}
        <tr>
            <th width="30">{{planet}}</th>
            <th colspan="7"><span style="color: rgb(95, 127, 108);">Emplacement disponible</span></th>
	    </tr>
        {{/existant}}
	{{/ViewData}}
  <tr>
    <th width="30">{{ExpeditionPosition}}</th>
    <th colspan="7">Espaces infinis</th>
</tr>
	

	<tr>
	  <td class="c" colspan="6">
    {{lbl_ColonizedPlanets}}
    </td>
	  <td class="c" colspan="2">
      <a href="#" 
        onmouseover="this.T_WIDTH=150;return escape('<table><tr><td class=\'c\' colspan=\'2\'>{{Legend}}</td></tr><tr><td width=\'125\'>{{Strong_player}}</td><td><span class=\'strong\'>f</span></td></tr><tr><td>{{Weak_player}}</td><td><span class=\'noob\'>d</span></td></tr><tr><td>{{Way_vacation}}</td><td><span class=\'vacation\'>v</span></td></tr><tr><td>{{Pendent_user}}</td><td><span class=\'banned\'>s</span></td></tr><tr><td>{{Inactive_7_days}}</td><td><span class=\'inactive\'>i</span></td></tr><tr><td>{{Inactive_28_days}}</td><td><span class=\'longinactive\'>I</span></td></tr><tr><td>Admin</td><td><span class=\'espionagereport\'>A</span></td></tr></table>')">
        {{Legend}}
      </a>
    </td>
	</tr>
	<tr>
	</tr>
	<tr style="display: none; align:left" id="fleetstatusrow">
	  <th colspan="8"><div style="align:left" id="fleetstatus"></div>
		<table style="font-weight: bold; align:left" id="fleetstatustable" width="100%">
		</table>
	  </th>
	</tr>
</table>

</center>
