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
    
    $this->Cell($len,5,'Trasnactional Report',0,0,'C');
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
    $pdf->Cell(20,5,'Enter Date');  
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell($aLen,5,'Name/Details'); 
    $pdf->Cell(20,5,'Credit',0,0,'R');
    $pdf->Cell(20,5,'Debit',0,0,'R'); 
    
    $pdf->ln();
    $pdf->SetFont('Arial','',10);
 

$sql = "select *, c.name as acctName from tbl_genledger g 
             left join tbl_coa c on g.account = c.account    
            where g.active = '1' and g.co_id = '$co' and g.enterdate between '$startdate' and '$enddate' order by transid, enterdate";
//echo $sql; 
//die; 

 try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        $trans[$x][$key] = $value;
                        
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

$TransID = 0;
$curTransID = 0;
$creditSubtotal = 0; 
$debitSubtotal = 0;
    for($i=0;$i<count($trans);$i++){
        $curTransID = $trans[$i]['transid'];
        
        if($TransID == 0){
        
        $pdf->Cell(20,5,retrieve_date($trans[$i]['enterdate']));
        $pdf->Cell(20,5,$trans[$i]['account']);
        
        $pdf->Cell($aLen,5,$trans[$i]['acctName'].'::'.$trans[$i]['memo']);
        $pdf->Cell(20,5,number_money($trans[$i]['credit']),0,0,'R');
        $pdf->Cell(20,5,number_money($trans[$i]['debit']),0,0,'R');
        $creditSubtotal = $creditSubtotal + $trans[$i]['credit'];
        $debitSubtotal = $debitSubtotal + $trans[$i]['debit'];        
        } elseif ($TransID == $curTransID) { 
            
            $pdf->Cell(20,5,retrieve_date($trans[$i]['enterdate']));
            $pdf->Cell(20,5,$trans[$i]['account']);
            $pdf->Cell($aLen,5,$trans[$i]['acctName'].'::'.$trans[$i]['memo']);
            $pdf->Cell(20,5,number_money($trans[$i]['credit']),0,0,'R');
            $pdf->Cell(20,5,number_money($trans[$i]['debit']),0,0,'R');
            $creditSubtotal = $creditSubtotal + $trans[$i]['credit'];
            $debitSubtotal = $debitSubtotal + $trans[$i]['debit'];
            
        } else {
            $pdf->Cell(40,5,''); 
            $pdf->Cell($aLen,5,' ',0,0,'R');
            $pdf->Cell(20,5,'=========',0,0,'R');
            $pdf->Cell(20,5,'=========',0,0,'R');
            $pdf->ln();
            $pdf->Cell(40,5,''); 
            $pdf->Cell($aLen,5,' ',0,0,'R');
            $pdf->Cell(20,5,number_money($creditSubtotal),0,0,'R');
            $pdf->Cell(20,5,number_money($debitSubtotal),0,0,'R');
            $pdf->ln();
             
            $creditSubtotal = 0;
            $debitSubtotal = 0; 
            
            
            $pdf->ln();
            $pdf->Cell(20,5,retrieve_date($trans[$i]['enterdate']));
            $pdf->Cell(20,5,$trans[$i]['account']);
            $pdf->Cell($aLen,5,$trans[$i]['acctName'].'::'.$trans[$i]['memo']);
            $pdf->Cell(20,5,number_money($trans[$i]['credit']),0,0,'R');
            $pdf->Cell(20,5,number_money($trans[$i]['debit']),0,0,'R');
            
            $creditSubtotal = $creditSubtotal + $trans[$i]['credit'];
            $debitSubtotal = $debitSubtotal + $trans[$i]['debit'];
            
        }
        
        
         $pdf->ln();
        $TransID = $curTransID;
        
    }
            $pdf->Cell(40,5,''); 
            $pdf->Cell($aLen,5,' ',0,0,'R');
            $pdf->Cell(20,5,'=========',0,0,'R');
            $pdf->Cell(20,5,'=========',0,0,'R');
            $pdf->ln();
            $pdf->Cell(40,5,''); 
            $pdf->Cell($aLen,5,' ',0,0,'R');
            $pdf->Cell(20,5,number_money($creditSubtotal),0,0,'R');
            $pdf->Cell(20,5,number_money($debitSubtotal),0,0,'R');
            $pdf->ln();

$pdf->output(); 
?>
