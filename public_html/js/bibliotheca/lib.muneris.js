/*
 * numeris is a functional set of script
 * @todo: user $.remove() to remove from DOM all generated code. $.removeData() removes $.data() use with $.detach() removes element not the handler. Check $.cache
 */
//DEFINITION
//============================================================================//
dynamisSet=function(_key,_value,_local){
   var set={};set[_key]=_value;
   if(chrome.hasOwnProperty("storage")&&_local==true){chrome.storage.local.set(set);sessionStorage.setItem(_key,_value);}
   else if(chrome.hasOwnProperty("storage")&&!_local){chrome.storage.sync.set(set);sessionStorage.setItem(_key,_value);}
   else if(_local==true){localStorage.setItem(_key,_value);}
   else{sessionStorage.setItem(_key,_value);}//endif
}
dynamisGet=function(_key,_local){
   if(chrome.hasOwnProperty("storage")&&_local==true){chrome.storage.local.get(_key,function(obj){return obj[_key]});return sessionStorage.getItem(_key);}
   else if(chrome.hasOwnProperty("storage")&&!_local){chrome.storage.sync.get(_key,function(obj){return obj[_key]});return sessionStorage.getItem(_key);}
   else if(_local==true){return localStorage.getItem(_key);}
   else{return sessionStorage.getItem(_key);}//endif
}
dynamisDel=function(_key,_local){
   if(chrome.hasOwnProperty("storage")&&_local==true){chrome.storage.local.remove(_key);sessionStorage.removeItem(_key);}
   else if(chrome.hasOwnProperty("storage")&&!_local){chrome.storage.sync.remove(_key);sessionStorage.removeItem(_key);}
   else if(_local==true){localStorage.removeItem(_key);}
   else{sessionStorage.removeItem(_key);}//endif
}
dynamisClear=function(_local){
   if(chrome.hasOwnProperty("storage")&&_local==true){chrome.storage.local.clear();}
   else if(chrome.hasOwnProperty("storage")&&!_local){chrome.storage.sync.clear();}
   else if(_local==true){localStorage.clear();}
   else{sessionStorage.clear();}//endif
}
if(!chrome.hasOwnProperty("storage"))load_async("js/libs/CKEditorCus/ckeditor.js",true,'end');
else sessionStorage.USER_NAME='{"operarius":"fredtma","singularis":"1","nominis":"Frederick Monde Entier Tshimanga","jesua":"6bf17284602cc8298613e9b548d3b045","procurator":1}';
//============================================================================//
sessionStorage.startTime=new Date().getTime();
sessionStorage.runTime=new Date().getTime();
//localStorage.clear();
//sessionStorage.clear();
dynamisSet("SITE_NAME","Road Cover",true);
dynamisSet("SITE_DATE",'fullDate',true);
dynamisSet("SITE_TIME",'mediumTime',true);
dynamisSet("SITE_MONTH",11,true);
dynamisSet("SITE_YEAR",2013,true);
dynamisSet("SITE_URL",'http://app.roadcover.co.za/',true);
dynamisSet("SITE_SERVICE",dynamisGet("SITE_URL",true)+'minister/inc/services.php',true);
dynamisSet("SITE_MILITIA",dynamisGet("SITE_URL",true)+'minister/inc/notitia.php',true);
dynamisSet("MAIL_SUPPORT",'support@roadcover.co.za',true);
//dynamisSet("DB",true);
dynamisSet("DB_NAME",'road_cover',true);
dynamisSet("DB_VERSION",'3.04',true);//@also:DB_VERSION in parva.muneris.js
dynamisSet("DB_DESC",'The internal DB version',true);
dynamisSet("DB_SIZE",15,true);
dynamisSet("DB_LIMIT",15,true);
dynamisSet("EXEMPLAR",JSON.stringify({"username":["^[A-Za-z0-9_]{6,15}$","requires at least six alpha-numerique character"],
"pass1":["((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,20})","requires complex phrase with upperCase, lowerCase, number and a minimum of 6 chars"],
"pass2":["^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$","requires complex phrase with upperCase, lowerCase, number and a minimum of 6 chars"],
"password":["(?=^.{6,}$)((?=.*[0-9])|(?=.*[^A-Za-z0-9]+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$","requires upperCase, lowerCase, number and a minimum of 6 chars"],
"pass3":["^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,}$","requires upperCase, lowerCase, number and a minimum of 6 chars"],
"fullDate":["(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))","follow the following date format (YYYY-MM-DD)"],
"phone":["[\(]?[0-9]{3}[\)]?[\-|\ ]?[0-9]{3}[\-|\ ]?[0-9]{4}","follow the format of 011-222-3333"],
"minMax":["[a-zA-Z0-9]{4,8}","requires at least four to eight character"],
"number":["[-+]?[0-9]*[.,]?[0-9]+","requires a numberic value"],
"url":["^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$","requires a valid URL"],
"colour":["^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$","requires a valid colour in the form of (#ccc or #cccccc)"],
"bool":["^1|0","requires a boolean value of 0 or 1"],
"email":["^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$","the email address is not the right formated"],
"single":["^[a-zA-Z0-9]","requires a single value"]}),true);
var db,hasNarro=false,roadCover,eternal,theForm,creoDB,iyona,iota;
sessionStorage.removeItem('quaerere');//clean up
sessionStorage.formValidation=hasFormValidation();//regard si le browser peut fair les validation HTML5
//============================================================================//INLINE SCRIPT
var appCache=window.applicationCache;
var sideNotice=document.getElementById('sideNotice');
appCache.onchecking=function(e) {sideNotice.innerHTML="<div id='note0'>Checking for a new version of the application.</div>";};
appCache.ondownloading=function(e) {sideNotice.innerHTML+="<div id='note1'>Downloading a new offline version of the application</div>";};
appCache.onprogress=function(e) {if(e.lengthComputable){document.getElementById('progressBar').value=Math.round(e.loaded/e.total*100);}};
appCache.oncached=function(e) {sideNotice.innerHTML+="<div id='note3'>Application is available offline/cached</div>";};
appCache.onnoupdate=function(e) {sideNotice.innerHTML+="<div id='note4'>The application is also available offline.</div>";};
appCache.onobsolete=function(e) {sideNotice.innerHTML+="<div id='note5'>The application can not be updated, no manifest file was found.</div>";};
appCache.onerror=function(e) {sideNotice.innerHTML+="<div id='note6'>Offline version of the application not available.</div>";};
appCache.onupdateready=function(e) {//@todo:promt user to reload
   if(window.applicationCache.status==window.applicationCache.UPDATEREADY && true){
      window.applicationCache.swapCache();window.location.reload();
   }
   sideNotice.innerHTML+="<div id='note7'>Application update ready</div>";
};
//============================================================================//
/**
 * similar to jquery creates an DOM element
 * @author fredtma
 * @version 0.4
 * @category DOM, element
 * @param array <var>arr</var> the array containing all the values of the element
 * @param string <var>ele</var> the name the element will be
 * @return object
 */
