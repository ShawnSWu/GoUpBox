<?php

class rootMember{
	
	private $account,$program_type,$expireDate,$used_machine;
	
	
	function __construct($account,$program_type,$expireDate,$used_machine) {
        $this->account=$account;
	    $this->program_type=$program_type;
		$this->expireDate=$expireDate;
		$this->used_machine=$used_machine;
	}
	
	function getAccount(){
		return $this->account;
	}
			
	function getProgramType(){
		return $this->program_type;
	}
	
	function getExpireDate(){
		return $this->expireDate;
	}
	
	function getUsedMachine(){
		return $this->used_machine;
	}
}




?>