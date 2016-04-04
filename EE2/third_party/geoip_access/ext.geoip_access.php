<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GeoIP Access
 *
 * @author		Denik
 * @copyright	Copyright (c) 2014
 * @link		http://denik.od.ua/
 * @since		Version 1.3
 * 
 */

class Geoip_access_ext {

	var $current		= array();
	var $settings		= array();
	var $name			= 'GeoIP Access';
	var $version		= '1.3';
	var $description	= 'Detect GEO position by IP address and write in global variables. Can use White/Black list countries for limit access.';
	var $settings_exist	= 'y';
	var $docs_url		= 'http://denik.od.ua/';
	var $countries		= array(
		"AP" => "Asia/Pacific Region",
		"EU" => "Europe",
		"AD" => "Andorra",
		"AE" => "United Arab Emirates",
		"AF" => "Afghanistan",
		"AG" => "Antigua and Barbuda",
		"AI" => "Anguilla",
		"AL" => "Albania",
		"AM" => "Armenia",
		"CW" => "Curacao",
		"AO" => "Angola",
		"AQ" => "Antarctica",
		"AR" => "Argentina",
		"AS" => "American Samoa",
		"AT" => "Austria",
		"AU" => "Australia",
		"AW" => "Aruba",
		"AZ" => "Azerbaijan",
		"BA" => "Bosnia and Herzegovina",
		"BB" => "Barbados",
		"BD" => "Bangladesh",
		"BE" => "Belgium",
		"BF" => "Burkina Faso",
		"BG" => "Bulgaria",
		"BH" => "Bahrain",
		"BI" => "Burundi",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BN" => "Brunei Darussalam",
		"BO" => "Bolivia",
		"BR" => "Brazil",
		"BS" => "Bahamas",
		"BT" => "Bhutan",
		"BV" => "Bouvet Island",
		"BW" => "Botswana",
		"BY" => "Belarus",
		"BZ" => "Belize",
		"CA" => "Canada",
		"CC" => "Cocos (Keeling) Islands",
		"CD" => "Congo, The Democratic Republic of the",
		"CF" => "Central African Republic",
		"CG" => "Congo",
		"CH" => "Switzerland",
		"CI" => "Cote D'Ivoire",
		"CK" => "Cook Islands",
		"CL" => "Chile",
		"CM" => "Cameroon",
		"CN" => "China",
		"CO" => "Colombia",
		"CR" => "Costa Rica",
		"CU" => "Cuba",
		"CV" => "Cape Verde",
		"CX" => "Christmas Island",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"DE" => "Germany",
		"DJ" => "Djibouti",
		"DK" => "Denmark",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"DZ" => "Algeria",
		"EC" => "Ecuador",
		"EE" => "Estonia",
		"EG" => "Egypt",
		"EH" => "Western Sahara",
		"ER" => "Eritrea",
		"ES" => "Spain",
		"ET" => "Ethiopia",
		"FI" => "Finland",
		"FJ" => "Fiji",
		"FK" => "Falkland Islands (Malvinas)",
		"FM" => "Micronesia, Federated States of",
		"FO" => "Faroe Islands",
		"FR" => "France",
		"SX" => "Sint Maarten (Dutch part)",
		"GA" => "Gabon",
		"GB" => "United Kingdom",
		"GD" => "Grenada",
		"GE" => "Georgia",
		"GF" => "French Guiana",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GL" => "Greenland",
		"GM" => "Gambia",
		"GN" => "Guinea",
		"GP" => "Guadeloupe",
		"GQ" => "Equatorial Guinea",
		"GR" => "Greece",
		"GS" => "South Georgia and the South Sandwich Islands",
		"GT" => "Guatemala",
		"GU" => "Guam",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HK" => "Hong Kong",
		"HM" => "Heard Island and McDonald Islands",
		"HN" => "Honduras",
		"HR" => "Croatia",
		"HT" => "Haiti",
		"HU" => "Hungary",
		"ID" => "Indonesia",
		"IE" => "Ireland",
		"IL" => "Israel",
		"IN" => "India",
		"IO" => "British Indian Ocean Territory",
		"IQ" => "Iraq",
		"IR" => "Iran, Islamic Republic of",
		"IS" => "Iceland",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JO" => "Jordan",
		"JP" => "Japan",
		"KE" => "Kenya",
		"KG" => "Kyrgyzstan",
		"KH" => "Cambodia",
		"KI" => "Kiribati",
		"KM" => "Comoros",
		"KN" => "Saint Kitts and Nevis",
		"KP" => "Korea, Democratic People's Republic of",
		"KR" => "Korea, Republic of",
		"KW" => "Kuwait",
		"KY" => "Cayman Islands",
		"KZ" => "Kazakhstan",
		"LA" => "Lao People's Democratic Republic",
		"LB" => "Lebanon",
		"LC" => "Saint Lucia",
		"LI" => "Liechtenstein",
		"LK" => "Sri Lanka",
		"LR" => "Liberia",
		"LS" => "Lesotho",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"LV" => "Latvia",
		"LY" => "Libya",
		"MA" => "Morocco",
		"MC" => "Monaco",
		"MD" => "Moldova, Republic of",
		"MG" => "Madagascar",
		"MH" => "Marshall Islands",
		"MK" => "Macedonia",
		"ML" => "Mali",
		"MM" => "Myanmar",
		"MN" => "Mongolia",
		"MO" => "Macau",
		"MP" => "Northern Mariana Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MS" => "Montserrat",
		"MT" => "Malta",
		"MU" => "Mauritius",
		"MV" => "Maldives",
		"MW" => "Malawi",
		"MX" => "Mexico",
		"MY" => "Malaysia",
		"MZ" => "Mozambique",
		"NA" => "Namibia",
		"NC" => "New Caledonia",
		"NE" => "Niger",
		"NF" => "Norfolk Island",
		"NG" => "Nigeria",
		"NI" => "Nicaragua",
		"NL" => "Netherlands",
		"NO" => "Norway",
		"NP" => "Nepal",
		"NR" => "Nauru",
		"NU" => "Niue",
		"NZ" => "New Zealand",
		"OM" => "Oman",
		"PA" => "Panama",
		"PE" => "Peru",
		"PF" => "French Polynesia",
		"PG" => "Papua New Guinea",
		"PH" => "Philippines",
		"PK" => "Pakistan",
		"PL" => "Poland",
		"PM" => "Saint Pierre and Miquelon",
		"PN" => "Pitcairn Islands",
		"PR" => "Puerto Rico",
		"PS" => "Palestinian Territory",
		"PT" => "Portugal",
		"PW" => "Palau",
		"PY" => "Paraguay",
		"QA" => "Qatar",
		"RE" => "Reunion",
		"RO" => "Romania",
		"RU" => "Russian Federation",
		"RW" => "Rwanda",
		"SA" => "Saudi Arabia",
		"SB" => "Solomon Islands",
		"SC" => "Seychelles",
		"SD" => "Sudan",
		"SE" => "Sweden",
		"SG" => "Singapore",
		"SH" => "Saint Helena",
		"SI" => "Slovenia",
		"SJ" => "Svalbard and Jan Mayen",
		"SK" => "Slovakia",
		"SL" => "Sierra Leone",
		"SM" => "San Marino",
		"SN" => "Senegal",
		"SO" => "Somalia",
		"SR" => "Suriname",
		"ST" => "Sao Tome and Principe",
		"SV" => "El Salvador",
		"SY" => "Syrian Arab Republic",
		"SZ" => "Swaziland",
		"TC" => "Turks and Caicos Islands",
		"TD" => "Chad",
		"TF" => "French Southern Territories",
		"TG" => "Togo",
		"TH" => "Thailand",
		"TJ" => "Tajikistan",
		"TK" => "Tokelau",
		"TM" => "Turkmenistan",
		"TN" => "Tunisia",
		"TO" => "Tonga",
		"TL" => "Timor-Leste",
		"TR" => "Turkey",
		"TT" => "Trinidad and Tobago",
		"TV" => "Tuvalu",
		"TW" => "Taiwan",
		"TZ" => "Tanzania, United Republic of",
		"UA" => "Ukraine",
		"UG" => "Uganda",
		"UM" => "United States Minor Outlying Islands",
		"US" => "United States",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VA" => "Holy See (Vatican City State)",
		"VC" => "Saint Vincent and the Grenadines",
		"VE" => "Venezuela",
		"VG" => "Virgin Islands, British",
		"VI" => "Virgin Islands, U.S.",
		"VN" => "Vietnam",
		"VU" => "Vanuatu",
		"WF" => "Wallis and Futuna",
		"WS" => "Samoa",
		"YE" => "Yemen",
		"YT" => "Mayotte",
		"RS" => "Serbia",
		"ZA" => "South Africa",
		"ZM" => "Zambia",
		"ME" => "Montenegro",
		"ZW" => "Zimbabwe",
		"A1" => "Anonymous Proxy",
		"A2" => "Satellite Provider",
		"O1" => "Other",
		"AX" => "Aland Islands",
		"GG" => "Guernsey",
		"IM" => "Isle of Man",
		"JE" => "Jersey",
		"BL" => "Saint Barthelemy",
		"MF" => "Saint Martin",
		"BQ" => "Bonaire, Saint Eustatius and Saba",
		"SS" => "South Sudan",
		"O1" => "Other"
	);

