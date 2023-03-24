<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Pdf.php
*
* Version: 1.0.0
*
* Author: Pedro Ruiz Hidalgo
*		  ruizhidalgopedro@gmail.com
*         @pedroruizhidalg
*
* Location: application/third_party/fpdf/libraries/Pdf.php
*
* Created:  2018-02-27
*
* Description:  This manages FPDF
*
* Requirements: PHP5 or above
*
*/

define('FPDF_FONTPATH', APPPATH . 'libraries/fpdf184/font');

require_once APPPATH . 'libraries/fpdf184/tfpdf.php';

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

function resizeToFit($imgFilename) {
	if (getimagesize($imgFilename) == false)
		return false;

	list($width, $height) = getimagesize($imgFilename);
	$widthScale = 2.5*70 / $width; //70mm
	$heightScale = 2.5*50 / $height; //50mm

	$scale = min($widthScale, $heightScale);

	return array(
		round(px2mm($scale * $width)),
		round(px2mm($scale * $height))
	);
}

class PDF_HTML extends tFPDF
{
    //variables of html parser
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;
	protected $ALIGN='';
    protected $fontList;
    protected $issetfont;
    protected $issetcolor;
	function __construct($orientation='P', $unit='mm', $format='A4')
	{
		//Call parent constructor
		parent::__construct($orientation,$unit,$format);

		//Initialization
		$this->B=0;
		$this->I=0;
		$this->U=0;
		$this->HREF='';
		$this->ALIGN='';


		$this->tableborder=0;
		$this->tdbegin=false;
		$this->tdwidth=0;
		$this->tdheight=0;
		$this->tdalign="L";
		$this->tdbgcolor=false;
		$this->pbegin = false;

		$this->oldx=0;
		$this->oldy=0;

		$this->fontlist=array("arial","times","courier","helvetica","symbol");
		$this->issetfont=false;
		$this->issetcolor=false;
		$this->col = 0; // thứ tự cột; cột đầu tiên là 1
		$this->row = 0; // thứ tự dòng, dòng đầu tiên là 1; là header của table;
	}

	//////////////////////////////////////
	//html parser

