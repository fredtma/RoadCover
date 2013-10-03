<?php
/*
 * Description
 *
 * @author fredtma
 * @version 0.5
 * @category iyona
 * @gloabl object $db
 * @see get_rich_custom_fields(), $iyona
 * @todo finish the function on this page
 * @uses file|element|class|variable|function|
 */

#==============================================================================#
/**
 * displays finance in longer tabular fashion
 */
function get_finance($_results) {
   $record  = 0;
   foreach ($_results as $items):
      $record++;
      unset($row);
      if ($record==1):
         $title = $items['Type'];
         echo <<<IYONA

         <table class='table table-bordered table-hover table-striped' summary="$title" >
         <caption><h4>$title</h4></caption>
IYONA;
      endif;

      foreach ($items->children() as $item):
         unset($tmp);
         if ($record==1):
            $name      = ucwords(strtolower($item->getName()));
            $row_head .= "<th id='{$item->getName()}'>$name</th>\n";
         endif;
         if ($item->getName()=='Agreement' && $item['Reference']=='true'):
            $tmp = "{$item['Id']} <br/> {$item['Uid']} <br/> {$item['Type']}";
         elseif ($item->getName()=='EventHistory'):
            $tmp = "<a href='#his$record' role='button' data-toggle='modal' class='his'>View History</a>".get_history($item, $title, $record);
         endif;

         $row .= "<td headers='{$item->getName()}' >{$tmp}&nbsp;$item</td>\n";
      endforeach;

      $rows .= "<tr>$row</tr>\n";
   endforeach;
      echo <<<IYONA

         <tr>$row_head</tr>
         $rows
      </table>
IYONA;
}
#==============================================================================#
/**
 * displays the history tabular data of finances
 */
function get_history($_history, $_title, $_rec){
   $cnt  = 0;
   $col  = 0;
   foreach($_history as $events):
      $cnt++;
      unset($row);
      foreach($events as $event):
         $col++;
         if ($cnt==1):
            $name      = ucwords(strtolower($event->getName()));
            $row_head .= "<th id='{$event->getName()}'>$name</th>\n";
         endif;
         $row .= "<td headers='{$event->getName()}'>&nbsp;$event</td>\n";
      endforeach;
      $rows .= "<tr>$row</tr>\n";
   endforeach;
   return <<<IYONA
   <section class='history_section modal hide fade' id='his$_rec'>
      <div class='modal-header'>
         <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
         $_title
      </div>
      <div class='modal-body'>
         <table class='table' summary="$_title" >
         <tr>$row_head</tr>
         $rows
         </table>
      </div>
      <!---
      <div class='modal-footer'><a href='#' class='btn'>Close</a><a href='#' class='btn btn-primary'>Save change</a></div>
      -->
   </section>
IYONA;
}//endfunction
#==============================================================================#
/**
 * get the xml displayed in a row & column fashion where the records are columns
 */
function get_father($_results, $_title='')
{
   $rec  = 0;
   $table= <<<IYONA

   <table class='table table-bordered table-hover table-striped' summary="$_title" >
   <caption><h4>$_title</h4></caption>
IYONA;
   foreach ($_results->children() as $results):
      $content[]  = $tmp = get_xml_tree($results, $rec);//iyona($tmp,1,1);
//      $content[]  = $tmp = get_transaction_tree($results, $rec);//iyona($tmp,1,1);
      $rec++;//exit;
   endforeach;
   $content = set_row($content);
   $table  .= <<<IYONA

      <tr><th>Field</th><th colspan='$rec' >Value</th></tr>
      $content
   </table>

IYONA;
      echo $table;
}
#==============================================================================#
/**
 * when getting the customer stream. from the specific node
 * get customer details
 */
function customer_stream($_streams)
{
   $_streams   = $_streams->xpath('/result/item/EventHistory/Dns.Bts.Finance.FinanceApplicationEvent/Request/TransmissionStream/Stream');
   $title      = "Customer details";
         $table = <<<IYONA

         <table class='table table-bordered table-hover table-striped' summary="$title" >
         <caption><h4>$title</h4></caption>
IYONA;
   $rec = 0;
   foreach ($_streams as $streams):#this is the array
      $stream     = new SimpleXMLElement($streams);#this is the simpleXML object
      $header[]   = get_xml_tree($stream->header, $rec);
      $message[]  = get_xml_tree($stream->messageElements, $rec, '', 'value');
      $trailer[]  = get_xml_tree($stream->trailer, $rec);
      $rec++;
   endforeach;
      $rec2    = $rec+1;
      $header  = set_row($header);#var_dump($header);
      $message = set_row($message);#var_dump($message);
      $trailer = set_row($trailer);#var_dump($trailer);
      $table  .= <<<IYONA

         <tr><th>Field</th><th colspan='$rec' >Value</th></tr>
         $header
         <tr><th colspan='$rec2' ><hr/></th></tr>$message
         <tr><th colspan='$rec2' ><hr/></th></tr>$trailer $rows
      </table>

IYONA;
      echo $table;
}//endfunction
#==============================================================================#
/**
 * runs through all the nodes of the simpleXML
 */