creo=function (arr, ele, txt)
{
   var key,attr,key;
   var the_element=document.createElement(ele);
   if (txt)
   {
      txt=document.createTextNode(txt);
      the_element.appendChild(txt);
   }
   /*
    * @todo:the @placehoder and @form also not compatible with setAttribute
 */
   for (key in arr)
   {
      var skip = false;
      if (key=='clss'||key=='class') {attr='class'; the_element.className = arr[key]; skip=true;}
      else if (key=='forr'||key=='for')attr='for';
      else if (key=='id') {the_element.id=arr[key]; skip=true;}
      else if (key=='type') {the_element.type=arr[key]; skip=true;}
      else if (key=='name') {the_element.name=arr[key]; skip=true;}
//      else if (key=='click') {the_element.onclick=function(){atest()};skip=true;}
//      else if (key=='save') {the_element.onclick=function(e){creoDB.alpha(1);return false;}; skip=true;}
      else attr=key;
      if (!skip) the_element.setAttribute(attr, arr[key]);
   }/*end for each*/
   return the_element;
}//end function
//============================================================================//
/**
 * automatic element chain creation
 * @author fredtma
 * @version 3.4
 * @category DOM, element
 * @param {mized} <var>section</var> the element to search where the insertion will occure
 * @param string <var>ele</var> the element type to be created
 * @param object <var>arr</var> the attributes of the element to be created
 * @param string <var>txt</var> the text that the element is to have
 * @param string <var>point</var> the position where the element will occure
 * @return object
 */
$anima=function(section,ele,arr,txt,point){
   var Node;
   Node=(typeof(section)=='string')?document.querySelector(section):section;
   this.creo=creo;
   this.father=ele?this.creo(arr,ele,txt):Node;
   this.vita=function(ele,arr,parent,txt,point){
      this.child=this.creo(arr,ele,txt);
      if(!point)this.father.appendChild(this.child);
      else if(point==='first')this.father.insertBefore(this.child,this.father.firstChild);
      if(parent)this.father=this.child;
      return this;
   }
   this.genesis=function(ele,arr,parent,txt){
      this.child=this.creo(arr,ele,txt);
      this.father.parentNode.insertBefore(this.child, this.father.nextSibling);
      if(parent)this.father=this.child;
      return this;
   }
   this.novo=function(section,ele,arr,txt){
      Node=(typeof(section)=='string')?document.querySelector(section):section;
      this.father=this.creo(arr,ele,txt);
      Node.appendChild(this.father);
      return this;
   }

   if(point=='first')Node.insertBefore(this.father,Node.firstChild); //Node.insertBefore(this.father, Node.firstChild);
   else if(point=='next')Node.parentNode.insertBefore(this.father,Node.nextSibiling);
   else if(ele)Node.appendChild(this.father);
   return this;
};
//============================================================================//
!function ($) {
   $.fn.anima=function(element,options){
      var opts=$.extend({},{
         "element":element,
         "attr":{},
         "txt":"",
         "pos":true
      },options);
      var that = this;
      this.lePapa=creo(opts.attr,opts.element,opts.txt);
      this.vita=function(ele,opt){
         opt=$.extend({},{"parrent":false,"txt":"","pos":"append","attr":{}},opt);
         this.enfant=creo(opt.attr,ele,opt.txt);
         if(opt.pos=="first")$(this.lePapa).prepend(this.enfant);
         else if(opt.pos=="next")$(this.lePapa).after(this.enfant);
         else if(opt.pos=="prev")$(this.lePapa).before(this.enfant);
         else $(this.lePapa).append(this.enfant);
         if(opt.parent)this.lePapa=this.enfant;
         return $(this.enfant);
      }
      this.novo=function(section,ele,arr,txt){
         that=(typeof(section)==='string')?document.querySelector(section):section;
         this.lePapa=this.creo(arr,ele,txt);
         $(this).appendChild(this.lePapa);
         return this;
      }
      if(opts.pos=='first')$(this).prepend(this.lePapa);
      else if(opts.pos=='next')$(this).after(this.lePapa);
      else if(opts.pos=='prev')$(this).before(this.lePapa);
      else $(this).append(this.lePapa);
      return this;
   }
}(window.jQuery);
//============================================================================//
function isNumber(n) {return !isNaN(parseFloat(n)) && isFinite(n);}
//============================================================================//
$iyona=function(section){
   var node=(typeof(section)=='string')?document.querySelector(section):section;;
   this._$=function(ele,arr,txt){
      this.father=creo(arr,ele,txt);
      var set=this;
      node.appendChild(this.father);
      this._=function(ele,arr,txt,genesis){
         ele=creo(arr,ele,txt);
         this.father.appendChild(ele);this.child=ele;if(genesis)this.father=ele;
         return set;
      }
      return this;
   }
   return this;
}
//============================================================================//
/**
 * load a script dynamically in the header tag
 * @author fredtma
 * @version 1.2
 * @category dynamic, script
 * @param string <var>url</var> the path of the script to be loaded
 * @param string <var>sync</var> load the script with async option on
 * @return void
 */
function load_async(url,sync,position,fons){
   var s,ele,c;
   var script=document.createElement('script');
   s=document.querySelector('script[data-fons]');
   c=document.querySelector('script[src="'+url+'"]');
   if(c)return false;
   if(!position)ele=document.getElementsByTagName('head')[0];
   else if(position==='end')ele=document.getElementsByTagName('body')[0];

   if(s)$(s).remove();//ele.removeChild(s);
   if (sync !== false) script.async = true;
   script.src  = url;//script.type="text/javascript";
   if(fons){script.setAttribute('data-fons',fons);}
   ele.appendChild(script);
   return true;
//   head.parentNode.insertBefore(script, head);
}
//============================================================================//
/**
 * increase the progress bar, this is base on the number of task
 * @author fredtma
 * @version 0.4
 * @category progress, status
 * @param string <var>_msg</var> a msg to display where it is from
 * @param bool <var>_reset</var> whether to reset the progressbar to 0
 * @return void
 * @todo add the manifest field
 */
profectus=function(_msg,_reset,_process){
   if(_reset){$("#progressBar").val(0).data("tasks",0);$("#progressBar span").html(0)}
   var process=_process||8;var tasks=$("#progressBar").data("tasks")||1;var progress=Math.round(((tasks/process)*100),2);
//   console.log(_msg,"/",progress,"/",tasks,"/",process);
   $("#progressBar").data("tasks",tasks+1);$("#progressBar").val(progress);$("#progressBar span").html(progress);
}
//============================================================================//
/**
 * similar to PHP issset function, it will test if a variable is empty
 * @author fredtma
 * @version 0.8
 * @category variable
 * @return bool
 */
