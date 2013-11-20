CodeIgniter Pushover
===========

CodeIgniter Pushover Library

Install this library with Sparks. http://getsparks.org/packages/Pushover/show

	$this->load->spark('pushover/0.0.3');
	$this->pushover->initialize(array(
		'app_key'	=> '<Application Key Here>',
		'user_key'	=> '<User Key Here>',
	));
	
	/**
	 * Use a short hand method
	 * $this->pushover->push(<message>, [title]);
	 * 
	 * Title is optional here
	 */
	
	$this->pushover->push('Whoo! Test', 'The title');
	
	/**
	 * Method that support any variable supported by Pushover
	 */
	 
	$this->pushover->push(array(
		'title'		=> 'This is the title',
		'message'	=> 'Some message here....',
		'device'	=> 'MyNexus',
		'timestamp'	=> time(),
	));

You can predefined your keys in config/pushover.php