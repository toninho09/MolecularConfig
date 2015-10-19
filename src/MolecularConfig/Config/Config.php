<?php
namespace MolecularConfig\config;
class Config{
	
	private $container;

	public function _contruct(){
		$this->container = [];
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
		if(!is_array($array)) throw new Exception("The config value is a not array", 1);

		foreach ($array as $key => $value) {
			$this->setConfig(($prefix != ''?$prefix.'.' : ''). $key,$value);
		}
	}

	public function loadFile($file){
		if(!file_exists($file)) throw new Exception("The config value is not a file", 1);
		$config = include_once $file;
		$path = pathinfo($file);
		if(is_array($config)){
			$this->loadArray($config,$path['filename']);
		}else{
			$this->setConfig($path['filename'], $config);
		}
	}

	public function getAll(){
		return $this->container;
	}

	public function all(){
		return $this->getAll();
	}
}