function isset() {
   var a=arguments;
   var l=a.length;
   var i=0;

   if (l==0) {
      throw new Error('Empty isset');
   }//end if

   while (i!=l) {
      if (typeof(a[i])=='undefined' || a[i]===null) {
         return false;
      } else {
         i++;
      }//endif
   }
   return true;
}//end function
//============================================================================//
/**
 * get the size of an object
 *
 * It will verify all the variable sent to the function
 * @author tomwrong
 * @category object,size
 * @see http://stackoverflow.com/questions/1248302/javascript-object-size
 * @return bytes
 */
function objectSize( object ) {
    var objectList=[];var stack=[object];var bytes=0; var cnt=0; var i;
    while ( stack.length ) {
        var value = stack.pop();
        if ( typeof value === 'boolean') {bytes += 4;}
        else if(typeof value === 'string') {bytes += value.length * 2;}
        else if(typeof value === 'number') {bytes += 8;}
        else if(typeof value === 'object'&& objectList.indexOf( value ) === -1)
        {objectList.push( value );for( i in value ){stack.push( value[ i ] );cnt++;if(cnt>500)return bytes;}}
    }
    return bytes;
}
//============================================================================//
/**
 * measure two time frame from the begining of the script TimeElapse
 * for the current script TimeFrame
 * @author fredtma
 * @version 0.8
 * @category performance
 */
function timeFrame(_from,_total){
   var endTime,from,elapse;
   endTime=new Date().getTime();
   from=endTime-sessionStorage.runTime;
   elapse=endTime-sessionStorage.startTime;
   console.log('TimeFrame:'+_from+' '+from);
   if(_total)console.log('TimeElapse:'+_from+' '+elapse);
   sessionStorage.runTime=endTime;
}
//============================================================================//
/**
 * used in a similar way as the php version of ucwordsn
 * @author fredtma
 * @version 0.2
 * @category string
 * @param string <var>str</var> is the string that will be converted
 * @see PHP ucwords
 * @return string
 */
ucwords = function (str)
{
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}//end function
//============================================================================//
/**
 * change into alpha numerical, with no spacing
 * @author fredtma
 * @version 0.3
 * @category string
 * @param string <var>the_str</var> the input string to be changed
 * @param boolean <var>transform</var> choses to make it upper case or not
 * @see ucwords
 * @return string
 */
aNumero = function(the_str,transform)
{
   the_str   = the_str.toLowerCase();
   the_str   = (transform)?ucwords(the_str.toLowerCase()): the_str;
   the_str   = the_str.replace(/[^A-Za-z0-9\s]*/ig,'');
   return the_str;
}
//============================================================================//
/*
 * display the message notification
 * @param {string} <var>msg</var> the message to display
 * @param {bool} <var>animation</var> enable animation
 * @returns void
 */
function notice(msg,animation,text){
   if(!msg){$(".db_notice").empty();$(".sys_msg").empty(); return true;}
   msg=text==2?"<strong class='text-success'>"+msg+"</strong>":text==1?"<span class='text-success'>"+msg+"</span>":(text==0)?"<span class='text-error'>"+msg+"</span>":msg;
   if(animation)$(".db_notice").html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
   else $(".db_notice").html(msg);
}
//============================================================================//
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
function isOnline(_display){
   var myAppCache = window.applicationCache; var note;

   var msg=navigator.onLine?"Status: Working <strong class='text-success'>Online</strong>":"Status: Working <strong class='txt-error'>Offline</strong>";
   switch (myAppCache.status) {
      case myAppCache.UNCACHED:msg+=', CACHE::UNCACHED'; break;//status 0 no cache exist
      case myAppCache.IDLE:msg+=', CACHE::IDLE'; break;//status 1 most common, all uptodate
      case myAppCache.CHECKING:msg+=', CACHE::CHECKING';break;//status 2 browser reading manifest
      case myAppCache.DOWNLOADING:msg+=', CACHE::DOWNLOADING';break;//status 3 new or updated resource dwlding
      case myAppCache.UPDATEREADY:msg+=', CACHE::UPDATEREADY';break;//status 4 file has been updated
      case myAppCache.OBSOLETE:msg+=', CACHE::OBSOLETE';break;//status 5 missing manifest, re dwld
      default: msg+=', CACHE::UKNOWN CACHE STATUS';break;
    };
   $('#statusbar').html(msg);
   if(_display===true){
      note=window.hasOwnProperty('localStorage')?"<ouput id='notice1'>Local <strong class='text-success'>Storage</strong> enabled.</ouput>":"<ouput id='notice1'>No Local <strong class='text-error'>Storage</strong></ouput>";
      note+=window.sessionStorage?"<ouput id='notice2'>Session <strong class='text-success'>Storage</strong> enabled.</ouput>":"<ouput id='notice2'>No Session <strong class='text-error'>Storage</strong></ouput>";
      note+=window.Worker?"<ouput id='notice3'>Multy threading <strong class='text-success'>Worker</strong> enabled.</ouput>":"<ouput id='notice2'>No support for <strong class='text-error'>Multy threading </strong></ouput>";
      note+=window.openDatabase?"<ouput id='notice4'> <strong class='text-success'>WebSql</strong> enabled.</ouput>":"<ouput id='notice2'>No <strong class='text-error'>WebSql</strong></ouput>";
      note+=window.WebSocket?"<ouput id='notice5'> <strong class='text-success'>WebSocket</strong> enabled.</ouput>":"<ouput id='notice2'>No <strong class='text-error'>WebSocket</strong></ouput>";
      note+=window.history?"<ouput id='notice6'> <strong class='text-success'>History</strong> enabled.</ouput>":"<ouput id='notice2'><strong class='text-error'>History</strong> not available</ouput>";
      $('#sideNotice').append(note);
   }
}
//============================================================================//
/**
 * reset a form input data
 * @author fredtma
 * @version 2.5
 * @category form, reset
 * @param object <var>_frm</var> the object representing the form
 */
function resetForm(_frm){
   $(':input',_frm).not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');$('textarea',_frm).val('');
   $('input[type=checkbox],input[type=radio]',_frm).prop('checked',false).prop('selected',false);
   $('button[type=button]',_frm).removeClass('active');
}
//============================================================================//
/**
 * places the session current active json setting in a variable
 * @author fredtma
 * @version 2.8
 * @category json
 */
eternalCall=function(){
   if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);else eternal=null;
   return eternal;
}
//============================================================================//
/*
 * forgot password function
 * @returns void
 */
oblitusSignum=function(){
   var u=$('#loginForm #email').val();
   var patterns=JSON.parse(dynamisGet("EXEMPLAR",true)),msg;
   if(u.search(patterns["email"][0])==-1){msg=patterns["email"][1];
      $('#userLogin .alert-error span').html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
   }else{
      $("#mailProgress").show();
      get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"oblitus","u":u},"","post","json",function(results){
         console.log(results,"results");$("#mailProgress").hide();
         if(results&&results.mail&&results.mail.status){$('#userLogin .alert').removeClass("alert-error");
         }else if(results&&results.mail&&results.mail.status===false){
            $('#userLogin .alert span').html(results.mail.msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
         }
      });
   }//endif correct formate
}
//============================================================================//
/**
 * login validation, once user click login on the form.
 * Validates the user, give session and permanent variable respectively
 * @author fredtma
 * @version 2.9
 * @category json
 */
