<?php
/**
 * Description of class
 *
 * @author ftshimanga
 */
class FILL_DB  {
	/*the forlder where xml files are located*/
   var $path = 'xml/';
	/*the object representing the main XML*/
   var $simpleXML;
	/*if using roadcover xml which are more complex and customized*/
   var $road_cover;
	/*use SET in the query insert for easy of readbility*/
	var $use_set=false;
   var $test_mode=true;
   var $append_table=false;
   #===========================================================================#CONSTRUCTION
   function __construct($_on='', $_filename='transaction.xsd',$test_node=true,$append_table=false){
      $this->test_mode=$test_node;
      $this->append_table=$append_table;
      if($this->set_xml($_filename)):
         iyona($_filename);
         switch ($_on)
         {
            case 'both'    : $this->fill_transactions(); $this->fill_quotes('quote.xsd'); $this->road_cover=true; break;
            case 'quotes'  : $this->fill_quotes(); $this->road_cover=true; break;
            case 'trans'   : $this->fill_transactions(); $this->road_cover=true; break;
            case 'agree'   : $this->fill_agreement(); $this->road_cover=true; break;
            default: break;
         }
      else:
         iyona("Could not read $_filename");
      endif;
   }//end function
   #===========================================================================#FILL AGREEMENT
   function fill_agreement($_filename=''){
      global $db;

      if ($_filename && is_readable($this->path.$_filename)):
         $this->simpleXML  = file_get_contents($this->path.$_filename);
         $this->simpleXML  = new SimpleXMLElement($this->simpleXML);
      endif;
      foreach($this->simpleXML as $items):
         if (true):
            $OfferingResults     = $db->qstr(count($items->OfferingResults->children()));
            $LatestOfferingResult= $db->qstr((string)$items->LatestOfferingResult->Status);
            $transaction         = $db->qstr((string)$items->Tx['Id']);
            $OfferingReference   = $db->qstr((string)$items->Offering['Id']);
            $Status              = $db->qstr((string)$items->Status);
            $DateModified        = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->DateModified))));
            $StartDate           = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->StartDate))));
            $EndDate             = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->EndDate))));
            $Id                  = $db->qstr((string)$items->Id);
            $Uid                 = $db->qstr((string)$items->Uid);

            $sql = <<<IYONA
REPLACE INTO {$this->append_table}AgreementResults (OfferingResults,LatestOfferingResult,`transaction`,OfferingReference,`Status`,DateModified,StartDate,EndDate,Id,Uid)
VALUES ($OfferingResults,$LatestOfferingResult,$transaction,$OfferingReference,$Status,$DateModified,$StartDate,$EndDate,$Id,$Uid)
IYONA;
            if(!$this->test_mode){$rs = $db->Execute($sql);iyona_message($rs,$sql,1);}
            else if($this->test_mode===true)_iyona($sql);
         endif;
      endforeach;
   }//endfunction
   #===========================================================================#FILL QUOTES
   function fill_quotes($_filename=''){
      global $db;

      if ($_filename && is_readable($this->path.$_filename)):
         $this->simpleXML  = file_get_contents($this->path.$_filename);
         $this->simpleXML  = new SimpleXMLElement($this->simpleXML);
      endif;
      foreach($this->simpleXML as $items):
         if (true):
            $QuotedValues     = count($items->QuotedValues->children());
            $QuoteResultItems = count($items->QuoteResultItems->children());
            $dateCreated         = date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->DateCreated)));
            $dateModified        = date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->DateModified)));
            $Agremeent        = $items->Agreement->Offering->Id;
            $transaction      = $items->Agreement->Tx['Id'];
            $sql = <<<IYONA
REPLACE INTO {$this->append_table}QuoteTransactions (Id, Uid, Ver, Agreement, Duration, DateModified, Status, StartDate, EndDate,
IsValid, CollectionType_cd, Period_cd, CollectionMethod_cd, TotalAmount, QuotingModuleInfo, DateCreated, QuotedValues, QuoteResultItems, transaction )
VALUES ('$items->Id', '$items->Uid', '$items->Ver', '$Agremeent', '$items->Duration', $dateModified, '$items->Status', '$items->StartDate', '$items->EndDate',
'$items->IsValid', '$items->CollectionType_cd', '$items->Period_cd', '$items->CollectionMethod_cd', '$items->TotalAmount', '$items->QuotingModuleInfo', $dateCreated,
 $QuotedValues, $QuoteResultItems, $transaction)
