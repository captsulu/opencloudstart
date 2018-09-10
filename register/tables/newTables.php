<? 
   
     
    
    
    //Basic COAs
    
    $sql  = "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1000', 'Petty Cash', 4, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1010', 'Checking Account', 4, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 1, '1200', 'Accounts Receivable', 5, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1310', 'Inventory Supplies', 6, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1490', 'Undeposited Funds', 6, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1700', 'Equipment', 7, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '2000', 'Accounts Payable', 9, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '3000', 'Opening Balance Equity', 15, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '1100', 'Credit Card', 10, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 1, '1210', 'Other Receivables', 5, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '2310', 'Sales Tax Payable', 11, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '2410', 'Benefits Payable', 11, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 2, '4000', 'Income', 1, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 2, '1100', 'Merchant Account', 1, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 2, '4040', 'Discounts', 1, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 2, '4080', 'Interest Income', 1, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 4, '5000', 'Cost of Goods Sold', 2, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '5730', 'Contract Labor', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 4, '5250', 'Commissions', 2, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '6000', 'Business Expense', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 5, '6015', 'Print', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 5, '6018', 'Online', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6150', 'Bad Debt', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6200', 'Bank Fees', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6300', 'Charitable Contributions', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6350', 'Commissions/Fees', 3, 1 );";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6450', 'Subscriptions ', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6460', 'Professional Membership Dues', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6550', 'Freight', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6600', 'Gifts', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6750', 'Interest Expense', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6850', 'Legal Fees', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6900', 'Licenses', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7000', 'Maintenance', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7050', 'Meals & Entertainment', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7100', 'Office Expenses', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7350', 'Postage', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7400', 'Office Rental', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7600', 'Telephone/Cable', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7610', 'Cellphone', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7620', 'Training', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7650', 'Travel', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7800', 'Utilities', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '8900', 'Other Expense', 14, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '9000', 'Gain/Loss Sale of Assets', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6355', 'Computer Repair', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7080', 'Merchant Account Fees', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 0, '8100', 'Other Income', 13, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '6465', 'Professional Development', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 3, '7640', 'Taxes and Licenses', 3, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2210', 'Payroll', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2220', 'Commissions', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2230', 'FICA', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2240', 'Unemployment Taxes', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2250', 'Workmens Compensation', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2260', 'Medical Benefits', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2270', '401K Company Match', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2275', 'Withholding FICA', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2280', 'Withholding Medical', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 16, '2210', 'Withholding 401K', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 12, '2310', 'Accrued - Rent', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 12, '2320', 'Accrued - Interest', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 12, '2330', 'Accrued - Property Taxes', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 12, '2340', 'Accrued - Warranty Expense', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 12, '2500', 'Sales Tax', 11, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 17, '2710', 'Note Payable', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 17, '2720', 'Mortgage Payable', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 17, '2730', 'Line of Credit', 6, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 18, '3100', 'Common Stock', 8, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 18, '3200', 'Preferred Stock', 8, 1);";
    $sql .= "insert into `tbl_coa` (co_id, group_id, account, name, type_id, active ) values ($account_num, 18, '3900', 'Retained Earnings', 8, 1);";
    
    
    //echo $sql;
           
    try 
{ 
    $rs = $dbh->obj_query( $sql ); 
         
    if ( $dbh->obj_error() ) 
        throw new Exception( $dbh->obj_error_message() ); 
         
    //echo $rs->obj_num_rows();  
} 
catch ( Exception $e )  
{ 
    //log error and/or redirect user to error page 
}  

 
 
    

    