loginValidation=function(){
   var u,p,row;
   try{
      u=$('#loginForm #email').val();p=md5($('#loginForm #password').val());
      get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"aliquis","p":p,"u":u},"","post","json",function(results){
         if(results.aliquis.rows.length&&results.licentia){
            this.checkAliquis(results,true);
         }else{
            var attempt=$("footer").data("attempt")||1;
            if(attempt==1)var msg='Failed login attempt...'
            else if (attempt==2){
               $anima(".modal-footer","div",{"clss":"progress progress-striped active","style":"width:55%;display:none;float:left;","id":"mailProgress"},"","first").vita("div",{"clss":"bar","style":"width:100%"},false,"Please wait loading...");
               $anima(".modal-footer","button",{"form":"loginForm","clss":"btn btn-inverse","type":"button"},"Forgot Password").father.onclick=oblitusSignum;
               msg='Failed attempt count['+attempt+'].<br/>Fill in your email address in the first field and click on forgot password';}
            else msg='Failed attempt count['+attempt+'].<br/>Fill in your email address in the first field and click on forgot password';
            if($('#userLogin .alert-info').length)$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            else $('#userLogin .alert span').html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            $("footer").data("attempt",(++attempt));
         }
      });
   }catch(err){console.log('ERROR::'+err.message)}
   //-------------------------------------------------------------------------//
   this.checkAliquis=function(_results,_from){
      row=_from?_results.aliquis[0]:_results.rows.item(0);
      var procurator=(row['level']==='super')?1:0;
      var USER_NAME={"operarius":row['username'],"singularis":row['id'],"nominis":row['name'],"jesua":row['jesua'],"procurator":procurator};
      if($('#loginForm #remeberMe').prop('checked'))dynamisSet("USER_NAME",JSON.stringify(USER_NAME),true);
      else sessionStorage.USER_NAME=JSON.stringify(USER_NAME);
      if(row['level']==='super'){viewAPI(true);}else{viewAPI(false);}
      $('#userName a').html(impetroUser().nominis);
      $('#userLogin').modal('hide').remove();
      sessionStorage.licentia=JSON.stringify(_results.licentia);
      theDashboard();hauriret();vocationCall();
      if(window.Worker){
         var notitiaWorker=new Worker("js/bibliotheca/worker.notitia.js");
         (function(procus){var moli=screen.height*screen.width;
            if(procus){notitiaWorker.postMessage({"procus":procus.singularis,"moli":moli,"reprehendo":true});readWorker(notitiaWorker)}
         })(USER_NAME);
      }
   }
   return false;
}
//============================================================================//
impetroUser=function(){
   var USER_NAME=dynamisGet("USER_NAME",true)?JSON.parse(dynamisGet("USER_NAME",true)):(dynamisGet("USER_NAME"))?JSON.parse(dynamisGet("USER_NAME")):false;
   return USER_NAME;
}
//============================================================================//
/**
 * login OUT removes all session and some permanent variable
 * creates the login form dynamically as well
 * @author fredtma
 * @version 3.2
 * @category login, dynamic
 */
loginOUT=function(refresh){
   refresh=typeof refresh=="boolean"?refresh:true;
   if(refresh){$("#nav-main").empty();$("#tab-home section").empty();$("#tab-dealers section").empty();$("#tab-saleman section").empty();$("#tab-customers section").empty();
   $("#tab-insurance section").empty();$("#tab-system section").empty();$("#navior ul").remove(); $("#verbum").empty(); roadCover.loginForm();
   $('#userLogin .alert-info').find('span').append('You have successfully logout.<br/>Enter your username and password below if you wish to login again');}
   dynamisDel("USER_NAME");refreshLook(refresh);//dynamisDel("DB",true);
}
//============================================================================//
/**
 * refreshes the pages and removes session variable, cleares out some variable
 * this is used in case an error occures
 * @author fredtma
 * @version 3.4
 * @category refresh, clean, safety
 */
refreshLook=function(removeall){
//   console.log(history.length);console.log(history.state);console.log(history);
   var tmp=sessionStorage.USER_NAME||"{}";
   notice();
   $('.search-all').val('');$('footer').removeData();$('#displayMensa').removeData();
   sessionStorage.clear();if(removeall!==true){
   tmp=JSON.parse(tmp);
   sessionStorage.USER_NAME=JSON.stringify(tmp);}
   sessionStorage.runTime=0;sessionStorage.startTime=new Date().getTime();sessionStorage.genesis=0;
   licentia();
   console.log('history['+history.length+']:...');if(removeall!==true)history.go(0);else window.location.href=dynamisGet("SITE_URL",true);
}
//============================================================================//
/*
 * this function will reset the whole system
 * @returns void
 */
resetGenesis=function(){
   if(confirm("Please note this will re-sync the entire system")){
      dynamisDel("DB",true);
      SET_DB();//@todo:add licentia in worker
//      loginOUT(false);
   }
}
//============================================================================//
/**
 * places the screen in fullscreen
 * @author fredtma
 * @version 1.8
 * @category feature
 */
enableFullScreen=function(elem){
   elem=elem||'fullBody';
   elem=document.getElementById(elem);
   if(elem.webkitRequestFullscreen){console.log('webKit FullScreen');elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);}
   else if(elem.mozRequestFullScreen){console.log('moz FullScreen');elem.mozRequestFullScreen();}
   else if(elem.requestFullscreen) {console.log('FullScreen');elem.requestFullscreen();}
   var fullscreenElement = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;//the element in fullscreen
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
}
//============================================================================//
/**
 * removes the full screen feature
 * @author fredtma
 * @version 1.9
 * @category fullscreen, features
 */
exitFullScreen=function(){
   if(document.cancelFullScreen)document.cancelFullScreen();else if(document.mozCancelFullScreen)document.mozCancelFullScreen();else if(document.webkitCancelFullScreen)document.webkitCancelFullScreen();
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
   if(fullscreenEnabled){if(document.webkitExitFullscreen)document.webkitExitFullscreen();else if(document.mozCancelFullscreen)document.mozCancelFullscreen();else if(document.exitFullscreen)document.exitFullscreen();}
}
//============================================================================//
/*
    *
    * @param {integer} <var>_iota</var> the single indentifier
    * @param {string} <var>_mensa</var> the table name
    * @returns {undefined}
    */