IYONA;
            if(!$this->test_mode){$rs = $db->Execute($sql);iyona_message($rs,$sql,1);}
            else if($this->test_mode===true)_iyona($sql);
         endif;
         $fields['Agreement']    = '{"Offering":["Id","Ver","Uid","Name","Description","Category_Id","IsActive","IsConfigured","CertificateType","Params","ExtendedProperty_cd","DefaultQuotingModule"],"1":"Status","2":"DateModified","3":"StartDate","4":"EndDate","5":"ExternalReferenceNo"}';
         $fields['QuoteResult']  = '["Id","Ver","Uid","PremiumType_cd","CurrentAmount","IsActive","isPartOfMainPremium","Amount","Text","isSelected","isOptional","GroupName","IsVisible","Description","SubCode"]';

         $this->insert_node($items->Agreement,'Quote_Agreement',$fields['Agreement'],'{}',array( 'Insurer'=>array('Insurer','Id'), 'transaction'=>0));
         $this->insert_node($items->QuoteResultItems->{'Dns.Quote.Premium.Premium'},'QuoteResultItems',$fields['QuoteResult'],'{}',array( 'QuoteResult'=>array('QuoteResult','Id'), 'transaction'=>$transaction));
         $this->insert_node($items->QuoteResultItems->{'Dns.Quote.Premium.EditablePremium'},'QuoteResultItems',$fields['QuoteResult'],'{}',array( 'QuoteResult'=>array('QuoteResult','Id'), 'transaction'=>$transaction));
      endforeach;
   }//endfunction
   #===========================================================================#FILL TRANSACTION
   function fill_transactions(){
      global $db;

      foreach($this->simpleXML as $items):
         if (true):
            $Holder              = $items->Holder->Id;
            $Intermediary        = $items->Intermediary->Id;
            $Fandi               = $items->FandI->Id;
            $Agreement           = (string)$items->Agreements->Agreement->Id;
            $dateCreated         = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->DateCreated))));
            $dateModified        = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->DateModified))));
            $DateStart           = $db->qstr(date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$items->Agreements->Agreement->StartDate))));
            $SysUser             = count($items->SysUser);
            $RelatedStakeholders = count($items->RelatedStakeholders->children());
            $TxItems             = count($items->TxItems->children());
            $TxCategoryDetails   = count($items->TxCategoryDetail->children());
            $TxShDetails         = count($items->TxShDetails->children());
            $TxItemsDetails      = count($items->TxItemDetails->children());
            $Agreements          = count($items->Agreements->children());
            $CategorySelections  = count($items->CategorySelections->children());
            $sql = <<<IYONA
REPLACE INTO {$this->append_table}Transactions (Id, Uid, Ver, Status, WorkflowInstanceId, Comments, DateCreated, DateModified, DateStart, DealType_cd, ExternalReferenceNumber, ChangeHistory,
NotTakenUpReason_cd, NotTakenUpDescription,Holder, Intermediary, FandI, Agreement, SysUser, RelatedStakeholders, TxItems, TxCategoryDetails, TxShDetails, TxItemsDetails, Agreements, CategorySelections )
VALUES ('$items->Id', '$items->Uid', '$items->Ver', '$items->Status', '$items->WorkflowInstanceId', '$items->Comments', $dateCreated, $dateModified, $DateStart, '$items->DealType_cd',
'$items->ExternalReferenceNumber', '$items->ChangeHistory', '$items->NotTakenUpReason_cd', '$items->NotTakenUpDescription', $Holder, $Intermediary, $Fandi, $Agreement, $SysUser, $RelatedStakeholders, $TxItems, $TxCategoryDetails, $TxShDetails, $TxItemsDetails, $Agreements, $CategorySelections)
IYONA;
            if(!$this->test_mode){$rs = $db->Execute($sql);iyona_message($rs,$sql,1);}
            else if($this->test_mode===true)_iyona($sql);
            iyona("DateBegin: $DateStart ".++$cnt);
