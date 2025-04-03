<?php
namespace Payroll\AuthModule\Controller;

use Strukt\Framework\Contract\Controller as AbstractController;

class User extends AbstractController{

	public function find($id){

		return "Couldn't find User:[id] - AuthModule\Controller\User::find Not Yet Implemented!";
	}

	public function getAll(){

		return "AuthModule\Controller\User::getAll Not Yet Implemented!";
	}

	public function doAuth($username, $password){

		$user = $this->get("User", array($username, $password));

		return $user->username == "admin" && $user->password == sha1("p@55w0rd");
	}
}