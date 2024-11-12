<?php
/*---------------------------------------------------------
/ Class: Template
/ Author: Bryan Wood
/ Date: September 24, 2004
/ 
/ DEVELOPER NOTE: This class is designed to work with any 
/ number of template blocks defined similarly to that 
/ of PHPLIB and PEAR.
/
/ Instead of using a template class created by someone 
/ else; I decided to become a more effective PHP developer
/ by creating a template class of my own. I have designed 
/ this class to provide support for nested blocks used 
/ throughout a single file.
---------------------------------------------------------*/

class Template {
	//*****************************************************************************
	// Variable List Start
	//*****************************************************************************
	
	/*-------------------------------------------
	/ Regular Expression content used to identify 
	/ allowed words for names in the template
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/	
	var $wordReg = "";
	
	/*-------------------------------------------
	/ Regular Expression content used to identify 
	/ placeholder tags
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	var $placeHolder = "";
	var $placeHolderStart = "@{";
	var $placeHolderEnd = "}@sm";

    /*-------------------------------------------
    / Regular Expression Content used to identify
    / template block regions
    /---------------
    / ~Bryan Wood
    /------------------------------------------*/
    var $blockStart = "";
    var $blockFull = "";
    var $blockEnd = "";

	/*-------------------------------------------
	/ Holds all the template content to be parsed
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	var $tpl_content = "";
	var $tpl_parsed = "";
	
	/*-------------------------------------------
	/ Variable List to be used with template 
	/ placeHolders
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	var $var_list = array();	
	
	//*****************************************************************************
	// Variable List End
	//*****************************************************************************
	
	/*-------------------------------------------
	/ Class constructor 
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function Template(){
		$this->wordReg = "([0-9A-Z_]+)";
		$this->placeHolder = $this->placeHolderStart.$this->wordReg.$this->placeHolderEnd;
		$this->blockStart = "<!-- BEGIN ([a-zA-z0-9_]+)>";
		$this->blockEnd = "<!-- END ([a-zA-z0-9_]+)>";
		$this->blockFull = $this->blockStart."(.)+".$this->blockEnd;
	}
	
	/*-------------------------------------------
	/ Reads the template file into memory 
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function loadTemplateFile($filename){
		//open file to read in
		$fp = fopen($filename, "r");
		$this->tpl_content = fread($fp, filesize($filename));
		fclose($fp);
	}
	
	/*-------------------------------------------
	/ Loads passed variable into class memory
	/ loaded values will be passed into the parser
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function loadVar($name, $value){ 
		$variables = &$this->var_list; 
		$variables[$name] = $value; 
	}
	
	/*-------------------------------------------
	/ Clears all values from the current list
	/ enabling reuse of the currently loaded
	/ template file
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function unLoadVars(){
		$this->var_list = array();
	}
	
	/*-------------------------------------------
	/ Clears the current template and variables
	/ from memory.
	/ This allows the reuse of the template object
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function unLoadTemplate(){
		$this->tpl_content = "";
		$this->tpl_parsed = "";
		$this->unLoadVars();
	}
	/*-------------------------------------------
	/ Parses and prints out the template with
	/ the inserted variables
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function parseTpl(){
		//fetch template content into a temparary variable
		$output = $this->tpl_content;
		
		//collect the variables to be replaced in the template
		preg_match_all($this->placeHolder, $output, $regs); //builds array of matched variable names
		$regs = $regs[0];
		
		//clean variable string
		for($i = 0; $i < count($regs); $i++){
			$regs[$i] = substr($regs[$i], 1, strlen($regs[$i])-2);
		}
		
		//create the pattern and its replacement then insert all values for the template
		for($i = 0; $i < count($regs); $i++){
			$pattern = $this->placeHolderStart.$regs[$i].$this->placeHolderEnd;
			$replacement = ""; //insure that the replacement value is at least an empty string
			
			//prevent unknown variable error
			if(isset($this->var_list[strtolower($regs[$i])])){
				$replacement = $this->var_list[strtolower($regs[$i])];
			}
			
			$output = preg_replace($pattern, $replacement, $output);
		}
		
		$this->tpl_parsed = $output; //Store the final parsed result
		/*
			THIS NEEDS TO STORE THE OUTPUT VALUE SO ANOTHER FUNCTION CAN PROVIDE THE VALUE 
			WHEN REQUESTED
		*/
	}
		
	/*-------------------------------------------
    / Identifies finds sub-block templates and
    / parses the template when it is the root
    / block
    / NOTE: Will call itself if a sub-block can
    / be identified with-in the current block
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/       
    function parseTplAdvanced($rec_block){

        /*///OPERATION OUTLINE//// START //
        --/ID block
        --ereg stops on first parse out name
        ereg();
        --ereg blockFull using block_name for blockID
        ereg();
        --store full block in local var
        $ptpl_block = "";
        --/replace block with placeholder of block name
        --ereg and replace full block with a parse-able var_name
        ereg();
        parseTpl($ptpl_block);
        --/parse current block vars
        --use current template(block) var parse code
        parseVar();
        --/reparse block into template
        --//reuse current template(block) var parse code
        -----parse in block
        parseVar($ptpl_block);
        --////OPERATION OUTLINE//// END /*/

        //fetch template content into a temparary variable
		$output = $this->tpl_content;
		
		//collect the variables to be replaced in the template
		preg_match_all($this->placeHolder, $output, $regs); //builds array of matched variable names
		$regs = $regs[0];
		
		//clean variable string
		for($i = 0; $i < count($regs); $i++){
			$regs[$i] = substr($regs[$i], 1, strlen($regs[$i])-2);
		}
		
		//create the pattern and its replacement then insert all values for the template
		for($i = 0; $i < count($regs); $i++){
			$pattern = $this->placeHolderStart.$regs[$i].$this->placeHolderEnd;
			$replacement = ""; //insure that the replacement value is at least an empty string
			
			//prevent unknown variable error
			if(isset($this->var_list[strtolower($regs[$i])])){
				$replacement = $this->var_list[strtolower($regs[$i])];
			}
			
			$output = preg_replace($pattern, $replacement, $output);
		}
		
		//echo $output; //currently parse outputs the final parsed item this will be changed
		$this->tpl_parsed = $output; //Store the final parsed result
		/*
			THIS NEEDS TO STORE THE OUTPUT VALUE SO ANOTHER FUNCTION CAN PROVIDE THE VALUE 
			WHEN REQUESTED
		*/
	}
	
	/*-------------------------------------------
	/ Parses and prints out the template with
	/ the inserted variables
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function returnParsed(){
		return $this->tpl_parsed;
	}
}//end Template Class

?>
