<?php

namespace Strukt\Package;

class PkgAuth implements \Strukt\Framework\Contract\Package{

	use \Strukt\Traits\ClassHelper;

	private $manifest;

	public function __construct(){

		$db = config("package.auth.default");

		$this->manifest = array(
			"cmd_name"=>"PkgAuth",
			"package"=>"pkg-auth",
			"files"=>array_map(fn($path)=>str($path)->prepend($db?ds($db):"")->yield(), array(
				"app/src/App/AuthModule/_AuthModule.sgf",
		        "app/src/App/AuthModule/Form/Permission.sgf",
		        "app/src/App/AuthModule/Form/User.sgf",
		        "app/src/App/AuthModule/Form/Role.sgf",
		        "app/src/App/AuthModule/Router/Permission.sgf",
		        "app/src/App/AuthModule/Router/User.sgf",
		        "app/src/App/AuthModule/Router/Index.sgf",
		        "app/src/App/AuthModule/Router/Auth.sgf",
		        "app/src/App/AuthModule/Router/Role.sgf",
		        "app/src/App/AuthModule/Controller/Permission.sgf",
		        "app/src/App/AuthModule/Controller/User.sgf",
		        "app/src/App/AuthModule/Controller/Role.sgf",
		        "app/src/App/Permission.sgf",
		        "app/src/App/User.sgf",
		        "app/src/App/RolePermission.sgf",
		        "app/src/App/Role.sgf"
			))
		);
	}

	public function getSettings($type):array{

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

	public function getName():string{

		return $this->manifest["package"];
	}

	public function getCmdName():string{

		return $this->manifest["cmd_name"];
	}

	public function getFiles():array|null{

		return $this->manifest["files"];
	}

	public function getModules():array|null{

		return null;
	}

	/**
	* Use php's class_exists function to identify a class that indicated your package is installed
	*/
	public function isPublished():bool{

		//This will return false because SomeClass::class shouldn't exists
		return class_exists($this->getClass("{{app}}\AuthModule\{{app}}AuthModule"));
	}

	public function getRequirements():array|null{
		
		return array(

			"pkg-db"
		);
	}
}