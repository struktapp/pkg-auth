<?php
namespace Payroll;

class User extends \Strukt\Entity{

	/**
	* @Type(string)
	*/
	public $username;

	/**
	* @Type(string)
	*/
	public $password;
}