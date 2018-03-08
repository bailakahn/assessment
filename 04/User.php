<?php

	/**
	* 
	*/
	class User
	{
		
		private $firstname;
		private $lastname;
		private $province;

		function __construct($firstname, $lastname, $province)
		{

			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->province = $province;

		}

		/**
		* @return string the user firstname 
		*/
		public function getFirstName(){

			return $this->firstname;

		}

		/**
		* @param string new user's firstname
		*/
		public function setFirstName($firstname){

			$this->firstname = $firstname;
		
		}

		/**
		* @return string the user lastname 
		*/
		public function getLastName(){

			return $this->lastname;

		}

		/**
		* @param string new user's lastname
		*/
		public function setLastName($lastname){

			$this->lastname = $lastname;
		
		}

		/**
		* @return string the user province 
		*/
		public function getProvince(){

			return $this->province;

		}

		/**
		* @param string new user's province
		*/
		public function setProvince($province){

			$this->province = $province;
		
		}

	}

?>