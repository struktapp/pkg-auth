<?php

namespace Payroll\AuthModule\Router;

use Strukt\Http\Request;
use Strukt\Http\Response\Plain as Response;
use Strukt\Framework\Contract\Router as AbstractRouter;

class Auth extends AbstractRouter{

	/**
	* @Route(/login)
	* @Method(POST)
	* @Form(User)
	*/
	public function login(Request $request){

		$username = $request->get("username");
		$password = $request->get("password");

		if($this->get("au.ctr.User")->doAuth($username, sha1($password))){

	    	new \Strukt\Auth($username);
	       	return response()->json(array(

	            "success"=>true, 
	            "message"=>"User successfully authenticated."
	        ));
	    }
	
        return response()->json(array(

            "success"=>false,
            "message"=>"Failed to authenticate user!"
        ));
	}

	/**
	* @Route(/current/user)
	* @Method(POST)
	*/
	public function currentUser(Request $request){

		$username = $request->getUser();

		return new Response($username);
		// return new Response(sprintf("%s %s", $user->getUsername(), $user->getToken());
	}

	/**
	* @Route(/logout)
	* @Method(POST)
	*/
	public function logout(Request $request){

		$request->getSession()->invalidate();

		return "Successfully logged out.";
	}
}