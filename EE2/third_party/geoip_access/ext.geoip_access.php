<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GeoIP Access
 *
 * @author		Denik
 * @copyright	Copyright (c) 2014
 * @link		http://denik.od.ua/
 * @since		Version 1.1
 * 
 */

class Geoip_access_ext {

	var $current		= array();
	var $settings		= array();
	var $name			= 'GeoIP Access';
	var $version		= '1.1';
	var $description	= 'White/Black list of countries';
	var $settings_exist	= 'y';
	var $docs_url		= 'http://denik.od.ua/';

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
		global $PREFS, $REGX, $IN, $DB, $GEOIP_REGION_NAME;
		
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

		// Get country code
		if( ! class_exists('GeoIP') )
		{
			//include(PATH_THIRD."geoip_access/geoip/geoip.inc");
			include(PATH_THIRD."geoip_access/geoip/geoipcity.inc");
			include(PATH_THIRD."geoip_access/geoip/geoipregionvars.php");
		}

		if( file_exists(PATH_THIRD."geoip_access/geoip/GeoIPCity.dat") )
		{
			$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoIPCity.dat", GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi, ee()->input->ip_address());
			ee()->config->_global_vars['geo_code']			= $record->country_code;
			ee()->config->_global_vars['geo_country_code']	= $record->country_code;
			ee()->config->_global_vars['geo_country_name']	= $record->country_name;
			ee()->config->_global_vars['geo_region']		= $record->region;
			ee()->config->_global_vars['geo_region_name']	= isset($GEOIP_REGION_NAME[$record->country_code][$record->region])?$GEOIP_REGION_NAME[$record->country_code][$record->region]:'';
			ee()->config->_global_vars['geo_city']			= $record->city;
			ee()->config->_global_vars['geo_zip']			= $record->postal_code;
			ee()->config->_global_vars['geo_latitude']		= $record->latitude;
			ee()->config->_global_vars['geo_longitude']		= $record->longitude;
			ee()->config->_global_vars['geo_metro_code']	= $record->metro_code;
			ee()->config->_global_vars['geo_area_code']		= $record->area_code;
			ee()->config->_global_vars['geo_continent_code']= $record->continent_code; // вылезла
		}
		elseif( file_exists(PATH_THIRD."geoip_access/geoip/GeoLiteCity.dat") )
		{
			$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi, ee()->input->ip_address());
			ee()->config->_global_vars['geo_code']			= $record->country_code;
			ee()->config->_global_vars['geo_country_code']	= $record->country_code;
			ee()->config->_global_vars['geo_country_name']	= $record->country_name;
			ee()->config->_global_vars['geo_region']		= $record->region;
			ee()->config->_global_vars['geo_region_name']	= isset($GEOIP_REGION_NAME[$record->country_code][$record->region])?$GEOIP_REGION_NAME[$record->country_code][$record->region]:'';
			ee()->config->_global_vars['geo_city']			= $record->city;
			ee()->config->_global_vars['geo_zip']			= $record->postal_code;
			ee()->config->_global_vars['geo_latitude']		= $record->latitude;
			ee()->config->_global_vars['geo_longitude']		= $record->longitude;
			ee()->config->_global_vars['geo_metro_code']	= $record->metro_code;
			ee()->config->_global_vars['geo_area_code']		= $record->area_code;
			ee()->config->_global_vars['geo_continent_code']= $record->continent_code; // вылезла
		}
		else
		{
			$gi = geoip_open(PATH_THIRD."geoip_access/geoip/GeoIP.dat", GEOIP_STANDARD);
			ee()->config->_global_vars['geo_country_code'] = ee()->config->_global_vars['geo_code'] = geoip_country_code_by_addr($gi, ee()->input->ip_address());

			ee()->config->_global_vars['geo_country_name']	= '';
			ee()->config->_global_vars['geo_region']		= '';
			ee()->config->_global_vars['geo_region_name']	= '';
			ee()->config->_global_vars['geo_city']			= '';
			ee()->config->_global_vars['geo_zip']			= '';
			ee()->config->_global_vars['geo_latitude']		= '';
			ee()->config->_global_vars['geo_longitude']		= '';
			ee()->config->_global_vars['geo_metro_code']	= '';
			ee()->config->_global_vars['geo_area_code']		= '';
			ee()->config->_global_vars['geo_continent_code']= '';

			if( class_exists('GeoIP') )
			{
				$geoip = new GeoIP();
				$id_country = array_search(ee()->config->_global_vars['geo_code'], $geoip->GEOIP_COUNTRY_CODES);
				ee()->config->_global_vars['geo_country_name'] = $id_country&&isset($geoip->GEOIP_COUNTRY_NAMES[$id_country]) ? $geoip->GEOIP_COUNTRY_NAMES[$id_country] : '';
			}
		}
		
		geoip_close($gi);
		unset($gi);

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
			exit(isset($this->current['tmpl_off'])?$this->current['tmpl_off']:"");
			return TRUE;
		}
	}

	// --------------------------------------------------------------------
	
	
	function settings_form($current)
	{
		if( ! class_exists('GeoIP') )
		{
			include(PATH_THIRD."geoip_access/geoip/geoip.inc");
		}
		$geoip = new GeoIP();
		
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
		foreach( $geoip->GEOIP_COUNTRY_NAMES as $c_id=>$c_name )
		{
			if( ! isset($geoip->GEOIP_COUNTRY_CODES[$c_id]) || $c_name=='' ) continue;
			$sel = (isset($current['white_c'])&&in_array($geoip->GEOIP_COUNTRY_CODES[$c_id], $current['white_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$geoip->GEOIP_COUNTRY_CODES[$c_id]."'>{$c_name}</option>";

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
		foreach( $geoip->GEOIP_COUNTRY_NAMES as $c_id=>$c_name )
		{
			if( ! isset($geoip->GEOIP_COUNTRY_CODES[$c_id]) || $c_name=='' ) continue;
			$sel = (isset($current['black_c'])&&in_array($geoip->GEOIP_COUNTRY_CODES[$c_id], $current['black_c'])) ? ' selected="select"':'';
			$field .= "<option$sel value='".$geoip->GEOIP_COUNTRY_CODES[$c_id]."'>{$c_name}</option>";

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

		// Generate table
		$ret .= $this->EE->table->generate();
    	
    	$ret .= form_submit('submit', lang('submit'), 'class="submit"');

    	$ret .= form_close();

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
	
	/*function _get_settings($return_all = TRUE, $force_refresh = TRUE)
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
			$settings = ($return_all === TRUE) ? $SESS->cache['dc'][__CLASS__]['settings'] : (isset($SESS->cache['dc'][__CLASS__]['settings'][ee()->config->item('site_id')])?$SESS->cache['dc'][__CLASS__]['settings'][ee()->config->item('site_id')]:array());
		}
		
		if( sizeof($settings)==0 )
		{
			// Write Default settings
			$settings = array();
		}

		return $settings;
	}*/

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