function get_xml_tree($_node, $_column=0, $_name='', $_only='', $_row=-1, $_level=0)#create an array for specific nod
{
   if (!count($_node)) return false;
   foreach ($_node->children() as $node) :
      $_row++;
      $name = $node->getName();
      if ($_name):
         preg_match_all("/->/",$_name,$found);
         $color= (111*count($found[0]))+333;
         $name = "{$_name}-><span style='color:#$color'>{$node->getName()}</span>";
      endif;
      if (count($node) > 0 && $_level==0):
            $_tmp_lvl   = $_level+1;
            $tmp        = get_xml_tree($node, $_column, $name, $_only, $_row, $_tmp_lvl);
            $_row       = $_row+count($tmp);
            foreach ($tmp as $key => $val):
               $row[$key][$_column] .= $val[$_column];
            endforeach;
      elseif (!empty($_only)):
         if($_only == $node->getName()):
            if ($_column==0) $row[$_row][$_column] .= "<th>$name</th>";
            $row[$_row][$_column] .= "<td>&nbsp;$node</td>";
         endif;
      else:
         if ($_column==0) $row[$_row][$_column] .= "<th>$name</th>";
         $row[$_row][$_column] .= "<td>&nbsp;$node</td>";
      endif;
   endforeach;
   return $row;
}//end function
#==============================================================================#
/**
 * not finished yet but displays results based upon nodes
 */
function get_transaction_tree($_result, $_record=0)
{
   if (!count($_result)) return false;
   $_row    = 0;
   $result  = $_result->xpath('Holder/CountryOfOrigin_cd');
   if ($_record==0) $row[$_row][$_record] .= "<th>Country of Origin</th>";
   $row[$_row][$_record] .= "<td>&nbsp;{$result[0]}</td>";

   return $row;
}
#==============================================================================#
/**
 * after extraction the xml this set the array in tabular format
 */
function set_row($_record)#create a string from the array node
{
   if (is_array($_record)):
      $cnt = 0;
      $total_col = count($_record);
      for ($col=0;$col<=$total_col;$col++):#nuber of recored
         $total_row = count($_record[$col]);
         for($row=0; $row <= $total_row; $row++ ):#number of rows
            $rows[$row][] = $_record[$col][$row][$col];
         endfor;
         $cnt++;
      endfor;
   endif;
   foreach ($rows as $set):
      $return .= "<tr>".implode('',$set)."</tr>\n";
   endforeach;
   return $return;
}
#==============================================================================#
/*
 * display the report for the transaction
 */
