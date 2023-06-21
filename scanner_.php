
<?php error_reporting(0); ?>
<?php

//use server\$Keywords;

define ("digit",["0","1","2","3","4","5","6","7","8","9"],true);

class TokenError{

 private $error_name="Illegal Character";
    private $details;
 public function __construct($detls){
  
  $this->details=$detls;
 }
 public function as_string(){

    $result= $this->details;
    return $result;
  }
}

class Token{

 public $type;
 public $value;

 public function __construct( $value ,$type,int $line){

  $this->type=$type;
  $this->value=$value;
  $this->line=$line;
 }
 public function to_string(){
 	
  echo "Line : ".$this->line."  "."Token Text:"."$this->type"." "."Token Type:"."$this->value";
 }

}
function isDigit($intCharacter){

 foreach (digit as $value) {
  if ($intCharacter==$value){
   return 1;
 } 
  }
  return 0;
  }

function isLetter($char){
 $bigch = range("A","Z");
 $bigch[]="_";
 $smalch=range("a","z");
 $Str[]=$bigch;
 $Str[]=$smalch;

 foreach ($Str as $value) {
  foreach ($value as $v){
      if ($char==$v){
    return 1;
    break;
      } 
  }
 }
 return 0;
}

class Lexem {
 private $line=1;
 private $columnPoint=-1;
 private $position;
 private $text;
 private $strword;
 private $current_char;
 private $tokens;
 private $errtokens;

 public function __construct($text){

  $this->errtokens=array();
  $this->tokens=array();
  $this->text=$text;
  $this->$strword="";
  $this->position=-1;
  $this->current_char=null;
  $this->totalerror=0;
  $this->advance();

 }
 public function advance(){

  $this->columnPoint+=1;//column every character
  $this->position+=1;
  if ($this->text[$this->position] !==null){ //! empty
         $this->current_char=$this->text[$this->position];
         //echo("a");
        } else
        {
         //echo("n");
         $this->current_char=null;}
         
    }

 

 public function back(){

  $this->columnPoint-=1;

  if ($this->text[--$this->position]!==null){
         $this->current_char=$this->text[$this->position];
        } else{
         $this->current_char=null;
        }

 }
 public function table_tokens($currentChar){

  			
		   
		   if (utf8_decode($currentChar)=="?"){//quotatMark
		   		$this->strword.=$currentChar;
		     	return "Accept";
		   }
		   elseif (isDigit($currentChar)){
		   		
		   		return $this->make_number();

		   }
		   
     
      		elseif($currentChar=="*"){
         		$this->strword.=$currentChar;
		   		$this->advance();
       			if($this->current_char=="*"){
        			$this->strword.=$this->current_char;
		   	  		$this->advance();

          		$this->make_comment();
       }
       else{
		   		if ($this->current_char==" " || $this->current_char=="\t"){
		   			$this->back();
		   			return "Accept";
		   		}
       }
     }
    
		   elseif($currentChar=="+" || $currentChar=="-" || $currentChar=="/"){
		   		$this->strword.=$currentChar;
		   		$this->advance();
		   		if ($this->current_char==" " || $this->current_char=="\t"){
		   			$this->back();
		   			return "Accept";
		   		}
		   }
		   elseif($currentChar=="(" || $currentChar==")"){
			$this->strword.=$currentChar;
			$this->advance();
			if ($this->current_char==" " || $this->current_char=="\t"){
			$this->back();
			return "Accept";
			}
			}
			elseif($currentChar==","){
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char==" " || $this->current_char=="\t"){
				$this->back();
				return "Accept";
				}
				}
		   elseif ($currentChar=="="){//transition for = ==
		   		$this->strword.=$currentChar;
		   		$this->advance();
				if ($this->current_char== "="){
					$this->strword.=$this->current_char;
				}else{
						$this->back();
					}
				$this->advance();
				if ($this->current_char==" " || $this->current_char=="\t"){
					$this->back();
					return "Accept";
				}
		   }//end ==


