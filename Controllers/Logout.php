<?php
			session_start();

	class Logout
	{
		public function __construct()
		{
			session_unset();
			session_destroy();
			header('location: '.base_url().'/login');
			die();
		}
	}
 ?>