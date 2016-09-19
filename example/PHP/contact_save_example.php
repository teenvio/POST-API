<?php

if (isset($_POST['email'])){

	require_once './class/APIClientPOST.php';

	$user="user";
	$plan="acount";
	$pass="pass";

	$api=new Teenvio\APIClientPOST($user,$plan,$pass);
	$id= $api->saveContact($_POST);
	echo "Id contacto: ".$id;

}

?>
<html>
<head><title>Ficha de Contacto</title></head>
<body>
<form method="post" action="">
<div class="tab-content form-horizontal">
				
	<div id="dpersonales" class="tab-pane fade in active">
		
		<div class="control-group input-append">
			<label for="inputError" class="control-label">Nombre</label>
			<div class="controls">
				<input type="text" title="nombre" value="" name="nombre">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Apellidos</label>
			<div class="controls">
				<input type="text" title="apellidos" value="" name="apellidos">
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">E-Mail</label>
			<div class="controls">
				<input type="text" title="email" value="" name="email">
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Dirección</label>
			<div class="controls">
				<input type="text" title="direccion" value="" name="direccion">
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Código Postal</label>
			<div class="controls">
				<input type="text" title="cpostal" value="" name="cpostal">
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Localidad</label>
			<div class="controls">
				<input type="text" title="ciudad" value="" name="ciudad">
			</div>
		</div>

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Provincia</label>
			<div class="controls">
				<input type="text" title="provincia" value="" name="provincia">
				
			</div>
		</div>

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Teléfono</label>
			<div class="controls">
				<input type="text" title="telperso" value="" name="telperso">
				
			</div>
		</div>

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Teléfono Móvil</label>
			<div class="controls">
				<input type="text" title="movilperso" value="" name="movilperso">
				
			</div>
		</div>

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Fecha de Nacimiento</label>
			<div class="controls">
				<input type="text" title="cumple" value="" name="cumple" id="dp1444126176910" class="hasDatepicker">
				
			</div>
		</div>						

	</div>
	<div id="dempresa" class="tab-pane fade">
		
		<div class="control-group input-append">
			<label for="inputError" class="control-label">Nombre</label>
			<div class="controls">
				<input type="text" title="empresa" value="" name="empresa">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Dirección</label>
			<div class="controls">
				<input type="text" title="edireccion" value="" name="edireccion">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Código Postal</label>
			<div class="controls">
				<input type="text" title="ecpostal" value="" name="ecpostal">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Localidad</label>
			<div class="controls">
				<input type="text" title="eciudad" value="" name="eciudad">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">Provincia</label>
			<div class="controls">
				<input type="text" title="eprovincia" value="" name="eprovincia">
				
			</div>
		</div>						

		<div class="control-group input-append">
			<label for="inputError" class="control-label">País</label>
			<div class="controls">
				<select name="epais" data-bruto="" data-placeholder="">
					<option value=" "> </option>
					<option value="AD">AD - Andorra &nbsp; </option>
					<option value="AE">AE - Emiratos Árabes Unidos &nbsp; </option>
					<option value="AF">AF - Afganistán &nbsp; </option>
					<option value="AG">AG - Antigua y Barbuda &nbsp; </option>
					<option value="AI">AI - Anguila &nbsp; </option>
					<option value="AL">AL - Albania &nbsp; </option>
					<option value="AM">AM - Armenia &nbsp; </option>
					<option value="AN">AN - Antillas Holandesas &nbsp; </option>
					<option value="AO">AO - Angola &nbsp; </option>
					<option value="AQ">AQ - Antártida &nbsp; </option>
					<option value="AR">AR - Argentina &nbsp; </option>
					<option value="AS">AS - Samoa Americana &nbsp; </option>
					<option value="AT">AT - Austria &nbsp; </option>
					<option value="AU">AU - Australia &nbsp; </option>
					<option value="AW">AW - Aruba &nbsp; </option>
					<option value="AX">AX - Islas Åland &nbsp; </option>
					<option value="AZ">AZ - Azerbaiyán &nbsp; </option>
					<option value="BA">BA - Bosnia y Herzegovina &nbsp; </option>
					<option value="BB">BB - Barbados &nbsp; </option>
					<option value="BD">BD - Bangladesh &nbsp; </option>
					<option value="BE">BE - Bélgica &nbsp; </option>
					<option value="BF">BF - Burkina Faso &nbsp; </option>
					<option value="BG">BG - Bulgaria &nbsp; </option>
					<option value="BH">BH - Bahrein &nbsp; </option>
					<option value="BI">BI - Burundi &nbsp; </option>
					<option value="BJ">BJ - Benin &nbsp; </option>
					<option value="BL">BL - Saint-Barthélemy &nbsp; </option>
					<option value="BM">BM - Bermuda &nbsp; </option>
					<option value="BN">BN - Brunei Darussalam &nbsp; </option>
					<option value="BO">BO - Bolivia &nbsp; </option>
					<option value="BR">BR - Brasil &nbsp; </option>
					<option value="BS">BS - Bahamas &nbsp; </option>
					<option value="BT">BT - Bután &nbsp; </option>
					<option value="BV">BV - Isla Bouvet &nbsp; </option>
					<option value="BW">BW - Botswana &nbsp; </option>
					<option value="BY">BY - Belarús &nbsp; </option>
					<option value="BZ">BZ - Belice &nbsp; </option>
					<option value="CA">CA - Canadá &nbsp; </option>
					<option value="CC">CC - Islas Cocos (Keeling) &nbsp; </option>
					<option value="CD">CD - Congo (Rep. Democrática) &nbsp; </option>
					<option value="CF">CF - República Centroafricana &nbsp; </option>
					<option value="CG">CG - Congo (Brazzaville) &nbsp; </option>
					<option value="CH">CH - Suiza &nbsp; </option>
					<option value="CI">CI - Costa de Marfil &nbsp; </option>
					<option value="CK">CK - Islas Cook &nbsp; </option>
					<option value="CL">CL - Chile &nbsp; </option>
					<option value="CM">CM - Camerún &nbsp; </option>
					<option value="CN">CN - China &nbsp; </option>
					<option value="CO">CO - Colombia &nbsp; </option>
					<option value="CR">CR - Costa Rica &nbsp; </option>
					<option value="CU">CU - Cuba &nbsp; </option>
					<option value="CV">CV - Cabo Verde &nbsp; </option>
					<option value="CW">CW - Curaçao &nbsp; </option>
					<option value="CX">CX - Isla de Navidad &nbsp; </option>
					<option value="CY">CY - Chipre &nbsp; </option>
					<option value="CZ">CZ - República Checa &nbsp; </option>
					<option value="DE">DE - Alemania &nbsp; </option>
					<option value="DJ">DJ - Yibuti &nbsp; </option>
					<option value="DK">DK - Dinamarca &nbsp; </option>
					<option value="DM">DM - Dominica &nbsp; </option>
					<option value="DO">DO - República Dominicana &nbsp; </option>
					<option value="DZ">DZ - Argelia &nbsp; </option>
					<option value="EC">EC - Ecuador &nbsp; </option>
					<option value="EE">EE - Estonia &nbsp; </option>
					<option value="EG">EG - Egipto &nbsp; </option>
					<option value="EH">EH - Sáhara Occidental &nbsp; </option>
					<option value="ER">ER - Eritrea &nbsp; </option>
					<option value="ES">ES - España &nbsp; </option>
					<option value="ET">ET - Etiopía &nbsp; </option>
					<option value="FI">FI - Finlandia &nbsp; </option>
					<option value="FJ">FJ - Fiyi &nbsp; </option>
					<option value="FK">FK - Islas Malvinas (Falkland) &nbsp; </option>
					<option value="FM">FM - Micronesia &nbsp; </option>
					<option value="FO">FO - Islas Feroe &nbsp; </option>
					<option value="FR">FR - Francia &nbsp; </option>
					<option value="GA">GA - Gabón &nbsp; </option>
					<option value="GB">GB - Reino Unido &nbsp; </option>
					<option value="GD">GD - Granada &nbsp; </option>
					<option value="GE">GE - Georgia &nbsp; </option>
					<option value="GF">GF - Guayana Francesa &nbsp; </option>
					<option value="GG">GG - Guernesey &nbsp; </option>
					<option value="GH">GH - Ghana &nbsp; </option>
					<option value="GI">GI - Gibraltar &nbsp; </option>
					<option value="GL">GL - Groenlandia &nbsp; </option>
					<option value="GM">GM - Gambia &nbsp; </option>
					<option value="GN">GN - Guinea &nbsp; </option>
					<option value="GP">GP - Guadalupe &nbsp; </option>
					<option value="GQ">GQ - Guinea Ecuatorial &nbsp; </option>
					<option value="GR">GR - Grecia &nbsp; </option>
					<option value="GS">GS - Georgia del Sur e Islas Sandwich &nbsp; </option>
					<option value="GT">GT - Guatemala &nbsp; </option>
					<option value="GU">GU - Guam &nbsp; </option>
					<option value="GW">GW - Guinea-Bissau &nbsp; </option>
					<option value="GY">GY - Guayana &nbsp; </option>
					<option value="HK">HK - Hong Kong &nbsp; </option>
					<option value="HM">HM - Islas Heard y McDonald &nbsp; </option>
					<option value="HN">HN - Honduras &nbsp; </option>
					<option value="HR">HR - Croacia &nbsp; </option>
					<option value="HT">HT - Haití &nbsp; </option>
					<option value="HU">HU - Hungría &nbsp; </option>
					<option value="ID">ID - Indonesia &nbsp; </option>
					<option value="IE">IE - Irlanda &nbsp; </option>
					<option value="IL">IL - Israel &nbsp; </option>
					<option value="IM">IM - Isla de Man &nbsp; </option>
					<option value="IN">IN - India &nbsp; </option>
					<option value="IO">IO - Territorio Brtiánico del Océano ?ndico &nbsp; </option>
					<option value="IQ">IQ - Irak &nbsp; </option>
					<option value="IR">IR - Irán &nbsp; </option>
					<option value="IS">IS - Islandia &nbsp; </option>
					<option value="IT">IT - Italia &nbsp; </option>
					<option value="JE">JE - Jersey &nbsp; </option>
					<option value="JM">JM - Jamaica &nbsp; </option>
					<option value="JO">JO - Jordania &nbsp; </option>
					<option value="JP">JP - Japón &nbsp; </option>
					<option value="KE">KE - Kenia &nbsp; </option>
					<option value="KG">KG - Kirguistán &nbsp; </option>
					<option value="KH">KH - Camboya &nbsp; </option>
					<option value="KI">KI - Kiribati &nbsp; </option>
					<option value="KM">KM - Islas Comoros &nbsp; </option>
					<option value="KN">KN - Saint Kitts y Nevis &nbsp; </option>
					<option value="KP">KP - Corea del Norte &nbsp; </option>
					<option value="KR">KR - Corea del Sur &nbsp; </option>
					<option value="KW">KW - Kuwait &nbsp; </option>
					<option value="KY">KY - Islas Caimán &nbsp; </option>
					<option value="KZ">KZ - Kazajstán &nbsp; </option>
					<option value="LA">LA - Laos &nbsp; </option>
					<option value="LB">LB - Líbano &nbsp; </option>
					<option value="LC">LC - Santa Lucía &nbsp; </option>
					<option value="LI">LI - Liechtenstein &nbsp; </option>
					<option value="LK">LK - Sri Lanka &nbsp; </option>
					<option value="LR">LR - Liberia &nbsp; </option>
					<option value="LS">LS - Lesoto &nbsp; </option>
					<option value="LT">LT - Lituania &nbsp; </option>
					<option value="LU">LU - Luxemburgo &nbsp; </option>
					<option value="LV">LV - Letonia &nbsp; </option>
					<option value="LY">LY - Libia &nbsp; </option>
					<option value="MA">MA - Marruecos &nbsp; </option>
					<option value="MC">MC - Mónaco &nbsp; </option>
					<option value="MD">MD - Moldova &nbsp; </option>
					<option value="ME">ME - Montenegro &nbsp; </option>
					<option value="MF">MF - Saint Martin &nbsp; </option>
					<option value="MG">MG - Madagascar &nbsp; </option>
					<option value="MH">MH - Islas Marshall &nbsp; </option>
					<option value="MK">MK - Macedonia &nbsp; </option>
					<option value="ML">ML - Malí &nbsp; </option>
					<option value="MM">MM - Myanmar &nbsp; </option>
					<option value="MN">MN - Mongolia &nbsp; </option>
					<option value="MO">MO - Macao &nbsp; </option>
					<option value="MP">MP - Islas Marianas del Norte &nbsp; </option>
					<option value="MQ">MQ - Martinica &nbsp; </option>
					<option value="MR">MR - Mauritania &nbsp; </option>
					<option value="MS">MS - Montserrat &nbsp; </option>
					<option value="MT">MT - Malta &nbsp; </option>
					<option value="MU">MU - Mauricio &nbsp; </option>
					<option value="MV">MV - Maldivas &nbsp; </option>
					<option value="MW">MW - Malawi &nbsp; </option>
					<option value="MX">MX - México &nbsp; </option>
					<option value="MY">MY - Malasia &nbsp; </option>
					<option value="MZ">MZ - Mozambique &nbsp; </option>
					<option value="NA">NA - Namibia &nbsp; </option>
					<option value="NC">NC - Nueva Caledonia &nbsp; </option>
					<option value="NE">NE - Níger &nbsp; </option>
					<option value="NF">NF - Norfolk Island &nbsp; </option>
					<option value="NG">NG - Nigeria &nbsp; </option>
					<option value="NI">NI - Nicaragua &nbsp; </option>
					<option value="NL">NL - Países Bajos &nbsp; </option>
					<option value="NO">NO - Noruega &nbsp; </option>
					<option value="NP">NP - Nepal &nbsp; </option>
					<option value="NR">NR - Nauru &nbsp; </option>
					<option value="NU">NU - Niue &nbsp; </option>
					<option value="NZ">NZ - Nueva Zelanda &nbsp; </option>
					<option value="OM">OM - Omán &nbsp; </option>
					<option value="PA">PA - Panamá &nbsp; </option>
					<option value="PE">PE - Perú &nbsp; </option>
					<option value="PF">PF - Polinesia Francés &nbsp; </option>
					<option value="PG">PG - Papua Nueva Guinea &nbsp; </option>
					<option value="PH">PH - Filipinas &nbsp; </option>
					<option value="PK">PK - Pakistán &nbsp; </option>
					<option value="PL">PL - Polonia &nbsp; </option>
					<option value="PM">PM - San Pedro y Miquelón &nbsp; </option>
					<option value="PN">PN - Islas Pitcairn &nbsp; </option>
					<option value="PR">PR - Puerto Rico &nbsp; </option>
					<option value="PS">PS - Territorio palestino &nbsp; </option>
					<option value="PT">PT - Portugal &nbsp; </option>
					<option value="PW">PW - Palau &nbsp; </option>
					<option value="PY">PY - Paraguay &nbsp; </option>
					<option value="QA">QA - Qatar &nbsp; </option>
					<option value="RE">RE - Reunión &nbsp; </option>
					<option value="RO">RO - Rumania &nbsp; </option>
					<option value="RS">RS - Serbia &nbsp; </option>
					<option value="RU">RU - Rusia &nbsp; </option>
					<option value="RW">RW - Ruanda &nbsp; </option>
					<option value="SA">SA - Arabia Saudita &nbsp; </option>
					<option value="SB">SB - Islas Salomón &nbsp; </option>
					<option value="SC">SC - Seychelles &nbsp; </option>
					<option value="SD">SD - Sudán &nbsp; </option>
					<option value="SE">SE - Suecia &nbsp; </option>
					<option value="SG">SG - Singapur &nbsp; </option>
					<option value="SH">SH - Santa Helena, Ascensión y Tristán da Cunha &nbsp; </option>
					<option value="SI">SI - Eslovenia &nbsp; </option>
					<option value="SJ">SJ - Svalbard y Jan Mayen &nbsp; </option>
					<option value="SK">SK - Eslovaquia &nbsp; </option>
					<option value="SL">SL - Sierra Leona &nbsp; </option>
					<option value="SM">SM - San Marino &nbsp; </option>
					<option value="SN">SN - Senegal &nbsp; </option>
					<option value="SO">SO - Somalia &nbsp; </option>
					<option value="SR">SR - Suriname &nbsp; </option>
					<option value="ST">ST - Santo Tomé y Príncipe &nbsp; </option>
					<option value="SV">SV - El Salvador &nbsp; </option>
					<option value="SY">SY - Siria &nbsp; </option>
					<option value="SZ">SZ - Suazilandia &nbsp; </option>
					<option value="TC">TC - Islas Turcas y Caicos &nbsp; </option>
					<option value="TD">TD - Chad &nbsp; </option>
					<option value="TF">TF - Territorios Franceses del Sur &nbsp; </option>
					<option value="TG">TG - Togo &nbsp; </option>
					<option value="TH">TH - Tailandia &nbsp; </option>
					<option value="TJ">TJ - Tayikistán &nbsp; </option>
					<option value="TK">TK - Tokelau &nbsp; </option>
					<option value="TL">TL - Timor Oriental &nbsp; </option>
					<option value="TM">TM - Turkmenistán &nbsp; </option>
					<option value="TN">TN - Túnez &nbsp; </option>
					<option value="TO">TO - Tonga &nbsp; </option>
					<option value="TR">TR - Turquía &nbsp; </option>
					<option value="TT">TT - Trinidad y Tobago &nbsp; </option>
					<option value="TV">TV - Tuvalu &nbsp; </option>
					<option value="TW">TW - Taiwan &nbsp; </option>
					<option value="TZ">TZ - Tanzania &nbsp; </option>
					<option value="UA">UA - Ucrania &nbsp; </option>
					<option value="UG">UG - Uganda &nbsp; </option>
					<option value="UM">UM - Estados Unidos (Islas Menores Alejadas) &nbsp; </option>
					<option value="US">US - Estados Unidos &nbsp; </option>
					<option value="UY">UY - Uruguay &nbsp; </option>
					<option value="UZ">UZ - Uzbekistán &nbsp; </option>
					<option value="VA">VA - Ciudad del Vaticano &nbsp; </option>
					<option value="VC">VC - San Vicente y las Granadinas &nbsp; </option>
					<option value="VE">VE - Venezuela &nbsp; </option>
					<option value="VG">VG - Islas Vírgenes Británicas &nbsp; </option>
					<option value="VI">VI - Islas Vírgenes de EE.UU. &nbsp; </option>
					<option value="VN">VN - Viet Nam &nbsp; </option>
					<option value="VU">VU - Vanuatu &nbsp; </option>
					<option value="WF">WF - Wallis y Futuna &nbsp; </option>
					<option value="WS">WS - Samoa &nbsp; </option>
					<option value="XK">XK - Kosovo &nbsp; </option>
					<option value="YE">YE - Yemen &nbsp; </option>
					<option value="YT">YT - Mayotte &nbsp; </option>
					<option value="ZA">ZA - Sudáfrica &nbsp; </option>
					<option value="ZM">ZM - Zambia &nbsp; </option>
					<option value="ZW">ZW - Zimbabue &nbsp; </option>
				</select>


						</div>
					</div>
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Teléfono</label>
						<div class="controls">
							<input type="text" title="teltrabajo" value="" name="teltrabajo">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Movil</label>
						<div class="controls">
							<input type="text" title="moviltrabajo" value="" name="moviltrabajo">
							
						</div>
					</div>						
				
				</div>
				<div id="dauxiliares" class="tab-pane fade">
					
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 1</label>
						<div class="controls">
							<input type="text" title="dato_1" value="" name="dato_1">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 2</label>
						<div class="controls">
							<input type="text" title="dato_2" value="" name="dato_2">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 3</label>
						<div class="controls">
							<input type="text" title="dato_3" value="" name="dato_3">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 4</label>
						<div class="controls">
							<input type="text" title="dato_4" value="" name="dato_4">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 5</label>
						<div class="controls">
							<input type="text" title="dato_5" value="" name="dato_5">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 6</label>
						<div class="controls">
							<input type="text" title="dato_6" value="" name="dato_6">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 7</label>
						<div class="controls">
							<input type="text" title="dato_7" value="" name="dato_7">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 8</label>
						<div class="controls">
							<input type="text" title="dato_8" value="" name="dato_8">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 9</label>
						<div class="controls">
							<input type="text" title="dato_9" value="" name="dato_9">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 10</label>
						<div class="controls">
							<input type="text" title="dato_10" value="" name="dato_10">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 11</label>
						<div class="controls">
							<input type="text" title="dato_11" value="" name="dato_11">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 12</label>
						<div class="controls">
							<input type="text" title="dato_12" value="" name="dato_12">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 13</label>
						<div class="controls">
							<input type="text" title="dato_13" value="" name="dato_13">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 14</label>
						<div class="controls">
							<input type="text" title="dato_14" value="" name="dato_14">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 15</label>
						<div class="controls">
							<input type="text" title="dato_15" value="" name="dato_15">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 16</label>
						<div class="controls">
							<input type="text" title="dato_16" value="" name="dato_16">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 17</label>
						<div class="controls">
							<input type="text" title="dato_17" value="" name="dato_17">
							
						</div>
					</div>						
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 18</label>
						<div class="controls">
							<input type="text" title="dato_18" value="" name="dato_18">
						</div>
					</div>
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 19</label>
						<div class="controls">
							<input type="text" title="dato_19" value="" name="dato_19">
						</div>
					</div>
				
					<div class="control-group input-append">
						<label for="inputError" class="control-label">Campo Auxiliar 20</label>
						<div class="controls">
							<input type="text" title="dato_20" value="" name="dato_20">
						</div>
					</div>
				</div>
				
			</div>
			
			<input type="submit" value="Enviar"/>
		</form>
	</body>
</html>

