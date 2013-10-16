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
$LIMIT=5000;
$pre='roadCover_';
$menber_name="if(member.Surname!='',CONCAT(member.FullNames,' ',member.Surname),CONCAT('[Company]: ',member.Name)) as Fullname";
if($_GET&&iyona_adm())$_POST=array_merge($_GET,$_POST);#@todo: remove this it's a debug purpose
iyona_log("#==============================================================================#",true);
iyona_log($_POST);
$select['getClients']  = $select['clients'] = "SELECT id,company,code,about,email,modified,creation,jesua FROM {$pre}clients";
$select['getDealer']   = $select['dealers'] = "SELECT name,code,modified,creation,jesua FROM {$pre}dealers;";
$select['getFeatures'] = $select['features'] = "SELECT id,feature,description,category,filename,manus,tab,modified,creation,jesua FROM {$pre}features;";
$select['getGroups']   = $select['groups'] = "SELECT id,name,`desc`,modified,creation,jesua FROM {$pre}groups";
$select['getUG']       = $select['link_users_groups'] = "SELECT id,`user`,`group` FROM {$pre}link_users_groups";
$select['getPU']       = $select['link_permissions_users'] = "SELECT id,`permission`,`user` FROM {$pre}link_permissions_users";
$select['getPG']       = $select['link_permissions_groups'] = "SELECT id,`permission`,`group` FROM {$pre}link_permissions_groups";
$select['getPages']    = $select['pages'] = "SELECT id,page_ref,title,content,`level`,`type`,modified,creation,jesua,`selector`,`option`,`position` FROM {$pre}pages";
$select['getPerm']     = $select['permissions'] = "SELECT id,name,`desc`,`page`,`enable`,`sub`,modified,creation,jesua FROM {$pre}permissions";
$select['getSaleman']  = $select['salesmen'] = "SELECT firstname,lastname,code,modified,creation,jesua FROM {$pre}salesmen;";
$select['getUsers']    = $select['users'] = "SELECT id,username,password,firstname,lastname,email,gender,`level`,modified,creation,jesua FROM {$pre}users";
switch($_POST['militia']){
#==============================================================================#
   case 'getClients':
   case 'getDealer':
   case 'getFeatures':
   case 'getGroups':
   case 'getUG':
   case 'getPU':
   case 'getPG':
   case 'getPages':
   case 'getPerm':
   case 'getSaleman':
   case 'getUsers': echo json_encode(array_result($select[$_POST['militia']]));break;
#==============================================================================#
   case 'dealers':
   case 'salesmen':
   case 'members':
      $y=$_POST['luna'][0]?$_POST['luna'][0]:date("Y");
      $m=$_POST['luna'][1]?$_POST['luna'][1]:date("m")-1;
      $srch="WHERE (MONTH(STR_TO_DATE(trans.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($m)} AND YEAR(STR_TO_DATE(trans.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($y)})";
      if($_POST['quaerere'] && $_POST['quaerere'][0]!=0):$srch.=" AND ";
         if($_POST['quaerere'][1]=='dealers'):$srch.="dealer.Id={$db->qstr($_POST['quaerere'][0])}";
         elseif($_POST['quaerere'][1]=='salesmen'):$srch.="agent.Id={$db->qstr($_POST['quaerere'][0])}";
         endif;
         $y=$_POST['luna'][0]?$_POST['luna'][0]:date("Y");
         $m=$_POST['luna'][1]?$_POST['luna'][1]:date("m")-1;
      endif;
      $sql=<<<IYONA
SELECT trans.Id,dealer.Name as Dealer, agree.Status,
CONCAT(agent.FullNames,' ',agent.Surname) as Salesman, $menber_name,member.IdentificationNumber as IDno,
agrement.Name,quot.Period_cd as Period,quot.CollectionMethod_cd as CollectionMethod,quot.TotalAmount, quot.DateModified
FROM road_Transactions trans
LEFT JOIN road_Intermediary dealer ON dealer.`Id`=trans.Intermediary
LEFT JOIN road_FandI agent ON agent.`Id`=trans.FandI
LEFT JOIN road_Agreements agree ON agree.transaction=trans.Id
INNER JOIN road_Holder member ON member.Id=trans.Holder
INNER JOIN road_QuoteTransactions quot ON quot.`transaction`=trans.`Id`
INNER JOIN road_Quote_Agreement agrement ON agrement.`Id`=quot.Agreement
$srch group by quot.`transaction` ORDER BY agent.Surname,member.Surname,quot.DateModified ASC LIMIT $LIMIT;
IYONA;
      iyona_log($sql);echo json_encode(array_result($sql,true));
      break;
#==============================================================================#
   case 'dealer-display':
   case 'dealers-display':
      $rows['address']=array_result("select * from road_Addresses a where a.holder={$db->qstr($_POST['iota'])}",true);
      $rows['company']=array_result("select a.IsInsurer, a.FSBNumber,a.RegistrationNumber as 'Vat Number', Name from road_RelatedStakeholders a where a.Id={$db->qstr($_POST['iota'])}",true);
      echo json_encode($rows);break;
#==============================================================================#
   case 'cautionem-dealer':
      $rows['address']=array_result("SELECT * FROM road_Addresses a WHERE a.holder={$db->qstr($_POST['iota'])} GROUP BY Uid ORDER BY `Type`",true);
      $rows['company']=array_result("SELECT * FROM {$pre}dealers a WHERE a.code={$db->qstr($_POST['iota'])}",true);
      $sql=<<<IYONA
SELECT CONCAT(agent.FullNames,' ',agent.Surname) as Salesman, $menber_name,member.IdentificationNumber as IDno, trans.Id as Deal,
quot.Period_cd as Period,quot.CollectionMethod_cd as CollectionMethod, quot.TotalAmount, quot.DateModified, sum(quot.TotalAmount) Total
FROM road_Transactions trans
LEFT JOIN road_Intermediary dealer on dealer.`Id`=trans.Intermediary
LEFT JOIN road_FandI agent on agent.`Id`=trans.FandI
INNER JOIN road_Holder member on member.Id=trans.Holder
INNER JOIN road_QuoteTransactions quot on quot.`transaction`=trans.`Id`
WHERE dealer.Id={$db->qstr($_POST['iota'])}
AND (MONTH(STR_TO_DATE(quot.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($_POST['m'])} AND YEAR(STR_TO_DATE(quot.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($_POST['y'])})
GROUP BY quot.`transaction` ORDER BY agent.Surname,member.Surname,quot.DateModified ASC
IYONA;
      $rows['customers']=array_result($sql,true);
      $sql=<<<IYONA
SELECT CONCAT(firstname,' ',lastname) as approver,invoice_number,account,dealer,i.creation,i.modified,due_date,`desc`,`status`,i.jesua
FROM {$pre}invoices i
LEFT JOIN {$pre}users u ON u.id=i.approver
WHERE dealer={$db->qstr($_POST['iota'])}
AND inv_month={$db->qstr($_POST['m'])} AND inv_year={$db->qstr($_POST['y'])}
IYONA;
      $rows['invoices']=array_result($sql,true);
      $rows['filename']=export2pastel($rows,$_POST['iota'],$_POST['m'],$_POST['y']);
      echo json_encode($rows);break;
#==============================================================================#
   case 'salesman-display':
   case 'salesmen-display':
      $rows['address']=array_result("select * from road_Addresses a where a.holder={$db->qstr($_POST['iota'])}");
      $rows['agent']=array_result("select Id,FullNames,Surname,IdentificationNumber from road_FandI a where a.Id={$db->qstr($_POST['iota'])}");
      echo json_encode($rows);break;
#==============================================================================#
   case 'customers':
      $y=$_POST['luna'][0]?$_POST['luna'][0]:date("Y");
      $m=$_POST['luna'][1]?$_POST['luna'][1]:date("m")-1;
      $srch="WHERE (MONTH(STR_TO_DATE(trans.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($m)} AND YEAR(STR_TO_DATE(trans.DateCreated,'%Y-%m-%d %h:%i:%s %p'))={$db->qstr($y)})";
      if($_POST['quaerere']):$srch.=" AND ";
         if($_POST['quaerere'][1]=='dealers'):$srch.="trans.Intermediary={$db->qstr($_POST['quaerere'][0])}";
         elseif($_POST['quaerere'][1]=='salesmen'):$srch.="trans.FandI={$db->qstr($_POST['quaerere'][0])}";
         endif;
      endif;
      $sql=<<<IYONA
SELECT member.Id as code,trans.DateCreated,$menber_name,IdentificationNumber as IDno,Race_cd Race,Nationality_cd Nationality,
Gender_cd Gender,Title_cd Title,EthnicGroup_cd EthnicGroup,trans.Id as "transaction"
FROM road_Transactions trans
INNER JOIN road_Holder member on member.Id=trans.Holder
$srch GROUP BY IDno ORDER BY DateCreated ASC LIMIT $LIMIT;
IYONA;
      $rows=array_result($sql,true);echo json_encode($rows);break;
#==============================================================================#CUSTOMER ALL
   case 'impetro omnia':
      $srch=$db->qstr($_POST['quaerere'].'%');
      $sql=<<<IYONA
SELECT member.Id as code,trans.DateCreated,$menber_name,IdentificationNumber as IDno,Race_cd Race,Nationality_cd Nationality,
Gender_cd Gender,Title_cd Title,EthnicGroup_cd EthnicGroup,trans.Id as "transaction"
FROM road_Transactions trans
INNER JOIN road_Holder member on member.Id=trans.Holder
WHERE member.Name LIKE $srch OR member.IdentificationNumber LIKE $srch OR trans.Id LIKE $srch;
IYONA;
      $rows=array_result($sql,true);echo json_encode($rows);break;
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
   #==============================================================================#CUSTOMER QUOTE
   case 'customers-quote':
      $sql=<<<IYONA
SELECT quot.DateCreated,quot.`Status`,quot.IsValid,quot.Period_cd,quot.CollectionType_cd,quot.CollectionType_cd,quot.TotalAmount
,res.PremiumType_cd,res.CurrentAmount as "Current Amount",res.IsActive,res.isPartOfMainPremium,FORMAT(res.Amount,2),res.Description,res.SubCode as "Sub Code"
FROM road_QuoteTransactions quot
INNER JOIN road_Transactions trans ON trans.Id=quot.transaction
LEFT JOIN road_QuoteResultItems res ON res.QuoteResult=quot.Id
WHERE trans.Holder={$db->qstr($_POST['iota'])};
IYONA;
      $sql=<<<IYONA
SELECT
res.PremiumType_cd,FORMAT(res.CurrentAmount,2) as "Current Amount",res.IsActive,res.isPartOfMainPremium,FORMAT(res.Amount,2)as Amount,res.Description,res.SubCode as "Sub Code"
FROM road_QuoteResultItems res
INNER JOIN road_Transactions trans ON trans.Id=res.transaction
WHERE trans.Holder={$db->qstr($_POST['iota'])}
GROUP BY res.PremiumType_cd;
IYONA;
      $rows=array_result($sql);echo json_encode($rows);break;
#==============================================================================#
#FUNCTIONS
#==============================================================================#LOGIN USER
   case 'aliquis':
      $p=$db->qstr($_POST['p']);$u=$db->qstr($_POST['u']);
      $sql="SELECT id,username,CONCAT(firstname,' ',lastname) as name,jesua,level FROM {$pre}users WHERE password=$p AND (email=$u OR username=$u)";
      $rows=array_result($sql);echo json_encode($rows);break;
      break;
#==============================================================================#count the login count
   case 'adde quemvis':
      $sql="UPDATE {$pre}users SET last_seen=NOW(), log_count=log_count+1 WHERE username={$db->qstr($_POST['quemvis'])} LIMIT 1";
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      break;
#==============================================================================#get all the db version
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
#==============================================================================#get the db changes
   case 'ipse':
      #find updates unseen updates for the user, on diferent device and devices not for that user
      $device  = md5($_SERVER['HTTP_USER_AGENT'].$_POST['moli']);
      $sql  = <<<IYONA
      SELECT mensa,jesua,trans,a.creation,a.id as ver
      FROM {$pre}versioning a
      LEFT JOIN {$pre}version_control b ON b.ver=a.id AND b.user={$db->qstr($_POST['ipse'])} AND b.device='$device'
      WHERE b.ver IS NULL OR (b.ver IS NOT NULL AND b.device!='$device' )
      GROUP BY a.trans, a.jesua ORDER BY a.id
IYONA;
      $db->SetFetchMode(ADODB_FETCH_ASSOC);
      $rs=$db->Execute($sql);iyona_message($rs,$sql);
      iyona_log($sql."\r\n<br/>".$db->ErrorMsg());
      if ($rs->_numOfRows>0)
      {
         while (!$rs->EOF) {
            extract($rs->fields);
            $table=str_replace($pre,'',$mensa);
            $sql= (strlen($jesua)>10)?$select[$table]." WHERE jesua='$jesua'":$select[$table]." WHERE id='$jesua'";
            $rs2=$db->Execute($sql);
            iyona_log($sql."\r\n<br/>".$db->ErrorMsg());
            if ($rs2->_numOfRows>0)
            {
               $cnt=0;$mensa=str_replace($pre,'',$mensa);
               $trans=($trans=="oMegA")?0:(($trans=="Alpha")?1:2);
               while (!$rs2->EOF) {$control[$mensa][$ver][$trans]=$rs2->fields;$cnt++;$rs2->MoveNext();}//end while of $rs @explain:user creation date so that the order of the object may be according
            }else{//when not found delete it completely, it is no longer necessary to keep it in the version table.
               $db->Execute("DELETE FROM {$pre}versioning WHERE jesua='$jesua'");
            }//end if of $rs1
            $rs->MoveNext();
         }//end while of $rs
         echo json_encode($control);
      }//end if of $rs
      break;
#==============================================================================#
}//end switch
iyona_log($_sql);
#==============================================================================##==============================================================================#
#==============================================================================##==============================================================================#
function array_result($_sql,$_assoc=false){
   global $db;
   if($_assoc)$db->SetFetchMode(ADODB_FETCH_ASSOC);
   $rs = $db->Execute($_sql);iyona_message($rs,$_sql);iyona_log($_sql);
   if ($rs->_numOfRows>0)
   {
      $cnt=0;
      while (!$rs->EOF) {$row[$cnt]=$rs->fields;$rs->MoveNext();$cnt++;}//end while of $rs
   }//end if of $rs
   $row['rows']['length']=$cnt;
   $row['rows']['source']='generated';
   return $row;
}
#==============================================================================#
function export2pastel($_rows,$_iota,$_m,$_y){
   $deb        =false;
   $filename   =SITE_DWLD."invoices/invoice{$_iota}_{$_y}{$_m}.csv";
   $address    =$_rows['address'];
   $company    =$_rows['company'][0];
   $customers  =$_rows['customers'];
   $invoices   =$_rows['invoices'][0];
   foreach ($address as $adrss) {
      if($adrss["Type"]=="Dns.Sh.AddressBook.PhysicalAddress"){
         $street=$adrss['StreetNumber']." ".$adrss['StreetName'];$suburb=$adrss['Suburb'];$city=$adrss['City'];$province=$adrss['Province_cd'];$code=$adrss['Code'];
      }else if($adrss["Type"]=="Dns.Sh.AddressBook.PostalAddress"){
         $street=$street?$street:$adrss['StreetNumber']." ".$adrss['StreetName'];$suburb=$suburb?$suburb:$adrss['Suburb'];$city=$city?$city:$adrss['City'];$province=$province?$province:$adrss['Province_cd'];$code=$code?$code:$adrss['Code'];
      }else if($adrss["Type"]=="Dns.Sh.AddressBook.MobileNumber"){$cell="({$adrss["AreaCode"]}) {$adrss["Number"]}";
      }else if($adrss["Type"]=="Dns.Sh.AddressBook.FixedLineNumber"){$tel="({$adrss["AreaCode"]}) {$adrss["Number"]}";
      }else if($adrss["Type"]=="Dns.Sh.AddressBook.EmailAddress"){$email="{$adrss["Address"]}";}
   }//end for
   $invNo=$invoices['invoice_number'];
   $accNo=($deb)?"ABB029":$company['account'];
   $date =($deb)?"27/05/2013":date("d/m/Y",strtotime($invoices['due_date']));
   $head=<<<IYONA
"Header","$invNo"," ","Y","$accNo",7,"$date"," ","N",0," "," "," ","$street","$suburb","$city","$province","$code"," ",0,"{$invoices['creation']}","$cell","$tel","$email",1," "," ",""," "\r\n
IYONA;
   foreach($customers as $key => $cust){
      $tax     =round((float)$cust['TotalAmount'],2);
      $no_tax  =round((float)$tax/1.14,2);
      $code    =($deb)?"ACC/LOC":$cust["CollectionMethod"];#JHB
      $store   ="JHB";
      $product =$cust["_48Months"];
      $d       =$cust["DateModified"]?"[{$cust["DateModified"]}]":"";
      $desc    ="{$cust["Salesman"]}:{$cust["Fullname"]} $d";
      $details.=<<<IYONA
"Detail",0,1,$no_tax,$tax," ",1,3,0,"$code","$product",4,"     ","$store"\r\n"Detail",0,1,0,0," ",0,3,0,"'","$desc",7,"",""\r\n"Detail",0,1,0,0," ",0,3,0,"'"," ",7," "," "\r\n
IYONA;
   }//foreach cust
   file_put_contents($filename, $head.$details);
   return str_replace(SITE_PUBLIC,SITE_URL,$filename);
}
#==============================================================================#
/* ON UPDATE dealers/salesmen table.
TRUNCATE roadCover_salesmen;

INSERT INTO roadCover_salesmen (dealer,firstname,lastname,code,idno,modified,creation,jesua)
SELECT dealer,FullNames,Surname,Id,IdentificationNumber,date_updated,NOW(),Uid FROM road_FandI;

DELETE FROM roadCover_dealers;

INSERT INTO roadCover_dealers (name,code,modified,creation,jesua,account,registration_number,vat_registration,is_insured,fsb_number)
SELECT Name,Id,NOW(),date_updated,Uid,null,null,VatRegistrationNumber,null,null FROM road_Intermediary;

UPDATE roadCover_dealers a
LEFT JOIN road_RelatedStakeholders b ON b.Id=a.code
SET a.registration_number=b.RegistrationNumber, a.vat_registration=b.VatRegistrationNumber,
a.is_insured=if(b.IsInsurer='false',false,true),a.fsb_number=b.FSBNumber;

UPDATE roadCover_dealers SET account='IMPHD' WHERE name = 'HONDA EAST RAND';
UPDATE roadCover_dealers SET account='IMPTY2' WHERE name = 'IMPERIAL TOYOTA KEMPTON PARK';
UPDATE roadCover_dealers SET account='IMPTY4' WHERE name = 'IMPERIAL TOYOTA STRIJDOMPARK';
UPDATE roadCover_dealers SET account='IMPNS4' WHERE name = 'IMPERIAL NISSAN PAROW';
UPDATE roadCover_dealers SET account='IMPBM1' WHERE name = 'KIMBERLEY MULTIFRANCHISE';
UPDATE roadCover_dealers SET account='IMPGM1' WHERE name = 'GM BLOEMFONTEIN';
UPDATE roadCover_dealers SET account='IMP08' WHERE name = 'FORD AND MAZDA CULEMBORG';
UPDATE roadCover_dealers SET account='IMP06' WHERE name = 'FORD AND MAZDA DIEP RIVER';
UPDATE roadCover_dealers SET account='IMP01' WHERE name = 'FORD AND MAZDA KEMPTON PARK';
UPDATE roadCover_dealers SET account='IMP02' WHERE name = 'FORD AND MAZDA KROONSTAD NEW';
UPDATE roadCover_dealers SET account='IMP03' WHERE name = 'FORD AND MAZDA PAARDEN EILAND';
UPDATE roadCover_dealers SET account='IMPLS1' WHERE name = 'AUDI CENTRE FOURWAYS';
UPDATE roadCover_dealers SET account='IMPLS3' WHERE name = 'LINDSAY SAKER HYDE PARK (VW)';
UPDATE roadCover_dealers SET account='IMPHD2' WHERE name = 'HONDA WESTRAND 1';
UPDATE roadCover_dealers SET account='IMPHD2' WHERE name = 'HONDA WESTRAND 1';
UPDATE roadCover_dealers SET account='IMPTY1' WHERE name = 'IMPERIAL TOYOTA BEDFORDVIEW';
UPDATE roadCover_dealers SET account='IMPTY3' WHERE name = 'IMPERIAL TOYOTA PARKTOWN 1';
UPDATE roadCover_dealers SET account='IMPNS1' WHERE name = 'IMPERIAL NISSAN EAST RAND';
UPDATE roadCover_dealers SET account='IMPA01' WHERE name = 'AUDI CENTRE AIRPORT';
UPDATE roadCover_dealers SET account='IMPBM5' WHERE name = 'VAAL RIDGE AUTO (BMW)';
UPDATE roadCover_dealers SET account='IMPGM3' WHERE name = 'GM GERMISTON';
UPDATE roadCover_dealers SET account='IMPGM6' WHERE name = 'GM ISANDO';
UPDATE roadCover_dealers SET account='IMP07' WHERE name = 'AUTO NICHE BLOEMFONTEIN';

 UPDATE road_Transactions SET DateCreated=STR_TO_DATE(DateCreated,'%d/%m/%Y %h:%i:%s %p'),DateModified=STR_TO_DATE(DateModified,'%d/%m/%Y %h:%i:%s %p');
 UPDATE road_QuoteTransactions SET DateCreated=STR_TO_DATE(DateCreated,'%d/%m/%Y %h:%i:%s %p'),DateModified=STR_TO_DATE(DateModified,'%d/%m/%Y %h:%i:%s %p');
 */
?>
