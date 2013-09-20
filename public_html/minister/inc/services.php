<?php
/*
 * accepts services request
 * @author fredtma
 * @version 2.5
 * @category service
 */
ini_set('memory_limit', '2056M');
ini_set('max_execution_time', 60*60*24);
header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');
include('muneris.php');
$LIMIT=500;
$pre='roadCover_';
if($_GET&&iyona_adm())$_POST=array_merge($_GET,$_POST);#@todo: remove this it's a debug purpose

switch($_POST['militia']){
#==============================================================================#
   case 'getUG': echo json_encode(array_result("SELECT id,`user`,`group` FROM {$pre}link_users_groups"));break;
   case 'getPU': echo json_encode(array_result("SELECT id,`permission`,`user` FROM {$pre}link_permissions_users"));break;
   case 'getPG': echo json_encode(array_result("SELECT id,`permission`,`group` FROM {$pre}link_permissions_groups"));break;
   case 'getPerm': echo json_encode(array_result("SELECT id,name,`desc`,`page`,`enable`,`sub`,modified,creation,jesua FROM {$pre}permissions"));break;
   case 'getPages': echo json_encode(array_result("SELECT id,page_ref,title,content,`level`,`type`,modified,creation,jesua,`selector`,`option`,`position` FROM {$pre}pages"));break;
   case 'getGroups': echo json_encode(array_result("SELECT id,name,`desc`,modified,creation,jesua FROM {$pre}groups"));break;
   case 'getUsers': echo json_encode(array_result("SELECT id,username,password,firstname,lastname,email,gender,`level`,modified,creation,jesua FROM {$pre}users"));break;
   case 'getClients': echo json_encode(array_result("SELECT id,company,code,about,email,modified,creation,jesua FROM {$pre}clients"));break;
   case 'getFeatures': echo json_encode(array_result("SELECT id,feature,description,category,filename,manus,tab,modified,creation,jesua FROM {$pre}features;"));break;
   case 'getDealer': echo json_encode(array_result("SELECT Id,Name,Uid FROM road_Intermediary;"));break;
   case 'getSaleman': echo json_encode(array_result("SELECT Id,FullNames,Surname,Uid,date_updated FROM road_FandI;"));break;
#==============================================================================#
   case 'dealers':
   case 'salesmen':
   case 'members':
      if($_POST['quaerere']):
         $srch="WHERE";
         if($_POST['quaerere'][1]=='dealers'):$srch.=" dealer.Id={$db->qstr($_POST['quaerere'][0])}";
         elseif($_POST['quaerere'][1]=='salesmen'):$srch.=" agent.Id={$db->qstr($_POST['quaerere'][0])}";
         endif;
      endif;
      $sql=<<<IYONA
SELECT trans.Id,dealer.Name as Dealer,
concat(agent.FullNames,' ',agent.Surname) as Salesman, concat(member.FullNames,' ',member.Surname) as Fullname,member.IdentificationNumber as IDno,agrement.Name,quot.Period_cd as Period,quot.CollectionMethod_cd as CollectionMethod,quot.TotalAmount, quot.DateModified
FROM road_Transactions trans
LEFT JOIN road_Intermediary dealer on dealer.`Id`=trans.Intermediary
LEFT JOIN road_FandI agent on agent.`Id`=trans.FandI
INNER JOIN road_Holder member on member.Id=trans.Holder
INNER JOIN road_QuoteTransactions quot on quot.`transaction`=trans.`Id`
INNER JOIN road_Quote_Agreement agrement on agrement.`Id`=quot.Agreement
$srch group by quot.`transaction`;
IYONA;
      echo json_encode(array_result($sql,true));
      break;
#==============================================================================#
   case 'dealer-display':
   case 'dealers-display':
      $rows['address']=array_result("select * from road_Addresses a where a.holder={$db->qstr($_POST['iota'])}");
      $rows['company']=array_result("select a.IsInsurer, a.FSBNumber,a.RegistrationNumber as 'Vat Number', Name from road_RelatedStakeholders a where a.Id={$db->qstr($_POST['iota'])}");
      echo json_encode($rows);break;
#==============================================================================#
   case 'salesman-display':
   case 'salesmen-display':
      $rows['address']=array_result("select * from road_Addresses a where a.holder={$db->qstr($_POST['iota'])}");
      $rows['agent']=array_result("select Id,FullNames,Surname,IdentificationNumber from road_FandI a where a.Id={$db->qstr($_POST['iota'])}");
      echo json_encode($rows);break;
#==============================================================================#
   case 'customers':
      if($_POST['quaerere']):
         $srch="WHERE";
         if($_POST['quaerere'][1]=='dealers'):$srch.=" trans.Intermediary={$db->qstr($_POST['quaerere'][0])}";
         elseif($_POST['quaerere'][1]=='salesmen'):$srch.=" trans.FandI={$db->qstr($_POST['quaerere'][0])}";
         endif;
      endif;
      $sql=<<<IYONA
SELECT member.Id as code,trans.DateCreated,concat(FullNames,' ',Surname) as Fullnames,IdentificationNumber as IDno,Race_cd Race,Nationality_cd Nationality,Gender_cd Gender,Title_cd Title,EthnicGroup_cd EthnicGroup
FROM road_Transactions trans INNER JOIN road_Holder member on member.Id=trans.Holder
$srch GROUP BY IDno ORDER BY DateCreated ASC LIMIT $LIMIT;
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER BRIEF
   case 'customers-brief':
      $sql=<<<IYONA
SELECT RegistrationNumber,car.Description,FirstDebitDate,MonthlyDebitDay,FORMAT(Deposit,2)Deposit,FORMAT(PrincipalDebt,2)PrincipalDebt,
FORMAT(sale1.FinancedAmount,2) as 'FSPFees',
FORMAT(sale2.FinancedAmount,2) as 'HandlinFees',
FORMAT(sale3.FinancedAmount,2) as 'ServiceAndDelivery',
FORMAT(sale4.FinancedAmount,2) as 'Vaps',
#FORMAT(sale5.FinancedAmount,2) as 'Accessories',
trans.Id
FROM road_Holder cust
INNER JOIN road_TxItems car ON car.holder=cust.Id
INNER JOIN road_Transactions trans ON trans.Holder=cust.Id
INNER JOIN road_TxCollectionCategoryDetail bank ON bank.`transaction`=trans.Id
INNER JOIN road_TxVehicleSaleCategoryDetail pay ON pay.`transaction`=trans.Id
LEFT JOIN road_SaleAmounts sale1 ON sale1.Tx=trans.Id AND sale1.AmountBreakdownType_cd ='FSPFees'
LEFT JOIN road_SaleAmounts sale2 ON sale2.Tx=trans.Id AND sale2.AmountBreakdownType_cd ='HandlingFees'
LEFT JOIN road_SaleAmounts sale3 ON sale3.Tx=trans.Id AND sale3.AmountBreakdownType_cd ='ServiceAndDelivery'
LEFT JOIN road_SaleAmounts sale4 ON sale4.Tx=trans.Id AND sale4.AmountBreakdownType_cd ='Vaps'
#LEFT JOIN road_SaleAmounts sale5 ON sale4.Tx=trans.Id AND sale5.AmountBreakdownType_cd ='Accessories'
WHERE cust.Id={$db->qstr($_POST['iota'])};
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER ADDRESS
   case 'customers-address':
      $sql=<<<IYONA
SELECT adr1.Address Email,CONCAT('(',adr3.AreaCode,')',adr3.Number) AS Tel ,CONCAT('(',adr4.AreaCode,')',adr4.Number) AS Cell
,CONCAT(adr5.UnitNumber,' ',adr5.UnitName) AS Unit,CONCAT(adr5.StreetNumber,' ',adr5.StreetName,' ',adr5.Suburb) AS Address,adr5.City,adr5.Province_cd Province,adr5.Code
,CONCAT(adr6.StreetNumber,' ',adr6.StreetName,', ',adr6.Suburb,' ',adr6.City,', ',adr6.Province_cd,' ',adr6.Code) AS PostAddress
FROM road_Holder cust
LEFT JOIN road_Addresses adr1 ON adr1.holder=cust.Id AND adr1.Type='Dns.Sh.AddressBook.EmailAddress' AND adr1.Address!=''
LEFT JOIN road_Addresses adr3 ON adr3.holder=cust.Id AND adr3.Type='Dns.Sh.AddressBook.FixedLineNumber' AND adr3.Number!=''
LEFT JOIN road_Addresses adr4 ON adr4.holder=cust.Id AND adr4.Type='Dns.Sh.AddressBook.MobileNumber' AND adr4.Number!=''
LEFT JOIN road_Addresses adr5 ON adr5.holder=cust.Id AND adr5.Type='Dns.Sh.AddressBook.PhysicalAddress' AND adr5.City!=''
LEFT JOIN road_Addresses adr6 ON adr6.holder=cust.Id AND adr6.Type='Dns.Sh.AddressBook.PostalAddress' AND adr6.City!=''
WHERE cust.Id={$db->qstr($_POST['iota'])};
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER EXPENSES
   case 'customers-expenses':
      $sql=<<<IYONA
SELECT `Group`,SubType_cd Category,Description,FORMAT(Amount,2) AS Amounts
FROM road_IncomeAndExpenses a
WHERE Person={$db->qstr($_POST['iota'])} AND Amount!='' AND Amount!=0
GROUP BY Category,Amount
ORDER BY `Group`,Category,Amount;
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER VEHICLE
   case 'customers-vehicle':
      $sql=<<<IYONA
SELECT a.Description Vehicle,a.MotorVehicleType, a.EngineNumber, a.FirstRegistrationDate, a.HasImmobiliser, a.RegistrationNumber,
a.VINNumber, a.Year, a.ItemType_cd ItemType, b.PurchaseDate,b.IsNew,b.IsDemo,b.UseType_Cd UseType,b.PurchaseDate,b.StockNumber,FORMAT(b.Amount,2)Amount
FROM road_TxItems a
LEFT JOIN road_TxVehicleDetail b ON b.`Type`=a.Id
WHERE a.holder={$db->qstr($_POST['iota'])}
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER VEHICLE
   case 'customers-payment':
      $sql=<<<IYONA
SELECT z.Id,a.AccountType_cd,a.BankAccountNo,a.FirstDebitDate,a.MonthlyDebitDay,
b.ApplicationType_cd,b.PurchasePurpose_cd,b.CustomerType_cd,b.RequestedInterestRate,b.PaymentFrequency_cd,b.ContractPeriod,b.RateType_cd,b.RequestedResidual,b.RequestedResidualPercentage,b.FinanceHouse_cd,
c.ConsentCreditBuro,c.ConfirmLOAReceived,d.SourceOfDeposit_cd,FORMAT(d.Deposit,2)Deposit,FORMAT(d.Discount,2)Discount,FORMAT(d.PrincipalDebt,2)PrincipalDebt
FROM road_Transactions z
LEFT JOIN road_TxCollectionCategoryDetail a ON a.`transaction`=z.Id
LEFT JOIN road_TxFinanceCategoryDetail b ON b.`transaction`=z.Id
LEFT JOIN road_TxConsentCategoryDetail c ON c.`transaction`=z.Id
LEFT JOIN road_TxVehicleSaleCategoryDetail d ON d.`transaction`=z.Id
WHERE z.Holder={$db->qstr($_POST['iota'])} GROUP BY z.Id;
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#CUSTOMER COVER
   case 'customers-cover':
      $sql=<<<IYONA
SELECT
IsNotCompletedTimeConstraint AS 'Is Not Completed Time Constraint',IsNotCompletedClientRequest AS 'Is Not Completed Client Request',IsFinanceOffered AS 'Is FinanceOffered',AcceptNoShortTermCover AS 'Accept No Short Term Cover',AcceptNoScratchAndDent AS 'Accept No Scratch And Dent',AcceptNoAddCover AS 'Accept No Add Cover',AcceptNoDepositCover AS 'Accept No Deposit Cover',AcceptNoWarranty AS 'Accept No Warranty',AcceptNoServicePlan AS 'Accept No Service Plan',AcceptNoMaintenancePlan AS 'Accept No Maintenance Plan',AcceptNoCreditLife AS 'Accept No Credit Life',RequiresServicePlan AS 'Requires Service Plan',RequiresWarranty AS 'Requires Warranty',AmountWillingToSpendOnVaps AS 'Amount Willing To Spend On Vaps'
FROM road_TxNeedsAnalysisCategoryDetail
INNER JOIN road_Transactions ON road_Transactions.Id=road_TxNeedsAnalysisCategoryDetail.transaction
WHERE road_Transactions.Holder={$db->qstr($_POST['iota'])};
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#
#FUNCTIONS
#==============================================================================#
   case 'adde quemvis':
      $sql="UPDATE {$pre}users SET last_seen=NOW(), log_count=log_count+1 WHERE username={$db->qstr($_POST['quemvis'])} LIMIT 1";
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      break;
#==============================================================================#
   case 'verto':
      if(empty($_POST['ver'])||!is_float((float)$_POST['ver'])) {return false;}
      if(is_array($_POST['revision']))$_POST['revision']=json_encode($_POST['revision']);
      $sql="REPLACE INTO {$pre}version_db (ver,revision)VALUES({$db->qstr($_POST['ver'])},{$db->qstr($_POST['revision'])})";
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      $sql="SELECT ver,revision FROM {$pre}version_db WHERE ver>{$db->qstr($_POST['cur'])}";
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      if ($rs->_numOfRows>0)
      {
         while (!$rs->EOF) {
            extract($rs->fields);
            if($revision)$return .= str_replace(array("&quot;","{","}"),array('"',"",""),$revision).",";
            $rs->MoveNext();
         }//end while of $rs
         $return = json_decode("{".rtrim($return,",")."}",true);
         echo json_encode($return);$jErr=json_last_error();
      }//end if of $rs
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      break;
#==============================================================================#
}//end switch
function array_result($_sql,$_assoc=false){
   global $db;
   if($_assoc)$db->SetFetchMode(ADODB_FETCH_ASSOC);
   $rs = $db->Execute($_sql);iyona_message($rs,$_sql,1);#iyona($_sql);
   if ($rs->_numOfRows>0)
   {
      $cnt=0;
      while (!$rs->EOF) {$row[$cnt]=$rs->fields;$rs->MoveNext();$cnt++;}//end while of $rs
   }//end if of $rs
   $row['rows']['length']=$cnt;
   $row['rows']['source']='generated';
   return $row;
}
?>