//exit(count($items)." and ".count($this->simpleXML));
         endif;
         $fields['Holder']       = '["Id","Ver","Uid","CountryOfOrigin_cd","EthnicGroup_cd","Initials","Surname","FullNames","PreferredName","MaidenName","IdentificationNumber","Title_cd","Gender_cd","Nationality_cd","BirthDate","Race_cd","RegistrationNumber","IsVatRegistered","VatRegistrationNumber","TradingAs","IsActive","CompanyType_cd","Name"]';
         $fields['Addresses']    = '{"Address":["Id","Ver","Uid","CountryCode","AreaCode","Number","Address","ContractType_cd","Line1","Line2","UnitName","UnitNumber","StreetName","StreetNumber","Province_cd","Suburb","City","Code","AddressStatus"]}';
         $fields['Intermediary'] = '["Id","Uid","Name","TradingAs","VatRegistrationNumber","CompanyName"]';
         $fields['FandI']        = '["Id","Uid","Name","FullNames","Surname","IdentificationNumber"]';
         $fields['Related'][0]   = '{"Sh":["Id","Uid","Ver","IsInsurer","IsPortalCompany","FSBNumber","RegistrationNr","RegistrationNumber","VatRegistrationNumber","TradingAs","Name","IsIntermediary"]}';