	function WriteHTML($html)
	{
		//var_dump($html);
		$html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><th><table><sup>"); //remove all unsupported tags
		//var_dump($html); die();
		$html=str_replace("<th>",'<td>',$html);
		$html=str_replace("</th>",'</td>',$html);
		$html=str_replace("\n",'',$html); //replace carriage returns with spaces
		$html=str_replace("\t",'',$html); //replace carriage returns with spaces
		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explode the string
		//var_dump($a); die();
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				//Text, giừa các thẻ có ký tự "".
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				elseif($this->tdbegin) { // khi item trước đó là thẻ <td>, giá trị $e là giá trị thẻ td
					//echo $e;
					/*
					if($this->row > 1)
					{
						if($this->col == 2)
						{
							$_x = $this->getX();
							$_y = $this->getY();
							$this->SetXY($_x + 70,$_y);
						}
					}*/
					if(trim($e)!='' && $e!="&nbsp;") {
						if($this->row == 1)
						{
							$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
						} else {
							if($this->col == 2)
							{
								$_xLocal = $this->getX();
								$_yLocal = $this->getY();
								$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
								$this->setXY($_xLocal,$_yLocal);
								$this->MultiCell($this->tdwidth,8,$e,0,'J');
								$this->setXY($_xLocal + 70,$_yLocal);
							} else{
								$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
							}
						}
					}
					elseif($e=="&nbsp;") {
						$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
					}
				}
				else
					$this->Write(5,stripslashes(txtentities($e)));
			}
			else
			{
				//Tag
				//echo $e . '</br>';
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					//Extract attributes
					$a2=explode(' ',$e);
					$tag=strtoupper(array_shift($a2));
					
					$attr=array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])]=$a3[2];
					}
					
					$this->OpenTag($tag,$attr);
				}
			}
		}
		//die();
	}

	function header_table()
	{
		$e = array(
			1=>'Hình ảnh cần cải tiến',
			2=>'Mô tả vấn đề',
			3=>'Kết luận'
		);
		$this->Cell(70,8,$e[1],1,0,'C',1);
		$this->Cell(70,8,$e[2],1,0,'C',1);
		$this->Cell(20,8,$e[3],1,0,'C',1);
	}

	function OpenTag($tag, $attr = null)
	{
		//Opening tag
		switch($tag){

			case 'SUP':
				if( !empty($attr['SUP']) ) {    
					//Set current font to 6pt     
					$this->SetFont('','',6);
					//Start 125cm plus width of cell to the right of left margin         
					//Superscript "1" 
					$this->Cell(2,2,$attr['SUP'],0,0,'L');
				}
				break;

			case 'TABLE': // TABLE-BEGIN
				$this->row = 0;
				$this->col = 0;				
				$this->tableborder=1;
				$this->SetDrawColor(224, 220, 220);
				$this->SetFont('VnTimesB','B',14);
				break;
			case 'TR': //TR-BEGIN
				$this->col = 0;
				$this->row++;
				//echo 'Vào '.$this->row;
				$this->tdbegin = false;
				// Lấy ví trí hiện tại
				$_x = $this->getX();
				$_y = $this->getY();
				if($_y + 70 > 297)
				{
					$this->AddPage();
					//$this->row = 1;
					$this->col = 0;
					$this->tableborder=1;
					$this->SetDrawColor(224, 220, 220);
					$this->SetFont('VnTimesB','B',14);
					$this->header_table();
					$this->Ln();
					
				}

				break;
			case 'TD': // TD-BEGIN
				$this->col++;
				//echo '[';
				//if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
				//else { 
					if($this->col ==1)
					{
						$this->tdwidth=70; // Set to your own width if you need bigger fixed cells
					} elseif($this->col == 2)
					{
						$this->tdwidth=70;
					} else {
						$this->tdwidth=20;
					}
				//}
				/*if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
				else {
					if($this->row == 1)
					{
						$this->tdheight=10; // Set to your own height if you need bigger fixed cells
					} else{
						$this->tdheight=50; // Set to your own height if you need bigger fixed cells
					}
				} */
				
				if($this->row == 1) // dòng đầu tiên. 
				{
					$this->tdheight=8; // Dòng đầu tiên header 10mm
					$this->SetFillColor(207, 199, 198);
					$this->tdbgcolor=true;
					$this->tdalign='C';
					$this->SetTextColor(0, 0, 0);
				} else {
					$this->tdheight=50; // Dòng khác 50mm
					//$this->SetFillColor(255, 255, 255);
					//$this->tdbgcolor=true;
					if($this->col == 3)
					{
						$this->tdalign='C';	
					} else {
						$this->SetFont('VnTimes','',11);
						$this->tdalign='L';
					}
					$this->SetTextColor(0, 0, 0);
				}
				
				$this->tdbegin=true;
				break;

			case 'HR':
				if( !empty($attr['WIDTH']) )
					$Width = $attr['WIDTH'];
				else
					$Width = $this->w - $this->lMargin-$this->rMargin;
				$x = $this->GetX();
				$y = $this->GetY();
				$this->SetLineWidth(0.2);
				$this->Line($x,$y,$x+$Width,$y);
				$this->SetLineWidth(0.2);
				$this->Ln(1);
				break;
			case 'STRONG':
				$this->SetStyle('B',true);
				break;
			case 'EM':
				$this->SetStyle('I',true);
				break;
			case 'B':
			case 'I':
			case 'U':
				$this->SetStyle($tag,true);
				break;
			case 'A':
				$this->HREF=$attr['HREF'];
				break;
			case 'IMG':
				$attr['WIDTH'] = 500;
				if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
					if(!isset($attr['WIDTH']))
						$attr['WIDTH'] = 0;
					if(!isset($attr['HEIGHT']))
						$attr['HEIGHT'] = 0;
					if(resizeToFit($attr['SRC']) != false)
					{
						list($_width,$_height) = resizeToFit($attr['SRC']);
						$this->Image($attr['SRC'], $this->GetX() + (70 - $_width)/2, $this->GetY() + (50 - $_height)/2, $_width, $_height);
					}
					$this->Cell(70,50,'',$this->tableborder,0,$this->tdalign,0);
				}
				break;
			case 'BLOCKQUOTE':
			case 'BR':
				$this->Ln(5);
				break;
			case 'P':
				$this->Ln(10);
				break;
			case 'FONT':
				if (isset($attr['COLOR']) && $attr['COLOR']!='') {
					$coul=hex2dec($attr['COLOR']);
					$this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
					$this->issetcolor=true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
					$this->SetFont(strtolower($attr['FACE']));
					$this->issetfont=true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE']!='') {
					$this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
					$this->issetfont=true;
				}
				break;
		}
	}

	function CloseTag($tag)
	{
		//Closing tag
		if($tag=='SUP') {
		}

		if($tag=='TD') { // TD-END
			//echo '] ';
			$this->tdbegin=false;
			$this->tdwidth=0;
			$this->tdheight=0;
			$this->tdalign="L";
			$this->tdbgcolor=false;
		}
		if($tag=='TR') { // TR-END
		
			$this->Ln();
		}
		if($tag=='TABLE') { // TABLE-END
			$this->tableborder=0;
		}

		if($tag=='STRONG')
			$tag='B';
		if($tag=='EM')
			$tag='I';
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
		if($tag=='FONT'){
			if ($this->issetcolor==true) {
				$this->SetTextColor(0);
			}
			if ($this->issetfont) {
				$this->SetFont('arial');
				$this->issetfont=false;
			}
		}
	}

	function SetStyle($tag, $enable)
	{
		//Modify style and select corresponding font
		$this->$tag+=($enable ? 1 : -1);
		$style='';
		foreach(array('B','I','U') as $s) {
			if($this->$s>0)
				$style.=$s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		//Put a hyperlink
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}

	function WriteBestPractises($html)
	{
		$html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><th><table><sup>"); //remove all unsupported tags
		$html=str_replace("<th>",'<td>',$html);
		$html=str_replace("</th>",'</td>',$html);
		$html=str_replace("\n",'',$html); //replace carriage returns with spaces
		$html=str_replace("\t",'',$html); //replace carriage returns with spaces
		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explode the string
		//var_dump($a); die();
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				//Text, giừa các thẻ có ký tự "".
				if($this->HREF)
					$this->_PutLink($this->HREF,$e);
				elseif($this->tdbegin) { // khi item trước đó là thẻ <td>, giá trị $e là giá trị thẻ td
					//echo $e;
					/*
					if($this->row > 1)
					{
						if($this->col == 2)
						{
							$_x = $this->getX();
							$_y = $this->getY();
							$this->SetXY($_x + 70,$_y);
						}
					}*/
					if(trim($e)!='' && $e!="&nbsp;") {
						$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
					}
					elseif($e=="&nbsp;") {
						$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,0,$this->tdalign,$this->tdbgcolor);
					}
				}
				elseif($this->pbegin)
				{
					$this->MultiCell(160,8,$e,1,'J');
				}
				else
					$this->Write(5,stripslashes(txtentities($e)));
					//$this->MultiCell(160,8,$e,1,'J');
			}
			else
			{
				//Tag
				//echo $e . '</br>';
				if($e[0]=='/')
					$this->_CloseTag(strtoupper(substr($e,1)));
				else
				{
					//Extract attributes
					$a2=explode(' ',$e);
					$tag=strtoupper(array_shift($a2));
					
					$attr=array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])]=$a3[2];
					}
					
					$this->_OpenTag($tag,$attr);
				}
			}
		}
	}

	function _WriteHTML($html) // Sử dụng để in html lên file pdf
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->_PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
				{
					if($e != '')
					{
						$e = '- '.$e;
						//$this->Justify($e,150,5);
						$this->Cell(10,5,'',0,0,'C');
						$this->MultiCell(150,8,$e,0,'J');
                    	//$this->Write(5,$e);
					}
				}
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->_CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->_OpenTag($tag,$prop);
                }
            }
        }
    }

	function _OpenTag($tag,$attr = null)
    {
        //Opening tag
		switch($tag){

			case 'SUP':
				if( !empty($attr['SUP']) ) {    
					//Set current font to 6pt     
					$this->SetFont('','',6);
					//Start 125cm plus width of cell to the right of left margin         
					//Superscript "1" 
					$this->Cell(2,2,$attr['SUP'],0,0,'L');
				}
				break;

			case 'TABLE': // TABLE-BEGIN
				$this->row = 0;
				$this->col = 0;				
				$this->tableborder=1;
				$this->SetDrawColor(224, 220, 220);
				$this->SetFont('VnTimesB','B',14);
				break;
			case 'TR': //TR-BEGIN
				$this->col = 0;
				$this->row++;
				//echo 'Vào '.$this->row;
				$this->tdbegin = false;
				// Lấy ví trí hiện tại
				$_x = $this->getX();
				$_y = $this->getY();
				if($_y + 50 > 297)
				{
					$this->AddPage();
					//$this->row = 1;
					$this->col = 0;
					$this->tableborder=1;
					$this->SetDrawColor(224, 220, 220);
					$this->SetFont('VnTimesB','B',14);
					//$this->header_table();
					$this->Ln();
					
				}

				break;
			case 'TD': // TD-BEGIN
				$this->col++;
				//echo '[';
				//if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
				//else { 
					if($this->col ==1)
					{
						$this->tdwidth=80; // Set to your own width if you need bigger fixed cells
					} elseif($this->col == 2)
					{
						$this->tdwidth=80;
					} else {
						$this->tdwidth=0;
					}
				//}
				/*if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
				else {
					if($this->row == 1)
					{
						$this->tdheight=10; // Set to your own height if you need bigger fixed cells
					} else{
						$this->tdheight=50; // Set to your own height if you need bigger fixed cells
					}
				} */
				
				if($this->row == 1) // dòng đầu tiên. 
				{
					$this->tdheight=6; // Dòng đầu tiên header 10mm
					$this->SetFillColor(207, 199, 198);
					$this->tdbgcolor=true;
					$this->tdalign='C';
					$this->SetTextColor(0, 0, 0);
				} else {
					$this->tdheight=50; // Dòng khác 50mm
					//$this->SetFillColor(255, 255, 255);
					//$this->tdbgcolor=true;
					if($this->col == 3)
					{
						$this->tdalign='C';	
					} else {
						$this->SetFont('VnTimes','',11);
						$this->tdalign='L';
					}
					$this->SetTextColor(0, 0, 0);
				}
				
				$this->tdbegin=true;
				break;

			case 'HR':
				if( !empty($attr['WIDTH']) )
					$Width = $attr['WIDTH'];
				else
					$Width = $this->w - $this->lMargin-$this->rMargin;
				$x = $this->GetX();
				$y = $this->GetY();
				$this->SetLineWidth(0.2);
				$this->Line($x,$y,$x+$Width,$y);
				$this->SetLineWidth(0.2);
				$this->Ln(1);
				break;
			case 'STRONG':
				$this->SetStyle('B',true);
				break;
			case 'EM':
				$this->SetStyle('I',true);
				break;
			case 'B':
			case 'I':
			case 'U':
				$this->SetStyle($tag,true);
				break;
			case 'A':
				$this->HREF=$attr['HREF'];
				break;
			case 'IMG':
				//var_dump($attr); die();
				$attr['WIDTH'] = 500;
				if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
					if(!isset($attr['WIDTH']))
						$attr['WIDTH'] = 0;
					if(!isset($attr['HEIGHT']))
						$attr['HEIGHT'] = 0;
					if(resizeToFit($attr['SRC']) != false)
					{
						list($_width,$_height) = resizeToFit($attr['SRC']);
						$this->Image($attr['SRC'], $this->GetX() + (80 - $_width)/2, $this->GetY() + (50 - $_height)/2, $_width, $_height);
					}
					$this->Cell(80,50,'',$this->tableborder,0,$this->tdalign,0);
				}
				break;
			case 'BLOCKQUOTE':
			case 'BR':
				$this->Ln(5);
				break;
			case 'P':
				$this->pbegin = true;
				//$this->Ln(10);
				break;
			case 'FONT':
				if (isset($attr['COLOR']) && $attr['COLOR']!='') {
					$coul=hex2dec($attr['COLOR']);
					$this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
					$this->issetcolor=true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
					$this->SetFont(strtolower($attr['FACE']));
					$this->issetfont=true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE']!='') {
					$this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
					$this->issetfont=true;
				}
				break;
		}
		/*
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->_SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
		if($tag=='LI')
			$this->Ln(3);
        if($tag=='P' && !empty($prop['ALIGN']))
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }*/
    }

	function _CloseTag($tag)
    {
        //Closing tag
		//Closing tag
		if($tag=='SUP') {
		}

		if($tag=='TD') { // TD-END
			//echo '] ';
			$this->tdbegin=false;
			$this->tdwidth=0;
			$this->tdheight=0;
			$this->tdalign="L";
			$this->tdbgcolor=false;
		}
		if($tag=='TR') { // TR-END
		
			$this->Ln();
		}
		if($tag=='TABLE') { // TABLE-END
			$this->tableborder=0;
		}

		if($tag=='STRONG')
			$tag='B';
		if($tag=='EM')
			$tag='I';
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
		if($tag=='FONT'){
			if ($this->issetcolor==true) {
				$this->SetTextColor(0);
			}
			if ($this->issetfont) {
				$this->SetFont('arial');
				$this->issetfont=false;
			}
		}
		if($tag == 'P')
		{
			$this->pbegin = false;
		}
		/*
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->_SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
			*/
    }
	function _SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function _PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

}//end of class