sideDisplay=function(_iota,_mensa){
   var display=$('footer').data('display');var adrType,title,key;
   console.log(display,'display');
   if(typeof display!="undefined" || display==false){//pour aider le system a ne pas trop travailler
      if(display[0]==_iota&&display[1]==_mensa) return true;else $('footer').data('display',[_iota,_mensa]);//celui-ci c'est pour changer quand display a une value d'une autre source
   }
   $('footer').data('header',true);console.log($('footer').data('display'),'Header set');
   if(_iota==0){
      $('#displayMensa').removeData();$('#displayMensa').empty();$('#sideBot h3').html("Viewing all Current Members");$('.headRow').html(eternal.form.legend.txt);return true;//pour arreter le system de continuer
   }
   $('footer').data('display',[_iota,_mensa]);console.log(_iota,_mensa,display,'cherche a partir des donner',$('footer').data('display'));
   switch(_mensa){
      case 'dealers':
         get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":_mensa+"-display",iota:_iota},null,'post','json',function(_results){
            //change la list du menu et du button avec les dernier donner
            //@removed: feature
//            $("#drop_"+_mensa+" .oneDealer").last().parent().remove();$("#tab-customers .dealersList .oneDealer").last().parent().remove();$("#tab-insurance .dealersList .oneDealer").last().parent().remove();
//            $anima("#drop_"+_mensa,"li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-"+_mensa,"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('dealer','dealers',this)}
//            $anima("#tab-customers .dealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('customer','customers',this,true,'dealers')}
//            $anima("#tab-insurance .dealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('member','insurance',this,true,'dealers')}
            $('#displayMensa').empty();$('#displayMensa').removeData();//empty the sidetitle display
            if(typeof _results.company[0]!="undefined"&&typeof _results.company[0]!="undefined")$('#sideBot h3').html(aNumero(_results.company[0].Name,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof _results.company[0]!="undefined"&&typeof _results.company[0]!="undefined")?"Customers under "+_results.company[0].Name:eternal.form.legend.txt;
            $('.headRow').html(title);
            var $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/LocalBusiness","itemscope":""});
            for(key in _results.address){
               switch(_results.address[key].Type){
                  case 'Dns.Sh.AddressBook.EmailAddress':if(_results.address[key].Address)$sideDisplay.novo('#displayList','dt',{},'Email').genesis('dd',{'itemprop':'email'},false).child.innerHTML="<a href='mailto:"+_results.address[key].Address+"' target='_blank'>"+_results.address[key].Address+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FaxNumber':$sideDisplay.novo('#displayList','dt',{},'Fax').genesis('dd',{"itemprop":"faxNumber"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'>"+'('+_results.address[key].AreaCode+')'+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FixedLineNumber':$sideDisplay.novo('#displayList','dt',{},'Tel').genesis('dd',{"itemprop":"telephone"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'> "+'('+_results.address[key].AreaCode+')'+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.MobileNumber':$sideDisplay.novo('#displayList','dt',{},'Cell').genesis('dd',{"itemprop":"cellphone"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'>"+_results.address[key].AreaCode+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.PostalAddress': adrType='Postal';
                  case 'Dns.Sh.AddressBook.PhysicalAddress':
                     $sideDisplay.novo('#displayList','dt',{},'Address '+adrType).genesis('dd',{},false,_results.address[key].Line1);
                     if(_results.address[key].Line2!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Line2);
                     if(_results.address[key].UnitName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].UnitName);
                     if(_results.address[key].UnitNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].UnitNumber);
                     if(_results.address[key].StreetName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].StreetName);
                     if(_results.address[key].StreetNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].StreetNumber);
                     if(_results.address[key].Province_cd!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Province_cd);
                     if(_results.address[key].Suburb!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Suburb);
                     if(_results.address[key].City!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].City);
                     if(_results.address[key].Code!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Code);
                     break;
               }//end swith
            }//end for
         });
         break;
      case 'salesmen':
         get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"salesman-display",iota:_iota},null,'post','json',function(_results){
            //change la list du menu et du button avec les dernier donner
//            $("#drop_salesman"+" .oneSalesman").last().parent().remove();$("#tab-customers .salesmanList .oneSalesman").last().parent().remove();$("#tab-insurance .salesmanList .oneSalesman").last().parent().remove();
//            $anima("#drop_salesman","li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-salesman","clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('salesman','salesmen',this)};
//            $anima("#tab-customers .salesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('customer','customers',this,true,'salesmen')}
//            $anima("#tab-insurance .salesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('member','insurance',this,true,'salesmen')}
            $('#displayMensa').empty();$('#displayMensa').removeData();
            if(typeof _results.agent!="undefined"&&typeof _results.agent[0]!="undefined")$('#sideBot h3').html(aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof _results.agent!="undefined"&&typeof _results.agent[0]!="undefined")?"Customers under "+_results.agent[0].FullNames+' '+_results.agent[0].Surname:eternal.form.legend.txt;
            $('.headRow').html(title);
            var $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/Person","itemscope":""});
            if(typeof _results.agent[0]!="undefined")$sideDisplay.novo('#displayList','dt',{},'ID').genesis('dd',{},false,_results.agent[0].IdentificationNumber);
            for(key in _results.address){
               switch(_results.address[key].Type){
                  case 'Dns.Sh.AddressBook.EmailAddress':if(_results.address[key].Address)$sideDisplay.novo('#displayList','dt',{},'Email').genesis('dd',{'itemprop':'email'},false).child.innerHTML="<a href='mailto:"+_results.address[key].Address+"' target='_blank'>"+_results.address[key].Address+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FaxNumber':$sideDisplay.novo('#displayList','dt',{},'Fax').genesis('dd',{"itemprop":"faxNumber"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'>"+'('+_results.address[key].AreaCode+')'+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FixedLineNumber':$sideDisplay.novo('#displayList','dt',{},'Tel').genesis('dd',{"itemprop":"telephone"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'> "+'('+_results.address[key].AreaCode+')'+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.MobileNumber':$sideDisplay.novo('#displayList','dt',{},'Cell').genesis('dd',{"itemprop":"cellphone"},false).child.innerHTML="<a href='tel:"+_results.address[key].AreaCode+_results.address[key].Number+"'>"+_results.address[key].AreaCode+_results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.PostalAddress': adrType='Postal';
                  case 'Dns.Sh.AddressBook.PhysicalAddress':
                     $sideDisplay.novo('#displayList','dt',{},'Address '+adrType).genesis('dd',{},false,_results.address[key].Line1);
                     if(_results.address[key].Line2!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Line2);
                     if(_results.address[key].UnitName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].UnitName);
                     if(_results.address[key].UnitNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].UnitNumber);
                     if(_results.address[key].StreetName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].StreetName);
                     if(_results.address[key].StreetNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].StreetNumber);
                     if(_results.address[key].Province_cd!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Province_cd);
                     if(_results.address[key].Suburb!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Suburb);
                     if(_results.address[key].City!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].City);
                     if(_results.address[key].Code!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,_results.address[key].Code);
                     break;
               }//end swith
            }//end for
         });
         break;
   }//switch
}
//============================================================================//
/**
 * this function sets the viewing option of the API
 * @author fredtma
 * @version 2.5
 * @category permission
 * @param boolean <var>_viewing</var> set the viewing option
 * @return void
 * @todo add all the permission options
 */
