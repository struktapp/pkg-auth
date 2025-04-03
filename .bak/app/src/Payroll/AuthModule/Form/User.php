<?php
namespace Payroll\AuthModule\Form;

use Strukt\Framework\Contract\Form as AbstractForm;

class User extends AbstractForm{
	
	/**
	* @IsNotEmpty()
	* @IsAlpha()
	*/
	public string $username;

	/**
	* @IsNotEmpty()
	*/
	public string $password;
}