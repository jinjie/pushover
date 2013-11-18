CodeIgniter Pushover
===========

CodeIgniter Pushover Library

	$this->load->spark('pushover/develop');
	$this->pushover->initialize(array(
		'app_key'	=> '<Application Key Here>',
		'user_key'	=> '<User Key Here>',
	));
	
	/**
	 * Use a short hand method
	 * $this->pushover->push(<message>, [title]);
	 */
	
	$result = $this->pushover->push('Whoo! Test');
	
	

You can predefined your keys in config/pushover.php