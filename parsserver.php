
<?php error_reporting(0); ?>
<?php


class stack{
    protected $stack;
    protected $limit;

    public function __construct($limit = 1000) {
        $this->stack = array();
        $this->limit = $limit;
    }

    public function push($item) {
        if (count($this->stack) < $this->limit) {
            array_unshift($this->stack, $item);
        } else {
            throw new RunTimeException('Stack is full!'); 
        }
    }

    public function pop() {
        if ($this->isEmpty()) {
          throw new RunTimeException('Stack is empty!');
      } else {
            return array_shift($this->stack);
        }
    }

    public function top() {
        return current($this->stack);
    }

    public function isEmpty() {
        return empty($this->stack);
    }

}

class Parser  {
//input
    public $input=null;
    public $line =null;
 	private $index=-1;
      private $indexline=-1;
      private $linee=null;
      private $resarr=array();
    //Stack
   	public $strack;

    //Table of rules
    public $table=array(
        array("SS CD ES","SS CD ES",null,null,null,null,null,null,null,null, null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array("@","^",null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,"$","#",null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,"Type ID CD'",null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,"{ CI' CI }",null,"Infer { CI }", null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"FC CI",null,"EM",null,"Comment CI",null,null,null,"VD CI",
             "VD CI","VD CI","VD CI","VD CI","VD CI","VD CI","VD CI",null,null,null,null,null,null,"RC CI",null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"FC CI'",null,"EM",null,"Comment CI'",null,null,null,"MD CI'",
             "MD CI'","MD CI'","MD CI'","MD CI'","MD CI'","MD CI'","MD CI'",null,null,null,null,null,null,"RC CI'",null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null,null,null,null,null,"FD MD'",
            "FD MD'","FD MD'","FD MD'","FD MD'","FD MD'","FD MD'","FD MD'",null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"EM","{ VD STS }","EM",null,"EM",";",null,null,"EM",
             "EM","EM","EM","EM","EM","EM","EM",null,null,null,null,null,null,"EM",null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,"EM",null,null,null,null,null,"DT ID ( PL )",
             "DT ID ( PL )","DT ID ( PL )","DT ID ( PL )","DT ID ( PL )","DT ID ( PL )","DT ID ( PL )","DT ID ( PL )",null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null,null,null,null,null,"Ipok",
            "Sipok","Craf","Sequence","Ipokf","Sipokf","Valueless","Rational",null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null,null,null,null,"EM","NEL",
            "NEL","NEL","NEL","NEL","NEL","NEL","NEL",null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null,null,null,null,null,"DT ID NEL'",
            "DT ID NEL'","DT ID NEL'","DT ID NEL'","DT ID NEL'","DT ID NEL'","DT ID NEL'","DT ID NEL'","DT ID NEL'",null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,"EM",null,
             null,null,null,null,null,null,null,", DT ID NEL'",null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"EM",null,"EM",null,"EM",null,null,null,"DT IL ; VD",
            "DT IL ; VD","DT IL ; VD","DT IL ; VD","DT IL ; VD","DT IL ; VD","DT IL ; VD","DT IL ; VD","DT IL ; VD",null,null,null,null,null,null,"EM",null,"EM",null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"ID IL'",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,"EM",null,null,null,
             null,null,null,null,null,null,null,", ID IL'",null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"ID ( AL ) ;",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"NEAL",null,null,null, null,null,null,"EM",null,
             null,null,null,null,null,null,null,null,null,null,null,null,"NEAL",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"EX NEAL'",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"EX NEAL'",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,"EM",null,
             null,null,null,null,null,null,null,", EX NEAL'",null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"TE EX'",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"TE EX'",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
      array(null,null,null,null,null,"EM",null,"EM",null, null,"EM",null,"EM",null,
             null,null,null,null,null,null,null,"EM","AOP TE EX'","AOP TE EX'",null,null,"EM",null,null,null,null,
             null,"EM","EM","EM","EM","EM","EM","EM","EM",null,null,null,null),
      array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,"+","-",null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
      array(null,null,null,null,null,"FA TE'",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"FA TE'",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
      array(null,null,null,null,null,"EM",null,"EM",null, null,"EM",null,"EM",null,
            null,null,null,null,null,null,null,"EM","EM","EM","MOP FA TE'","MOP FA TE'","EM",null,null,null,null,
             null,"EM","EM","EM","EM","EM","EM","EM","EM",null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,"*","/",null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"ID",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"Number",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
        array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,"Require ( FN ) ;",null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,"STR",null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,"EM",null, null,null,null,null,"ST STS",
             "ST STS","ST STS","ST STS","ST STS","ST STS","ST STS","ST STS",null,null,null,null,null,null,null,null,"ST STS","ST STS",
             null,null,null,null,null,null,null,null,null,"ST STS","ST STS","ST STS","ST STS"),
       array(null,null,null,null,null,null,null,"EM",null, null,null,null,null,"AS",
             "AS","AS","AS","AS","AS","AS","AS",null,null,null,null,null,null,null,null,"AS","IS",
             null,null,null,null,null,null,null,null,null,"HS","WS","RS","ETS"),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,"VD = EX ;",
            "VD = EX ;","VD = EX ;","VD = EX ;","VD = EX ;","VD = EX ;","VD = EX ;","VD = EX ;",null,null,null,null,null,null,null,null,"VD = EX ;",
             null,null,null,null,null,null,null,null,null,null,null,null,null),       
       array(null,null,null,null,null,null,"{ STS }",null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),            
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,"If ( CE ) BS IS'",
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,"EM",null, null,null,null,null,"EM",
             "EM","EM","EM","EM","EM","EM","EM",null,null,null,null,null,null,null,null,"EM","EM",
             "Else BS",null,null,null,null,null,null,null,null,"EM","EM","EM","EM"),
       array(null,null,null,null,null,"CO CE'",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"CO CE'",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,"EM",null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,"COP CO","COP CO",null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,"&&","||",null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,"EX CMOP EX",null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"EX CMOP EX",null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,"==","!=",">",">=","<","<=",null,null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,"However ( CE ) BS",null,null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,"When ( EX ; EX ; EX ) BS",null,null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,"Respondwith EX ;",null),
       array(null,null,null,null,null,null,null,null,null, null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,
             null,null,null,null,null,null,null,null,null,null,null,null,"Endwith ;")    
    			/*array("is","other",null,null,null,null),
    			array("if e st es",null,null,null,null,null),
    			array(null,null,"else st",null,null,"em"),
    			array(null,null,null,"0","1",null)*/
			);

    public $terminals=array("@","^","$","#","Type","ID","{","}","Infer","Comment",";","(",")","Ipok","Sipok","Craf","Sequence",
                            "Ipokf","Sipokf","Valueless","Rational",",","+","-","*","/","Number","Require","STR","=","If",
                            "Else","&&","||","==","!=",">",">=","<","<=","However","When","Respondwith","Endthis");
    public $nonTers=array("PG","SS","ES","CD","CD'","CI","CI'","MD","MD'","FD","DT","PL","NEL","NEL'","VD","IL","IL'",
                          "FC","AL","NEAL","NEAL'","EX","EX'","AOP","TE","TE'","MOP","FA","RC","FN","STS","ST","AS",
                          "BS","IS","IS'","CE","CE'","COP","CO","CMOP","HS","WS","RS","ETS"); 
    
    //public $terminals=array("if","other","else","0","1","%");
	//public $nonTers=array("st","is","es","e"); 


	public function __construct($in ,$line)//run timme
	{
		
		$this->strack=new stack();
		
		$this->input=$in;
            $this->line=$line;
            //echo  $this->line ;
	}

	private function pushRule($rule)
	{
		$rule=explode(" ",$rule);
		for ($i=count($rule)-1; $i>=0; $i--) {

			$this->strack->push($rule[$i]);
			
		}
	}

	public function algorithm()
	{
        $this->strack->push("%");
        $this->strack->push("PG");
    //Read one token from input
    
    $token=$this->read();
    $this->linee=$this->readLine();
    //echo $token;
    $rule_in_print=null;
    $top=null;
    
    do
    {
        $top=$this->strack->pop();
        
        //if top is non-terminal
        if($this->isNonTerminal($top))
        {
            $rule_in_print=$top;
        	$rule=$this->getRule($top,$token);
        	$this->pushRule($rule);

        }
        else if($this->isTerminal($top)){
        if($top !=$token){
                     //$this->linee=$this->readLine();
        	         $this->resarr[]="$this->linee UN";
                     
		 	
		}
		else{//if match

    	
                  $this->resarr[]="$this->linee MA ".$rule_in_print;
      
		      $token = $this->read();
                  $this->linee=$this->readLine();
		//top=pop();
			}
    	}
        
        
    
    }while($top != "%");//out of the loop when %
    //echo "ss".$top .$token;
      return $this->resarr;
      
	}


	private function read() {
		$stwrdarr=explode(" ",$this->input);
        $this->index++;
        //echo "   ".$stwrdarr[$this->index];
        return $stwrdarr[$this->index];
        
    }
    private function readLine() {

            $stliner=explode(" ",$this->line);
        $this->indexline++;
       //  echo "   ".$stliner[$this->index];
        return $stliner[$this->index];
        
    }

    private function isNonTerminal($s)
    {
    	for ($i=0; $i <count($this->nonTers) ; $i++) { 
    			if ($s ==$this->nonTers[$i]){
    				return true;
    			}
    	}
    	
        return false;
    }


    private function isTerminal($s)
    {
    	for ($i=0; $i < count($this->terminals) ; $i++) { 
    			if ($s ==$this->terminals[$i]){
    				return true;
    			}
    	}
    	
        return false;
    }


    public function getRule($nonTerminal,$term)
    {
        
     $row = $this->getnonTermIndex($nonTerminal);
     $column = $this->getTermIndex($term);
     $rule = $this->table[$row][$column];
     //echo $rule."</br>";
    if($rule == null)
    { 
             //$this->linee=$this->readLine();
            $this->resarr[]="$this->linee UN";
            
          
    }

    return $rule;
    }

    private function getnonTermIndex($non) {
        for ($i=0; $i <count($this->nonTers) ; $i++) { 
            if ($non ==$this->nonTers[$i]){
                return  $i ;
                
            }
            //echo $non; 
        }
        //echo "error.";
     
       return -1;
    }

    private function getTermIndex($term) {
        for ($i=0; $i < count($this->terminals) ; $i++) { 
            if ($term ==$this->terminals[$i]){
                return $i ;
                
            }
            //echo $term;
        }
        //echo "Error1";
      
       return -1;
    }

}//end Class

function runPasrer($text,$lin){

            echo("<br>");
            $parser=new Parser($text,$lin);
            $result=$parser->algorithm();
            return $result;

            }


 ?>

