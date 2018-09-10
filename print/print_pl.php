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
    
    $this->Cell($len,5,'Profit and Lost Statement',0,0,'C');
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

//print_r($frm); 
     
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

$aLen = $compheader[1]-60; 

$pdf=new PDF( $orient, 'mm', 'Letter');
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,4,'     Income');
 
$pdf->ln();
$incomebal = 0;
    $sql = "select l.account, c.name, (sum(debit) + sum(credit)) as credit from tbl_genledger l
        	join tbl_coa c on c.account = l.account
        where l.co_id = '$co' and l.active = '1' and 
            c.type_id in( 1,13) and 
            l.enterdate between '$startdate' and '$enddate'
        group by l.account ";
        
    //get income information 
           try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        $income[$x][$key] = $value;
                        if($key == 'credit'){
                            $incomebal = $incomebal + $value;
                        }
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
            
        
//$pdf->MultiCell(210,5,$sql);
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell($aLen,5,'Name'); 
    $pdf->Cell(40,5,'Amount');
    $pdf->ln();
    $pdf->SetFont('Arial','',10);


    for($a=0;$a<count($income);$a++){
        
        $pdf->Cell(20,5,$income[$a]['account']); 
        $pdf->Cell($aLen,5,$income[$a]['name']); 
        $pdf->Cell(20,5,number_money($income[$a]['credit']),0,0,'R');
        $pdf->ln();
    }
        //subtotal income 
        $pdf->Cell($aLen+10,5,'');
        $pdf->Cell(20,5,'===============');
        $pdf->ln();
        $pdf->Cell($aLen+20,5,'');
        $pdf->Cell(20,5,number_money($incomebal),0,0,'R');
        $pdf->ln(10);
        
        
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(180,4,'     Expenses');
 
$pdf->ln();       
$expensebal = 0;


    $sql = "select l.account, c.name, (sum(debit) + sum(credit)) as credit from tbl_genledger l
	                   join tbl_coa c on c.account = l.account
                    where l.co_id = '$co' and l.active = '1' and 
                          c.type_id in( 3,14) and 
                          l.enterdate between '$startdate' and '$enddate'
                    group by l.account ";
                    
                    
            try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        $expense[$x][$key] = $value;
                        if($key == 'credit'){
                            $expensebal = $expensebal + $value;
                        }
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
                     
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell($aLen,5,'Name'); 
    $pdf->Cell(40,5,'Amount');
    $pdf->ln();
    $pdf->SetFont('Arial','',10);
                           
       for($a=0;$a<count($expense);$a++){
        
        $pdf->Cell(20,5,$expense[$a]['account']); 
        $pdf->Cell($aLen,5,$expense[$a]['name']); 
        $pdf->Cell(20,5,number_money($expense[$a]['credit']),0,0,'R');
        $pdf->ln();
    }
        //subtotal expense
        $pdf->Cell($aLen+10,5,'');
        $pdf->Cell(20,5,'===============');
        $pdf->ln();
        $pdf->Cell($aLen+20,5,'');
        $pdf->Cell(20,5,number_money($expensebal),0,0,'R');
        $pdf->ln(10);
  
  $ordincome = $incomebal - $expensebal;
$pdf->Cell(70,4,'Net Ordinary Income');
$pdf->Cell(25,4,number_decimal($ordincome),0,0,'R');
$pdf->ln(8);

$cogsbal = 0;
//normally you would also Deduct COGS Here 
$sql =  "select l.account, c.name, (sum(debit) + sum(credit)) as credit from tbl_genledger l
	                   join tbl_coa c on c.account = l.account
                    where l.co_id = '$co' and l.active = '1' and 
                          c.type_id = '2' and 
                          l.enterdate between '$startdate' and '$enddate'
                    group by l.account ";
                    
          try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        $cog[$x][$key] = $value;
                        if($key == 'credit'){
                            $cogsbal = $cogsbal + $value;
                        }
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

 if(isset($cog) && count($cog)>0){
    
    $pdf->SetFont('Arial','B',10); 
    $pdf->Cell(180,4,'     Cost of Goods Sold');
 
    $pdf->ln(); 



                     
    $pdf->Cell(20,5,'Account'); 
    $pdf->Cell($aLen,5,'Name'); 
    $pdf->Cell(40,5,'Amount');
    $pdf->ln();
    $pdf->SetFont('Arial','',10);
                       
    for($a=0;$a<count($cog);$a++){
        
        $pdf->Cell(20,5,$cog[$a]['account']); 
        $pdf->Cell($aLen,5,$cog[$a]['name']); 
        $pdf->Cell(20,5,number_money($cog[$a]['credit']),0,0,'R');
        $pdf->ln();
    }
        //subtotal expense
        $pdf->Cell($aLen+10,5,'');
        $pdf->Cell(20,5,'===============');
        $pdf->ln();
        $pdf->Cell($aLen+20,5,'');
        $pdf->Cell(20,5,number_money($cogsbal),0,0,'R');
        $pdf->ln(10);

}
$pdf->SetFont('Arial','B',10);
$ordincome = ($incomebal - $expensebal) - $cogsbal;

$pdf->Cell(70,4,'Net Income');
$pdf->Cell(25,4,number_decimal($ordincome),0,0,'R');
$pdf->ln();
 
$pdf->output(); 
?>
 