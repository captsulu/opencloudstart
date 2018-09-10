<? 
    require('../interface/config.inc.ihtml'); 
    require('fpdf/fpdf.php'); 
    define('FPDF_FONTPATH','fpdf/font/');
   
class PDF extends FPDF
{
//Page header
function Header(){
    global $compheader;

    $this->Cell(180,5,'Account Reconciliation Report',0,0,'C');
    $this->ln();
    $this->Cell(180,5,$compheader[0],0,0,'C');
    $this->ln();
    $this->Cell(180,5,'Account Reconcile: '.$compheader[1].' - '.$compheader[2],0,0,'C');
    $this->ln(10);
    
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

//print_r($frm); 
     
    //get company information to display on report
      //get the withdrawls
    $sql2 = "select * from tbl_company c
	join tbl_coa a on c.id = a.co_id where c.active = '1' and c.id = '$co' and a.account = '$account' ";
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
$compheader[1] = $account; 
$compheader[2] = $company['name'];    
    

$pdf=new PDF('P','mm','Letter');
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(10); 
$pdf->Cell(40,5,'Start Date: '); 
$pdf->Cell(40,5,retrieve_date($startdate));
$pdf->Cell(40,5,'Opening Balance: '); 
$pdf->Cell(40,5,number_money($startbalance));
$pdf->ln();
$pdf->Cell(40,5,'End Date: '); 
$pdf->Cell(40,5,retrieve_date($enddate)); 
$pdf->Cell(40,5,'Ending Balance: '); 
$pdf->Cell(40,5,number_money($endbalance)); 
$pdf->ln(12);

$pdf->line(10,55,210,55);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,5,'Cleared Deposit Items'); 
$pdf->SetFont('Arial','',10);
$pdf->ln();

 $pdf->Cell(40,4,'Date');
 $pdf->Cell(40,4,'Ref'); 
 $pdf->Cell(100,4,'Memo'); 
 $pdf->Cell(40,4,'Amount'); 
 
 
 $pdf->ln(); 
 
if(isset($debitAdd) && strlen($debitAdd)>0){
$debitAdd = substr($debitAdd,1,strlen($debitAdd));

    $sql = "select * from tbl_genledger where co_id = '$co' and transid in($debitAdd) and account = '$account' and active = '1' and reconcile = '1'";
    
    
             try  
    {  $rs = $dbh->obj_query( $sql );
    $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $debits[$x][$key] = $value;   
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
    
$subdebitAdd = 0;
for($a=0;$a<count($debits);$a++){
    //$pdf->Cell(20,4,$debits[$a]['transid']);
    $pdf->Cell(40,4,retrieve_date($debits[$a]['enterdate'])); 
    $pdf->Cell(40,4,$debits[$a]['reference']); 
    $pdf->Cell(100,4,$debits[$a]['memo']); 
    $pdf->Cell(40,4,number_money($debits[$a]['debit'])); 
    
    $subdebitAdd = $subdebitAdd + $debits[$a]['debit'];
    
    $pdf->ln();
 }   
    $pdf->ln();
    $pdf->Cell(180,4,' SubTotal Deposits ',0,0,'R');
    $pdf->Cell(40,4,number_money($subdebitAdd));
 
} //if exists
//get withdrawls 
$pdf->ln();
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,5,'Cleared Withdrawl Items'); 
$pdf->SetFont('Arial','',10);
$pdf->ln();


 $pdf->Cell(40,4,'Date');
 $pdf->Cell(40,4,'Ref'); 
 $pdf->Cell(100,4,'Vendor'); 
 $pdf->Cell(40,4,'Amount'); 
 
