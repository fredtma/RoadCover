<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

include('../../inc/muneris.php');
include('library.php');
include('class.reader.php');
   $content = file_get_contents('xml/transactionAugust.xsd');
//   $content = file_get_contents('xml/transaction.xsd');
   echo htmlspecialchars_decode($xml);
   $results  = new SimpleXMLElement($content);

if ($_POST['query'] || $_POST['dealer_code']  || $_POST['salesman_code'] || false):
   $content = substr($_POST['query'],strpos($_POST['query'], '<result>'));
   $option  = 'finance';
   $option  = 'transaction';
   $option  = 'report transaction';
   $search  = $_POST['salesman_code']?'SALES':(($_POST['dealer_code'])?'DEALER':'ALL');

   switch ($option):
      case 'finance':
         get_finance($results);
         customer_stream($results);
         break;
      case 'transaction':
         get_father($results, 'Transaction Details');
         break;
      case 'report transaction':
         $table = report_transaction($results, 'Transaction Report', $search);
         break;
      default: $c; break;
   endswitch;
else:
   list($dealers,$salesman) = get_dealers($results);
endif;
//$reader = new FILL_DB('quotes','QuotesAugust.xsd',false,'road_');
//$reader = new FILL_DB('trans','transactionAugust.xsd',false,'road_');
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dealer Net</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='../../../css/bootstrap.min.css' rel='stylesheet' media='screen'>
      <script src='../../../js/libs/jquery-1.9.0/jquery.min.js'></script>
      <script src='../../../js/bootstrap.min.js'></script>
      <style type="text/css">
         body {padding-top: 40px;padding-bottom: 40px;background-color: #f5f5f5;}
         .form-signin { max-width: 30em;padding: 2em;margin: 0 auto;background-color: #fff;border: 1px solid #e5e5e5;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);box-shadow: 0 1px 2px rgba(0,0,0,.05);}
         .form-signin .form-signin-heading,.form-signin .checkbox {margin-bottom: 10px;}
         .form-signin textarea{font-size: 16px;height: auto;margin-bottom: 15px;padding: 7px 9px;}
         .form-signin input{height: auto;margin-bottom: 15px;}
         .form-signin .size1 {width:22em;}.form-signin .size2 {width:7em;}
         .form-signin textarea {height:20em; width:30em; font-size:1em;}

         /*.table {border-top: 1px solid #999; border-left: 1px solid #999;border-spacing: 0.1em; border-collapse: separate; margin:0.5em;}*/
         .table th, .table td {white-space: nowrap; font-size:0.8em;}
         .table caption {font-family: Geneva, Arial, Helvetica, sans-serif; color: #993333; padding-bottom: 5px; text-align: left;}
         .table tfoot {background:#ccc; font-weight:bold;}
         /*.table th {background-color: #ccc; font-family: "Courier New", Courier, mono; text-align: left;}*/

         .border {border:1px solid blue;}
         .full {width:100%;}
         .history_section {display:none; width:800px;}
         .cell {border:1px solid red;}
         .row {border: 1px solid black; width:100%;}
         .bold {font-weight: 900;}.white {background-color:white;}.center{margin-top:7em;text-align: center;}
         .grey{border:0.1em solid grey; background:#f9f9f9;padding-left:0.5em;-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;}
         .small{font-size: 0.8em;}.wrap {white-space:normal; table-layout: fixed; font-size: 1em; } .wrap td, .wrap th{ word-wrap: break-word; white-space: normal; }
         .wrap thead {background:#ccc; font-weight:bold;}
         /*overwrite*/
         .row-fluid [class*="span"] {min-height: 20px;}
         .row-fluid div {white-space: normal;}

         .wrap th:first-child,.wrap td:first-child {width:2em;}
         @media print{.no_print{display:none;}}
         <?php if (!$dealers && !$salesman):?>
         .the_search{display:none;}
         <?php endif;?>
      </style>
   </head>
   <body>
      <div class="container the_search">
         <form class="form-signin" method="POST" style="display:">
            <h2 class="form-signin-heading">Insert Query</h2>
            <fieldset>
               <legend>Dealers Search</legend>
               <div class='input-append full' >
                  <input id='dealer_value' class='size1' name='dealer_value' placeholder="Select the related dealer..." type='text' />
                  <input id='dealer_code' name='dealer_code'  type='hidden' />
                  <div class='btn-group'>
                     <button class='btn dropdown-toggle size2' data-toggle='dropdown'>
                        Dealer&nbsp;&nbsp;<span class='caret'></span>
                     </button>
                     <ul class='dropdown-menu'><?=$dealers?></ul>
                  </div>
               </div>
               <legend>Salesman Search</legend>
               <div class='input-append full'>
                  <input id='salesman_value' class='size1' name='salesman_value' placeholder="Select sales person..." type='text' />
                  <input id='salesman_code' name='salesman_code'  type='hidden' />
                  <div class='btn-group '>
                     <button class='btn dropdown-toggle size2' data-toggle='dropdown'>
                        Salesman&nbsp;&nbsp;<span class='caret'></span>
                     </button>
                     <ul class='dropdown-menu'><?=$salesman?></ul>
                  </div>
               </div>
            </fieldset>
<!--            <label for='query'>
               <textarea name='query' id='query' placeholder="Paste the query here" class="input-block-level"></textarea>
            </label>-->
            <button class="btn btn-large btn-primary" type="submit">Extract Query</button>
         </form>
      </div> <!-- /container -->
      <?=$table?>
<script type="text/javascript" language="Javascript">
   $('#tabular a').click(function(e){e.preventDefault();$(this).tab('show'); $('.info').removeClass('info');})
   $('.toCustom').click(function(e){/**/e.preventDefault();/**/row=$(this).parents('tr').attr('class');/**/move=$(this).attr('href');/**/$(move+' .info').removeClass('info');/**/if(move=='#customer'){/**/i  = row.search('-')+1;/**/row = '.'+row.substring(i);/*console.log(row);*/$(row).addClass('info');/**/} else {/**/i=move.search('#')+1;/**/clss='.'+move.substring(i);/*console.log(clss+'--'+row);*/$(clss+'-'+row).addClass('info');}/**/$('#tabular a[href="'+move+'"]').tab('show');/**/});
   $('#new_search').click(function(){window.location.href=window.location.href;/*$('.the_search').slideDown('slow');},function(){$('.the_search').slideUp('slow');*/});
   $('.link_dealer').click(function(){$('#dealer_value').val($(this).text());/**/$('#dealer_code').val($(this).attr('href'));/**/$(this).closest('form').submit();});
   $('.link_sales').click(function(){$('#salesman_value').val($(this).text());/**/$('#salesman_code').val($(this).attr('href'));/**/$(this).closest('form').submit();});
</script>
   </body>
</html>
