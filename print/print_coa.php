<? 
    require('../interface/config.inc.ihtml'); 
    require('fpdf/fpdf.php'); 
    define('FPDF_FONTPATH','fpdf/font/');

    
class PDF extends FPDF
{
//Page header
function Header(){
    global $compheader;
    
    $len = $compheader[1];
    
    $this->Cell($len,5,'Chart of Accounts',0,0,'C');
    $this->ln();
    $this->Cell($len,5,$compheader[0],0,0,'C');
    $this->ln(10);
    $this->line(5,25,$len,25);
}
   
    
    //Page footer
function Footer(){
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    $this->line(10,265,210,265);
    //Arial italic 8
    $this->SetFont('Arial','I',9);
    //Page number
    $this->Cell(0,10,' - Page '.$this->PageNo().' -  Print Date: '.date("m-d-Y"),0,0,'C');
	}

}


$frm = array_merge($_POST, $_COOKIE);
extract($frm); 

    //get company information to display on report
      //get the withdrawls
    $sql2 = "select * from tbl_company where active = '1' and id = '$co' ";
             try  
    {  $rs = $dbh->obj_query( $sql2 );
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $company[$key] = $value;   
            }
            
        }
        
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }
    
$compheader[0] = $company['companyName'];
if($orient == 'P'){
    $compheader[1] = '210';
}
if($orient == 'L'){
    $compheader[1] = '275'; 
}

$aLen = $compheader[1]-80;

$pdf=new PDF( $orient, 'mm', 'Letter');
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages();
$pdf->AddPage();

    $sql = "select c.account, t.name as acctType, c.name   from tbl_coa c 
	           left join tbl_types t on c.type_id = t.id
            where c.active = '1' and c.co_id = '$co'
                order by t.id, c.account ";
             try  
    {  $rs = $dbh->obj_query( $sql );
    $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $coa[$x][$key] = $value;   
            }
            $x++;
        }
        
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }

    //header information 
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell(80,5,'Account Type'); 
    $pdf->Cell(100,5,'Account Name'); 
    $pdf->ln(10); 
    $type = '';
    for($a=0;$a<count($coa);$a++){
        $curtype = $coa[$a]['acctType'];
        
        if($type == ''){
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,5,$coa[$a]['acctType']);
            $pdf->SetFont('Arial','',10);
            $pdf->ln();
                
            $pdf->Cell(20,5,$coa[$a]['account']);
            $pdf->Cell(80,5,$coa[$a]['acctType']);
            $pdf->Cell(100,5,$coa[$a]['name']);
        } elseif($curtype == $type){
            $pdf->Cell(20,5,$coa[$a]['account']);
            $pdf->Cell(80,5,$coa[$a]['acctType']);
            $pdf->Cell(100,5,$coa[$a]['name']);
            
        } else {
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(80,5,$coa[$a]['acctType']);
            $pdf->SetFont('Arial','',10);
            $pdf->ln();
            
            $pdf->Cell(20,5,$coa[$a]['account']);
            $pdf->Cell(80,5,$coa[$a]['acctType']);
            $pdf->Cell(100,5,$coa[$a]['name']);
            
            
        }
        
        
        $type = $curtype;
        $pdf->ln();
    }
 
 
 
 
$pdf->output(); 
?>
 