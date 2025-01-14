<?php

namespace Strukt\Package;

class PkgAuth implements \Strukt\Framework\Contract\Package{

	use \Strukt\Traits\ClassHelper;

	private $manifest;

	public function __construct(){

		$this->manifest = array(
			"cmd_name"=>"PkgAuth",
			"package"=>"pkg-auth",
			"files"=>array(
				"app/src/App/AuthModule/_AuthModule.php",
		        "app/src/App/AuthModule/Form/Permission.php",
		        "app/src/App/AuthModule/Form/User.php",
		        "app/src/App/AuthModule/Form/Role.php",
		        "app/src/App/AuthModule/Router/Permission.php",
		        "app/src/App/AuthModule/Router/User.php",
		        "app/src/App/AuthModule/Router/Index.php",
		        "app/src/App/AuthModule/Router/Auth.php",
		        "app/src/App/AuthModule/Router/Role.php",
		        "app/src/App/AuthModule/Controller/Permission.php",
		        "app/src/App/AuthModule/Controller/User.php",
		        "app/src/App/AuthModule/Controller/Role.php",
		        "app/src/App/Permission.php",
		        "app/src/App/User.php",
		        "app/src/App/RolePermission.php",
		        "app/src/App/Role.php"
			)
		);
	}

	public function getSettings($type){

		$settings = array(
			"App:Cli"=>array(
				"providers"=>array(),
				"middlewares"=>array(),
				"commands"=>array()
			),
			"App:Idx"=>array(
				"providers"=>array(),
				"middlewares"=>array()
			)
		);

		return $settings[$type];
	}

	public function getName(){

		return $this->manifest["package"];
	}

	public function getCmdName(){

		return $this->manifest["cmd_name"];
	}

	public function getFiles(){

		return $this->manifest["files"];
	}

	public function getModules(){

		return null;
	}

	/**
	* Use php's class_exists function to identify a class that indicated your package is installed
	*/
	public function isPublished(){

		//This will return false because SomeClass::class shouldn't exists
		return class_exists($this->getClass("{{app}}\AuthModule\{{app}}AuthModule"));
	}

	public function getRequirements(){
		
		return array(

			"pkg-db"
		);
	}
}