class Pdf extends PDF_HTML
{
    protected $orientation;
    protected $size;
    protected $rotation;
    protected $units;
    protected $logo;
    protected $head_title;
    protected $head_subtitle;
    protected $footer_page_literal;
	protected $left_signal;
	protected $right_signal;

    public $margin;


    private $base_url;
    private $format;

    function __construct()
    {
        $ci                     =   & get_instance();
        $ci->load->helper('url');
        $ci->load->config('pdf');

        $this->orientation          =   $ci->config->item('orientation');
        $this->size                 =   $ci->config->item('size');
        $this->rotation             =   $ci->config->item('rotation');
        $this->units                =   $ci->config->item('units');
        $this->format               =   $ci->config->item('format');
        $this->head_title           =   $this->format($ci->config->item('head_title'));
        $this->head_subtitle        =   $this->format($ci->config->item('head_subtitle'));
        $this->footer_page_literal  =   $this->format($ci->config->item('footer_page_literal'));
        $this->font                 =   $ci->config->item('font');
		$this->left_signal                 =   $ci->config->item('left_signal');
		$this->right_signal                 =   $ci->config->item('right_signal');
        $this->margin = array(
                      'top'=>  $ci->config->item('marginTop'),
                      'bottom'=>$ci->config->item('marginBottom'),
                      'left'=>$ci->config->item('marginLeft'),
                      'right'=>$ci->config->item('marginRight')
                    );

        $this->base_url         =   $ci->config->item('url_wrapper');
        if ( $this->base_url === TRUE)
            $this->logo = base_url( $ci->config->item('logo') );
        else
            $this->logo = $ci->config->item('logo');


        // lets construct the fpdf objet!
        parent::__construct( $this->orientation , $this->units , $this->size );
        $this->SetFont($this->font);
        $this->SetMargins($ci->config->item('marginLeft'), $ci->config->item('marginTop'), $ci->config->item('marginRight'));
		$this->AddFont('VnTimes','','times.ttf',true);
		$this->AddFont('VnTimesB','B','timesbd.ttf',true);
		$this->AddFont('VnTimesI','I','timesi.ttf',true);
		$this->AddFont('VnTimesBI','BI','timesbi.ttf',true);
		$this->SetFont('VnTimes','',14);
    }

    /**
    * header function
    *
    * @param none
    * @return none
    **/
    function header()
    {
        /*
        $this->Image($this->logo,10,8,22);
        $this->SetFont( 'Times' , 'B' ,13 );
        $this->Cell(30,0,'',0);

        $this->Cell(120,10,$this->head_title,1,0,'C');
        $this->Ln('5');
        $this->SetFont('Times','B',8);
        $this->Cell(30);

        $this->Cell(120,10,$this->head_subtitle,1,0,'C');
        $this->Ln(20);
        */
    }

