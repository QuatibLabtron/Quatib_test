<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  ======================================= 
 *  Author     : Team Tech Arise 
 *  License    : Protected 
 *  Email      : info@techarise.com 
 * 
 *  ======================================= 
 */
require_once APPPATH . "/third_party/PHPExcel.php";
class Excel extends PHPExcel 
{

	var $excelCellRowIndex  = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");  //Excel Column Index Array  

    var $startRowIndex      = 0; //Skip the row from top of the excel page

    var $excelFormat        = "xls"; //default excel page format

    var $freezCol           = 1; //set default freeze coloumn position

    var $dataEvenColor      = "EAF1F8"; //alternative class even color TRM 07/04/2012

    var $dataOddColor       = "FFFFFF"; //alternative class odd color  TRM 07/04/2012

    var $headerBGColor      = "AEDAF3"; //Default header BG Color  TRM 07/04/2012

    var $headerFontColor    = "000000"; //Default header fone color  TRM 07/04/2012

    var $headerBorderColor  = "999999"; //Default header border color  TRM 07/04/2012

    var $dataBorderColor    = "DADCDD"; //Default data cell border Color  TRM 07/04/2012

    var $dataColumnWise    	= 0; //Default it writes row first else will write column first TRM 07/04/2012

    var $hyperLinkColor    	= "0b03fa"; //hyperlink color TRM 13/04/2012

	

	var $dataSentColor		= '87CEFA'; //Default Quote status color  TRM 29/01/2013

	var $dataUnSentColor	= 'FFFF99'; //Default Quote status color  TRM 29/01/2013

	var $dataAcceptedColor	= '88ca88'; //Default Quote status color  TRM 29/01/2013

	var $dataRejectedColor	= 'e67399'; //Default Quote status color  TRM 29/01/2013

    var $dataScheduledColor	= 'd1e4f2'; //Default Quote status color  TRM 29/01/2013

    public function __construct() 
    {
        parent::__construct();
    }

    function init_default_param($arrDefault = array())
    {
        if(is_array($arrDefault))
        {
            if(count($arrDefault)>0)
            {
                 foreach($arrDefault as $key=>$value)
                 {
                    $this->$key = $value;
                 }
            } 
        }
    }

    function generatesDynamicColoumn($run_cols_set = 1)
    {
        if($run_cols_set>0)
        {
              $cellIndex = 26;
              
            for($k = 0 ; $k < $run_cols_set; $k++)
            {
                for($appendChar = 0 ; $appendChar < 26; $appendChar++)
                {

                  $prefix = $this->excelCellRowIndex[$k];

                  $this->excelCellRowIndex[$cellIndex] = $prefix .$this->excelCellRowIndex[$appendChar];

                  $cellIndex++;

                }
            }
        }
    }

}


?>