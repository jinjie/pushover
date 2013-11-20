<?php

class Pushover
{

	protected $config = array();
	protected $endpoint = 'https://api.pushover.net/1/';

	public function __construct($config = array())
	{
		$ci =& get_instance();
		
		// Try to load Phil's curl library
		$ci->load->spark('curl/1.3.0');
		
		$ci->load->config('pushover', TRUE);
		$this->config = $ci->config->item('pushover');
		
		$this->initialize($config);
	}
	
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
	
	protected function _execute($uri, $params)
	{
		$ci =& get_instance();
		
		$params['token'] = $this->config['app_key'];
		$params['user'] = $this->config['user_key'];

		$result = $ci->curl->simple_post($this->endpoint . $uri . "." . $this->config['format'], $params);
		
		if ($result)
		{
			switch (strtolower($this->config['format']))
			{
				case 'json' :
					return json_decode($result);
					break;
				case 'xml' :
					return simplexml_load_string($result);
					break;
			}
		}
		else
		{
			return FALSE;
		}
	}

}