		   elseif ($currentChar =="[" || $currentChar=="]" ||
		   	$currentChar=="{" || $currentChar=="}" || $current_char==","){//trns braces
		   			$this->strword.=$currentChar;
					return "Accept";
			}//end {]}
			elseif ($currentChar =="^" || $currentChar=="@" || $currentChar=="#" || $currentChar=="$"){//trns smbo
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char==" " || $this->current_char=="\t"){
		   			$this->back();
		   			return "Accept";
		   		}
		   	}//end symbol

 
			elseif ($currentChar ==">" ){
			//trns < > =
 
				$this->strword.=$currentChar;
				$this->advance();
				 if ($this->current_char== "="){
					
					$this->strword.=$this->current_char;
					
				}else{
					
						
						$this->back();
					}

				$this->advance();
				 if ($this->current_char==" " || $this->current_char=="\t"){
					
					$this->back();
					return "Accept";
				}

			}//end < > = 
			elseif ($currentChar ==">" || $currentChar =="<"){
			//trns < > =

				
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char=="/") {

					$stat=$this->make_MultiComment();
					
				}
				elseif ($this->current_char== "="){
					
					$this->strword.=$this->current_char;
					
				}else{
					
						
						$this->back();
					}

				$this->advance();
				
				if ($this->current_char==" " || $this->current_char=="\t"){
						
						$this->back();
						return "Accept";
				}

			}//end < > =
			

			elseif ($currentChar =="!"){//trns !=
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char== "="){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char==" " || $this->current_char=="\t"){
						
							$this->back();
							return "Accept";
						}
				}else{
						$this->back();
					}
			}//end !=


			elseif ($currentChar =="&"){//trns &&
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char== "&"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char==" " || $this->current_char=="\t"){
									
						$this->back();
						return "Accept";
							}
				}else{
						$this->back();
					}

			}//end &&

			elseif ($currentChar =="|"){//trns ||
				$this->strword.=$currentChar;
				$this->advance();
				if ($this->current_char== "|"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char==" " || $this->current_char=="\t"){
									
						$this->back();
						return "Accept";
							}
				}else{
						$this->back();
					}
			}//end ||

			elseif ($currentChar =="~"){
				$this->strword.=$currentChar;
		   		$this->advance();
		   		if ($this->current_char==" " || $this->current_char=="\t"){
		   			$this->back();
		   			return "Accept";
		   		}
		   }

		   
		   		
   	//Require , Respondwith ,Rational
			elseif ($currentChar =="R"){
			 	$this->strword=$currentChar;
			 	$this->advance();
			   if ($this->current_char== "e"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char== "q"){
						return $this->make_Require();
					}
					elseif ($this->current_char== "s"){
						return $this->make_Respondwith();
					}
				}
				elseif ($this->current_char== "a"){
					return $this->make_Rational();
				}
			}
   
   //Craf , Conditionof
			elseif ($currentChar =="C"){
				$this->strword="C";
				$this->advance();
			    if ($this->current_char== "r"){
					    $this->strword.=$this->current_char;
				    	return $this->make_Craf();
			   }
			    elseif ($this->current_char== "o"){
					    $this->strword.=$this->current_char;
					    return $this->make_Conditionof();
			   }
			}
   
   	//Endthis , Else
			elseif ($currentChar =="E"){
				$this->strword="E";
				$this->advance();
			    if ($this->current_char== "l"){
				    	$this->strword.=$this->current_char;
					    return $this->make_Else();
			   }
			    elseif ($this->current_char== "n"){
					    $this->strword.=$this->current_char;
					    return $this->make_Endthis();
			   }
			}
   
   	//Srap , Sipok , Sipokf , Sequence ,Scan
			elseif ($currentChar =="S"){
				 $this->strword="S";
			 	$this->advance();
				    if ($this->current_char== "r"){
			       	$this->strword.=$this->current_char;
					      return $this->make_Srap();
				}
			     elseif ($this->current_char== "i"){
				      $this->strword.=$this->current_char;
				      return $this->make_Sipok();
			   }
			     elseif ($this->current_char== "e"){
				      $this->strword.=$this->current_char;
				      return $this->make_Sequence();
			   }
			     elseif ($this->current_char== "c"){
				       $this->strword.=$this->current_char;
				       return $this->make_Scan();
			   }
			}
   
   	//Ipok , Ipokf ,Infer , If
			elseif ($currentChar=="I"){
				$this->strword="I";
				$this->advance();
			   if ($this->current_char== "p"){
				    $this->strword.=$this->current_char;
				    return $this->make_Ipok();
			   }
			   elseif ($this->current_char== "n"){
			     	$this->strword.=$this->current_char;
			      return $this->make_Infer();
			   }
			   elseif ($this->current_char== "f"){
				     $this->strword.=$this->current_char;
				     return $this->make_If();
			   }
			}
   
   	//Type
			elseif ($currentChar =="T"){
				 $this->strword="T";
				 return $this->make_Type();
			}
   
   //Valueless
			elseif ($currentChar =="V"){
				 $this->strword="V";
				 return $this->make_Valueless();
			}
   
   	//However
			elseif ($currentChar =="H"){
				 $this->strword="H";
				 return $this->make_However();
			}
   
   	//When
			elseif ($currentChar =="W"){
			  $this->strword="W";
				 return $this->make_When();
			}
			   
   

		    else{
		   		//echo $currentChar;
		   		if (isLetter($currentChar)){
		   			 $this ->make_identifer();
      
		   		}else{
		   		$this->strword.=$currentChar;
		   		return "err";
		   	}
		}
        
		   
	}//end Fun

	

		 public function FunctionName($states){

		 	$Keywords=array("Type"=>"Class","Infer"=>"Inheritance","If"=>"Condition","Else"=>"Condition","Ipok"=>"Integer","Sipok"=>"SInteger","Craf"=>"Character","Sequence"=>"String","Ipokf"=>"Float","Sipokf"=>"SFloat",
   "Valueless"=>"Void","Rational"=>"Boolean","Endthis"=>"Break","However"=>"Loop","When"=>"Loop","Respondwith"=>"Return",
   "Srap"=>"Struct","Scan"=>"Switch","Conditionof"=>"Switch","Sequence"=>"String","@"=>"Start Symbol","^"=>"Start Symbol",
   "*"=>"Arithmetic Operation","+"=>"Arithmetic Operation","/"=>"Arithmetic Operation","-"=>"Arithmetic Operation",
   "&&"=>"Logical Operator","||"=>"Logical Operator","~"=>"Logical Operator","=="=>"relational operators","#"=>"End Symbol",
   "!="=>"relational operators",">"=>"relational operators","<"=>"relational operators",">="=>"relational operators",
   "<="=>"relational operators","="=>"Assignment operator","->"=>"Access operator","{"=>"Braces","["=>"Braces",
   "}"=>"Braces","]"=>"Braces","Require"=>"Inclusion","“"=>"Quotation Mark","’"=>"Quotation Mark","$"=>"End Symbol","("=>"paranthis",")"=>"pararthis",","=>"comma");
    
		 	switch ($states){

		   	case "Accept":{
		   		//echo $this->strword;

		   		if (isDigit($this->strword[0])){
		   			$this->tokens[]=new Token("NUMBER",$this->strword,$this->line);
		   		}
        elseif($this->strword[0]=="<"&& $this->strword[1]=="/"){
		   			$this->tokens[]=new Token("COMMENT",$this->strword,$this->line);
		   		}
     
       
       	else{

       		  $this->tokens[]=new Token($Keywords[$this->strword],$this->strword,$this->line);
           }
           
          
		   		break;
		   	} 
		   	default:{
		   		$this->errtokens[]=new TokenError("Line #:$this->line "."col:$this->columnPoint"."&emsp;"."Error in Token Text: ".$this->strword);//err
		   		$this->totalerror+=1;
		   		break;
		   		
		   }//end Switch
		 }

   }
		public function check_tokens(){
			$state="";
			while ($this->current_char!= null || $this->current_char !=""){
				
				if ($this->current_char==" " || $this->current_char=="\t"){
					$this->FunctionName($state);
					$this->strword="";
					$this->advance();

				}elseif ($this->current_char=="\n") {
					$this->advance();
							$this->columnPoint=0;//better ev tm repeat
							$this->line+=1;	
							continue;
				}
				 else if( $this->current_char==";"){
				 	$this->tokens[]=new Token("semi",";",$this->line);
					$this->advance();
					if ($this->current_char=="\n"){
							
							$this->advance();
							$this->columnPoint=0;//better ev tm repeat
							$this->line+=1;	
							continue;
						}
					}
				else{	
				$state=$this->table_tokens($this->current_char);
				//echo $state;
					$this->advance();
					
				}

			}//endWhile
			//$this->FunctionName($state);
			
			return array($this->errtokens,$this->tokens,$this->totalerror);

		}//endFun
  
  
  public  function make_Respondwith(){
		 
		if ($this->current_char== "s"){
		    $this->strword .=$this->current_char;
		    $this->advance();
		    if ($this->current_char== "p"){
				$this->strword .=$this->current_char;
				$this->advance();
				if ($this->current_char== "o"){
					$this->strword .=$this->current_char;
					$this->advance();
					if ($this->current_char== "n"){
						$this->strword .=$this->current_char;
						$this->advance();
						if ($this->current_char== "d"){
							$this->strword .=$this->current_char;
							$this->advance();
							if ($this->current_char== "w"){
								$this->strword .=$this->current_char;
								$this->advance();
								if ($this->current_char== "i"){
									$this->strword .=$this->current_char;
									$this->advance();
									if ($this->current_char== "t"){
										$this->strword .=$this->current_char;
										$this->advance();
										if ($this->current_char== "h"){
											$this->strword .=$this->current_char;
											return "Accept";
										   }
									  }
								  }
							  }
						  }
						}
					}
				}
			}
	}
 
 
  public  function make_Require(){
		if ($this->current_char== "q"){
			$this->strword .=$this->current_char;
			$this->advance();
			if ($this->current_char== "u"){
				$this->strword.=$this->current_char;
				$this->advance();
				if ($this->current_char== "i"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char== "r"){
						$this->strword.=$this->current_char;
						$this->advance();
						if ($this->current_char== "e"){
							$this->strword.=$this->current_char;
								return "Accept";
									}
						}
					}
				}
			}
	}
 
 
  public  function make_Rational(){
	if ($this->current_char== "a"){
		$this->strword.=$this->current_char;
		$this->advance();
		if ($this->current_char== "t"){
			$this->strword.=$this->current_char;
		    $this->advance();
			if ($this->current_char== "i"){
				$this->strword.=$this->current_char;
				$this->advance();
				if ($this->current_char== "o"){
				    $this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char== "n"){
						$this->strword.=$this->current_char;
						$this->advance();
						if ($this->current_char== "a"){
							$this->strword.=$this->current_char;
							$this->advance();
							if ($this->current_char== "l"){
								$this->strword.=$this->current_char;
									return "Accept";
									}
								}
							}		
						}
					}
				}
		}
	}
 
 
  public function make_Craf(){
	   
		$this->advance();
		if ($this->current_char== "a"){
			$this->strword.=$this->current_char;
			$this->advance();
			if ($this->current_char== "f"){
				$this->strword.=$this->current_char;
				return "Accept";
				}							
		}
  }
  
  
  public  function make_Endthis(){
		
		$this->advance();
	    if ($this->current_char== "d"){
			$this->strword.=$this->current_char;
			$this->advance();
			if ($this->current_char== "t"){
				$this->strword.=$this->current_char;
				$this->advance();
				if ($this->current_char== "h"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char== "i"){
						$this->strword.=$this->current_char;
						$this->advance();
						if ($this->current_char== "s"){
							$this->strword.=$this->current_char;
										return "Accept";
									}
								}
							}
						}
					}
    }
    
    
  public function make_Srap(){
		$this->advance();
			 if ($this->current_char== "a"){
				 $this->strword.=$this->current_char;
				 $this->advance();
					 if ($this->current_char== "p"){
					  $this->strword.=$this->current_char;
					  return "Accept";
						 $this->advance();
					 }							
			 }
	}
 
 
 
  	public  function make_Sipok(){
		$this->advance();
				if ($this->current_char== "p"){
				   $this->strword.=$this->current_char;
				   $this->advance();
					   if ($this->current_char== "o"){
					     $this->strword.=$this->current_char;
					     $this->advance();
									if ($this->current_char== "k"){
										$this->strword.=$this->current_char;
										$this->advance();
										if ($this->current_char== "f"){
											$this->strword.=$this->current_char;
											return "Accept";
											$this->advance();
										}
										$this->back();
										return "Accept";
									}
					}
				}
	}
 
 
  	public  function make_Ipok(){
		  $this->advance();
					if ($this->current_char== "o"){
					  $this->strword.=$this->current_char;
					  $this->advance();
									if ($this->current_char== "k"){
										$this->strword.=$this->current_char;
										$this->advance();
										if ($this->current_char== "f"){
											$this->strword.=$this->current_char;
											return "Accept";
											$this->advance();
										}
										$this->back();
										return "Accept";
									}
					}
	}
 
 
  	public  function make_Infer(){
	  	$this->advance();
					if ($this->current_char== "f"){
					  $this->strword.=$this->current_char;
					  $this->advance();
									if ($this->current_char== "e"){
										$this->strword.=$this->current_char;
										$this->advance();
										if ($this->current_char== "r"){
											$this->strword.=$this->current_char;
											return "Accept";
											$this->advance();
										}
									}
					}
	}
 
 
  	public  function make_Sequence(){
		  $this->advance();
					if ($this->current_char== "q"){
					  $this->strword.=$this->current_char;
					  $this->advance();
									if ($this->current_char== "u"){
										$this->strword.=$this->current_char;
										$this->advance();
										if ($this->current_char== "e"){
											$this->strword.=$this->current_char;
											$this->advance();
											if ($this->current_char== "n"){
											  $this->strword.=$this->current_char;
											  $this->advance();
											   if ($this->current_char== "c"){
												   $this->strword.=$this->current_char;
												   $this->advance();
										       if ($this->current_char== "e"){
													      $this->strword.=$this->current_char;
													return "Accept";
													$this->advance();
										      	  } 
											   } 
											}
										}
									}
					}
	}
 
 
  public function make_Type(){
		$this->advance();
		 if ($this->current_char== "y"){
			 $this->strword.=$this->current_char;
			 $this->advance();
			 if ($this->current_char== "p"){
				 $this->strword.=$this->current_char;
				 $this->advance();
					 if ($this->current_char== "e"){
					  $this->strword.=$this->current_char;
					  return "Accept";
						 $this->advance();
					 }							
			 }
		 }
	 }
  
  
  public function make_constant(){ // make digit or float digit 
		
		$dot_str=".";
		$dot_count=0;
		while ($this->current_char !=null and isDigit($this->current_char) ||$this->current_char== $dot_str){

			if ($this->current_char===$dot_str){

				if ($dot_count==1){Break;}
				$dot_count+=1;
			}
			

			$this->strword.=$this->current_char;
			$this->advance();
			}

			
			return "Accept";		
	}
 
 
  	public  function make_Valueless(){
		  $this->advance();
		  if ($this->current_char== "a"){
		        $this->strword.=$this->current_char;
		        $this->advance();
				if ($this->current_char== "l"){
				  $this->strword.=$this->current_char;
				  $this->advance();
					if ($this->current_char== "u"){
					  $this->strword.=$this->current_char;
					  $this->advance();
						if ($this->current_char== "e"){
						  $this->strword.=$this->current_char;
						  $this->advance();
						  if ($this->current_char== "l"){
							   $this->strword.=$this->current_char;
						    	$this->advance();
							if ($this->current_char== "e"){
								$this->strword.=$this->current_char;
								$this->advance();
								if ($this->current_char== "s"){
									$this->strword.=$this->current_char;
									$this->advance();
										if ($this->current_char== "s"){
											$this->strword.=$this->current_char;
											return "Accept";
											   $this->advance();
										   }
								  }
							  }
						  }
						}
					}
				}
			}
	}
 
 
  public  function make_However(){
		$this->advance();
		if ($this->current_char== "o"){
			$this->strword.=$this->current_char;
			$this->advance();
				if ($this->current_char== "w"){
				 $this->strword.=$this->current_char;
				  $this->advance();
					if ($this->current_char== "e"){
					  $this->strword.=$this->current_char;
					  $this->advance();
						if ($this->current_char== "v"){
						  $this->strword.=$this->current_char;
						  $this->advance();
						  if ($this->current_char== "e"){
						    	$this->strword.=$this->current_char;
						    	$this->advance();
									if ($this->current_char== "r"){
										$this->strword.=$this->current_char;
										return "Accept";
										$this->advance();
									}
						  }
						}
					}
				}
			}
	}
 
 
  	public  function make_When(){
		  $this->advance();
		  if ($this->current_char== "h"){
		    $this->strword.=$this->current_char;
			   $this->advance();
				if ($this->current_char== "e"){
				   $this->strword.=$this->current_char;
				   $this->advance();
									if ($this->current_char== "n"){
										$this->strword.=$this->current_char;
										return "Accept";
										$this->advance();
									}
				}
			}
	}
 
 
  public  function make_If(){
			 return "Accept";
			 $this->advance();
	}
 
 
  public function make_Else(){

		$this->advance();
		if ($this->current_char== "s"){
			$this->strword.=$this->current_char;
			$this->advance();
			if ($this->current_char== "e"){
				$this->strword.=$this->current_char;
				return "Accept";
					 }
				}							
	}
 
 
  	public function make_Scan(){
		 $this->advance();
			 if ($this->current_char== "a"){
				 	$this->strword.=$this->current_char;
				  $this->advance();
					 if ($this->current_char== "n"){
					 	$this->strword.=$this->current_char;
					  return "Accept";
						 $this->advance();
					 }							
			 }
	}
 
 
    public  function make_Conditionof(){
		$this->advance();
		if ($this->current_char== "n"){
		    $this->strword.=$this->current_char;
		    $this->advance();
			if ($this->current_char== "d"){
				$this->strword.=$this->current_char;
				$this->advance();
				if ($this->current_char== "i"){
					$this->strword.=$this->current_char;
					$this->advance();
					if ($this->current_char== "t"){
						$this->strword.=$this->current_char;
						$this->advance();
						if ($this->current_char== "i"){
							$this->strword.=$this->current_char;
							$this->advance();
							if ($this->current_char== "o"){
								$this->strword.=$this->current_char;
								$this->advance();
								if ($this->current_char== "n"){
									$this->strword.=$this->current_char;
									$this->advance();
									if ($this->current_char== "o"){
										$this->strword.=$this->current_char;
										$this->advance();
										if ($this->current_char== "f"){
											$this->strword.=$this->current_char;
											return "Accept";
										   }
									}
								  }
							  }
						  }
						}
					}
				}
			}
	}


	public function make_number(){ // make digit or float digit 
		  
		  $dot_str=".";
		  $dot_count=0;
		  $E_count=0;
		  $plus_count=0;
		  $state=null;
		  
		  while ( (isDigit($this->current_char)||
		   $this->current_char== $dot_str || $this->current_char=="E" ||
		  $this->current_char=="+" || $this->current_char=="-")){//Accept state 2 or 4
		   
		   if (isDigit($this->current_char)){
		    $state="Accept";
		    $this->strword.=$this->current_char;
		       $this->advance();
		   }
		    elseif ($this->current_char==$dot_str){
		      	if ($dot_count==1){
		     		$state="notAccept";
		     		break;//err
		      }
		     $state="waitAccept";
		     $dot_count+=1;
		     $this->strword.=$this->current_char;
		       $this->advance();
		     }
		    elseif ($state=="waitAccept" && $this->current_char=="E"){
		     if ($E_count==1){
		     $state="notAccept";
		     break;//err
		      }
		     $state="SwaitAccept";//e+-
		     $E_count+=1;
		     $this->strword.=$this->current_char;
		       $this->advance();
		    }
		    elseif ($state=="SwaitAccept" && ($this->current_char=="+" ||$this->current_char=="-")){
		      if ($plus_count==1){
		     $state="notAccept";
		     break;//err
		      }
		     $state="waitAccept";//e+-
		     $plus_count+=1;
		     $this->strword.=$this->current_char;
		       $this->advance();
		    }

		    elseif ($state=="waitAccept" && isDigit($this->current_char)){
		       $state="Accept";
		       $this->strword.=$this->current_char;
		           $this->advance();
		     }
		     else{
		      $state="notAccept";
		      break;//err
		     }


		  }//End loop

		  if ($state =="notAccept"){
		  while ($this->current_char!=" ") {
			  
			  	$this->advance();
		  }
		  $this->back();
		  return $state;
		}
			$this->back();
		  	return $state;

		 }

	public function make_identifer(){
		  
		  $state="";

		  while ($this->current_char!=null and $this->current_char!=" "){

		   if (isLetter($this->current_char) || isDigit($this->current_char)){
		    $state="Accept";
		   }
		   else{
		    $state="Error";
		    break;
		   }
		   $this->strword.=$this->current_char;
		   $this->advance();
		  }
		  	$this->tokens[]=new Token("ID",$this->strword,$this->line);
		  	$this->advance;
		  	$this->strword="";
      		
 		}


 public function make_comment(){
 		$state="error";
 			if ($this->current_char=="*") {
 				while ($this->current_char !="\n") {
 					$this->strword.=$this->current_char;
 					$this->advance();
 				}
 				
 				$state= "Accept";

 			}

 		if ($state=="error"){//because check after ev space
 		while ($this->current_char!=" ") {
			  	
			  	$this->advance();
		  }
		
		  
		}
		$this->tokens[]=new Token("COMMENT",$this->strword,$this->line);
		$this->advance();

		$this->strword = "" ;

 	}
    
	 public function make_MultiComment(){

		$state="error";
 		$this->strword.=$this->current_char;
 		$this->advance();
   		while (true) {

           $this->strword.=$this->current_char;
 	       $this->advance();
           if($this->current_char=="/"){
            	$this->strword.=$this->current_char;
 	    		$this->advance();
            	if( $this->current_char==">"){
            		$this->strword.=$this->current_char;
          			$state= "Accept";
          			break;
          }
        }
    }

		return $state;
	}
 

	}//end Class


		function runScanner($text){

		echo("<br>");
		$lexer=new Lexem($text);
		$result=$lexer->check_tokens();
		return $result;


		}

		?>

