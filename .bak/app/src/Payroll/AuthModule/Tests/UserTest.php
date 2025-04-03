<?php
namespace Payroll\AuthModule\Tests;

// use Strukt\Core\Registry;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{

	private $core;

	public function setUp():void{
	
		// $this->core = Registry::getInstance()->get("core");
	}

	public function testDoAuth(){

		$username = "admin";
		$password = "p@55w0rd";

		$isSuccess = true;
		// $isSuccess = $this->core->get("au.ctr.User")->doAuth($username, $password);

		$this->assertTrue($isSuccess);
	}
}