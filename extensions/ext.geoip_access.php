<?php  if ( ! defined('EXT') ) exit('No direct script access allowed');
/**
 * Template Rewrite
 *
 * @author		Denik
 * @copyright	Copyright (c) 2012
 * @link		http://www.denik.od.ua/
 * @since		Version 1.0
 * 
 */

class Geoip_access {

	var $current		= array();
	var $settings		= array();
	var $name			= 'GeoIP Access';
	var $version		= '1.0';
	var $description	= 'White/Black list of countries';
	var $settings_exist	= 'y';
	var $docs_url		= 'http://www.denik.od.ua/';

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
		
		// Get country code
		if( ! class_exists('GeoIP') )
		{
			//include(PATH_LIB."geoip/geoip.inc.php");
			include(PATH_LIB."geoip/geoipcity.inc.php");
			include(PATH_LIB."geoip/geoipregionvars.php");
		}
		if( file_exists(PATH_LIB."geoip/GeoIPCity.dat") )
		{
			$gi = geoip_open(PATH_LIB."geoip/GeoIPCity.dat", GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi, $IN->IP);
			$IN->global_vars['geo_code']		= $record->country_code;
			$IN->global_vars['geo_country_code']= $record->country_code;
			$IN->global_vars['geo_country_name']= $record->country_name;
			$IN->global_vars['geo_region']		= $record->region;
			$IN->global_vars['geo_region_name']	= isset($GEOIP_REGION_NAME[$record->country_code][$record->region])?$GEOIP_REGION_NAME[$record->country_code][$record->region]:'';
			$IN->global_vars['geo_city']		= $record->city;
			$IN->global_vars['geo_zip']			= $record->postal_code;
			$IN->global_vars['geo_latitude']	= $record->latitude;
			$IN->global_vars['geo_longitude']	= $record->longitude;
			$IN->global_vars['geo_metro_code']	= $record->metro_code;
			$IN->global_vars['geo_area_code']	= $record->area_code;
			$IN->global_vars['geo_continent_code']	= $record->continent_code; // вылезла
		}
		elseif( file_exists(PATH_LIB."geoip/GeoLiteCity.dat") )
		{
			$gi = geoip_open(PATH_LIB."geoip/GeoLiteCity.dat", GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi, $IN->IP);
			$IN->global_vars['geo_code']		= $record->country_code;
			$IN->global_vars['geo_country_code']= $record->country_code;
			$IN->global_vars['geo_country_name']= $record->country_name;
			$IN->global_vars['geo_region']		= $record->region;
			$IN->global_vars['geo_region_name']	= isset($GEOIP_REGION_NAME[$record->country_code][$record->region])?$GEOIP_REGION_NAME[$record->country_code][$record->region]:'';
			$IN->global_vars['geo_city']		= $record->city;
			$IN->global_vars['geo_zip']			= $record->postal_code;
			$IN->global_vars['geo_latitude']	= $record->latitude;
			$IN->global_vars['geo_longitude']	= $record->longitude;
			$IN->global_vars['geo_metro_code']	= $record->metro_code;
			$IN->global_vars['geo_area_code']	= $record->area_code;
			$IN->global_vars['geo_continent_code']	= $record->continent_code; // вылезла
		}
		else
		{
			$gi = geoip_open(PATH_LIB."geoip/GeoIP.dat", GEOIP_STANDARD);
			$IN->global_vars['geo_country_code'] = $IN->global_vars['geo_code'] = geoip_country_code_by_addr($gi, $IN->IP);

			$IN->global_vars['geo_country_name']= '';
			$IN->global_vars['geo_region']		= '';
			$IN->global_vars['geo_region_name']	= '';
			$IN->global_vars['geo_city']		= '';
			$IN->global_vars['geo_zip']			= '';
			$IN->global_vars['geo_latitude']	= '';
			$IN->global_vars['geo_longitude']	= '';
			$IN->global_vars['geo_metro_code']	= '';
			$IN->global_vars['geo_area_code']	= '';
			$IN->global_vars['geo_continent_code']	= '';

			if( class_exists('GeoIP') )
			{
				$geoip = new GeoIP();
				$id_country = array_search($IN->global_vars['geo_code'], $geoip->GEOIP_COUNTRY_CODES);
				$IN->global_vars['geo_country_name'] = $id_country&&isset($geoip->GEOIP_COUNTRY_NAMES[$id_country]) ? $geoip->GEOIP_COUNTRY_NAMES[$id_country] : '';
			}
		}
		
		geoip_close($gi);
		unset($gi);

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
		
		if( ! class_exists('GeoIP') )
		{
			include(PATH_LIB."geoip/geoip.inc.php");
		}
		$geoip = new GeoIP();
		
		$current = isset($current[$PREFS->ini('site_id')]) ? $current[$PREFS->ini('site_id')] : array();

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
		
		$field = "<label>".$DSP->input_checkbox('cp_auth', 'y', isset($current['cp_auth']) ? $current['cp_auth']:'')." Да</label>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'width'=>'210px', 'text' => $DSP->qdiv('defaultBold', 'Всегда открыть доступ для<br />авторизованных администраторов?')),
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = $DSP->input_textarea('white_ips', ( ! isset($current['white_ips'])) ? '' : $current['white_ips'], 8);
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $DSP->qdiv('defaultBold', 'Белый список IP-адресов<br />(вводить через Enter)')), //.$LANG->line('catgroups_desc')
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = "<select name='white_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		foreach( $geoip->GEOIP_COUNTRY_NAMES as $c_id=>$c_name )
		{
			if( ! isset($geoip->GEOIP_COUNTRY_CODES[$c_id]) || $c_name=='' ) continue;
			$sel = (isset($current['white_c'])&&in_array($geoip->GEOIP_COUNTRY_CODES[$c_id], $current['white_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$geoip->GEOIP_COUNTRY_CODES[$c_id]."'>{$c_name}</option>";
		}
		$field .= "</select>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $DSP->qdiv('defaultBold', 'Белый список стран<br />(Будут доступны только эти страны, остальные - нет<br />Приоритетнее чем Черный список)')), //.$LANG->line('catgroups_desc')
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = "<select name='black_c[]' multiple='multiple' size='10'><option value=''>- -</option>";
		foreach( $geoip->GEOIP_COUNTRY_NAMES as $c_id=>$c_name )
		{
			if( ! isset($geoip->GEOIP_COUNTRY_CODES[$c_id]) || $c_name=='' ) continue;
			$sel = (isset($current['black_c'])&&in_array($geoip->GEOIP_COUNTRY_CODES[$c_id], $current['black_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$geoip->GEOIP_COUNTRY_CODES[$c_id]."'>{$c_name}</option>";
		}
		$field .= "</select>";
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $DSP->qdiv('defaultBold', 'Черный список стран')), //.$LANG->line('catgroups_desc')
			array('class' => 'tableCellOne', 'text' => $DSP->qspan('default', $field)),
		));
		
		$field = $DSP->input_textarea('tmpl_off', ( ! isset($current['tmpl_off'])) ? '' : $current['tmpl_off'], 8);
		$DSP->body .= $DSP->table_row(array(
			array('class' => 'tableCellOne', 'text' => $DSP->qdiv('defaultBold', 'Шаблон "доступ запрещен"')), //.$LANG->line('catgroups_desc')
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