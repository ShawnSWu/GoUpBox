<?php

class MachineInfo{
	
	
	private $mid,$maxSpaceTb,$model;
	
	function __construct($mid,$maxSpaceTb,$model) {
       $this->mid=$mid;
	   $this->maxSpaceTb=$maxSpaceTb;
	   $this->model=$model;
	}
	
	function getMid(){
		return $this->mid;
	}
	
	function getMaxSpaceTb(){
		return $this->maxSpaceTb;
	}
	
	function getModel(){
		return $model->model;
	}
}
?>