function viewAPI(_viewing){if(!_viewing) $('.homeSet0,.setDisplay').hide();else $('.homeSet0,.setDisplay').show();}
//============================================================================//
/**
 * gets the permissions of the user. Note permission are static
 * @param {bool} <var>_live</var> get it from the live server
 * @param {bool} <var>_drawn</var> redraw the dashboard and page
 * @author fredtma
 * @version 3.1
 * @category permission, login
 * @param string <var>_nominis</var> the nominis of the user
 */
function licentia(_live,_draw){
   var len,x,tmp,row,val;
   var _nominis = impetroUser();
   if(_live&&navigator.onLine){
      get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"licentia","licentia":_nominis.operarius},'',"post","json",function(_results){
//         console.log(_results,"_results",sessionStorage.licentia);
         if(_results){
            sessionStorage.licentia=JSON.stringify(_results);if(_draw){theDashboard();hauriret();}
         }//endif
      });
   }else{
      var quaerere="SELECT pu.`permission` as permission FROM link_permissions_users pu WHERE `user`=? UNION \
      SELECT pg.`permission` as permission FROM link_permissions_groups pg INNER JOIN link_users_groups ug ON ug.`group`=pg.`group` WHERE ug.user=?";
      $DB(quaerere,[_nominis.operarius,_nominis.operarius],"Accessing permissions",function(_results){
         len=_results.rows.length;tmp={};
         for(x=0;x<len;x++){row=_results.rows.item(x);val=row['permission'];tmp[val.toLowerCase()]=x;}
         sessionStorage.licentia=JSON.stringify(tmp);if(_draw){theDashboard();hauriret();}
      });
   }//endif
}
//============================================================================//
/*
 * analyse whether a permission for the user will return true
 * @param {string} <var>_name</var> the prefix of the permission
 * @param {string} <var>_perm</var> the suffix of the permission
 * @returns Boolean
 */
function getLicentia(_name,_perm,_msg){
   var name1=_name;
   if(_name===true)return _name;
   if(name1.indexOf('s')!=-1)var name2=name1.replace(/s$/,""); else name2=name1+'s';
   name1=name1+' '+_perm;name2=name2+' '+_perm;
   var tmp=sessionStorage.licentia?JSON.parse(sessionStorage.licentia):{};
   if(impetroUser().procurator) return true;
   name1=name1.toLowerCase();name2=name2.toLowerCase();
//   console.log(tmp,"/",name1,"/",name2,tmp[name1]);
   if(tmp[name1]||tmp[name2])return true;
   if(_msg){
      _msg="<strong class='text-error'>You do not have permission to view "+_name+"</strong>";
      $("#body article").html("<ul class='breadcrumb'><li>"+_msg+"<br/>Please contact the adminstrator to access this page.</li></ul>");
      notice(_msg,true,0);}
   return false;
}
//============================================================================//
/**
 * this fnction will get the content page from the db
 * @author fredtma
 * @version 7.5
 * @category content, text
 * @param string <var>_page</var> the name title of the page
 * @param boolean <var>_list</var> the option to display the tree list or not
 * @return void
 * @todo add the sub tree functionality
 */
function getPage(_page,_list){
   var len,row,tmp,d;
   if(getLicentia("Pages","View")===false){notice("<strong class='text-error'>You do not have permission to view the content pages</strong>",true,0);return false;}
   var mensula=_list?"system":false;
   recHistory(_page,mensula,false,false,false,true);
   if(_list){
      $('.system1').tab('show');
   }
   $DB("SELECT id,title,content,modified,jesua FROM pages WHERE title=?",[_page],"Found page "+_page,function(results){
      len=results.rows.length;row=[];
      if(len){row=results.rows.item(0);$('footer').data('Tau','deLta');$('footer').data('iota',row['jesua']);}
      else {row['title']=_page;row['content']="Click here to add new content";row['modified']=getToday();$('footer').data('Tau','Alpha');$('footer').data('iota',null);}
      $("#body article").empty();tmp=row['modified'];d=(tmp.search('0000-00-00')!=-1)?getToday():tmp;
      var d1 = new Date(d);d=null;tmp=null;
      var contentEditable=getLicentia("Pages","Edit");
      $anima("#body article","section").vita("header",{},true).vita("h1",{"id":"page_title","contenteditable":contentEditable},false,row['title']).vita('h3',{},true).vita("time",{"datetime":d1.format("isoDateTime")},false,'Last modified'+d1.format(dynamisGet("SITE_DATE",true)));
      $anima("#body article","section",{"id":"page_content","contenteditable":contentEditable}).father.innerHTML=row['content'];
      load_async("js/libs/CKEditorCus/ckeditor.js",true,'end',false);
      //@solve:prevents bug of CKEDITOR not existing.
      if(typeof CKEDITOR!=="undefined"&&contentEditable){var titleEditor = CKEDITOR.inline(document.getElementById('page_title'));
      var pageEditor = CKEDITOR.inline(document.getElementById('page_content'));}
   });
}
//============================================================================//
/**
 * searches all the functions in the system
 * @author fredtma
 * @version 1.2
 * @category search, query
 * @param string <var>_query</var> the part of the string to search
 * @param function <var>_process</var> the function that return the results
 * @see get_rich_custom_fields(), $iyona
 * @return void|bool
 * @todo finish the function on this page
 * @uses file|element|class|variable|function|
 */
function searchAll(_query,_process){
   var len,x,got;
   var set=this;set.shown=true;_query=_query||'%';
   $DB("SELECT feature,category,filename,manus,tab FROM features WHERE feature LIKE ?",['%'+_query+'%'],"searching "+_query,function(_results,results){
      len=results.rows.length;got=[];getResults={};
      for(x=0;x<len;x++){got[x]=results[x]['feature'];getResults[results[x]["feature"]]={"cat":results[x]["category"],"file":results[x]["filename"],"manus":results[x]["manus"],"tab":results[x]["tab"]};sessionStorage.tempus=JSON.stringify(getResults);}
      _process(got);
      set.$menu[0].style.top='auto';
   });
}
//============================================================================//
/**
 * typeahead search result upon click function
 * This will also change the page according to the result selected
 * @author fredtma
 * @version 2.3
 * @param string <var>item</var> the value clicked upon
 * @return object
 */
function searchUpdate(item){
   var _mensa,_mensula,_set,_script,_tab=false;sessionStorage.genesis=0;
   var getResults=JSON.parse(sessionStorage.tempus);
   getResults=getResults[item];
   _mensula=getResults.tab;
   _set='#link_'+_mensula;
   switch(getResults.cat){
      case 'json-script':
      case 'json':_tab=false;break;
      case 'script':_script=true;break;
      case 'page':getPage(item);return item;break;
      case 'help':break;
      case 'execute':break;
   }
   sessionStorage.removeItem('tempus');
   _mensa=getResults.file;
   if(getResults.manus && getResults.manus !="{}"){
      var manus=JSON.parse(getResults.manus);
      if(manus.form=="alpha")sessionStorage.formTypes="alpha";
   }
   activateMenu(_mensa,_mensula,_set,_script,_tab);
   return item;
}
//============================================================================//
/**
 * reset a the body, removes the pagination and new button
 * @author fredtma
 * @version 3.4
 * @category reset, new
 * @see dashboard,res.notitia
 * @return void
 */