 $pdf->ln(); 

if(isset($creditAdd) && strlen($creditAdd)>0){
$creditAdd = substr($creditAdd,1,strlen($creditAdd));


    $sql = "select * from tbl_genledger g
	left join tbl_vendors v on g.vendorid = v.id 
    where g.co_id = '$co' and transid in($creditAdd) and account = '$account' and g.active = '1' and reconcile = '1'";
    
             try  
    {  $rs = $dbh->obj_query( $sql );
    $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $credits[$x][$key] = $value;   
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
 
 $subcreditsAdd = 0;
 for($a=0;$a<count($credits);$a++){
    //$pdf->Cell(20,4,$debits[$a]['transid']);
    $pdf->Cell(40,4,retrieve_date($credits[$a]['enterdate'])); 
    $pdf->Cell(40,4,$credits[$a]['reference']); 
    $pdf->Cell(100,4,$credits[$a]['coname']); 
    $pdf->Cell(40,4,number_money($credits[$a]['credit'])); 
    
    $subcreditsAdd = $subcreditsAdd + $credits[$a]['credit'];
    
    $pdf->ln();
    
 }   
    $pdf->ln();
    $pdf->Cell(180,4,' SubTotal Deposits ',0,0,'R');
    $pdf->Cell(40,4,number_money($subcreditsAdd));
    $pdf->ln();
} //if exists

 
 //////////////////////////////////////////////////////////uncleared deposits 
 
 
$pdf->ln();
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,5,'Un-Cleared Deposit Items'); 
$pdf->SetFont('Arial','',10);
$pdf->ln();


 $pdf->Cell(40,4,'Date');
 $pdf->Cell(40,4,'Ref'); 
 $pdf->Cell(100,4,'Memo'); 
 $pdf->Cell(40,4,'Amount'); 
 
 $pdf->ln(); 

    $sql = "select * from tbl_genledger where co_id = '$co' and account = '$account' and active = '1' and reconcile is null and debit>0 and enterdate between '$startdate' and '$enddate' ";
    
      
             try  
    {  $rs = $dbh->obj_query( $sql );
    $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $debits[$x][$key] = $value;   
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
 
     
    
$subdebitAdd = 0;
for($a=0;$a<count($debits);$a++){
    //$pdf->Cell(20,4,$debits[$a]['transid']);
    $pdf->Cell(40,4,retrieve_date($debits[$a]['enterdate'])); 
    $pdf->Cell(40,4,$debits[$a]['reference']); 
    $pdf->Cell(100,4,$debits[$a]['memo']); 
    $pdf->Cell(40,4,number_money($debits[$a]['debit'])); 
    
    $subdebitAdd = $subdebitAdd + $debits[$a]['debit'];
    
    $pdf->ln();
 }   
    $pdf->ln();
    $pdf->Cell(180,4,' SubTotal Un Cleared Deposits ',0,0,'R');
    $pdf->Cell(40,4,number_money($subdebitAdd));
 
 
 
$pdf->ln();
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,5,'Un-Cleared Withdrawl Items'); 
$pdf->SetFont('Arial','',10);
$pdf->ln();


 $pdf->Cell(40,4,'Date');
 $pdf->Cell(40,4,'Ref'); 
 $pdf->Cell(100,4,'Memo'); 
 $pdf->Cell(40,4,'Amount'); 
 
$pdf->ln(); 

    $sql = "select * from tbl_genledger g
	left join tbl_vendors v on g.vendorid = v.id  
    where g.co_id = '$co' and account = '$account' and g.active = '1' and reconcile is null and credit>0 and enterdate between '$startdate' and '$enddate' ";
    
      
             try  
    {  $rs = $dbh->obj_query( $sql );
    $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $credits[$x][$key] = $value;   
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
 
  $subcreditsAdd = 0;
 for($a=0;$a<count($credits);$a++){
    //$pdf->Cell(20,4,$debits[$a]['transid']);
    $pdf->Cell(40,4,retrieve_date($credits[$a]['enterdate'])); 
    $pdf->Cell(40,4,$credits[$a]['reference']); 
    $pdf->Cell(100,4,$credits[$a]['coname']); 
    $pdf->Cell(40,4,number_money($credits[$a]['credit'])); 
    
    $subcreditsAdd = $subcreditsAdd + $credits[$a]['credit'];
    
    $pdf->ln();
    
 }   
    $pdf->ln();
    $pdf->Cell(180,4,' SubTotal Uncleared Withdrawls ',0,0,'R');
    $pdf->Cell(40,4,number_money($subcreditsAdd));
    $pdf->ln();
 
 
 
$pdf->output(); 
?>
   
        
    