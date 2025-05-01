<?php

namespace Strukt\Package;

use Strukt\Fs as Filesystem;

/**
* @author Moderator <pitsolu@gmail.com>
*/
class PkgAuth implements \Strukt\Framework\Contract\Package{

	use \Strukt\Traits\ClassHelper;

	private $manifest;
	private $files;

	public function __construct(){

		$app_name = config("app.name");
		$db = config("package.auth.default");

		$this->files = [

			"app/src/App/AuthModule/_AuthModule.sgf",
	        "app/src/App/AuthModule/Form/Permission.sgf",
	        "app/src/App/AuthModule/Form/User.sgf",
	        "app/src/App/AuthModule/Form/Role.sgf",
	        "app/src/App/AuthModule/Router/Permission.sgf",
	        "app/src/App/AuthModule/Router/User.sgf",
	        "app/src/App/AuthModule/Router/Auth.sgf",
	        "app/src/App/AuthModule/Router/Role.sgf",
	        "app/src/App/AuthModule/Controller/Permission.sgf",
	        "app/src/App/AuthModule/Controller/User.sgf",
	        "app/src/App/AuthModule/Controller/Role.sgf",
	        "app/src/App/Permission.sgf",
	        "app/src/App/User.sgf",
	        "app/src/App/RolePermission.sgf",
	        "app/src/App/Role.sgf"
		];

		$this->manifest = array(

			"cmd_name"=>"PkgAuth",
			"package"=>"pkg-auth",
			"files"=>array_map(fn($path)=>str($path)->prepend($db?ds($db):"")->yield(), $this->files),
			"modules"=>array(
				"AuthModule"
			)
		);
	}

	/**
	 * @return void
	 */
	public function preInstall():void{

		//
	}

	/**
	 * @param string $type
	 * 
	 * @return array
	 */
	public function getSettings(string $type):array{

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

	/**
	 * @return string
	 */
	public function getName():string{

		return $this->manifest["package"];
	}

	/**
	 * @return string
	 */
	public function getCmdName():string{

		return $this->manifest["cmd_name"];
	}

	/**
	 * @return array|null
	 */
	public function getFiles():array|null{

		return $this->manifest["files"];
	}

	/**
	 * @return array|null
	 */
	public function getModules():array|null{

		return $this->manifest["modules"];
	}

	/**
	* Use php's class_exists function to identify a class that indicated your package is installed
	* 
	* @return bool
	*/
	public function isPublished():bool{

		$facet_classes = [

			"{{app}}\AuthModule\{{app}}AuthModule",
			"{{app}}\AuthModule\Form\Permission",
	        "{{app}}\AuthModule\Form\User",
	        "{{app}}\AuthModule\Form\Role",
	        "{{app}}\AuthModule\Router\Permission",
	        "{{app}}\AuthModule\Router\User",
	        "{{app}}\AuthModule\Router\Auth",
	        "{{app}}\AuthModule\Router\Role",
	        "{{app}}\AuthModule\Controller\Permission",
	        "{{app}}\AuthModule\Controller\User",
	        "{{app}}\AuthModule\Controller\Role",
	        "{{app}}\Permission",
	        "{{app}}\User",
	        "{{app}}\RolePermission",
	        "{{app}}\Role",
		];

		$self = $this;
		return (bool)arr($facet_classes)
						->each(fn($k,$class)=>class_exists($self->getClass($class)))
						->product();
	}

	/**
	 * @return array|null
	 */
	public function getRequirements():array|null{
		
		return array(

			"pkg-db"
		);
	}

	/**
	 * @return void
	 */
	public function postInstall():void{

		Filesystem::rmdir(".cache");
	}

	/**
	 * @deprecated In package:publish command but with folders instead of zip file
	 * 
	 * @return bool
	 */
	public function remove():bool{

		$app_name = config("app.name");
		$files = array_map(fn($path)=>str($path)
										->replace("/App/", sprintf("/%s/", $app_name))
										->replace(".sgf",".php")
										->replace("_", $app_name)
										->yield(), $this->files);

		$zip_name = str(ds(".bak"))
						->concat("pkg-auth--")
						->concat(today()->format("YmdHis"))
						->concat(".zip")
						->yield();

		$success = Filesystem::addZipList($zip_name, $files);
		if($success){

			$exempt[] = sprintf("%sAuthModule.php", $app_name);
			array_map(fn($file)=>negate(in_array(basename($file), $exempt))?Filesystem::rm($file):null, $files);
			Filesystem::rmdir(".cache");

			return true;
		}

		return false;
	}
}