/*
//         $fields['Related'][1]['Sh']['Addresses']['Dns.Sh.ShAddress'][] = 'Addresses';
//         $fields['Related'][1]['Sh']['Addresses']['Dns.Sh.ShAddress'][] = '{"Address":["Id","Ver","Uid","CountryCode","AreaCode","Number","Address","ContractType_cd","Line1","Line2","UnitName","UnitNumber","StreetName","StreetNumber","Province_cd","Suburb","City","Code","AddressStatus"]}';
*/
         $fields['TxItems']      = '{"Item":["Id","Uid","Ver","MotorVehicleType","HasRunflat","EngineNumber","FirstRegistrationDate","HasImmobiliser","MM_Code","RegistrationNumber","VINNumber","Year","ItemType_cd","Description"]}';
         $fields['TxFinance']    = '["Id","Uid","Ver","ApplicationType_cd","PurchasePurpose_cd","CustomerType_cd","RequestedInterestRate","PaymentFrequency_cd","ContractPeriod","RateType_cd","RequestedResidual","RequestedResidualPercentage","FinanceHouse_cd"]';
         $fields['TxCollection'] = '{"Account":["Id","Uid","Ver","AccountHolder","AccountType_cd","BankAccountNo","BankAccountHolderName"],"1":"frequency_cd","2":"paymentmethod_cd","3":"FirstDebitDate","4":"MonthlyDebitDay"}';
         $fields['TxConsent']    = '["Id","Uid","Ver","ConsentCreditBuro","ConsentTelemarketing","ConsentCrossSell","ConsentOtherCompanies","ConfirmLOAReceived","ConsentInformationStoring","ConsentAgent"]';
         $fields['TxNeeds']      = '["Id","Uid","Ver","IsNotCompletedTimeConstraint","IsNotCompletedClientRequest","IsFinanceOffered","AcceptNoShortTermCover","AcceptNoScratchAndDent","AcceptNoAddCover","AcceptNoDepositCover","AcceptNoWarranty","AcceptNoServicePlan","AcceptNoMaintenancePlan","AcceptNoCreditLife","RequiresServicePlan","RequiresWarranty","AmountWillingToSpendOnVaps"]';
         $fields['TxVehicle']    = '["Id","Uid","Ver","Deposit","Discount","OEMExtras","SourceOfDeposit_cd","PrincipalDebt","CostPrice"]';
         $fields['SaleAmounts'][0] = '{}';
         $fields['SaleAmounts'][1]['Dns.Bts.VehicleSale.TxVehicleSaleNsaAmountBreakDown'][] = 'SaleAmounts';
         $fields['SaleAmounts'][1]['Dns.Bts.VehicleSale.TxVehicleSaleNsaAmountBreakDown'][] = '["Id","Ver","Uid","AmountBreakdownType_cd","CashAmount","MonthlyAmount","FinancedAmount","BulkedAmount"]';
         $fields['SaleAmounts'][1]['Dns.Bts.VehicleSale.TxVehicleSaleNsaAmountBreakDown'][] = '{}';
         $fields['SaleAmounts'][1]['Dns.Bts.VehicleSale.TxVehicleSaleNsaAmountBreakDown'][] = array('Tx'=>array('Tx','Id'));
         $fields['SaleAmounts'][2]['Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'][] = 'SaleAmounts';
         $fields['SaleAmounts'][2]['Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'][] = '["Id","Ver","Uid","AmountBreakdownType_cd","CashAmount","MonthlyAmount","FinancedAmount","BulkedAmount"]';
         $fields['SaleAmounts'][2]['Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'][] = '{}';
         $fields['SaleAmounts'][2]['Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'][] = array('Tx'=>array('Tx','Id'));
         $fields['SaleAmounts'][3]['Dns.Bts.VehicleSale.TxVehicleVapsSaleAmountBreakDown'][] = 'SaleAmounts';
         $fields['SaleAmounts'][3]['Dns.Bts.VehicleSale.TxVehicleVapsSaleAmountBreakDown'][] = '["Id","Ver","Uid","AmountBreakdownType_cd","CashAmount","MonthlyAmount","FinancedAmount","BulkedAmount"]';
         $fields['SaleAmounts'][3]['Dns.Bts.VehicleSale.TxVehicleVapsSaleAmountBreakDown'][] = '{}';
         $fields['SaleAmounts'][3]['Dns.Bts.VehicleSale.TxVehicleVapsSaleAmountBreakDown'][] = array('Tx'=>array('Tx','Id'));
         $fields['TxShDetails']  = '["Id","Uid","Ver","SourceOfFunds_Cd","OccupationCategory_Cd","EmploymentSector_Cd","Occupation_Cd","SalaryDay","MonthsAtEmployer"]';
         $fields['IncExp']       = '["Id","Uid","Ver","IsIncome","Amount","SubType_cd","Group","Description"]';
         $fields['PlanDetail']   = '["Id","Uid","Ver","CurrentPlan_cd","CoverFromKm","CoverUptoKm","ContractPeriod_cd"]';
         $fields['VehicleDetail']= '["Id","Uid","Ver","ODOMeterReading","Amount","IsNew","IsDemo","UseType_Cd","PurchaseDate","StockNumber","IsAgedOldies"]';
         $fields['Agreements']   = '["Id","Uid","Status","OfferingId","OfferingUid","LatestOfferingResultId","LatestOfferingResultUid","StartDate"]';
         $fields['CatSelections']= '["Id","Uid","Ver","Status"]';

         $children['Holder']     = '["Addresses"]';
         $this->insert_node($items->Holder,'Holder',$fields['Holder'],$children['Holder'], array('Type'=>array("iyona-node","Type"), 'transaction'=>$items->Id));

         $this->insert_node($items->Holder->Addresses->{'Dns.Sh.ShAddress'},'Addresses',$fields['Addresses'],'{}', array('Type'=> array("Address","Type"),'holder'=>array("Sh","Id") ));
         foreach($items->RelatedStakeholders->{'Dns.Bts.TxStakeholder'} as $adr):
            $this->insert_node($adr->Sh->Addresses->{'Dns.Sh.ShAddress'},'Addresses',$fields['Addresses'],'{}', array('Type'=> array("Address","Type"),'holder'=>array("Sh","Id") ));
         endforeach;
         $this->insert_node($items->Intermediary,'Intermediary',$fields['Intermediary'],'{}', array('transaction'=>$items->Id,'dealer'=>$Intermediary));
         $this->insert_node($items->FandI,'FandI',$fields['FandI'],'{}', array('transaction'=>$items->Id));
         $this->insert_node($items->RelatedStakeholders->{'Dns.Bts.TxStakeholder'},'RelatedStakeholders',$fields['Related'],'{}', array('ref'=>array('Parent','Id'),'Type'=>array('Sh','Type'),'transaction'=>$items->Id));
         $this->insert_node($items->TxItems->{'Dns.Bts.TxItem'},'TxItems',$fields['TxItems'],'{}', array('Type'=>array('Item', 'Type'),'transaction'=>$items->Id,'holder'=>$Holder));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TxFinanceCategoryDetail'},'TxFinanceCategoryDetail',$fields['TxFinance'],'{}', array('transaction'=>$items->Id));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TxCollectionCategoryDetail'},'TxCollectionCategoryDetail',$fields['TxCollection'],'{}', array('BankBranch'=>array('BankBranch','Id'),'transaction'=>$items->Id));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TxConsentCategoryDetail'},'TxConsentCategoryDetail',$fields['TxConsent'],'{}', array('transaction'=>$items->Id));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TxNeedsAnalysisCategoryDetail'},'TxNeedsAnalysisCategoryDetail',$fields['TxNeeds'],'{}', array('transaction'=>$items->Id));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'},'TxVehicleSaleCategoryDetail',$fields['TxVehicle'],'{}', array('transaction'=>$items->Id,'Tx'=>array('Tx','Id')));
         $this->insert_node($items->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'}->SaleAmounts,'SaleAmounts',$fields['SaleAmounts']);
         $this->insert_node($items->TxShDetails->{'Dns.Bts.TxShOccupationDetail'},'TxShDetails',$fields['TxShDetails'],'{}',array('Person'=>array('Sh','Id'),'transaction'=>$items->Id));
         $this->insert_node($items->TxShDetails->{'Dns.Bts.TxShOccupationDetail'}->_internalIncomeAndExpenses->{'Dns.Bts.Earning'},'IncomeAndExpenses',$fields['IncExp'],'{}',array('Person'=>array('Sh','Id'),'transaction'=>$items->Id));
         $this->insert_node($items->TxItemDetails->{'Dns.Bts.TxMvPrepaidPlanDetail'},'TxMvPrepaidPlanDetail',$fields['PlanDetail'],'{}',array('Type'=>array('Item','Id'),'transaction'=>$items->Id));
         $this->insert_node($items->TxItemDetails->{'Dns.Bts.TxVehicleDetail'},'TxVehicleDetail',$fields['VehicleDetail'],'{}',array('Type'=>array('Item','Id'),'transaction'=>$items->Id));
         $this->insert_node($items->Agreements->Agreement,'Agreements',$fields['Agreements'],'{}',array('transaction'=>$items->Id));
         $this->insert_node($items->CategorySelections->{'Dns.Bts.TxCategorySelection'},'CategorySelections',$fields['CatSelections'],'{}',array( 'Category'=>array('Category','Id'), 'transaction'=>$items->Id));

      endforeach;
   }//endfunction
   #===========================================================================#INSERT QUERY
   function insert_node($_items, $_table, $_fields, $_children='{}', $_attribute='', $tb_field='') {
      global $db;

      if (count($_items)>0):
         foreach ($_items as $item):
				$cnt++;
            $fields  = $_fields;
             if($this->road_cover)$sql     = "SELECT Uid FROM {$this->append_table}$_table WHERE Uid='{$item->Uid}'";#for road cover query
             else $sql = "SELECT id FROM {$this->append_table}$_table WHERE id='{$item->id}'";
            $rs      = $db->Execute($sql); iyona_message($rs, $sql);
            unset($children,$tmp_fields,$sub_key);
            if(!$rs->_numOfRows):
               if (is_array($_fields)):#if an array it means that there is to be an inner call to a node.
                  foreach ($_fields as $key => $inner):
                     if($key!=0) $inner_nodes[] = $this->inner_node($inner,$item);
                  endforeach;
                  $fields = $_fields[0];#_iyona($inner_nodes);
               endif;
               $child_opt = json_decode($_children, true);
               $fields    = json_decode($fields, true);
               #==================================================================#
               foreach($fields as $key => $field):#value of fields
                  if (is_array($field)) :
                     foreach ($field as $fld):#fields with array
                        $sub_key       = $key;#the name of the sub node, used else where
                        $val           = $item->$key->$fld;#field value that has a sub node
                        if(stripos((string)$fld,"Date")!==false)$val=date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$val)));
                        $children[]=$val;
                        $tmp_fields[]  = (string)$fld;#tmp array for fields that will be re-used
                     endforeach;
                  else :
                     $val    = $item->$field;
                     if(stripos((string)$field,"Date")!==false)$val=date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$val)));
                     $children[]=$val;
                     $tmp_fields[]  = (string)$field;
                  endif;
               endforeach;
               $fields = $tmp_fields;
               #==================================================================#
               if (is_array($child_opt)):
                  foreach($child_opt as $key => $child) :#counting the fields of children nodes
                     if (is_array($child)) :
                        $fields[] = $key;#fields list from key
                        foreach ($child as $chld) $children[] = count($item->$key->{$chld});#nodes with sub nodes
                     else:
                        $fields[] = $child;#fields list from child name
                        $val = count($item->{$child}->children());#single nodes count
                        if(stripos($child,"Date")!==false)$val=date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$val)));
                        $children[]=$val;
                     endif;
                  endforeach;
               endif;
               #==================================================================#
               if(is_array($_attribute)) :
                  foreach($_attribute as $key => $value):
                     $iyona_node=false;
                     if(is_array($value)&&$value[0]=="iyona-node")$iyona_node=true;
                     $fields[]   = $key;#adds the field
                     $data       = (isset($sub_key))?(string)$item->$sub_key->{$value[0]}[$value[1]]:(string)$item->{$value[0]}[$value[1]];#if there is sub key get data from sub node
                     if(gettype($value)=='array' && isset($sub_key) && !empty($data))  $val=$data;#if there is sub key and is empty get data from parent
                     else if (gettype($value)=='array'&&!$iyona_node)                  $val=(string)$item->{$value[0]}[$value[1]];#the value either a direct simpleXML value or an array which will find the attribute
                     else if ($iyona_node)                                             $val=(string)$item[$value[1]];#get the parent node attribute
                     else (string)                                                     $val=$value;
                     if(stripos($key,"Date")!==false)$val=date('Y-m-d h:i:s',strtotime(str_replace("/","-",(string)$val)));
                     $children[]=$val;
                  endforeach;
               endif;
               #==================================================================#
               if($children && $fields):
						if (!empty($tb_field)):
							$tmp 		= json_decode($tb_field, true);
							$fields 	= (is_array($tmp) && !empty($tmp))?$tmp:explode(',',$tb_field);
						endif;
						if ($this->use_set):#this is to make insert query use SET for ease of reading
							$SET = "SET ";
							foreach($fields as $k => $v):
								$SET .= "$v={$db->qstr($children[$k])},\n";
							endforeach;
							$SET = rtrim($SET,",\n");
							$sql = "INSERT INTO {$this->append_table}$_table \n$SET";
						else:
                     $children   = array_map("qstr",$children);
                     $children   = implode(",",$children);
							$fields     = implode('`,`',$fields);
							$sql        = "REPLACE INTO {$this->append_table}$_table (`$fields`) \n VALUES ($children)";
						endif;
                  #if ($_table=='jobs_new') _iyona($sql."\n#=====================================================#$cnt\n",1);
                  if(!$this->test_mode)$rs = $db->Execute($sql);
                  else if ($this->test_mode==$_table) _iyona($sql);
                  else if ($this->test_mode===true) _iyona($sql);
                  iyona_message($rs,$sql,1);
                endif;
               #==================================================================#for inner nodes
               if(count($inner_nodes)>0):
                  foreach ($inner_nodes as $inner):
                     $inner_node = $inner[1];
                     $inner_table= $inner[0][0];
                     $inner_field= $inner[0][1];
                     $inner_child= $inner[0][2]?$inner[0][2]:'{}';
                     $inner_att  = $inner[0][3]?$inner[0][3]:'';
                     $this->insert_node($inner_node, $inner_table, $inner_field, $inner_child, $inner_att);
                  endforeach;
               endif;
            endif;
         endforeach;
      endif;
      _iyona($cnt);
   }//endfunction
   #===========================================================================#
   function inner_node($_fields, $_node){
      foreach($_fields as $node => $fields):
         if (!is_numeric($node)):
            list($_fields, $_node) = $this->inner_node($fields, $_node->{$node});
         else:
            return array($_fields, $_node);
         endif;
      endforeach;
      return array($_fields, $_node);
   }//end function
   #===========================================================================#
   function set_xml ($_filename, $_path='') {

      $this->path = $_path?$_path:$this->path;
      if(is_readable($this->path.$_filename)):
         $this->simpleXML  = file_get_contents($this->path.$_filename);
         $this->simpleXML  = new SimpleXMLElement($this->simpleXML);
         return true;
      else:
         return false;
      endif;

   }//end function
}//end class
#==============================================================================#
function qstr($arr)
{
   global $db;return $db->qstr($arr);
}//end function
#==============================================================================#

?>
