<?php
namespace MolecularConfig\config;
class Config{
	
	private $container;

	private $exceptionDir;

	public function __construct(){
		$this->container = [];
		$this->exceptionDir = [".",".."];
	}

	public function setConfig($config,$value = null){
		$this->container[$config] = $value;
	}

	public function getConfig($config){
		return $this->container[$config];
	}

	public function get($config){
		return $this->getConfig($config);
	}

	public function set($config,$value = null){
		$this->setConfig($config, $value);
	}

	public function loadArray($array,$prefix = ''){
		if(!is_array($array)) throw new \Exception("The config value is a not array", 1);

		foreach ($array as $key => $value) {
			$this->setConfig(($prefix != ''?$prefix.'.' : ''). $key,$value);
		}
	}

	public function loadFile($file,$prefix = null){
		if(!file_exists($file)) throw new \Exception("The config value is not a file", 1);
		$config = include_once $file;
		$path = pathinfo($file);
		$prefix = !empty($prefix)? $prefix.".".$path['filename'] : $path['filename'];
		if(is_array($config)){
			$this->loadArray($config,$prefix);
		}else{
			$this->setConfig($prefix, $config);
		}
	}

	public function loadFolder($folder,$prefix = ''){
		$files = scandir($folder);
		foreach ($files as $file) {
			if(in_array($file, $this->exceptionDir)) continue;
			$filePath = $folder.DIRECTORY_SEPARATOR.$file;
			if(is_file($filePath))$this->loadFile($filePath,$prefix);
			if(is_dir($filePath))$this->loadFolder($filePath,$file.$prefix);
		}	
	}

	public function getAll(){
		return $this->container;
	}

	public function all(){
		return $this->getAll();
	}
}