<?php
namespace Payroll\AuthModule\Router;

use Strukt\Http\Request;
use Strukt\Http\Response\Plain as Response;
use Strukt\Framework\Contract\Router as AbstractRouter;

class Index extends AbstractRouter{

	/**
	* @Route(/)
	* @Method(GET)
	*/
	public function welcome(){
		
		return "</b>Strukt Works!<b>";
	}

	/**
	* @Route(/hello/world)
	* @Method(GET)
	*/
	public function helloWorld(){

		//return $this->core()->get("assets")->get("/index.html");
		return response()->body(fs("public/static")->cat("index.html"));
	}
	
	/**
	* @Route(/hello/{name:alpha})
	* @Method(GET)
	*/
	public function helloTo($name, Request $request){

		return sprintf("<b>Hello %s!</b>", $name);	
	}

	/**
	* @Route(/users/all)
	* @Permission(user_all)
	* @Method(GET)
	*/
	public function getAllUsers(){
		
		return $this->get("au.ctr.User")->getAll();
	}

	/**
	* @Route(/user)
	* @Method(GET)
	* @Auth()
	*/
	public function getUser(Request $request){

		$id = $request->query->get("id");

		return $this->get("au.ctr.User")->find($id);
	}

	/**
	* @Route(/test)
	* @Method(GET)
	*/
	public function testException(){

		throw new \RuntimeException("Whoops!");
	}	
}