    /**
    * footer function
    *
    * @param none
    * @return none
    **/
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times','I',8);
        $this->Cell(20,10,"{$this->left_signal}",0,0,'L');
		$this->Cell(110,10,"{$this->footer_page_literal} ".$this->PageNo().'/{nb}',0,0,'C');
		$this->Cell(30,10,"{$this->right_signal}",0,0,'R');
    }

    /**
    * logo getter
    *
    * @param none
    * @return string
    **/
    function get_logo()
    {
        return $this->logo;
    }

    /**
    * orientation getter
    *
    * @param none
    * @return string
    **/
    function get_orientaion()
    {
        return $this->orientation;
    }

    /**
    * size getter
    *
    * @param none
    * @return string
    **/
    function get_size()
    {
        return $this->size;
    }

    /**
    * rotation getter
    *
    * @param none
    * @return int
    **/
    function get_rotation()
    {
        return $this->rotation;
    }

    /**
    * units getter
    *
    * @param none
    * @return string
    **/
    function get_units()
    {
        return $this->units;
    }

    /**
    * Head title getter
    *
    * @param none
    * @return string
    **/
    function get_head_title()
    {
        return $this->head_title;
    }

    /**
    * Head subtitle getter
    *
    * @param none
    * @return string
    **/
    function get_head_subtitle()
    {
        return $this->head_subtitle;
    }

    /**
    * addpage function
    *
    * @param string
    * @param mixed
    * @param int
    * @return void
    **/

    function Add_Page( $orientation=NULL , $size=NULL , $rotation=NULL )
    {
        if( is_null($orientation) )
            $orientation = $this->orientation;
        else
            $this->orientation = $orientation;

        if( is_null($size) )
            $size = $this->size;
        else
            $this->size = $size;

        if( is_null($rotation) )
            $rotation = $this->rotation;
        else
            $this->rotation = $rotation;

        $this->AddPage( $this->orientation , $this->size , $this->rotation );
    }

    /**
    * render function
    *
    * @param string
    * @param string
    * @param bool
    * @return void
    *
    * Behaviour:
    * dest,             indicates where send the documment. It can bo one of following
    *                   'I': send the file inline to the browser. The PDF viewer is used if available.
    *                   'D': send to the browser and force a file download with the name given by name.
    *                   'F': save to a local file with the name given by name (may include a path).
    *                   'S': return the document as a string.
    *
    * name,             The name of the file. It is ignored in case of destination S.
    *                   The default value is doc.pdf.
    *
    * $this->format,    Indicates if name is encoded in ISO-8859-1 (false) or UTF-8 (true).
    *                   Only used for destinations I and D.
    *                   The default value is false.
    **/
    function render($dest='I',$name='document.pdf')
    {
        $this->Output($dest,$name,$this->format);
    }


    /**
    * format function
    *
    * @param string
    * @return string
    **/
    function format($str)
    {
        return utf8_decode($str);
    }

    function make_report($data)
    {
        //var_dump($data['areas_assessment_findings']); die();
		//Vẽ trang bìa
        //$str = iconv('UTF-8', 'windows-1252', "CHƯƠNG TRÌNH ĐÁNH GIÁ THỰC HÀNH TỐT 5S");
		$_str_title_first_page = "CHƯƠNG TRÌNH ĐÁNH GIÁ THỰC HÀNH TỐT 5S";
		$_str_sub_title_first_page = "Năng suất - vì một ngày mai tốt hơn hôm nay";

        $_str_body_first_page_1 = "BÁO CÁO";
        $_str_body_first_page_2 = "ĐÁNH GIÁ THỰC HÀNH TỐT 5S";
		$_str_sub_body_first_page = "5S Assessment Rreport";
        $_str_company_name_first_page = mb_strtoupper($data['record']['company_name']);

        $_str_assessment_date_first_page = "NGÀY ĐÁNH GIÁ/ Assessment Date: ".$data['record']['assessment_date'];

        $_str_team_first_page = "ĐOÀN CHUYÊN GIA ĐÁNH GIÁ";
        $_str_sub_team_first_page = "Assessment Team";

		$_arr_member = array();
		foreach($data['members'] as $key=>$value)
		{
			if($key == 1)
			{
				$value['title'] = "- Trưởng đoàn đánh giá/ Team Leader";
				
			} else {
				$value['title'] = "- Chuyên gia đánh giá/ Assensor";
			}
			$_arr_member[$key] = $value;
		}
    	//$_arr_member = array( 1=>array('name'=>"Vũ Thị Thu Hà", 'title'=>"- Trưởng đoàn đánh giá/ Team Leader"),
		//					  2=>array('name'=>"Nguyễn Huy Đoàn", 'title'=>"- Chuyên gia đánh giá/ Assensor"));			

		$_str_report_date = "Ngày báo cáo/ Report Date:";
		$_str_report_leader = "Trưởng đoàn/ Team Leader: ".$_arr_member[1]['name'];
		$_str_report_signal = "Ký tên/ Signature:";

		$_str_title_second_page = "B. THÔNG TIN CHUNG";
		$_str_sub_title_second_page = "General Information";

		$_str_title_mark_page = "KẾT QUẢ ĐÁNH GIÁ";
		$_str_sub_title_mark_page = "Summary of Marks";
		$_str_title_best_page = "E. HÌNH ẢNH MINH HỌA THỰC HÀNH TỐT 5S";
		$_str_sub_title_best_page = "Photo Illustration of 5S Best Practices";
		$_str_title_finding_page = "F. CÁC PHÁT HIỆN ĐÁNH GIÁ VÀ KHUYẾN NGHỊ CẢI TIẾN";
		$_str_sub_title_finding_page = "Assessment Findings and suggestion";

        $this->AddPage();
		$this->SetFont('VnTimesB','B',16);
        $this->Cell(160,0,$_str_title_first_page,0,1, 'C');
		$this->SetFont('VnTimesBI','BI',13);
		$this->Ln(6);
		$this->Cell(160,0,$_str_sub_title_first_page,0,1, 'C');
		$this->Ln(5);
		$this->SetLineWidth(0.5);
		$this->SetDrawColor(245, 151, 53);
		$y = $this->getY();
		$this->Line($this->margin['left'],$y, 31.5 + $this->margin['left'], $y);
		$this->SetDrawColor(3, 110, 182);
		$this->Line($this->margin['left']+32,$y, 160 + $this->margin['left'], $y);
		$this->Ln(15);
		
		//$this->Cell(160,30,$this->image(FPDF_FONTPATH.'/image/logo.jpg',$this->GetX(), $this->GetY(),60),0,0,'C',false);
		//$this->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
		$this->image(FPDF_FONTPATH.'/image/logo.jpg',$this->GetX() + 50, $this->GetY(),60);

        $this->Ln(15);
        $rectX = $this->getX();
        $rectY = $this->getY() + 30;

        $this->SetFont('VnTimesB','B',24);
        $this->SetTextColor(3, 110, 182);
        $this->Ln(45);
        $this->Cell(160,0,$_str_body_first_page_1,0,1, 'C');
        $this->Ln(15);
        $this->Cell(160,0,$_str_body_first_page_2,0,1, 'C');
        $this->Ln(15);
        $this->Cell(160,0,$_str_sub_body_first_page,0,1, 'C');
        $this->Ln(10);
        $this->MultiCell(160,15,$_str_company_name_first_page,0,'C');

        $this->Ln(5);
        $this->SetFont('VnTimesB','B',14);
        $this->Cell(160,0,$_str_assessment_date_first_page,0,1, 'C');

        $rectHeight = $this->getY() - $rectY + 15;
		$this->SetLineWidth(0.1);
        $this->SetDrawColor(245, 66, 81);
        $this->Rect($rectX, $rectY,160,$rectHeight);
        $this->Rect($rectX+0.5, $rectY + 0.5,159,$rectHeight - 1);

        $this->SetFont('VnTimes','',13);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(25);
        $this->Cell(160,0,$_str_team_first_page,0,1, 'C');
        $this->Ln(10);
        $this->Cell(160,0,$_str_sub_team_first_page,0,1, 'C');
		$this->Ln(2);
		//$this->setX($this->getX + 15);
		foreach($_arr_member as $k=>$member)
		{
			$this->Ln(8);
			$this->Cell(10,0,'',0,0, 'L');
			$this->Cell(70,0,$k.'. '.$member['name'],0,0, 'L');
			$this->Cell(70,0,$member['title'],0,1, 'L');
		}

		$this->Ln(20);
		$this->Cell(160,0,$_str_report_date,0,1, 'L');
		$this->Ln(8);
		$this->Cell(160,0,$_str_report_leader,0,1, 'L');
		$this->Ln(8);
		$this->Cell(160,0,$_str_report_signal,0,1, 'L');

        $this->AliasNbPages();
		// Thêm trang mới - Blank - Mục lục
		$this->AddPage();
		
		// Thêm trang mới - header -- General Information
		$this->AddPage();
		$this->SetDrawColor(245, 151, 53);
        //$this->Rect($this->getX(), $this->getY() -3,160,12);
		$this->SetFont('VnTimesB','B',13);
        $this->SetTextColor(3, 110, 182);
		$this->Ln(1);
		$this->Cell(160,10,$_str_title_second_page .'/ '.$_str_sub_title_second_page,1,1, 'C');
		//$this->Ln(4);
		//$this->Cell(160,0,$_str_sub_title_second_page,0,1, 'C');
		// Hết header
		//Phần body
		$_org_name = "TÊN TỔ CHỨC/ Organization: " . $data['record']['company_name']; 
		$this->SetFont('VnTimes','',12);
        $this->SetTextColor(0, 0, 0);
		$this->Ln(1);
		$this->Cell(6,10,'1.',0,0, 'L');
		$this->MultiCell(154,10,$_org_name,0, 'L');
		//$this->Ln(1);
		$this->Cell(6,10,'',0,0, 'L');
		$_org_address = "ĐỊA CHỈ/ Address: " . $data['company_address'];
		$this->MultiCell(154,10,$_org_address,0, 'L');
		$_org_tel = "TEL: ".$data['record']['tel'];
		$_org_fax = "FAX: ".$data['record']['fax'];
		$this->Cell(6,10,'',0,0, 'L');
		$this->Cell(77,10,$_org_tel,0, 0,'L');
		$this->Cell(77,10,$_org_fax,0, 1,'L');

		// --------- Đại diện có thẩm quyền
		$_org_authorized = "ĐẠI DIỆN CÓ THẨM QUYỀN/ Authorized Representative: ". $data['record']['authorized'];
		$_org_designation = "CHỨC VỤ/ Designation: ".$data['record']['designation'];

		$this->Cell(6,10,'2.',0,0, 'L');
		$this->MultiCell(154,10,$_org_authorized,0, 'L');
		$this->Cell(6,10,'',0,0, 'L');
		$this->MultiCell(154,10,$_org_designation,0, 'L');
		// Ngày đánh giá

		$_assessment_date = "NGÀY ĐÁNH GIÁ/ Assessment Date: ".$data['record']['assessment_date'];
		$this->Cell(6,10,'3.',0,0, 'L');
		$this->MultiCell(154,10,$_assessment_date,0, 'L');

		// Chuẩn mực đánh giá

		$_assessment_criteria = "CHUẨN MỰC ĐÁNH GIÁ/ Assessment Criteria:";
		//$_sub_assessment_criteria = "Assessment Criteria:";
		$_x = $this->getX();
		$_y = $this->getY();
		$this->Cell(6,10,'4.',0,0, 'L');
		$this->MultiCell(57,10,$_assessment_criteria,0, 'L');
		$this->setXY($_x + 83,$_y);
		$this->MultiCell(77,10,$data['record']['assessment_criteria'],0, 'L');

		//Loại hình đánh giá
		$this->Ln();
		$_assessment_type = "LOẠI HÌNH ĐÁNH GIÁ/ Assessment Type: ".$data['record']['assessment_type'];
		$this->Cell(6,10,'5.',0,0, 'L');
		$this->MultiCell(154,10,$_assessment_type,0, 'L');

		// 6. Hình thức đánh giá
		$_assessment_modelity = "HÌNH THỨC ĐÁNH GIÁ/ Assessment Modelity: ".$data['record']['assessment_modelity'];
		$this->Cell(6,10,'6.',0,0, 'L');
		$this->MultiCell(154,10,$_assessment_modelity,0, 'L');

		//7. Sản phẩm/ dịch vụ chính
		$_main_product = "SẢN PHẨM, DỊCH VỤ CHÍNH/ Main products and services: ";
		$this->Cell(6,10,'7.',0,0, 'L');
		$this->MultiCell(154,10,$_main_product,0, 'L');
		$this->Cell(6,10,'',0,0, 'L');
		$this->MultiCell(154,10,$data['record']['product'],0, 'L');
		//8. Phạm vi đánh giá
		$_assessment_scope = "PHẠM VI ĐÁNH GIÁ/ Scope of Assessment";
		$this->Cell(6,10,'8.',0,0, 'L');
		$this->MultiCell(154,10,$_main_product,0, 'L');
		$this->Cell(6,10,'',0,0, 'L');
		$this->MultiCell(154,10,$data['record']['assessment_scope'],0, 'L');
		//Hết body
		// --------------- Hết General Information ----

		// Thêm trang mới - header -- Summary of Marks
		$this->AddPage();
		$this->SetDrawColor(245, 151, 53);
        //$this->Rect($this->getX(), $this->getY() -3,160,12);
		$this->SetFont('VnTimesB','B',13);
        $this->SetTextColor(3, 110, 182);
		$this->Ln(1);
		$this->Cell(160,10,'C. '.$_str_title_mark_page .'/ '.$_str_sub_title_mark_page,1,1, 'C');
		$this->Ln(4);
		
		// Hết header
		//Phần body
		$this->SetDrawColor(0, 0, 0); // Màu đen
		$this->SetLineWidth(0.1);
		$_rectTopX = $this->getX();
		$_rectTopY = $this->getY();
		$this->SetTextColor(0, 0, 0);
		
		$_archivement = "KẾT QUẢ ĐẠT ĐƯỢC/ Archivement:";
		$this->Cell(10,10,'1.',0,0, 'R');
		$this->Cell(150,10,$_archivement,0,0, 'L');
		$this->Ln(8);
		$this->SetFont('VnTimes','',13);
		$this->_WriteHTML($data['record']['archivement']);
		$this->Ln(1);
		$_x = $this->getX();
		$_y = $this->getY();
		$this->Rect($_rectTopX,$_rectTopY,160,$_y - $_rectTopY);
		//$this->setXY($_x,$_y + 120);
		$_rectTopX = $_x;
		$_rectTopY = $_y;
		$this->SetTextColor(0, 0, 0);
		$_main_problem = "NHỮNG VẤN ĐỀ TỒN TẠI CHÍNH/ Main existing problem:";
		$this->SetFont('VnTimesB','B',13);
		$this->Cell(10,10,'2.',0,0, 'R');
		$this->Cell(150,10,$_main_problem,0,0, 'L');
		$this->Ln(8);
		$this->SetFont('VnTimes','',13);
		$this->_WriteHTML($data['record']['main_problem']);
		$_x = $this->getX();
		$_y = $this->getY();
		$this->Rect($_rectTopX,$_rectTopY,160,$_y - $_rectTopY);
		//die();
		//$this->WriteHTML($data['record']['comment']);
		$this->AddPage(); // Tạo trang mới cho kết quả điểm
		$_rectTopX = $this->getX();
		$_rectTopY = $this->getY();
		$_TopX = $this->getX();
		$_TopY = $this->getY();
		$_score = "ĐIỂM ĐÁNH GIÁ/ Scored";
		$_header_1 = "Các khu vực được đánh giá/ Assessment Areas";
		$_header_2 = "Điểm đánh giá/ Marks";
		$_header_21 = "Điểm tối đa/ Full";
		$_header_22 = "Điểm đạt/ Scored";
		$_header_3 = "Tính theo phần trăm/ Percentage";
		$_header_4 = "Kết luận/ Final";
		$_footer_1 = "Tổng cộng/ Total";
		$_pass = "Đạt";
		$_fail = "Không đạt";
		$_width_1 = 60;
		$_width_2 = 50;
		$_width_3 = 50;
		$this->SetFont('VnTimesB','B',13);
		$this->Cell(10,10,'3.',0,0, 'R');
		$this->Cell(150,10,$_score,0,1, 'L');
		$_x = $this->getX();
		$_y = $this->getY();
		$_height_line_1 = $_y - $_rectTopY;
		$this->Rect($_rectTopX,$_rectTopY,160,$_height_line_1);
		$_rectTopX = $_x;
		$_rectTopY = $_y;
		$this->SetXY($_x,$_y + 6);
		$this->SetFont('VnTimesB','B',11);
		$this->MultiCell($_width_1,6,$_header_1,0,'C');
		$_height1 = $this->getY() - $_rectTopY + 9 - 6;
		$this->Rect($_rectTopX,$_rectTopY,$_width_1,$_height1);
		$_rectTopX = $_rectTopX + $_width_1;
		$this->SetXY($_rectTopX,$_rectTopY);
		$this->MultiCell($_width_2,9,$_header_2,0,'C');
		$_height = $this->getY() - $_rectTopY;
		$this->Rect($_rectTopX,$_rectTopY,$_width_2,$_height);
		$this->SetXY($_rectTopX,$this->getY());
		$_x = $this->getX();
		$_y = $this->getY();
		$this->MultiCell(25,6,$_header_21,0,'C');
		$this->Rect($_x,$_y,25,$_height1 - $_height);

		$this->SetXY($_x+25,$_y);
		$this->MultiCell(25,6,$_header_22,0,'C');
		$this->Rect($_x+25,$_y,25,$_height1 - $_height);

		$this->SetXY($_rectTopX+$_width_2,$_rectTopY + 2);
		$this->MultiCell(30,6,$_header_3,0,'C');
		$this->Rect($_rectTopX+$_width_2,$_rectTopY,30,$_height1);
		$this->SetXY($_rectTopX+$_width_2+30,$_rectTopY + 5);
		$this->MultiCell(20,6,$_header_4,0,'C');
		$this->Rect($_rectTopX+$_width_2,$_rectTopY,$_width_3,$_height1);

		$_x = $_TopX;
		$_y = $_TopY + $_height_line_1 + $_height1;

		$this->setXY($_x,$_y);
		$this->SetFont('VnTimes','',11);

		$_color = [
			[255,0,0],
			[255,255,0],
			[50,0,255],
			[255,0,255],
			[0,255,0],
			[255,0,50],
			[0,0,255],
			[50,50,250],
			[100,50,50],
			[50,100,250],
		];
		$_data = array();
		foreach($data['areas_assessment'] as $key=>$area)
		{
			//row
			// xử lý item of data ro draw chart
			if($key > 9)
			   $_key = 0;
			else $_key = $key;   
			

			//
			$index = $key + 1;
			$area_name = explode('/',$area['name']);
			if(!empty($area_name))
			{
				$area_name = trim($area_name[0]);
			}
			else {
				$area_name = $area['name'];
			}
			$max_score = $area['count_result']*5;
			$score = $area['total_score'];
			$_percent = $area['count_result'] == 0 ? 0: number_format(100*$area['total_score']/($area['count_result']*5),2);

			$_item = array(
				'color' => $_color[$_key],
				'value' => $_percent
			); 
			$_data[$area_name] = $_item;
			$_result = "Không đạt";
			if($_percent > 69.99)
			{
				$_result = "Đạt";
			}
			$percent = $_percent . '%';
			$_x = $this->getX();
			$_y = $this->getY();
			$_xRow = $_x;
			$_yRow = $_y;
			$_width_table = $_width_1 + $_width_2 + $_width_3;
			$_height_row = 8;
			$this->setXY($_x,$_y + 1);
			//col 1
			$this->MultiCell(10,6,$index,0,'C');
			$this->Rect($_xRow,$_yRow,10,8);

			//col 2
			$this->setXY($_x+10,$_y + 1);
			$this->MultiCell(50,6,$area_name,0,'L');		
			$this->Rect($_xRow + 10,$_yRow,50,8);

			// col 3
			$this->setXY($_xRow+60,$_y + 1);
			$this->MultiCell(25,6,$max_score,0,'C');		
			$this->Rect($_xRow + 60,$_yRow,25,8);
			// col 4
			$this->setXY($_xRow+85,$_y + 1);
			$this->MultiCell(25,6,$score,0,'C');		
			$this->Rect($_xRow + 85,$_yRow,25,8);
			// col 5
			$this->setXY($_xRow+110,$_y + 1);
			$this->MultiCell(30,6,$percent,0,'C');		
			$this->Rect($_xRow + 110,$_yRow,30,8);
			// col 6
			$this->setXY($_xRow+140,$_y + 1);
			$this->MultiCell(20,6,$_result,0,'C');		
			$this->Rect($_xRow + 140,$_yRow,20,8);
			$this->Rect($_xRow,$_yRow,$_width_table,8);
			// Set Next Row
			$this->SetXY($_xRow,$_yRow+$_height_row);
			// end row
		}
		// Footer of table
		$_xRow = $this->getX();
		$_yRow = $this->getY();
		$max_marks = $data['max_marks'];
		$total_scored = $data['scored'];
		$_total_p = $max_marks==0 ? '0' : number_format((100*$total_scored/$max_marks),2);
		$total_p = $_total_p . '%';
		$this->SetFont('VnTimesB','B',11);
		//col 1
		$this->SetXY($_xRow,$_yRow+2);
		$this->MultiCell(60,6,$_footer_1,0,'C');	
		$this->Rect($_xRow,$_yRow,60,8);
		//col 2
		$this->SetXY($_xRow + 60,$_yRow+2);
		$this->MultiCell(25,6,$max_marks,0,'C');
		$this->Rect($_xRow + 60,$_yRow,25,8);
		//col 3
		$this->SetXY($_xRow + 85,$_yRow+2);
		$this->MultiCell(25,6,$total_scored,0,'C');
		$this->Rect($_xRow + 85,$_yRow,25,8);
		//col 4
		$this->SetXY($_xRow + 110,$_yRow+2);
		$this->MultiCell(30,6,$total_p,0,'C');
		$this->Rect($_xRow + 110,$_yRow,30,8);
		//col 5
		$this->Rect($_xRow,$_yRow,$_width_table,8);
		$this->Ln(5);
		// Vẽ biểu đồ tại đây
		$_chartOfResult = "BIỂU ĐỒ KẾT QUẢ/ Chart of result";
		$this->SetFont('VnTimesB','B',13);
		$this->Cell(10,10,'4.',0,0, 'R');
		$this->Cell(150,10,$_chartOfResult,0,1, 'L');

		
		$chartX=$this->getX();
		$chartY=$this->getY();

		//dimension
		$chartWidth=160;
		$chartHeight=100;

		//padding
		$chartTopPadding=10;
		$chartLeftPadding=20;
		$chartBottomPadding=20;
		$chartRightPadding=5;

		//chart box
		$chartBoxX=$chartX+$chartLeftPadding;
		$chartBoxY=$chartY+$chartTopPadding;
		$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
		$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

		//bar width
		$barWidth=10;
		
		//chart data
		/*
		$_data = [
			'lorem'=>[
				'color'=>[255,0,0],
				'value'=>90],
			'ipsum'=>array(
				'color'=>array(255,255,0),
				'value'=>30),
			'dolor'=>array(
				'color'=>array(50,0,255),
				'value'=>50),
			'sit'=>array(
				'color'=>array(255,0,255),
				'value'=>50),
			'amet'=>array(
				'color'=>array(0,255,0),
				'value'=>40)
		];*/
		
		//$dataMax
		$dataMax=100;
		/*
		foreach($_data as $item){
			if($item['value']>$dataMax)$dataMax=$item['value'];
		}
		*/
		//data step
		$dataStep=10;
		

		//set font, line width and color
		$this->SetFont('VnTimes','',9);
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(0);

		//chart boundary
		$this->Rect($chartX,$chartY,$chartWidth,$chartHeight);
		
		//vertical axis line
		$this->Line(
			$chartBoxX ,
			$chartBoxY , 
			$chartBoxX , 
			($chartBoxY+$chartBoxHeight)
			);
		//horizontal axis line
		$this->Line(
			$chartBoxX-2 , 
			($chartBoxY+$chartBoxHeight) , 
			$chartBoxX+($chartBoxWidth) , 
			($chartBoxY+$chartBoxHeight)
			);
		
		///vertical axis
		//calculate chart's y axis scale unit
		$yAxisUnits=$chartBoxHeight/$dataMax;

		

		//draw the vertical (y) axis labels
		for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
			//y position
			$yAxisPos=$chartBoxY+($yAxisUnits*$i);
			//draw y axis line
			$this->Line(
				$chartBoxX-2 ,
				$yAxisPos ,
				$chartBoxX ,
				$yAxisPos
			);
			//set cell position for y axis labels
			$this->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
			//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
			$_yLabel = $dataMax-$i;
			$_yLabel = $_yLabel . '%';
			$this->Cell($chartLeftPadding-4 , 5 , $_yLabel, 0 , 0 , 'R');
		}

		///horizontal axis
		//set cells position
		$this->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

		//cell's width
		$xLabelWidth=$chartBoxWidth / count($_data);
		$barWidth= $xLabelWidth/3;
		//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
		//loop horizontal axis and draw the bar
		$barXPos=0;
		$_xLabel = $this->getX();
		$_yLabel = $this->getY();
		foreach($_data as $itemName=>$item){
			//print the label
			//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');--------------
			$this->SetXY($_xLabel+$barXPos*$xLabelWidth,$_yLabel);
			$this->MultiCell($xLabelWidth , 5 , $itemName , 0 ,'C');
			
			///drawing the bar
			//bar color
			$this->SetFillColor($item['color'][0],$item['color'][1],$item['color'][2]);
			//bar height
			$barHeight=$yAxisUnits*$item['value'];
			//bar x position
			$barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
			$barX=$barX-($barWidth/2);
			$barX=$barX+$chartBoxX;
			//bar y position
			$barY=$chartBoxHeight-$barHeight;
			$barY=$barY+$chartBoxY;
			//draw the bar
			$this->Rect($barX,$barY,$barWidth,$barHeight,'DF');
			$this->setXY($barX,$barY - 5);
			$this->Cell($barWidth,6,$item['value'].'%',0,0,'C');
			//increase x position (next series)
			$barXPos++;
		}
		$this->SetDrawColor($_color[0][0],$_color[0][1],$_color[0][2]); // Màu đỏ
		$this->Line(
			$chartBoxX + 2,
			$chartBoxY + 30*$yAxisUnits, 
			$chartBoxX+($chartBoxWidth), 
			$chartBoxY + 30*$yAxisUnits,
			);
		//axis labels
		//$this->SetFont('Arial','B',12);
		//$this->SetXY($chartX,$chartY);
		//$this->Cell(100,10,"Amount",0);
		//$this->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
		//$this->Cell(100,5,"Series",0,0,'C');
		
		//Hết body
		// --------------- Hết Summary of Marks ----

		// Thêm trang mới - header -- Kế luận & kiến nghị
		$_str_conclue = "D. KẾT LUẬN VÀ KIẾN NGHỊ";
		$_str_sub_conclue = "Conclusions and Recommendations";
		$this->AddPage();
		$this->SetDrawColor(245, 151, 53);
        $this->Rect($this->getX(), $this->getY() -3,160,12);
		$this->SetFont('VnTimesB','B',13);
        $this->SetTextColor(3, 110, 182);
		$this->Ln(1);
		$this->Cell(160,0,$_str_conclue,0,1, 'C');
		$this->Ln(5);
		$this->Cell(160,0,$_str_sub_conclue,0,1, 'C');
		$this->Ln(10);
		// Hết header
		//Phần body Kế luận & kiến nghị
		// Khởi tạo dữ liệu

		$_kl1 = array(
			1=>"$_str_company_name_first_page đạt $total_scored điểm thực hành 5S trên tổng số $max_marks điểm tại các khu vực được đánh giá, tương ứng đạt $_total_p% tổng số điểm. Kết quả này đáp ứng yêu cầu xét cấp chứng chỉ Thực hành tốt 5S theo quy định (>= 70%). Đoàn chuyên gia đánh giá sẽ hoàn thành hồ sơ và kiến nghị Viện Năng Suất Việt Nam xem xét, quyết định cấp chứng chỉ Thực hành tốt 5S cho Công ty.",
			2=>"$_str_company_name_first_page phải triển khai các điểm cần cải tiến trong báo cáo này và gửi lại báo cáo cải tiến cho Đoàn chuyên gia đánh giá trước ngày   /   / để làm cơ sở cho việc theo dõi, giám sát tiếp theo.",
			3=>"Chứng chỉ Thực hành tốt 5S có giá trị 03 năm kể từ ngày cấp. Thực hành tốt 5S của Công ty sẽ được kiểm tra giám sát một lần sau 18 tháng kể từ ngày cấp chứng chỉ và sẽ đánh giá lại sau 03 năm để tiếp tục gia hạn hiệu lực chứng chỉ."
		);
		$_kl2 = array(
			1=>"$_str_company_name_first_page đạt $total_scored điểm thực hành 5S trên tổng số $max_marks điểm tại các khu vực được đánh giá, tương ứng đạt $_total_p% tổng số điểm. Kết quả này chưa đáp ứng yêu cầu xét cấp chứng chỉ Thực hành tốt 5S theo quy định (>= 70%).",
			2=>"$_str_company_name_first_page phải triển khai các điểm cần cải tiến trong báo cáo này và gửi lại báo cáo cải tiến cho Đoàn chuyên gia đánh giá trước ngày   /   /   để làm cơ sở cho việc kiến nghị Viện Năng Suất Việt Nam xem xét, quyết định cấp chứng chỉ Thực hành tốt 5S cho $_str_company_name_first_page hoặc phải tiến hành đánh giá lại một phần hay toàn bộ các hoạt động 5S của tổ chức.",
			3=>"Chứng chỉ Thực hành tốt 5S có giá trị 03 năm kể từ ngày cấp. Thực hành tốt 5S của Công ty sẽ được kiểm tra giám sát một lần sau 18 tháng kể từ ngày cấp chứng chỉ và sẽ đánh giá lại sau 03 năm để tiếp tục gia hạn hiệu lực chứng chỉ."
		);
		$_kl3 = array(
			1=>"Công ty $_str_company_name_first_page đạt $total_scored điểm thực hành 5S trên tổng số $max_marks điểm tại các khu vực được đánh giá, tương ứng đạt $_total_p% tổng số điểm. Kết quả này chưa đáp ứng yêu cầu xét cấp chứng chỉ Thực hành tốt 5S theo quy định (>= 70%).",
			2=>"Công ty $_str_company_name_first_page phải triển khai các điểm cần cải tiến trong báo cáo này và gửi lại báo cáo cải tiến cho Đoàn chuyên gia đánh giá trước ngày   /   /    để làm cơ sở cho việc tiến hành kiểm tra, đánh giá lại toàn bộ các hoạt động 5S của tổ chức theo quy định.",
			
		);

		$_kn = array(
			1=>"Triển khai các điểm cần cải tiến trong mục F. CÁC PHÁT HIỆN ĐÁNH GIÁ VÀ KHUYẾN NGHỊ CẢI TIẾN (theo mẫu kèm theo).",
			2=>"Tập trung ưu tiên cải tiến đối với những vấn đề tồn tại chính đã nếu ở phần 2 trong mục C. KẾT QUẢ ĐÁNH GIÁ, và các điểm lưu ý (O) trong mục F. CÁC PHÁT HIỆN ĐÁNH GIÁ VÀ KHUYẾN NGHỊ CẢI TIẾN, cần có kế hoạch thực hiện khắc phục, và gửi báo cáo kết quả thực hiện trong hồ sơ đánh giá giám sát giữa kỳ/ đánh giá lại."
		);
		$_kl = "";
		if($_total_p >= 70)
		{
			$_kl = $_kl1;
		} elseif($_total_p >=60){
			$_kl = $_kl2;
		} else{
			$_kl = $_kl3;
		}


		$this->SetTextColor(0,0,0);
		$this->Cell(160,0,"I. KẾT LUẬN",0,1, 'L');
		$this->Ln(4);
		$this->SetFont('VnTimes','',13);
		foreach($_kl as $key=>$value)
		{
			$_x = $this->getX();
			$_y = $this->getY();
			$this->Cell(10,8,$key.'.',0,0, 'R');
			$this->setXY($_x + 10,$_y);
			$this->MultiCell(150,8,$value,0,'J');
		}
		$this->Ln(8);
		$this->SetFont('VnTimesB','B',13);
		$this->Cell(160,0,"II. KIẾN NGHỊ",0,1, 'L');
		$this->Ln(8);
		$this->SetFont('VnTimes','',13);
		$this->MultiCell(160,8,"$_str_company_name_first_page cần:",0,'J');
		$this->Ln(4);
		foreach($_kn as $key=>$value)
		{
			$_x = $this->getX();
			$_y = $this->getY();
			$this->Cell(10,8,$key.'.',0,0, 'R');
			$this->setXY($_x + 10,$_y);
			$this->MultiCell(150,8,$value,0,'J');
		}

		// Thêm trang mới - header -- Best Practices
		$this->AddPage();
		$this->SetDrawColor(245, 151, 53);
        $this->Rect($this->getX(), $this->getY() -3,160,12);
		$this->SetFont('VnTimesB','B',13);
        $this->SetTextColor(3, 110, 182);
		$this->Ln(1);
		$this->Cell(160,0,$_str_title_best_page,0,1, 'C');
		$this->Ln(5);
		$this->Cell(160,0,$_str_sub_title_best_page,0,1, 'C');
		$this->Ln(8);
		// Hết header
		//Phần body
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(224, 220, 220);
		foreach($data['areas_best_practices'] as $key=>$best_practice)
		{
			$this->SetFont('VnTimesB','B',13);
			$this->Cell(160,8,$best_practice['name'],1,1, 'L');
			$this->WriteBestPractises($best_practice['best_practices_content']);
			$this->Ln(8);
		}
		//Hết body
		// --------------- Hết Best Practices ----

		// Thêm trang mới - header -- finding
		$this->AddPage();
		$this->SetDrawColor(245, 151, 53);
        $this->Rect($this->getX(), $this->getY() -3,160,12);
		$this->SetFont('VnTimesB','B',13);
        $this->SetTextColor(3, 110, 182);
		$this->Ln(1);
		$this->Cell(160,0,$_str_title_finding_page,0,1, 'C');
		$this->Ln(5);
		$this->Cell(160,0,$_str_sub_title_finding_page,0,1, 'C');
		$this->Ln(10);
		// Hết header
		//Phần body assessment_findings_content
		$this->SetDrawColor(224, 220, 220);
		foreach($data['areas_assessment_findings'] as $key=>$value)
		{
        	
			//echo $value['assessment_findings_content']; die();
			if($key > 0)
			{
				$this->AddPage();
			}	
			$this->SetFont('VnTimesB','B',13);
        	$this->SetTextColor(3, 110, 182);
			$this->Cell(160,8,$value['name'],1,1, 'L');
			//$this->Ln(3);		
			$this->WriteHTML($value['assessment_findings_content']);
			
			//die();
		}
		//Hết body
		// --------------- Hết finding ----
		


		//$this->AddPage();
		//$this->SetFont('Times','',12);
		//for($i=1;$i<=40;$i++)
		//	$this->Cell(0,10,'Printing line number '.$i,0,1);
		//$pdf->Output();
		

    }
}



/** this ends this file
* application/third_party/fpdf/libraries/Pdf.php
*/
