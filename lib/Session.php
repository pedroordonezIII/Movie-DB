<?php

 class Session{

	/*
	initiliaze static function that
	does not require initializing 
	object to begin the session
	*/
	public static function init(){
		session_start();
	}

	/** 
	 * set method
	that sets a key 
	equal to a value
	for the corresponding 
	entities of the user 
	when creating a session
	*/
	public static function set($key, $value){
		$_SESSION[$key] = $value; 
	}


	/**
	 * get method that returns 
	 * the specified session key
	 * value based on the set method
	 */
	public static function get($key){
		//check if key is set
		if(isset($_SESSION[$key])){
			//return the key
			return $_SESSION[$key];
		}else{
			return false;
		}

	}

	/**
	 * function that will check the session each time
	 * the page is reloaded.  If admin login is not set
	 * or false, it will run this, destroy the session, 
	 * and redirect to the login page.
	 */
	public static function checkSession(){
		//initialize session
		self::init();
		//it will no longer be set when logging out
		if(self::get("adminlogin") == false){
			//destroy session
			self::destroy();
			//redirect it to login.php
			header("Location:../login.php"); 
		}
	}

	/**
	 * checks the login and if adminlogin session attribute
	 * is true, redirect to the dashboard
	 */
	public static function checkLogin(){
		//start the session
		self::init();
		if(self::get("adminlogin") == true){
			header("Location:dashboard.php"); 
		}
	}

	/**
	 * Destroy the current session and redirect
	 * tp the login.php page
	 */
	public static function destroy(){
		//destroy the session
		session_destroy(); 
		//redirect to login page using header
		//when session is destroyed
		header("Location:login.php"); 
	}

	/**
	 * Destroy the current session and redirect
	 * tp the login.php page
	 */
	public static function destroyAdmin(){
		//destroy the session
		session_destroy(); 
		//redirect to login page using header
		//when session is destroyed
		header("Location:../login.php"); 
	}

 }

?>