function report_transaction($_results, $_title, $_search='ALL')
{
   $_POST['salesman_code'] = $_POST['salesman_code']?substr($_POST['salesman_code'],1):NULL;
   $_POST['dealer_code']   = $_POST['dealer_code']?substr($_POST['dealer_code'],1):NULL;

   switch ($_search)
   {
      case 'SALES': $results = search_node($_results, $_POST['salesman_code'], $_search); break;
      case 'DEALER':$results = search_node($_results, $_POST['dealer_code'], $_search); break;
      default:break;
   }
//   iyona($_POST,1);
//   iyona($results,1);
   $na      = 'N/A';
   $user    = $results->FandI->Name.' '.$results->FandI->Surname;
   $interm  = $results->Intermediary->Name;
   $date    = $results->DateCreated;
   $makeDesc= "All Vehicle Makes";
   $modDesc = "All Vehicle Makes";
   $group   = $results->Intermediary->CompanyName;
   $insurer = $results->RelatedStakeholders->{'Dns.Bts.TxStakeholder'}->Sh->IsInsurer;
   $insurer = $insurer=='False'?'No':$insurer;
   $newUsed = (string)$results->TxItemDetails->{'Dns.Bts.TxVehicleDetail'}->IsNew=='False'?"Used Deals":"New Deals";
   $demo    = (string)$results->TxItemDetails->{'Dns.Bts.TxVehicleDetail'}->IsDemo=='False'?"":" and Demo";
   $newUsed = $newUsed.$demo;
   $region  = "All Report Structures / Regions";
   $repDate = date('d/m/Y H:i:s A');
   #===========================================================================#

   $company = "Roadcover <br/> BORDEREAUX REPORT";
   $res     = $results->RelatedStakeholders->{'Dns.Bts.TxStakeholder'}[0];
   $dealer  = $res->Sh->TradingAs?$res->Sh->TradingAs:$res->Sh->Name;
   $dealerID= (string)$res->Sh->Id;
   if((string)$res->Sh->Uid==(string)$results->Intermediary->Uid) $company .= '<br/>Dealer\'s details';
   foreach ($res->Sh->Addresses->{'Dns.Sh.ShAddress'} as $node):
      switch ((string)$node->Address['Type']):
         case 'Dns.Sh.AddressBook.FixedLineNumber':
            $busPhone= '('.$node->Address->AreaCode.')'.$node->Address->Number;
            break;
         case 'Dns.Sh.AddressBook.FaxNumber':
            $faxNo   = '('.$node->Address->AreaCode.')'.$node->Address->Number;
            break;
         case 'Dns.Sh.AddressBook.EmailAddress':
            $busEmail= $node->Address->Address;
            break;
         case 'Dns.Sh.AddressBook.PhysicalAddress':
            $address = 'Phisical Address:'.$node->Address->StreetNumber.' ';
            $address.= $node->Address->StreetName.'<br/>';
            $address.= $node->Address->Suburb.'<br/>';
            $address.= $node->Address->City.'<br/>';
            $address.= $node->Address->Province_cd.'<br/>';
            break;
         case 'Dns.Sh.AddressBook.PostalAddress':
            $tmp = (string)$node->Address->Line1;
            if (empty($tmp)) break;
            $address1 = 'Postal Address:'.$node->Address->Line1.'<br/>';
            $address1.= $node->Address->Line2.'<br/>';
            $address1.= $node->Address->Suburb.'<br/>';
            $address1.= $node->Address->City.'<br/>';
            $address1.= $node->Address->Code.'<br/>';
            break;
      endswitch;
   endforeach;

   $dealReg = $res->Sh->FSBNumber;
   $VAT     = $res->Sh->VatRegistrationNumber;
   $trans  = display_trans($_results, $_search, $dealerID);
   #===========================================================================#
   $table   = <<<IYONA

   <table class='table table-bordered white' summary="$_title" >
   <caption><h4>$_title</h4><button class='btn no_print' style='margin-left:0.2em' id='new_search'><i class='icon-refresh'></i>&nbsp;New Search</button></caption>
      <tr><td>
         <div class='row-fluid' ><div class='span2 bold'>User:</div><div class='span2'>$user</div><div class='span2 bold'>Report Date:</div><div class='span2'>$repDate</div></div>
         <div class='row-fluid'><div class='span2 bold'>Intermediary Selection:</div><div class='span2'>$interm</div><div class='span2 bold'>Group:</div><div class='span2'>$group</div><div class='span2'>$region</div></div>
         <div class='row-fluid'><div class='span2 bold'>Dates Between:</div><div class='span2'>$date</div><div class='span2 bold'>Insurer:</div><div class='span2'>$insurer</div><div class='span2 bold'>New Or Used:</div><div class='span2'>$newUsed</div></div>
         <div class='row-fluid'><div class='span2 bold'>Vehicle Make:</div><div class='span2'>$makeDesc</div><div class='span2 bold'>Vehicle Model:</div><div class='span2'>$modDesc</div></div>
      </td></tr><tr><td>
          <div class='row-fluid'>
            <div class='span6 grey'>
               <div class='row-fluid'><div class='span4 bold'>Dealer:</div><div class='span8'>$dealer</div></div>
               <div class='row-fluid'><div class='span4 bold'>Address:</div><div class='span8'>$address</div></div>
               <div class='row-fluid'><div class='span4 bold'>Business Phone:</div><div class='span8'>$busPhone</div></div>
               <div class='row-fluid'><div class='span4 bold'>Fax No:</div><div class='span8'>$faxNo</div></div>
               <div class='row-fluid'><div class='span4 bold'>Business EMail:</div><div class='span8'>$busEmail</div></div>
               <div class='row-fluid'><div class='span4 bold'>Dealer Reg No:</div><div class='span8'>$dealReg</div></div>
               <div class='row-fluid'><div class='span4 bold'>VAT No:</div><div class='span8'>$VAT</div></div>
            </div>
               <div class='span6 center'>
                  $company
               </div>
            </div>
      </td></tr><tr><td>
         <ul class='nav nav-tabs' id='tabular'>
            <li class='active'><a href='#insure'><i class='icon-tag'></i>Insurance</a></li>
            <li><a href='#customer'><i class='icon-user'></i>Customer</a></li>
            <li><a href='#expense'><i class='icon-book'></i>Expenses</a></li>
            <li><a href='#vehicle'><i class='icon-road'></i>Vehicle</a></li>
            <li><a href='#payment'><i class='icon-lock'></i>Payment</a></li>
            <li><a href='#cover'><i class='icon-briefcase'></i>Cover</a></li>
            <li><a href='#road'><i class='icon-download-alt'></i>Road Cover</a></li>
         </ul>
      </td></tr><tr><td>
        $trans
      </td></tr>
   </table>
IYONA;
   return $table;
}
#==============================================================================#
/**
 * get the single value from the xml
 * depreciated and no longer use
 */
function get_single_result($_results, $_path, $_rec=0, $_option=0)
{
   $result = $_results->xpath($_path);
   if ($_option)iyona($result);
   return $result[$_rec];
}
#==============================================================================#
/**
 * display function
 */
function _iyona ($__var, $__adm=false, $__stop=false, $__write=false, $__append=false)
{
   if (!$__write)
   {
      echo "<pre>\n";
      if (is_array($__var)) {var_dump($__var);reset($__var);}
      else var_dump ($__var);
      if ($__stop) exit;
      echo "</pre>\n";
   }//end if
   else
   {
      $filename = APPROOT.'/tmp/temp_log.html';
      if (is_writable($filename))
      {
         $__var = '<pre>'.date('Y/m/d H:i:s').' :: '.$_GET['p'].' :: '.print_r($__var,true).'</pre>';
         if ($__append) file_put_contents($filename, $__var,FILE_APPEND);
         else if (!$__append) file_put_contents($filename, $__var);
      } else if (iyona_adm()) { echo "File is not writen";} //end if
   }//end if
}//end function
#==============================================================================#
/**
 * display the transaction for the specific option
 */
