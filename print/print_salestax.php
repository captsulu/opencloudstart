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
    
    $this->Cell($len,5,'Sales Tax Report',0,0,'C');
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

/// get tax information 

    $sql = "select sum(debit-credit) as incomeAmt from tbl_genledger g 
	           left join tbl_coa c on g.account = c.account
	        where c.type_id in(4,5,1) and g.active = '1' and g.co_id = '$co'
                and enterdate between '$startdate' and '$enddate'";
                
      try{
        $rs = $dbh->obj_query($sql); 
        $obj = $rs->obj_fetch_object();
        $incomeAmt = $obj->incomeAmt;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }         

 
 if(isset($nontax)){       
/// get invoice non-taxable income
    $sql2 = "select sum(amountdue) as nontaxAmt from tbl_invdetail i
		          left join tbl_invoice t on i.invoice_id = t.id 
                where i.active = '1' and co_id = '$co' and taxable = '0' and
                    i.create_date between '$startdate' and '$enddate'"; 
     
          try{
        $rs = $dbh->obj_query($sql2); 
        $obj = $rs->obj_fetch_object();
        $nontaxAmt = $obj->nontaxAmt;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }         
 }              
/// get invoice taxable income 

    $sql3 = "select sum(amountdue) as taxAmt from tbl_invdetail i
		          left join tbl_invoice t on i.invoice_id = t.id 
                where i.active = '1' and co_id = '$co' and taxable = '1' and
                    i.create_date between '$startdate' and '$enddate'"; 
     
          try{
        $rs = $dbh->obj_query($sql3); 
        $obj = $rs->obj_fetch_object();
        $taxAmt = $obj->taxAmt;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }  
    
  /// get invoice taxable income 

    $sql3 = "select sum(amountdue) as taxAmt from tbl_invdetail i
		          left join tbl_invoice t on i.invoice_id = t.id 
                where i.active = '1' and co_id = '$co' and taxable = '1' and
                    i.create_date between '$startdate' and '$enddate'"; 
     
          try{
        $rs = $dbh->obj_query($sql3); 
        $obj = $rs->obj_fetch_object();
        $taxAmt = $obj->taxAmt;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }    
    
   $sql4 = "select sum(salestax) as salestax from tbl_invoice
                where active = '1' and
            co_id = '$co' and
            create_date between '$startdate' and '$enddate'"; 
    
           try{
        $rs = $dbh->obj_query($sql4); 
        $obj = $rs->obj_fetch_object();
        $salestax = $obj->salestax;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }    
   
  //get COA salestax for company
   try
     { $rs = $dbh->obj_query("select salestaxcoa from tbl_company where id = '$co' and active = '1'");
       $obj = $rs->obj_fetch_object(); 
       $salestaxcoa = $obj->salestaxcoa;
     } catch ( Exception $e ) { 
        //log error and/or redirect user to error page 
        echo $dbh->obj_error_message();
            die;
    }  
    
    
    $sql5 = "select sum(credit) as taxdue from tbl_genledger 
                where co_id = '1' and 
                active = '1' and 
                credit>0 and 
                account = '$salestaxcoa'";
            
        
          try{
        $rs = $dbh->obj_query($sql5); 
        $obj = $rs->obj_fetch_object();
        $taxdue = $obj->taxdue;
        
      } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
            echo $dbh->obj_error_message();
            die;
    }            

$pdf=new PDF( $orient, 'mm', 'Letter');
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(90,5,'Gross Income: ');
$pdf->Cell(40,5,number_money($incomeAmt),0,0,'R');
$pdf->ln();

if(isset($nontax)){
$pdf->Cell(90,5,' Non-taxable Invoice Receivables:  '); 
$pdf->Cell(40,5,number_money($nontaxAmt),0,0,'R');
$pdf->ln();
}

$pdf->Cell(90,5,' Taxable Invoice Receivables:  '); 
$pdf->Cell(40,5,number_money($taxAmt),0,0,'R');
$pdf->ln(10);

$pdf->Cell(90,5,' Invoiced SalesTax:  '); 
$pdf->Cell(40,5,number_money($salestax),0,0,'R');
$pdf->ln();


$pdf->Cell(90,5,' General Ledger SalesTax:  '); 
$pdf->Cell(40,5,number_money($taxdue),0,0,'R');
$pdf->ln();
  
 
 
 

$pdf->output(); 
?>
