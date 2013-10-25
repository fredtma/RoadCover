/*
 * ima is now. Ajax library
 */
/******************************************************************************/
/**
 * used to send data via ajax get
 *
 * It will verify all the variable sent to the function
 * @author fredtma
 * @version 1.5
 * @category ajax, send data
 * @param string <var>www</var> give the path of the file to send the data to
 * @param json <var>var_set</var> json string of all the variable to be passed
 * @param string <var>object</var> the object that will receive the posted data, if not set no data will be sent back
 * @param string <var>method</var> whether to send the data via post or get
 * @param string <var>format</var> the data will be sent back as xml,htm,script,json,jsonp,text
 * @return void|bool
 */
get_ajax = function (www, var_set, object, method, format, call_success)
{
   var msg;
   if (!format) format  = 'html';
   if (!method) method  = 'post';
   if (!call_success) call_success = true;
   $.ajax({
      type: method,
      url: www,
      data: var_set,
      success: function(data)
      {
         if (object && format == 'html')
         {
            $(object).html(data);
            if (typeof(call_success)=='function') call_success(data,object);
            else if (call_success==true) {ajax_success(data); }
         }
         else if (format == 'json' && typeof(call_success)=='function') call_success(data,object);
         else if (format == 'json' ) receiver(data,object);
      },
      error: function(data,j, txt)
      {
         msg=j+'::'+txt;
         object=object||'#sideNotice .db_notice';
         $(object).html('There was an error sending data asynchronuosly::'+msg);
      },
      dataType: format
   });
}/*end function*/
/******************************************************************************/
/**
 * return empty function
 */
function ajax_success () {};
/******************************************************************************/
/**
 * used in conjunction with .ajaxError().
 * note you can use error() on v1.5 and up
 * @author fredtma
 * @version 2.1
 * @category ajax, automatic
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @see get_ajax()
 * @return string
 * @todo add function and more definition for (event, response, ajaxSettings, thrownError)
 * For backward compatibility with XMLHttpRequest, a jqXHR or (response) object will expose the following properties and methods:
   readyState
   status
   statusText
   responseXML and/or responseText when the underlying request responded with xml and/or text, respectively
   setRequestHeader(name, value) which departs from the standard by replacing the old value with the new one rather than concatenating the new value to the old one
   getAllResponseHeaders()
   getResponseHeader()
   abort()
 */
function ajax_error (event, response, ajaxSettings, thrownError)
{
/*   alert(event+'-'+response+'-'+ajaxSettings+'-'+thrownError);*/
   $(this).append(response.responseText+'<br/><strong>Error:</strong>'+thrownError);
/*   $.each(ajaxSettings,function(k,v){$('#debug_inbox').append(k+'='+v+'<br/>')});*/
}
/******************************************************************************/
/**
 * json call and response function for success entry
 * @author fredtma
 * @param {string} <var>_form</var> the type of form to run
 * @version 3.8
 * @category ajax, dynamic
 * @return json
 */
function findJSON(data){
//   jQuery.removeData();//clear cash
   var eternal=data;
   timeFrame('ALPHA--');
   sessionStorage.active=JSON.stringify(data);//@todo:fix the first time it loads it's empty
   theForm = new SET_FORM();
   theForm._Set("#body article");
   var formTypes=(typeof(eternal['form']['options'])!='undefined')?eternal.form.options.type:sessionStorage.formTypes;//using [bracket] to resolve undefined error
   //DB SETUP
   var creoDB=new SET_DB();sessionStorage.removeItem('formTypes');
   switch(formTypes){
      case 'alpha':var spicio=localStorage.USER_NAME?JSON.parse(localStorage.USER_NAME):JSON.parse(sessionStorage.USER_NAME); creoDB.alpha(null,null,spicio.jesua);break;
      case 'betaTable':get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa},'','post','json',function(results){theForm.setBeta(results,3);});break;
      default:creoDB.beta();break;
   }
   timeFrame('OMEGA',true);
}
/******************************************************************************/
/**
 * the default all around error handling function for json request
 * @author fredtma
 * @version 2.4
 * @category ajax, json, error handling
 */