function display_trans($_results, $_search='ALL', $dealerID='')
{
   $enable  = array('ins'=>1, 'cus'=>1, 'exp'=>1, 'car'=>1, 'pay'=>1, 'cov'=>1, 'roa'=>1);
   $na      = 'n/a';
   $table   = "<div class='tab-content'>\n";
   #===========================================================================#insurer
   if($enable[ins]):
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      $trans_arr[]            = (string)$results->Uid;
      unset($ins);$cnt++;
      $head                   = "<th>No</th>";
      $td                     = "<td>$cnt</td>";
      $ins['Pol No']          = $results->Id;
      $ins['Client']          = ucwords(strtolower("{$results->Holder->FullNames} {$results->Holder->Surname}"));
      $ins['External Pol No'] = $results->ExternalReferenceNumber;#???
      $ins['Sum Insured']     = $na;#???
      $ins['Reg Number']      = $results->TxItems->{'Dns.Bts.TxItem'}->Item->RegistrationNumber;#from TcItems car registration
      $ins['Inception Date']  = $results->TxCategoryDetail->{'Dns.Bts.TxCollectionCategoryDetail'}->FirstDebitDate;#the date of the first debit
      $ins['Product Name']    = $results->TxItems->{'Dns.Bts.TxItem'}->Item->Description;#car description

      $ins['Premium VAT']     = (double)$results->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'}->PrincipalDebt;#what is left to be paid after deposit
      $salesAmount            = $results->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'}->SaleAmounts->{'Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'};

      foreach($salesAmount as $sales):
         $ins['FSP Fee']         = (double)search_value($sales, 'FSPFees', 'AmountBreakdownType_cd', 'FinancedAmount');
         $ins['Service Fee']     = (double)search_value($sales, 'HandlingFees', 'AmountBreakdownType_cd', 'FinancedAmount');
//         $ins['Licene And Registration']  = (double)search_value($sales, 'LiceneAndRegistration', 'AmountBreakdownType_cd', 'FinancedAmount');
//         $ins['Service And Delivery']     = (double)search_value($sales, 'ServiceAndDelivery', 'AmountBreakdownType_cd', 'FinancedAmount');
         search_value($sales, 'FSPFees', 'AmountBreakdownType_cd', 'FinancedAmount');
      endforeach;
//      $ins['FSP Fee']         = (double)$results->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'}->SaleAmounts->{'Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'}[1]->FinancedAmount;
//      $ins['Service Fee']     = (double)$results->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'}->SaleAmounts->{'Dns.Bts.VehicleSale.TxVehicleSaleAmountBreakDown'}[3]->FinancedAmount;
      $ins['Insurer Admin Fee'] = $na;
      $ins['Admin Fee']       = $na;
      $ins['Comm']            = $na;
      $ins['Insurer Premiumn']= $na;
      $ins['Stocknumber Period (Months)'] = $results->TxCategoryDetail->{'Dns.Bts.TxFinanceCategoryDetail'}->ContractPeriod;
      $Tpre    += is_numeric($ins['Premium VAT'])?$ins['Premium VAT']:0;
      $Tfsp    += is_numeric($ins['FSP Fee'])?$ins['FSP Fee']:0;
      $Tserv   += is_numeric($ins['Service Fee'])?$ins['Service Fee']:0;
      $TinsA   += is_numeric($ins['Insurer Admin Fee'])?$ins['Insurer Admin Fee']:0;
      $Tadm    += is_numeric($ins['Insurer Admin Fee'])?$ins['Insurer Admin Fee']:0;
      $Tcom    += is_numeric($ins['Comm'])?$ins['Comm']:0;
      $TinsP   += is_numeric($ins['Insurer Premiumn'])?$ins['Insurer Premiumn']:0;
      $Tstck   += is_numeric($ins['Stocknumber Period (Months)'])?$ins['Stocknumber Period (Months)']:0;
      $ZAR     = 'R ';
      $ins['Premium VAT']     = $ZAR.number_format($ins['Premium VAT'], 2, '.', ' ');
      $ins['FSP Fee']         = $ZAR.number_format($ins['FSP Fee'], 2, '.', ' ');
      $ins['Service Fee']     = $ZAR.number_format($ins['Service Fee'], 2, '.', ' ');

      $Tpre_                  = $ZAR.number_format($Tpre, 2, '.', ' ');
      $Tfsp_                  = $ZAR.number_format($Tfsp, 2, '.', ' ');
      $Tserv_                 = $ZAR.number_format($Tserv, 2, '.', ' ');

      foreach($ins as $key => $val) {$td .= "<td>$val</td>"; $head .= "<th>$key</th>";}
      $row .= "<tr>$td</tr>";
   endforeach;
   $table .= <<<IYONA

        <div class='tab-pane active table-hover table-striped' id='insure'>
           <table class='table wrap'>
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan='8'>TOTAL</td><td>$Tpre_</td><td>$Tfsp_</td><td>$Tserv_</td><td>$TinsA</td><td>$Tadm</td><td>$Tcom</td><td>$TinsP</td><td>$Tstck</td></tr></tfoot>
            </table>
         </div><!--insure-->
IYONA;
   endif;
   #===========================================================================#customer
   if($enable[cus]):
   reset($_results);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      unset($cust,$td,$head);$cnt++;
      $cust[No]               = $cnt;
      $cust[Customer]         = $name = ucwords(strtolower("{$results->Holder->FullNames} {$results->Holder->Surname}"));
      $cust['Date Created']   = $results->DateCreated;
      $cust['Date Modified']  = $results->DateModified;
      $cust['ID Number']      = $results->Holder->IdentificationNumber;
      #this can be done better
      $adrss                  = $results->Holder->Addresses->{'Dns.Sh.ShAddress'};
      $cust[Cell]             = $adrss[0]->Address->Number?'('.$adrss[0]->Address->AreaCode.')'.$adrss[0]->Address->Number:'';
      $cust[Email]            = $adrss[1]->Address->Address;
      $cust[addss]            = $adrss[3]->Address->StreetNumber.' '.$adrss[3]->Address->StreetName.', '.$adrss[3]->Address->City.', '.$adrss[3]->Address->Code;
      $employ                 = $results->TxShDetails->{'Dns.Bts.TxShOccupationDetail'}[0];
      $cust['Source of funds']= $employ->SourceOfFunds_Cd;
      $cust[Occupation]       = $employ->Occupation_Cd;
      $cust[Sector]           = $employ->EmploymentSector_Cd;
      $cust['Months at employer']    = $employ->MonthsAtEmployer;
      #$salary  = $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'GrossIncome']/Amount");
      $salary                 = $employ->_internalIncomeAndExpenses;#iyona($salary);
      $cust[salary]           = search_value($salary->{'Dns.Bts.Earning'}, 'GrossIncome');#$salary[0];
      $cust[salary]           = $ZAR.number_format($cust[salary],2,'.',' ');
//      foreach ($employ->_internalIncomeAndExpenses as $item):endforeach;
      foreach($cust as $key => $val) {$td .= "<td>$val</td>"; $head .= "<th>$key</th>";}
      $row .= <<<IYONA
           <tr class='$results->Uid'>
            $td
            <td>
               <a href='#expense' title='View $name expenses' class='toCustom'><i class='icon-book'></i></a>&nbsp;
               <a href='#vehicle' title='View $name vehicle' class='toCustom'><i class='icon-road'></i></a>&nbsp;
               <a href='#payment' title='View $name payment' class='toCustom'><i class='icon-lock'></i></a>&nbsp;
               <a href='#cover'   title='View $name cover' class='toCustom'><i class='icon-briefcase'></i></a>&nbsp;
               <a href='#road'   title='View $name Road cover' class='toCustom'><i class='icon-download-alt'></i></a>
            </td>
           </tr>
IYONA;
   endforeach;
   $table .= <<<IYONA

         <div class='tab-pane table-hover table-striped' id='customer'>
           <table class='table wrap'>
               <thead><tr>$head<th>View</th></tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=14></td></tr></tfoot>
            </table>
         </div><!--#customer tab-->
IYONA;
   endif;
   #===========================================================================#EXPENSES
   if($enable[exp]):
   reset($_results);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      unset($salary,$exp,$td,$head);$cnt++;
      $surname = $results->Holder->Surname;
      $name    = $results->Holder->FullNames;
      $inc['No']           = array($cnt);
      $inc['Customer']     = array("<a href='#customer' class='toCustom' title='Click here to view $name details'>".ucwords(strtolower("$name $surname"))."</a>");
      $employ  = $results->TxShDetails->{'Dns.Bts.TxShOccupationDetail'}[0];/*
       $inc[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'GrossIncome']/Amount");
       $inc[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Commission']/Amount");
       $inc[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Overtime']/Amount");
       $inc[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'OtherIncome']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Bond']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Policy']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'MunicipalRates']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Telephone']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'CreditCard']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'ClothingAccount']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Overdraft']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Transport']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'FoodAndEntertainment']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Education']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Maintenance']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Household']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Vehicle']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'SalaryDeductions']/Amount");
       $exp[]= $employ->xpath("_internalIncomeAndExpenses/Dns.Bts.Earning[SubType_cd = 'Other']/Amount");*/
      $record= $employ->_internalIncomeAndExpenses;
      $inc['Gross']        = search_value($record->{'Dns.Bts.Earning'}, 'GrossIncome');
      $inc['Commission']   = search_value($record->{'Dns.Bts.Earning'}, 'Commission');
      $inc['Overtime']     = search_value($record->{'Dns.Bts.Earning'}, 'Overtime');
      $inc['Other Income'] = search_value($record->{'Dns.Bts.Earning'}, 'OtherIncome');
      $exp['Bond']         = search_value($record->{'Dns.Bts.Earning'}, 'Bond');
      $exp['Policy']       = search_value($record->{'Dns.Bts.Earning'}, 'Policy');
      $exp['Municipal']    = search_value($record->{'Dns.Bts.Earning'}, 'MunicipalRates');
      $exp['Telephone']    = search_value($record->{'Dns.Bts.Earning'}, 'Telephone');
      $exp['Credit Card']  = search_value($record->{'Dns.Bts.Earning'}, 'CreditCard');
      $exp['Clothing']     = search_value($record->{'Dns.Bts.Earning'}, 'ClothingAccount');
      $exp['Overdraft']    = search_value($record->{'Dns.Bts.Earning'}, 'Overdraft');
      $exp['Transport']    = search_value($record->{'Dns.Bts.Earning'}, 'Transport');
      $exp['Food & entertaiment'] = search_value($record->{'Dns.Bts.Earning'}, 'FoodAndEntertainment');
      $exp['Education']    = search_value($record->{'Dns.Bts.Earning'}, 'Education');
      $exp['Maintenance']  = search_value($record->{'Dns.Bts.Earning'}, 'Maintenance');
      $exp['Household']    = search_value($record->{'Dns.Bts.Earning'}, 'Household');
      $exp['Vehicle']      = search_value($record->{'Dns.Bts.Earning'}, 'Vehicle');
      $exp['Deduction']    = search_value($record->{'Dns.Bts.Earning'}, 'SalaryDeductions');
      $exp['Other']        = search_value($record->{'Dns.Bts.Earning'}, 'Other');

       foreach ($inc as $key => $sal) { if ($key!='Customer'&&$key!='No')$sal[0]=$ZAR.number_format((double)$sal[0],2,'.',' '); $td .= "<td class='text-success'>".$sal[0]."</td>"; $head .= "<th>$key</th>";}
       foreach ($exp as $key => $sal) { $sal[0]=$ZAR.number_format((double)$sal[0],2,'.',' '); $td .= "<td class='text-error'>".$sal[0]."</td>"; $head .= "<th>$key</th>";}
       $row .= "<tr class='expense-$results->Uid'>$td</tr>\n";
   endforeach;
   $table .= <<<IYONA

         <div class='tab-pane table-hover table-striped' id='expense'>
           <table class='table wrap'>
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=21></td></tr></tfoot>
            </table>
         </div><!--expense-->
IYONA;
   endif;
   #===========================================================================#VEHICLE
   if($enable[car]):
   reset($_results);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      unset($td,$head);$cnt++;
      $item                      = $results->TxItems->{'Dns.Bts.TxItem'}->Item;
      $td['No']                  = $cnt;
      $td['Customer']            = "<a href='#customer' class='toCustom' title='Click here to view {$results->Holder->FullNames} details'>".ucwords(strtolower("{$results->Holder->FullNames} {$results->Holder->Surname}"))."</a>";
      $td['Vehicle Type']        = $item->MotorVehicleType;
      $td['Engine Number']       = $item->EngineNumber;
      $td['RegistrationDate']    = $item->FirstRegistrationDate;
      $td['Immobiliser']         = $item->HasImmobiliser;
      $td['Registration Number'] = $item->RegistrationNumber;
      $td['VIN Number']          = $item->VINNumber;
      $td['Year']                = $item->Year;
      $td['Type']                = $item->ItemType_cd;
      $td['Model']               = $item->Description;
      $item                      = $results->TxItemDetails->{'Dns.Bts.TxVehicleDetail'};
      $td['Purchase Date']       = $item->PurchaseDate;
      $td['New']                 = $item->IsNew;
      $td['Demo']                = $item->IsDemo;
      $td['Use']                 = $item->UseType_Cd;
      $td['Purchase Date']       = $item->PurchaseDate;
      $td['StockNumber']         = $item->StockNumber;
      $td['Amount'] = $cost[(string)$results->Uid] = $ZAR.number_format((double)$item->Amount,2,'.',' ');
      $row                      .= "<tr class='vehicle-$results->Uid'>";
      foreach ($td as $h => $t):
         $row .= "<td>$t</td>";
         $head.= "<th>$h</th>";
      endforeach;
      $row  .= "</tr>";
   endforeach;
   $table .= <<<IYONA

        <div class='tab-pane table-hover table-striped' id='vehicle'>
           <table class='table wrap'>
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=17></td></tr></tfoot>
           </table>
        </div><!--vehicle-->
IYONA;
   endif;
   #===========================================================================#payment
   if($enable[pay]):
   reset($_results);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      unset($td,$head);$cnt++;
      $td[No]                          = $cnt;
      $td['Customer']                  = "<a href='#customer' class='toCustom' title='Click here to view {$results->Holder->FullNames} details'>".ucwords(strtolower("{$results->Holder->FullNames} {$results->Holder->Surname}"))."</a>";
      $item                            = $results->TxCategoryDetail->{'Dns.Bts.TxCollectionCategoryDetail'};
      $td['Account']                   = $item->Account->AccountType_cd;
      $td['Account No']                = $item->Account->BankAccountNo;
//      $td['payment method']            = $item->paymentmethod_cd;
      $td['FirstDebitDate']            = $item->FirstDebitDate;
      $td['Debit Day']                 = $item->MonthlyDebitDay;
      $item                            = $results->TxCategoryDetail->{'Dns.Bts.TxFinanceCategoryDetail'};
      $td['Application Type']          = $item->ApplicationType_cd;
      $td['Purchase Purpose']          = $item->PurchasePurpose_cd;
      $td['Customer Type']             = $item->CustomerType_cd;
      $td['Requested Interest Rate']   = $item->RequestedInterestRate;
      $td['Frequency']                 = $item->PaymentFrequency_cd;
      $td['Period']                    = $item->ContractPeriod;
      $td['Rate']                      = $item->RateType_cd;
      $td['Residual']                  = $item->RequestedResidual;
      $td['Residual Percentage']       = $item->RequestedResidualPercentage;
      $td['Finance House']             = $item->FinanceHouse_cd;
      $item                            = $results->TxCategoryDetail->{'Dns.Bts.TxConsentCategoryDetail'};
      $td['Consent Credit Buro']       = $item->ConsentCreditBuro;
      $td['Confirm LOA Received']      = $item->ConfirmLOAReceived;
      $item                            = $results->TxCategoryDetail->{'Dns.Bts.TransactionCategoryDetail.TxVehicleSaleCategoryDetail'};
      $td['Method']                    = $item->SourceOfDeposit_cd;
      $td['Cost']                      = $ZAR.number_format((double)$cost[(string)$results->Uid],2,'.',' ');
      $td['Deposit']                   = $ZAR.number_format((double)$item->Deposit,2,'.',' ');
      $td['Discount']                  = $ZAR.number_format((double)$item->Discount,2,'.',' ');
      $td['Owing']                     = $ZAR.number_format((double)$item->PrincipalDebt,2,'.',' ');
      $row                      .= "<tr class='payment-$results->Uid'>";
      foreach ($td as $h => $t):
         $row .= "<td>$t</td>";
         $head.= "<th>$h</th>";
      endforeach;
      $row  .= "</tr>";
   endforeach;
   $table .= <<<IYONA

        <div class='tab-pane table-hover table-striped' id='payment'>
           <table class='table wrap'>
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=23></td></tr></tfoot>
           </table>
        </div><!--payment-->
IYONA;
   endif;
   #===========================================================================#cover
   if($enable[cov]):
   reset($_results);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search)) continue;
      unset($td,$head);$cnt++;
      $td[No]                          = $cnt;
      $td['Customer']                  = "<a href='#customer' class='toCustom' title='Click here to view {$results->Holder->FullNames} details'>".ucwords(strtolower("{$results->Holder->FullNames} {$results->Holder->Surname}"))."</a>";
      $item                            = $results->TxCategoryDetail->{'Dns.Bts.TxNeedsAnalysisCategoryDetail'};
      $td['Requires Additional Cover'] = $item->RequiresAdCover;
      $td['Requires Deposit Cover']    = $item->RequiresDepositCover;
      $td['Accept No Short Term Cover']= $item->AcceptNoShortTermCover;
      $td['Accept No Add Cover']       = $item->AcceptNoAddCover;
      $td['Accept No Deposit Cover']   = $item->AcceptNoDepositCover;
      $td['Requires Short Term']       = $item->RequiresShortTerm;
      $td['Requires Warranty']         = $item->RequiresWarranty;
      $td['Requires Service Plan']     = $item->RequiresServicePlan;
      $td['Requires Maintenance Plan'] = $item->RequiresMaintenancePlan;
      $td['Is Finance Offered']        = $item->IsFinanceOffered;
      $td['Amount Willing To Spend On Vaps'] = $ZAR.number_format($item->AmountWillingToSpendOnVaps,2,'.',' ');
      $row                      .= "<tr class='cover-$results->Uid'>";
      foreach ($td as $h => $t):
         $row .= "<td>$t</td>";
         $head.= "<th>$h</th>";
      endforeach;
      $row  .= "</tr>";
   endforeach;
   $t       = count($td);
   $table .= <<<IYONA

        <div class='tab-pane table-hover table-striped' id='cover'>
           <table class='table wrap' >
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=$t></td></tr></tfoot>
           </table>
        </div><!--cover-->