	/**
	 * Constructor
	 */
	function __construct($settings = '')
	{
		$this->EE =& get_instance();

		//$this->settings = $this->_get_settings(true);
		$this->settings = $settings;
		$this->current = isset($this->settings[ee()->config->item('site_id')])?$this->settings[ee()->config->item('site_id')]:array();
	}
	
	// --------------------------------------------------------------------
	
	function sessions_start($SESS)
	{
		global $GEOIP_REGION_NAME;
		
//if( ee()->input->ip_address == '85.238.119.62' ) ee()->input->ip_address = '104.156.247.163'; // test US country

		if( REQ == 'CP' )
		{
			if( ! isset($this->settings['global']['cp_ips'])
				|| ! is_array($this->settings['global']['cp_ips'])
				|| ! in_array(ee()->input->ip_address(), $this->settings['global']['cp_ips']) )
			{
				$this->settings['global'] = array('cp_ips'=>array());

				$q = ee()->db->query("SELECT DISTINCT s.`ip_address` FROM `exp_sessions` AS s WHERE s.`admin_sess`='1'");
				foreach( $q->result_array() as $row )
				{
					$this->settings['global']['cp_ips'][] = $row['ip_address'];
				}
				
				// update the settings
				$query = ee()->db->query("UPDATE `exp_extensions` SET `settings` = '" . addslashes(serialize($this->settings)) . "' WHERE `class` = '" . __CLASS__ . "'");
			}
			return TRUE;
		}

		// Default vars
		$record_vars = array(
			'geo_code'           => '',
			'geo_country_code'   => '',
			'geo_country_name'   => '',
			'geo_region'         => '',
			'geo_region_name'    => '',
			'geo_city'           => '',
			'geo_zip'            => '',
			'geo_latitude'       => '',
			'geo_longitude'      => '',
			'geo_metro_code'     => '',
			'geo_dma_code'       => '',
			'geo_area_code'      => '',
			'geo_continent_code' => ''
		);

		// Detect record
		$record = FALSE;
		if( function_exists('geoip_database_info') )
		{
			$record = geoip_record_by_name( ee()->input->ip_address() );
		}
		else
		{
			// Load library
			if( ! class_exists('GeoIP') ) include(PATH_THIRD."geoip_access/geoip/geoipcity.inc");

			$gi = FALSE;

			// Use full database ?
			if( file_exists(PATH_THIRD."geoip_access/geoip/GeoIPCity.dat") )
			{
				$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoIPCity.dat", GEOIP_STANDARD);
				$record = geoip_record_by_addr($gi, ee()->input->ip_address() );
			}
			
			if( !$record && file_exists(PATH_THIRD."geoip_access/geoip/GeoLiteCity.dat") )
			{
				if( $gi !== FALSE ) geoip_close($gi); // close previous file handel
				$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
				$record = geoip_record_by_addr($gi, ee()->input->ip_address() );
			}

			if( !$record && file_exists(PATH_THIRD."geoip_access/geoip/GeoIP.dat") )
			{
				if( $gi !== FALSE ) geoip_close($gi); // close previous file handel
				$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoIP.dat", GEOIP_STANDARD);
				$record = array('country_code' => geoip_country_code_by_addr($gi, ee()->input->ip_address() ));
			}
			
			if( $gi !== FALSE ) geoip_close($gi);
			unset($gi);
		}

		// Set record data
		foreach( $record as $key => $value ) $record_vars['geo_'.$key] = $value;

		// Update values
		if( $record_vars['geo_code'] == '' ) $record_vars['geo_code'] = $record_vars['geo_country_code'];
		if( $record_vars['geo_region_name'] == '' && $record_vars['geo_region']!='' && $record_vars['geo_code']!='' )
		{
			include(PATH_THIRD."geoip_access/geoip/geoipregionvars.php");
			$record_vars['geo_region_name'] = isset($GEOIP_REGION_NAME[$record_vars['geo_code']][$record_vars['geo_region']]) ? 
					$GEOIP_REGION_NAME[$record_vars['geo_code']][$record_vars['geo_region']] :
					'';
		}
		if( $record_vars['geo_country_name'] == '' && $record_vars['geo_code']!='' && class_exists('GeoIP') )
		{
			$geoip = new GeoIP();
			$id_country = array_search($record_vars['geo_code'], $geoip->GEOIP_COUNTRY_CODES);
			$record_vars['geo_country_name'] = $id_country&&isset($geoip->GEOIP_COUNTRY_NAMES[$id_country]) ?
				$geoip->GEOIP_COUNTRY_NAMES[$id_country] :
				'';
		}

		// Write results to GLOBAL_VARS
		ee()->config->_global_vars = array_merge(ee()->config->_global_vars, $record_vars);

		// Check allow to view site
		if( isset($this->current['cp_auth']) && $this->current['cp_auth']=='y'
			&& isset($this->settings['global']['cp_ips'])
			&& is_array($this->settings['global']['cp_ips'])
			&& in_array(ee()->input->ip_address(), $this->settings['global']['cp_ips'])  )
		{
			// Allow all CP ips
			return TRUE;
		}
		
		if( isset($this->current['white_ips'])
			&& $this->current['white_ips']!='' )
		{
			// Allow white ips
			$this->current['white_ips'] = explode("\n",$this->current['white_ips']);
			if( in_array(ee()->input->ip_address(), $this->current['white_ips']) ) return TRUE;
		}
		
		if( isset($this->current['white_c'])
			&& is_array($this->current['white_c'])
			&& count($this->current['white_c'])>0 )
		{
			// Without Blacklist
			if( ! in_array(ee()->config->_global_vars['geo_code'], $this->current['white_c']) )
				exit(isset($this->current['tmpl_off'])?$this->current['tmpl_off']:"");
			return TRUE;
		}
		
		if( isset($this->current['black_c'])
			&& is_array($this->current['black_c'])
			&& count($this->current['black_c'])>0
			&& in_array(ee()->config->_global_vars['geo_code'], $this->current['black_c']) )
		{
			if( isset($this->current['tmpl_off']) ) echo $this->current['tmpl_off'];
			exit();
			return TRUE;
		}
	}

