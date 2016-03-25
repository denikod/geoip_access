<?php  if ( ! defined('EXT') ) exit('No direct script access allowed');
/**
 * GeoIP Access
 *
 * @author		Denik
 * @copyright	Copyright (c) 2012-2014
 * @link		http://denik.od.ua/
 * @since		Version 1.3
 * 
 */

class Geoip_access {

	var $current		= array();
	var $settings		= array();
	var $name			= 'GeoIP Access';
	var $version		= '1.3';
	var $description	= 'White/Black list of countries';
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
	function Geoip_access($settings = '')
	{
		GLOBAL $PREFS;
		$this->settings = $this->_get_settings(true);
		$this->current = isset($this->settings[$PREFS->ini('site_id')])?$this->settings[$PREFS->ini('site_id')]:array();
	}
	
	// --------------------------------------------------------------------
	
	function sessions_start($SESS)
	{
		global $PREFS, $REGX, $IN, $DB, $GEOIP_REGION_NAME;
		
//if( $IN->IP == '85.238.119.62' ) $IN->IP = '104.156.247.163'; // test US country

		if( REQ == 'CP' )
		{
			if( ! isset($this->settings['global']['cp_ips'])
				|| ! is_array($this->settings['global']['cp_ips'])
				|| ! in_array($IN->IP, $this->settings['global']['cp_ips']) )
			{
				$this->settings['global'] = array('cp_ips'=>array());

				$q = $DB->query("SELECT DISTINCT s.`ip_address` FROM `exp_sessions` AS s WHERE s.`admin_sess`='1'");
				foreach( $q->result as $row )
				{
					$this->settings['global']['cp_ips'][] = $row['ip_address'];
				}
				
				// update the settings
				$query = $DB->query("UPDATE `exp_extensions` SET `settings` = '" . addslashes(serialize($this->settings)) . "' WHERE `class` = '" . __CLASS__ . "'");
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
			$record = geoip_record_by_name($IN->IP);
		}
		else
		{
			// Load library
			if( ! class_exists('GeoIP') ) include(PATH_LIB."geoip/geoipcity.inc");

			$gi = FALSE;

			// Use full database ?
			if( file_exists(PATH_LIB."geoip/GeoIPCity.dat") )
			{
				$gi = geoip_open(PATH_LIB."geoip/GeoIPCity.dat", GEOIP_STANDARD);
				$record = geoip_record_by_addr($gi, $IN->IP);
			}
			
			if( !$record && file_exists(PATH_LIB."geoip/GeoLiteCity.dat") )
			{
				if( $gi !== FALSE ) geoip_close($gi); // close previous file handel
				$gi = geoip_open(PATH_LIB."geoip/GeoLiteCity.dat", GEOIP_STANDARD);
				$record = geoip_record_by_addr($gi, $IN->IP);
			}

			if( !$record && file_exists(PATH_LIB."geoip/GeoIP.dat") )
			{
				if( $gi !== FALSE ) geoip_close($gi); // close previous file handel
				$gi = geoip_open(PATH_LIB."geoip/GeoIP.dat", GEOIP_STANDARD);
				$record = array('country_code' => geoip_country_code_by_addr($gi, $IN->IP));
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
			include(PATH_LIB."geoip/geoipregionvars.php");
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
		$IN->global_vars = array_merge($IN->global_vars, $record_vars);

		// Check allow to view site
		if( isset($this->current['cp_auth']) && $this->current['cp_auth']=='y'
			&& isset($this->settings['global']['cp_ips'])
			&& is_array($this->settings['global']['cp_ips'])
			&& in_array($IN->IP, $this->settings['global']['cp_ips'])  )
		{
			// Allow all CP ips
			return TRUE;
		}
		
		if( isset($this->current['white_ips'])
			&& $this->current['white_ips']!='' )
		{
			// Allow white ips
			$this->current['white_ips'] = explode("\n",$this->current['white_ips']);
			if( in_array($IN->IP, $this->current['white_ips']) ) return TRUE;
		}
		
		if( isset($this->current['white_c'])
			&& is_array($this->current['white_c'])
			&& count($this->current['white_c'])>0 )
		{
			// Without Blacklist
			if( ! in_array($IN->global_vars['geo_code'], $this->current['white_c']) )
				exit(isset($this->current['tmpl_off'])?$this->current['tmpl_off']:"");
			return TRUE;
		}
		
		if( isset($this->current['black_c'])
			&& is_array($this->current['black_c'])
			&& count($this->current['black_c'])>0
			&& in_array($IN->global_vars['geo_code'], $this->current['black_c']) )
		{
			exit(isset($this->current['tmpl_off'])?$this->current['tmpl_off']:"");
			return TRUE;
		}
	}

	// --------------------------------------------------------------------
	
	
	function settings_form($current)
	{
		global $DSP, $PREFS, $LANG, $IN;
		
		if( ! function_exists('geoip_database_info') )
		{
			if( ! class_exists('GeoIP') )
			{
				include(PATH_LIB."geoip/geoip.inc");
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
		$current = isset($current[$PREFS->ini('site_id')]) ? $current[$PREFS->ini('site_id')] : array();

		asort($this->countries);

		$DSP->crumbline = TRUE;
		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
		$DSP->crumb .= $DSP->crumb_item($this->name);
		
		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));
		
		$DSP->body = $DSP->form_open(
			array(
				'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
				'name'   => 'ext_settings',
				'id'     => 'ext_settings'
			),
			array('name' => get_class($this))
		);
		
		$DSP->body .= $DSP->table_open(array('class' => "tableBorder", 'width' => "100%", 'valign' => "top"));
		$DSP->body .= $DSP->table_row(array(array('class' => "tableHeadingAlt", 'colspan'=>"2", 'text' => $this->name)));
		
		$field = "<label>".$DSP->input_checkbox('cp_auth', 'y', isset($current['cp_auth']) ? $current['cp_auth']:'')." ".$LANG->line('yes')."</label>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'width'=>'210px', 'text' => $LANG->line('access_administrators')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = $DSP->input_textarea('white_ips', ( ! isset($current['white_ips'])) ? '' : $current['white_ips'], 8);
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $LANG->line('white_list_ip')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = "<select name='white_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		$list = array();

		foreach( $this->countries as $c_code=>$c_name )
		{
			$sel = (isset($current['white_c'])&&in_array($c_code, $current['white_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$c_code."'>{$c_name}</option>";

			if( $sel ) $list[] = $c_name;
		}
		$field = "<b>In settings now:</b> ".(count($list)?implode(", ", $list):'--')."<br />".$field."</select>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $LANG->line('white_list_countries')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = "<select name='black_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		$list = array();
		foreach( $this->countries as $c_code=>$c_name )
		{
			$sel = (isset($current['black_c'])&&in_array($c_code, $current['black_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$c_code."'>{$c_name}</option>";

			if( $sel ) $list[] = $c_name;
		}
		$field = "<b>In settings now:</b> ".(count($list)?implode(", ", $list):'--')."<br />".$field."</select>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $LANG->line('black_list_countries')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = $DSP->input_textarea('tmpl_off', ( ! isset($current['tmpl_off'])) ? '' : $current['tmpl_off'], 8);
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $LANG->line('tmpl_access_denied')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$DSP->body .= $DSP->table_c();
		$DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit());
		$DSP->body .= $DSP->form_c();
	}
	
	/**
	* Save Settings
	**/
	function save_settings()
	{
		global $DB, $PREFS;

		// unset the name
		unset($_POST['name']);

		// load the settings from cache or DB
		// force a refresh and return the full site settings
		$settings = $this->_get_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $_POST;
		// Clear null's and double of array
		foreach( $settings[$PREFS->ini('site_id')] as $key=>&$var )
		{
			if( is_array($var) )
				foreach( $var as $k=>$v ) {
					if( $v=='' ) unset($var[$k]);
					unset($settings[$PREFS->ini('site_id')][$key.'_'.$k]);
				}
		}

		// update the settings
		$query = $DB->query("UPDATE `exp_extensions` SET `settings` = '" . addslashes(serialize($settings)) . "' WHERE `class` = '" . __CLASS__ . "'");
	}
	
	function _get_settings($return_all = TRUE, $force_refresh = TRUE)
	{

		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;

		// Get the settings for the extension
		if(isset($SESS->cache['dc'][__CLASS__]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT `settings` FROM `exp_extensions` WHERE enabled = 'y' AND `class` = '" . __CLASS__ . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['dc'][__CLASS__]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}
		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache['dc'][__CLASS__]['settings']) !== TRUE)
		{
			$settings = ($return_all === TRUE) ? $SESS->cache['dc'][__CLASS__]['settings'] : (isset($SESS->cache['dc'][__CLASS__]['settings'][$PREFS->ini('site_id')])?$SESS->cache['dc'][__CLASS__]['settings'][$PREFS->ini('site_id')]:array());
		}
		
		if( sizeof($settings)==0 )
		{
			// Write Default settings
			$settings = array();
		}

		return $settings;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Register hooks by adding them to the database
	 */
	function activate_extension()
	{
		global $DB;

		// default settings
		$settings =	array();
		
		$hook = array();
		$hook[] = array(
			'extension_id'	=> '',
			'class'			=> __CLASS__,
			'method'		=> 'sessions_start',
			'hook'			=> 'sessions_start',
			'settings'		=> serialize($settings),
			'priority'		=> 99,
			'version'		=> $this->version,
			'enabled'		=> 'y'
		);
	
		foreach( $hook as $h ) $DB->query($DB->insert_string('exp_extensions',	$h));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstalls extension
	 */
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM `exp_extensions` WHERE `class` = '".__CLASS__."'");
	}
}
// END CLASS Geoip_access

/* End of file ext.geoip_access.php */