IYONA;
   endif;
   #===========================================================================#ROAD
   if($enable[roa]):
   $content = file_get_contents('xml/Quotes-04-30-Live.xsd');
   $_results= new SimpleXMLElement($content);
   unset($row,$cnt);
   foreach($_results as $results):
      if (!in_node($results, $_search, $trans_arr)) continue;
      unset($td,$head);$cnt++;
      $td[No]                    = $cnt;
      $item                      = $results->QuotedValues;
      $td['Customer']            = "<a href='#customer' class='toCustom' title='Click here to view {$item->holder->person->fullnames} details'>".ucwords(strtolower("{$item->holder->person->fullnames} {$item->holder->person->surname}"))."</a>";
      $td['Principal Debt']      = $ZAR.get_number($item->vehiclesalecategorydetail->principaldebt);
      $td['Deposit']             = $ZAR.get_number($item->vehiclesalecategorydetail->deposit);
      $td['Dealer']              = $item->intermediary->name;
      $item                      = $results->Agreement;
      $td['Name']                = $item->Offering->Name;
      $td['Period_cd']           = $results->Period_cd;
      $td['CollectionMethod_cd'] = $results->CollectionMethod_cd;
      $td['Total Amount']        = $ZAR.get_number($results->TotalAmount);
      $td['DateModified']        = $item->DateModified;