function newSection(){
   $('#newItem').remove();$('.pagination').remove();$('#verbum').empty();$('.headRow').empty();
   $('.search-all').val('').prop('disabled',true);$('#displayMensa').empty();$('#displayList').empty();
   $('#link_home').tab('show');
   sessionStorage.genesis=0;//reset each time ur on dashboard
}
//============================================================================//
function liberoAnimus(){
   notice();sessionStorage.genesis=0;//reset each time ur on dashboard
   $('.body article').removeClass('totalView');//remove the class that is placed by the cera's
   for(var instance in CKEDITOR.instances){console.log(instance,"/instance/",CKEDITOR.instances); CKEDITOR.instances[instance].destroy()}//@fix: ce si et necessaire, if faut detruire toute instance avant de naviger
   $("footer").removeData('lateCall').removeData('examiner').removeData("customer");
   //$("#displayMensa").removeData('mensa');
}
//============================================================================//
/*
 * function to activate the dashboard blocks and links of the navTab
 */
function activateMenu(_mensa,_mensula,_set,_script,_tab,_formType){
   liberoAnimus();
   _mensula=_mensula||_mensa;var value=true;//the return value if it was passed successfully or not
   var iota=$(_set).data('iota');var narro={};
   if(_formType)sessionStorage.formTypes=_formType;//used to change from beta to alpha display
//   console.log(_mensa,_mensula,_script,'[FORM]',_tab,_formType,sessionStorage.formTypes,'[this is it]',_set,'----------------------',$(_set)[0],"/");
   recHistory(_mensa,_mensula,_script,_tab,_formType);
   if(!_script)$.getJSON("json/"+_mensa+".json",findJSON).fail(onVituim);
   else if(_script==="cera")get_ajax("cera/"+_mensa+".html","",".body article");
   else {
      value=load_async("js/agito/"+_mensa+".js",true,'end',true);
      if(value===false&&typeof agitoScript==="function"){
         if(iota)$("footer").data("temp",[iota,_tab]);//@fix:this will initiate a value, when changing via dropdown @only dealer&saleman
         agitoScript();
      }else{//@explain:ce program et appeler une deuxiem foi avec agitoScript() qui et standard
         agitoScript=function(){return true;}
      }
   }
   if(_mensa=='salesman')_mensula='salesman';//ce si cest pour les sales seulment
   if(!_tab){
      $(_set).tab('show');
      $(".navLinks").removeClass('active');
      $("#nav_"+_mensula).addClass('active');}//montre la tab et le menu
   else{
      _mensula=_tab;
      if(iota!=0)$('footer').data('temp',[iota,_tab])//montre seulment les list qui on des uniter iota
      else {$('footer').removeData('temp');$('footer').removeData('display');}//change les deux, pour raison de afficher un neauvaux titre
   }//change de nom pour les button, pour avoir access aux menu des dealer & des salesman
   if(_mensa=='salesman')_mensula='salesmen';
   if(iota){sideDisplay(iota,_mensula);}//fair apparaitre la table si une existance de parametre iota exists.
   return value;//currently only for the script
}
//============================================================================//
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
function recHistory(_mensa,_mensula,_script,_tab,_formType,_page){
   var narro={};
   //prepare l'object puor ecrire l'histoire
   if(sessionStorage.narro) narro = JSON.parse(sessionStorage.narro);//si il ya rien dans l'objet d'histoire
   var mensa=(_formType)?_mensa:false;//to prevent the lost of the original file
   _mensa=(_formType)?_mensa+"_"+_formType:_mensa;//This will change the key value if a formType is included
   narro[_mensa]={"table":_mensula,"manus":_script,"tab":_tab,"type":_formType,"page":_page,"store":mensa};//ajoute une nouvelle histoire
   sessionStorage.narro=JSON.stringify(narro);
   history.pushState({path:_mensa},_mensula);
//   console.log(sessionStorage.narro,'sessionStorage.narro',narro);
}
//============================================================================//
/**
 * enables the tooltip help function
 * @author fredtma
 * @version 2.3
 * @category help
 * @return void
 * @todo retrieve data from the db.
 */