	// --------------------------------------------------------------------
	
	
	function settings_form($current)
	{
		// AJAX Actions
		if( ee()->input->get('act')=='ajax' )
		{
			//BASE.AMP.'C=addons_extensions'.AMP.'M=extension_settings'.AMP.'file=geoip_access&act=ajax'
			
			if( ee()->input->get('get')=='regions' && $country = ee()->input->get('country') )
			{
				global $GEOIP_REGION_NAME;

				include(PATH_THIRD."geoip_access/geoip/geoipregionvars.php");
				$regions = array();
				if( isset($GEOIP_REGION_NAME[$country]) ) $regions = $GEOIP_REGION_NAME[$country];
				
				echo json_encode($regions);
				exit();
			}

			//echo json_encode($this->countries);
			exit();
		}



		if( ! function_exists('geoip_database_info') )
		{
			if( ! class_exists('GeoIP') )
			{
				include(PATH_THIRD."geoip_access/geoip/geoip.inc");
			}
			$geoip = new GeoIP();

			$this->countries = array();
			foreach( $geoip->GEOIP_COUNTRY_NAMES as $c_id=>$c_name )
			{
				if( ! isset($geoip->GEOIP_COUNTRY_CODES[$c_id]) || $c_name=='' ) continue;
				$code = $geoip->GEOIP_COUNTRY_CODES[$c_id];
				$this->countries[$code] = $c_name;
			}
		}
		$current = isset($current[ee()->config->item('site_id')]) ? $current[ee()->config->item('site_id')] : array();

		ee()->load->helper('form');
    	ee()->load->library('table');

    	$ret = "";
    	$ret .= form_open('C=addons_extensions'.AMP.'M=save_extension_settings'.AMP.'file=geoip_access');

    	// Основная таблица
		$this->EE->load->library('table');
		$this->EE->table->set_template(array('table_open'=>'<table cellspacing="0" cellpadding="0" border="0" class="mainTable order_list">'));

		// Admin access
		$this->EE->table->add_row(array(
			array('data' => lang('access_administrators'), 'class' => "tableHeadingAlt", 'style' => "width: 300px;"),
			array('data' => "<input type='checkbox' name='cp_auth' value='y' ".(isset($current['cp_auth']) ? "checked='check'":'')."' /> ".lang('yes'))
		));

		// White IPs
		$this->EE->table->add_row(array(
			array('data' => lang('white_list_ip'), 'class' => "tableHeadingAlt"),
			array('data' => "<textarea rows='8' name='white_ips'>".(( ! isset($current['white_ips'])) ? '' : $current['white_ips'])."</textarea>")
		));

		// White Countries
		$field = "<select name='white_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		$list = array();
		foreach( $this->countries as $c_code=>$c_name )
		{
			$sel = (isset($current['white_c'])&&in_array($c_code, $current['white_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$c_code."'>{$c_name}</option>";

			if( $sel ) $list[] = $c_name;
		}
		$field = "<b>In settings now:</b> ".(count($list)?implode(", ", $list):'--')."<br />".$field."</select>";
		$this->EE->table->add_row(array(
			array('data' => lang('white_list_countries'), 'class' => "tableHeadingAlt"),
			array('data' => $field)
		));

		// Black Countries
		$field = "<select name='black_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		$list = array();
		foreach( $this->countries as $c_code=>$c_name )
		{
			$sel = (isset($current['black_c'])&&in_array($c_code, $current['black_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$c_code."'>{$c_name}</option>";

			if( $sel ) $list[] = $c_name;
		}
		$field = "<b>In settings now:</b> ".(count($list)?implode(", ", $list):'--')."<br />".$field."</select>";
		$this->EE->table->add_row(array(
			array('data' => lang('black_list_countries'), 'class' => "tableHeadingAlt"),
			array('data' => $field)
		));

		// Template "Access Denied"
		$this->EE->table->add_row(array(
			array('data' => lang('tmpl_access_denied'), 'class' => "tableHeadingAlt"),
			array('data' => "<textarea rows='8' name='tmpl_off'>".(( ! isset($current['tmpl_off'])) ? '' : $current['tmpl_off'])."</textarea>")
		));




		// Block categories
		$field = <<<HTML
		<div class="mor">
		<div class='geo_rules'>
			<table class="cloneable row-sortable">
				<thead>
					<tr>
						<th scope="col" class="{sorter: false}">&nbsp;</th>
						<th scope="col">Location</th>
						<th scope="col">Category</th>
						<th scope="col">Rule</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class='dragHandle'><span class='sort icon'>Drag to reorder</span></td>
						<td><div class="location"><input class="country" type="hidden" name="country" value="US" /><input class="region" type="hidden" name="region" value="IL" /><span class='title'>USA / Illinois</span></div></td>
						<td><select><option>Category</option></select></td>
						<td>Block | Allow</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<div class="actions">
			<button type='button' class='icon add'>Add rule</button>
		</div>
<style>
.geo_rules .location .title {border-bottom:1px dashed #46BDEF; cursor: pointer;}
.geo_rules .location .locate {margin-top:5px; background: #ffffff; border: 1px solid; display: block; padding: 10px; width: 250px;}
.geo_rules .location .locate select {width:100%;}
</style>
HTML;
		//$field .= "";
		$this->EE->table->add_row(array(
			array('data' => lang('geo_rules'), 'class' => "tableHeadingAlt"),
			array('data' => $field)
		));

		// Generate table
		$ret .= $this->EE->table->generate();
    	
    	$ret .= form_submit('submit', lang('submit'), 'class="submit"');

    	$ret .= form_close();

    	$ajax_url = str_replace('&amp;', '&', BASE).'&C=addons_extensions&M=extension_settings&file=geoip_access&act=ajax';
    	$json_countries = json_encode($this->countries);

    	$ret .= <<<JAVASCRIPT
<script type="text/javascript" charset="utf-8">
	jQuery.fn.geo_location_field = function(options){
		var countries = $json_countries;
		var options = jQuery.extend({
			debug: false,
			trigger: '.title'
		}, options);
		
		if( options.debug ) console.log('Geo location field: Start');

		tools = {
			countries: function(){
				var fld = $("<select><option value=''>Country</option><option value=''>--</option></select>"); // <option value='ALL'>All countries</option>
				$.each(countries, function(code, title){
					fld.append("<option value='"+code+"'>"+title+"</option>");
				});
				return fld;
			},
			load_regions: function(code, fnc){
				$.get('$ajax_url'+'&get=regions&country='+code, function(data){
					var fld = $("<select><option value=''>All regions</option><option value=''>--</option></select>");
					data = $.parseJSON(data);
					$.each(data, function(code, title){
						fld.append("<option value='"+code+"'>"+title+"</option>");
					});

					if( typeof(fnc)=='function' ) fnc(fld);
					//return fld;
				});
			}
		};

		return this.each(function(){
			var fld = $(this);

			trigger = fld.find(options.trigger).length ? fld.find(options.trigger) : fld;
			trigger.click(function(){
				
				if( fld.find('.locate').length ) return false;

				// Initialize template
				var locate = $("<div class='locate'><div class='select'></div><div class='actions'><button class='ok' type='button'>Ok</button><button class='cancel' type='button'>Cancel</button></div></div>").hide();
				var locate_select = locate.find(".select");
					
				var country = tools.countries();
				locate_select.append(country)

				var region = "";
				country.change(function(){
					console.log('countries change', country.val());
					
					if( typeof(region)=='object' ) region.remove();
					if( country.val()!='' && country.val()!='ALL' )
					{
						tools.load_regions(country.val(), function(obj){
							region = obj;
							locate_select.append(region);

							region.change(function(){
								console.log('region change', region.val());
							});
						});
					}
				});

				// Include location select
				fld.append(locate);
				locate.slideDown('fast');
				
				// Save location and destroy form
				locate.find('.actions .ok').click(function(e){
					var location_title = '';
					if( fld.find('input.country').length )
					{
						fld.find('input.country').val( country.val() );
						location_title += country.find('option:selected').text();
					} else console.log('Error saving country!', country.val() );
					if( typeof(region) == 'object' )
					{
						if( fld.find('input.region').length )
						{
							location_title += ' / ' + region.find('option:selected').text();
							fld.find('input.region').val( region.val() );
						} else console.log('Error saving region!', region.val() );
					}

					fld.find('>.title').html(location_title);

					locate.remove();
					e.stopPropagation();
				});
				
				// Cancel select
				locate.find('.actions .cancel').click(function(e){
					locate.remove();
					e.stopPropagation();
				});
			});
		});
	};
$(function(){

	/*$.get('$ajax_url', function(data){
		console.log($.parseJSON(data));
	});*/

	$(".geo_rules > table").NSM_Cloneable({
		addTrigger: $(".actions .add"),
		appendTarget: '>tbody',
		cloneTemplate: $('<tr><td class="dragHandle"><span class="sort icon">Drag to reorder</span></td><td><div class="location"><input class="country" type="hidden" name="country" value="" /><input class="region" type="hidden" name="region" value="" /><span class="title">Select location</span></div></td><td><table class="rules row-sortable"><tbody></tbody></table><div class="actions"></div></td><td><span class="icon delete" type="button">Удалить</span></td></tr>')
	})
	//.NSM_UpdateInputsOnChange({inputNamePrefix:"tmpl_rewrite", targetSelector: '>tbody>tr'})
	.tableDnD({dragHandle:'dragHandle'})
	.bind("addCloneEnd.NSM_Cloneable", function(e, clone){ 
		templateRules(clone);
		$(this).trigger("update").tableDnDUpdate();
	})
	.bind("deleteCloneEnd.NSM_Cloneable", function(e, clone){ 
		$(this).trigger("update").tableDnDUpdate();
	});
	
	// Templates each
	$(".geo_rules > table > tbody > tr").each(function(){
		templateRules($(this));
		//$(this).find('tbody tr').DC_UpdateIndexes({indexCount:2});
	});



	function templateRules(tmpl)
	{
		var table = tmpl.find('table:first');
		var actions = tmpl.find('.actions');

		console.log(tmpl);

		tmpl.find('.location').geo_location_field();

		/*tmpl.find('.location .sel').click(function(){
			var _this = $(this);
			var name = _this.find('input').attr('name');
			var sel = $("<select name='"+name+"'><option value=''>Country</option><option value=''>--</option></select>").appendTo(_this.parent());

			$.each(countries, function(code, title){
				sel.append("<option value='"+code+"'>"+title+"</option>");
			});

			var cancel = $("<a>Cancel</a>").appendTo(_this.parent());
			cancel.click(function(){
				_this.find('input').attr('name', _this.find('input').data('name'));
				_this.show();
				sel.remove();
				cancel.remove();
			});

			_this.find('input').data('name', _this.find('input').attr('name'));
			_this.find('input').removeAttr('name');
			_this.hide();
			console.log('hide .sel');

			sel.change(function(){
				console.log('load states');
			});

		});*/
	}
});
</script>
JAVASCRIPT;

    	return $ret;
	}
	
	/**
	* Save Settings
	**/
	function save_settings()
	{
		// unset the submit
		unset($_POST['submit']);

		ee()->lang->loadfile('geoip_access');

		// load the settings from cache or DB
		// force a refresh and return the full site settings
		//$settings = $this->_get_settings(TRUE, TRUE);
		$settings = $this->settings;

		// add the posted values to the settings
		$settings[ee()->config->item('site_id')] = $_POST;
		// Clear null's and double of array
		foreach( $settings[ee()->config->item('site_id')] as $key=>&$var )
		{
			if( is_array($var) )
				foreach( $var as $k=>$v ) {
					if( $v=='' ) unset($var[$k]);
					unset($settings[ee()->config->item('site_id')][$key.'_'.$k]);
				}
		}

		// update the settings
		ee()->db->where('class', __CLASS__);
		ee()->db->update('extensions', array('settings' => serialize($settings)));

		ee()->session->set_flashdata('message_success', lang('settings_saved'));
		ee()->functions->redirect(BASE.AMP.'C=addons_extensions'.AMP.'M=extension_settings'.AMP.'file=geoip_access');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Register hooks by adding them to the database
	 */
	function activate_extension()
	{
		$this->settings = array();
		
		$data = array(
			'class'     => __CLASS__,
			'method'    => 'sessions_start',
			'hook'      => 'sessions_start',
			'settings'  => serialize($this->settings),
			'priority'  => 1,
			'version'   => $this->version,
			'enabled'   => 'y'
		);
		
		$this->EE->db->insert('extensions', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Disable the extention
	 */    
	function disable_extension()
	{		
		//
		// Remove added hooks
		//
		$this->EE->db->delete('extensions', array('class'=>__CLASS__));
	}
}
// END CLASS Geoip_access

/* End of file ext.geoip_access.php */