//      $td['StartDate']       = $item->StartDate;
//      $td['EndDate']       = $item->EndDate;
      $items = $results->QuoteResultItems->{'Dns.Quote.Premium.Premium'};
      if(count($items)):
         foreach($items as $item):
            $key     = (string)$item->PremiumType_cd;
            $td[$key]  = get_number($item->CurrentAmount);
         endforeach;
      endif;
      $items = $results->QuoteResultItems->{'Dns.Quote.Premium.EditablePremium'};
      if(count($items)):
         foreach($items as $item):
            $key     = (string)$item->PremiumType_cd;
            $td[$key]  = get_number($item->CurrentAmount);
         endforeach;
      endif;
      $row              .= "<tr class='road-{$results->Agreement->Tx[Uid]}'>";
      foreach ($td as $h => $t):
         $row .= "<td>$t</td>";
         $head.= "<th>$h</th>";
      endforeach;
      $row  .= "</tr>";
   endforeach;
   $t       = count($td);
   $table .= <<<IYONA

        <div class='tab-pane table-hover table-striped' id='road'>
           <table class='table wrap' >
               <thead><tr>$head</tr></thead>
               <tbody>$row</tbody>
               <tfoot><tr><td colspan=$t></td></tr></tfoot>
           </table>
        </div><!--cover-->