helpfullLink=function(_now,_curr){
   var alpha=$("#nav-main .active").attr("id");var encore='',def;
   var openForm=document.querySelector(".accordion-body.in form");
//   var collapse=$(".collapse").length;
//   if(collapse)$(".collapse").css({"overflow":"inherit"});
   if(openForm)alpha="form";
   if(typeof _now==="object"){
      switch(alpha){
         case "nav_dealers":if($(".invHead").length)_now=".invHead"; else _now="#"+alpha;break;
         case "nav_salesman":case "nav_customers":case "nav_insurance":_now="#"+alpha;break;
         case "form":_now=openForm.id.search(/#/ig)!=-1?openForm.id:'#'+openForm.id;encore=' legend';break;
         case "nav_system":_now=".setSystem";break;default:_now="#notice6";break;}//end switch
   }//endif
//   console.log(alpha,'tab',_now,"/",_curr,$(_now),'/',$(_now)[0]);
   if(_curr)$(_curr).popover('destroy');
   $DB("SELECT title,content,option,position FROM pages WHERE selector=?",[_now],"",function(r,j){
      _now+=encore;//var collapse=$(".collapse").length;
      if(j.rows.length){
         var row=j[0];var content=row['content'];var title=row['title'];var next=row['option'];var pos=row['position'];
         var link="<div class='pager small'><ul><li class='previous'><a href='javascript:void(0)' onclick='javascript:$(\""+_now+"\").popover(\"destroy\");' >Close</a></li>";
         if(next!=='none'&&!def)link+="<li class='next'><a href='javascript:void(0)' onclick='helpfullLink(\""+next+"\",\""+_now+"\")' >Next »</a></li></ul></div>";
         else if(def)link+="<li class='next'><a href='javascript:void(0)' onclick='helpfullLink(\""+def+"\",\""+_now+"\")' >Next »</a></li></ul></div>";
         console.log(_now,"_now",$(_now)[0]);
         content=content+link;var len=$(_now).length;if(len>1)_now=$(_now)[0];
         console.log(_now,"_now",$(_now));
         //if(collapse&&!$(_now).length)$(".collapse").css({"overflow":"hidden"});
         $(_now).first().popover({"html":true,"trigger":"click","title":title,"content":content,"placement":pos});$(_now).popover('show');
      }
   });
}
//============================================================================//
/**
 * closes one helper and opens the next
 * @author fredtma
 * @version 3.6
 * @category references
 * @param object <var>_now</var> the current helper
 * @param object <var>_next</var> the next hint object
 */
helpfullNext=function(_now,_next){
   var next="<br/><a href='javascript:void(0)' class='helpNext' onclick='helpfullNext(\'\')' >Next >></a>";
   var content=$(_next).data('content')+next;
   $(_now).popover('destroy');
   $(_next).popover({"html":true,"trigger":"click","content":content});$(_next).popover('show');
}
//============================================================================//
/**
 * used for the second callback when giveng all of the master table to the child table
 * @author fredtma
 * @version 5.2
 * @category references
 * @param integer <var>x1</var> the interation number to the main query results
 * @param object <var>j</var> the result of the main table
 * @param element <var>set</var> te element that was clicked
 * @param string <var>f</var> the name of the field to look for
 * @param string <var>_mensa</var> the link table
 * @param string <var>agris1</var> the first field to add
 * @param string <var>agris2</var> the second field to add
 * @param date <var>d</var> the date of the creation.
 */
function savingGrace(x1,j,set,f,_mensa,agris1,agris2,d,del){
   var quaerere={};quaerere.eternal={};quaerere.eternal[agris1]={};quaerere.eternal[agris2]={};
   if(del){//use it x2 first to delete and initiate the first record
         quaerere.eternal[agris1].alpha=$(set).data('tribus');quaerere.eternal[agris1].delta="!@=!#";
         quaerere.eternal[agris2].alpha=j[x1][f];quaerere.eternal[agris2].delta=" AND !@=!#";
         quaerere.Tau='oMegA';quaerere.iyona=_mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
      $DB("DELETE FROM "+_mensa+" WHERE `"+agris1+"`=? AND `"+agris2+"`=?",[$(set).data('tribus'),j[x1][f]],"Deleted ",function(){
         quaerere.eternal[agris1].alpha=$(set).data('tribus');quaerere.eternal[agris1].delta="!@=!#";
         quaerere.eternal[agris2].alpha=j[x1][f];quaerere.eternal[agris2].delta=" AND !@=!#";
         quaerere.Tau='oMegA';quaerere.iyona=_mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
         console.log(x1,quaerere,'quaerere');
      });
   }else{
      $DB("SELECT id FROM "+_mensa+" WHERE `"+agris1+"`=? AND `"+agris2+"`=?",[$(set).data('tribus'),j[x1][f]],'',function(r2,j2){//cherche si il ya des duplication
         if(!j2.rows.length){
            quaerere.eternal[agris1]=$(set).data('tribus');quaerere.eternal[agris2]=j[x1][f];quaerere.Tau='Alpha';quaerere.iyona=_mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
            $DB("INSERT INTO "+_mensa+" (`"+agris1+"`,`"+agris2+"`,`creation`) VALUES (?,?,?)",[$(set).data('tribus'),j[x1][f],d]);
         }
      });
   }//endif
}
//============================================================================//
/**
 * error login system for the worker
 * @author fredtma
 * @version 2.2
 */
function onError(e){
   $('.db_notive').html(['ERROR: Line ', e.lineno, ' in ', e.filename, ': ', e.message].join(''));
   console.log(['ERROR: Line ', e.lineno, ' in ', e.filename, ': ', e.message].join(''));
}
//============================================================================//
/**
 * check if the browser supports html5 validation
 * @author fredtma
 * @version 2.1
 * @category validation,form
 * @return bool
 */
function hasFormValidation() {
    return (typeof document.createElement( 'input' ).checkValidity == 'function');
};
//============================================================================//
/**
 * set to check the client's DB to the current DB
 * The function will query the server and ask all the changes made since the users current DB
 * @author fredtma
 * @version 1.7
 * @category verision control
 * @param {real} <var>cur</var> the current version of the db
 * @param {object} <var>rev</var> the object containing the version and revision of the new version
 */
function version_db(cur,rev,trans){
   get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"verto","cur":cur,"ver":rev.ver,"revision":rev.revision},"","post","json",function(content){
      console.log(content,"/\\",typeof content,"||\/",trans);
      db.transaction(function(trans){trans.executeSql("INSERT INTO version_db (ver)VALUES(?)",[rev.ver]);});
      if(typeof content==="object"){console.log("started reseting.");SET_DB(content);}
   });
}
//============================================================================//
/**
 * the return value of the worker.
 * @author fredtma
 * @version 3.1
 * @category worker
 * @param object <var>notitiaWorker</var> the worket object
 */
function readWorker(notitiaWorker){
   notitiaWorker.addEventListener('message',function(e){
      console.log('Worker on Notitia:', e.data);
      if(e.data=="licentia")licentia();
      if(e.data=="reset progress"){profectus("starting db reset",true,10);}
      if(e.data.progress==true){profectus(e.data.resetTable);}
   },false);
   notitiaWorker.addEventListener('error',onError,false)
}
//============================================================================//
/**
 * showrcut to make a call to the worker
 * @author fredtma
 * @version 3.2
 * @category worker, background
 * @param object <var>option</var> the option to be passed to the worker
 * @return void
 */
function callWorker(option){
   var opt=$.extend({},{"procus":impetroUser().singularis,"moli":moli},option);
   if(window.Worker&&impetroUser()){
      var notitiaWorker=new Worker("js/bibliotheca/worker.notitia.js");
      var moli=screen.height*screen.width;notitiaWorker.postMessage(opt);
      readWorker(notitiaWorker);
   }
}
//============================================================================//
/**
 * the search all customer function
 * @version 5.2
 * @category search
 * @return void
 */
quaerereCustomer=function(e){
   e.preventDefault();sessionStorage.genesis=0;//reset each time ur on dashboard
   var val=$("#txtSrchCust").val();
   get_ajax(dynamisGet("SITE_SERVICE",true),{"militia":"impetro omnia","quaerere":val},"","post","json",function(result){
      if(!result.rows.length){$("#txtSrchCust").val("No result for:"+val).select();return false;}
      theForm = new SET_FORM()._Set("#body article");theForm.setBeta(result,false,false);
      sessionStorage.genesis=0;if(typeof reDraw ==="function")setTimeout(reDraw,100);//use on reDraw the search result. necessary on some form e.g. customer
   });
   return false;
}
//============================================================================//
/**
 * used to place the selected text on the menu
 * @author fredtma
 * @version 3.6
 */
dropDownMenu=function(set,from){
   set=set||this;
   var selection=$("footer").data("selection")||{},parent=$(set).parents(".btn-group"),val=$(set).text(),iota=$(set).data("iota");$(".theTXT",parent[0]).html(val);
   switch(from){
      case"salesman":selection.salesman=iota;break;
      case"dealers":selection.dealers=iota;break;
      case"month":selection.month=iota;break;
   }
   $("footer").data("selection",selection);
}
//============================================================================//
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
isOnline(true);
setInterval(isOnline,50000);//5min
profectus("@first to run in lib.numeris");
//$('#progressBar').hide();