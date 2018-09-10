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
    
    $this->Cell($len,5,'Balance Statement',0,0,'C');
    $this->ln();
    $this->Cell($len,5,$compheader[0],0,0,'C');
    $this->ln(); 
    $this->Cell($len,5,$compheader[2],0,0,'C');
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

$compheader[2] = 'Period '.$startdate." thru ".$enddate;

$startdate = storage_date($startdate); 
$enddate = storage_date($enddate);

$aLen = $compheader[1]-100; 

$pdf=new PDF( $orient, 'mm', 'Letter');
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',10); 
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell($aLen,5,'Name'); 
    $pdf->Cell(20,5,'Credit',0,0,'R');
    $pdf->Cell(20,5,'Debit',0,0,'R'); 
    $pdf->Cell(20,5,'Balance',0,0,'R');
    $pdf->ln();
    $pdf->SetFont('Arial','',10);
 

$sql = "select l.account, c.name, t.name as acctType, sum(credit) as credit, sum(debit) as debit from tbl_genledger l
 	join tbl_coa c on c.account = l.account
	join tbl_types t on c.type_id = t.id
 where l.co_id = '$co' and 
 l.active = '1' and
 l.enterdate between '$startdate' and '$enddate'
 group by  c.type_id, l.account 
 order by l.account";

    try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        $balance[$x][$key] = $value;
                        
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
   $type='';
   $curBalance = 0;
   $mstBalance = 0;
   for($a=0;$a<count($balance);$a++){
     $curtype = $balance[$a]['acctType'];
     if($type == ''){
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(80,5,'   '.$balance[$a]['acctType']); 
      $pdf->SetFont('Arial','',10);
      $pdf->ln();
      $pdf->Cell(20,5,$balance[$a]['account']);
      $pdf->Cell($aLen,5,$balance[$a]['acctType'].' : '.$balance[$a]['name']);
      $pdf->Cell(20,5,$balance[$a]['credit'],0,0,'R');
      $pdf->Cell(20,5,$balance[$a]['debit'],0,0,'R');
      $pdf->Cell(20,5,number_money($balance[$a]['debit']-$balance[$a]['credit']),0,0,'R');
      $curBalance = $curBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
      $mstBalance = $mstBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
        
     }else if($curtype == $type){
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20,5,$balance[$a]['account']);
      $pdf->Cell($aLen,5,$balance[$a]['acctType'].' : '.$balance[$a]['name']);
      $pdf->Cell(20,5,$balance[$a]['credit'],0,0,'R');
      $pdf->Cell(20,5,$balance[$a]['debit'],0,0,'R');
      $pdf->Cell(20,5,number_money($balance[$a]['debit']-$balance[$a]['credit']),0,0,'R');
      $curBalance = $curBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
      $mstBalance = $mstBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
     } else {
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,'===========',0,0,'R');
      $pdf->ln();  
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,number_money($curBalance),0,0,'R');
      $curBalance = 0;  
      $pdf->ln(10);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(80,5,'   '.$balance[$a]['acctType']);
      $pdf->SetFont('Arial','',10); 
      $pdf->ln();
      $pdf->Cell(20,5,$balance[$a]['account']);
      $pdf->Cell($aLen,5,$balance[$a]['acctType'].' : '.$balance[$a]['name']);
      $pdf->Cell(20,5,$balance[$a]['credit'],0,0,'R');
      $pdf->Cell(20,5,$balance[$a]['debit'],0,0,'R');
      $pdf->Cell(20,5,number_money($balance[$a]['debit']-$balance[$a]['credit']),0,0,'R');
      $curBalance = $curBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
      $mstBalance = $mstBalance + ($balance[$a]['debit']-$balance[$a]['credit']);
        
     } 
      
     $type = $balance[$a]['acctType']; 
      $pdf->ln();  
    }
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,'===========',0,0,'R');
      $pdf->ln();  
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,number_money($curBalance),0,0,'R');
      $pdf->ln(10);
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,'===========',0,0,'R');
      $pdf->ln();  
      $pdf->Cell($aLen+60,' ');
      $pdf->Cell(20,5,number_money($mstBalance),0,0,'R');  
    




$pdf->output(); 
?>