IYONA;
   endif;
   #============================================================================#END
$table .="\n      </div><!--#tab-content-->\n";

   return $table;
}
#==============================================================================#
/**
* searches a key and return the value
*/
function search_value($_results, $_search, $_key='SubType_cd', $_return='Amount')
{
	if (count($_results)>0):
//		iyona($_results);
      foreach($_results as $results):
		#iyona($results->$_key);
			if ($results->$_key == $_search) return $results->$_return;
		endforeach;
	endif;
}
#==============================================================================#
/**
 * similar to the search_value, but this one searches for the value in the node and returns that single node
 * @author fredtma
 * @version 0.5
 * @category search
 */
function search_node($_results, $_key, $_search, $_stop=true)
{
   foreach ($_results as $results):
      if($_search=='SALES') $node = (string)$results->FandI->Uid;
      elseif($_search=='DEALER') $node = (string)$results->Intermediary->Uid;

      if ($node==$_key && $_stop) return $results;
      else $return[] = $results;
   endforeach;
   return $return;
}
#==============================================================================#
/**
 * get the name of all the dealers
 */
function get_dealers($_results)
{
   foreach($_results->Children() as $results):
      $node          = ucwords(strtolower((string)$results->Intermediary->CompanyName));
      $Uid           = (string)$results->Intermediary->Uid;
      $dealer[$Uid]  = $node;
      $node          = ucwords(strtolower((string)$results->FandI->Name.' '.(string)$results->FandI->Surname));
      $Uid           = (string)$results->FandI->Uid;
      $sales[$Uid]   = $node;
   endforeach;
   asort($dealer);
   asort($sales);
   foreach($dealer as $key => $li) $deal .= "<li><a href='#$key' class='link_dealer'>$li</a></li>";
   foreach($sales as  $key => $li) $sale .= "<li><a href='#$key' class='link_sales'>$li</a></li>";
   return array($deal,$sale,$dealer,$sales);
}
#==============================================================================#
/**
 * used to find if the current not has the right dealer or sales person
 * @author fredtma
 * @version 0.7
 * @category search
 * @param array <var>$_var</var>
 * @return void|bool <var>$_var</var>
 */
function in_node($_item, $_search, $_dealer='')
{
   $return = false;

   if (is_array($_dealer)):
//      iyona($_dealer,1);
//      iyona((string)$_item->Agreement->Tx['Uid'],1);
      if ( in_array((string)$_item->Agreement->Tx['Uid'], $_dealer)) $return = true;
   endif;
   switch ($_search)
   {
      case 'SALES': if ( (string)$_item->FandI->Uid == $_POST['salesman_code']) $return = true; break;
      case 'DEALER':if ( (string)$_item->Intermediary->Uid == $_POST['dealer_code']) $return = true; break;
      default:break;
   }
   return $return;
}
//end function
#==============================================================================#
/**
 * change the xml type to digital type
 * @author fredtma
 * @version 3.5
 * @category number
 * @gloabl object $db
 * @param number <var>$_number</var> the number to be reformated
 */
function get_number($_number)
{
   return number_format((double)$_number,2,'.',' ');
}//end function

#==============================================================================#

?>
