<?php

/**
 * A simple CodeIgniter Pushover Library
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Kong Jin Jie
 * @link		https://github.com/aspiredesigns/pushover
 */

class Pushover
{

	protected $config	= array(); // Variable to store the configuration

	protected $endpoint	= 'https://api.pushover.net/1/'; // The base url of Pushover API

	/**
	 * Pushover constructor
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	
	public function __construct($config = array())
	{
		$ci =& get_instance();
		
		// Try to load Phil's curl library
		$ci->load->spark('curl/1.3.0');
		
		// Loads the configuration
		$ci->load->config('pushover', TRUE);
		
		// Store the configuration as array into the variable
		$this->config = $ci->config->item('pushover');
		
		// Override any default configuration
		$this->initialize($config);
	}
	
	/**
	 * Initialize the configuration
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	
	public function initialize($config = array())
	{
		foreach ($config as $key => $value)
		{
			if (isset($this->config[$key]))
			{
				$this->config[$key] = $value;
			}
		}
	}
	
	/**
	 * Push a message
	 *
	 * This method may take a short hand
	 *
	 * @access	public
	 * @param	array
	 * @param	string
	 */
	
	public function push($params = array(), $title = '')
	{
		// Use for shorthand
		if (is_string($params))
		{
			$params = array(
				'message'	=> $params,
				'title'		=> $title,
			);
		}
		
		return $this->_execute('messages', $params);
	}
	
	/**
	 * Really send the message to the API
	 *
	 * @access	protected
	 * @param	string
	 * @param	array
	 */
	
	protected function _execute($uri, $params)
	{
		$ci =& get_instance();
		
		// Sets the token and user for API validation
		$params['token'] = $this->config['app_key'];
		$params['user'] = $this->config['user_key'];
		
		// Send the POST message to the API
		$result = $ci->curl->simple_post($this->endpoint . $uri . "." . $this->config['format'], $params);
		
		if ($result)
		{
			switch (strtolower($this->config['format']))
			{
				case 'json' :
					// If format is json, decode the string to object and return
					return json_decode($result);
					break;
				case 'xml' :
					// If format is xml, convert it to SimpleXMLElement and return
					return simplexml_load_string($result);
					break;
			}
		}
		else
		{
			// Fail!
			return FALSE;
		}
	}

}

// End of file