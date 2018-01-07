<?php

class Member{
	
	private $account,$password,$email,$phone,$programType,$enableTime,$usedMachine;
	
	function __construct($account,$password,$email,$phone,$programType,$enableTime,$usedMachine) {
       $this->account=$account;
	   $this->password=$password;
	   $this->email=$email;
	   $this->phone=$phone;
	   $this->programType=$programType;
	   $this->programType=$programType;
	   $this->enableTime=$enableTime;
	   $this->usedMachine=$usedMachine;
    }
	
		function getAccount(){
			return $this->account;
		}
			
		function setPhone($changePhone){
			$this->phone=$changePhone;
		}
			
		function getPhone(){
			return $this->phone;
		}
				
		function setEmail($changeEmail){
			$this->email=$changeEmail;
		}
		
		function getEmail(){
			return $this->email;
		}
		
		
		function setPassword($changePassword){
			$this->password=$changePassword;
		}
		
		function getPassword(){
			return $this->password;
		}
		
		
		function setProgramType($changeProgramType){
			$this->programType=$changeProgramType;
		}
		
		function getProgramType(){
			return $this->programType;
		}
		
		
		function setEnableTime($changeEnableTime){
			$this->enableTime=$changeEnableTime;
		}
		
		function getEnableTime(){
			return $this->enableTime;
		}
	
		function setUsedMachine($changeUsedMachine){
			$this->usedMachine=$changeUsedMachine;
		}
		
		function getUsedMachine(){
			return $this->usedMachine;
		}
	
}



?>