onVituim=function(event, jqxhr,textStatus){
   var err='<p>ajaxError:'+jqxhr+','+textStatus+'</p>';
   $('#sideNotice .db_notice').append(err);
};
/******************************************************************************/
/**
 * saves the pages data into the db
 * @author fredtma
 * @version 2.7
 * @category save, content, ajax
 * @return void
 */
function saveData(){
   var title=$('#page_title').text();var content=$('#page_content').html();var Tau=$('footer').data('Tau');
   var day=getToday();var iota=$("footer").data("iota");var tmp;var jesua=md5(title+day);
   var q={"eternal":{'blossom':{"alpha":iota,"delta":"!@=!#"},"title":title,"content":content,"modified":day,"creation":day,"jesua":jesua,"level":"admin","type":"content"},"Tau":Tau,"iyona":"pages"};
   sessionStorage.quaerere=JSON.stringify(q);
   var arr=[title,content,day,day,jesua,"admin","content"];
   var quaerere="INSERT INTO pages (title,content,modified,creation,jesua,`level`,`type`) VALUES (?,?,?,?,?,?,?)";
   if(iota){quaerere="UPDATE pages SET title=?,content=?,modified=?,`level`=?,`type`=? WHERE id=?";arr=[title,content,day,"admin","content",iota]}
   $DB(quaerere,arr,"Setup page "+title,function(results){
      iota=iota||results.insertId;
      if(!$(".db_notice").data('toggle')||$(".db_notice").data('toggle')==0){$(".db_notice").data('toggle',1);tmp='text-success';}else {$(".db_notice").data('toggle',0);tmp='text-warning';}
      $(".db_notice").html("<span class='"+tmp+"'>The page "+title+", has been saved.</span>").animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
      $("footer").data("iota",iota);$("footer").data("Tau","deLta");});
}//end function send data to the server to update via ajax
/******************************************************************************/
/**
 * Get an item from the DB
 *
 * @author fredtma
 * @version 3.5
 * @category DB
 * @param string <var>mensa</var> the name of the table to get
 * @param string <var>type</var> the type of list to return
 */
function impetroDB(_mensa,_type,_ele){
   var cnt=0,menuDealers={};
   if(_mensa=='dealers'){
      $DB("SELECT name,code FROM dealers ",[],"",function(r,j){
         $.each(j,function(i,row){if(i=='rows') return true;cnt++;
            switch(_type){
               case'list':menuDealers["dealer_"+row['code']]={"href":"javascript:void(0)","clss":"oneDealer","iota":row['code'],"txt":row['name']};break;
            }
         });
         menuDealers=roadCover.btnDropDown({"btnDealer3":{"clss":"btn btn-info seamless non_procer allDealerInv","href":"javascript:void(0)","icon":"icon-book","txt":"All Dealers"},"btnDealerCaret":{"clss":"btn btn-info dropdown-toggle seamless non_procer","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubDealersList3":{"clss":"dropdown-menu dealersList","sub":menuDealers}});
         $(_ele).append(menuDealers);
         var dealerTemp=$('footer').data('temp'),defaultDealer=1771;;
         if(dealerTemp&&dealerTemp[0])$(".allDealerInv .theTXT").text($("#btnSubDealersList3 a[data-iota="+dealerTemp[0]+"]").text());
         else $(".allDealerInv .theTXT").text($("#btnSubDealersList3 a[data-iota="+defaultDealer+"]").text());
         $(_ele+" #btnSubDealersList3 a").click(function(){
            var parent=$(this).parents(".btn-group"),val=$(this).text(),iota=$(this).data("iota");$(".theTXT",parent[0]).html(val);
            var selection={"month":$("#monthList").val(),"dealers":iota};console.log(selection,"selection",_ele+" #btnSubDealersList3 li",this);getInvoice(iota);
         });
      });//end dealer DB
   }//endif
}
/******************************************************************************/
/**
 * used to measure script execution time
 *
 * It will verify all the variable sent to the function
 * @author fredtma
 * @version 0.5
 * @category iyona
 * @gloabl aboject $db
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @see get_rich_custom_fields(), $iyona
 * @return void|bool
 * @todo finish the function on this page
 * @uses file|element|class|variable|function|
 */
