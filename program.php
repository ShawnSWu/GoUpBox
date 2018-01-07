<?php

class program {
	
	private $program_type,$price,$used_space_GB,$available_days;
	
	function __construct($program_type,$price,$used_space_GB,$available_days){
		$this->program_type=$program_type;
		$this->price=$price;
		$this->used_space_GB=$used_space_GB;
		$this->available_days=$available_days;
	}
	
	
	function getProgramType(){
		return $this->program_type;
	}

	function setProgramType($changeProgramType){
		$this->program_type=$changeProgramType;
	}
	
	function getPrice(){
		return $this->price;
	}

	function setPrice($changePrice){
		$this->price=$changePrice;
	}
	
	function getUsedSpaceGB(){
		return $this->used_space_GB;
	}

	function setUsedSpaceGB($changeUsedSpaceGB){
		$this->used_space_GB=$changeUsedSpaceGB;
	}
	
	function getAvailableDays(){
		return $this->available_days;
	}

	function setAvailableDays($changeAvailableDays){
		$this->available_days=$changeAvailableDays;
	}
	
	
	
}



?>