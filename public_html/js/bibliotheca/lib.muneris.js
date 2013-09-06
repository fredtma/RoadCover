/*
 * numeris is a functional set of script
 * @todo: user $.remove() to remove from DOM all generated code. $.removeData() removes $.data() use with $.detach() removes element not the handler. Check $.cache
 */
//DEFINITION
sessionStorage.startTime=new Date().getTime();
sessionStorage.runTime=new Date().getTime();
localStorage.SITE_NAME="Road Cover";
localStorage.SITE_DATE='fullDate';
localStorage.SITE_TIME='mediumTime';
localStorage.SITE_URL='http://localhost/RoadCover/public_html/';
localStorage.SITE_SERVICE='https://nedbankqa.jonti2.co.za/modules/DealerNet/services.php';
localStorage.SITE_MILITIA='https://nedbankqa.jonti2.co.za/modules/DealerNet/notitia.php';
localStorage.MAIL_SUPPORT='support@roadcover.co.za';
localStorage.DB;
localStorage.DB_NAME='road_cover';
localStorage.DB_VERSION='1.0';
localStorage.DB_DESC='The internal DB version';
localStorage.DB_SIZE=15;
localStorage.DB_LIMIT=15;
localStorage.PASSPATERN='.{6,}';//(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
var db,hasNarro=false,roadCover,eternal,theForm,creoDB,iyona,iota,notitiaWorker;
sessionStorage.removeItem('quaerere');//clean up
//============================================================================//WORKERS
//notitiaWorker=new Worker("js/bibliotheca/worker.notitia.js");
//notitiaWorker.postMessage({"novum":{"perm":1}});
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
   var the_element   = document.createElement(ele);
   if (txt)
   {
      txt = document.createTextNode(txt);
      the_element.appendChild(txt);
   }
   /*
    * @todo:the @placehoder and @form also not compatible with setAttribute
 */
   for (key in arr)
   {
      var skip = false;
      if (key=='clss') {attr='class'; the_element.className = arr[key]; skip=true;}
      else if (key=='forr')attr='for';
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
   this.creo=creo;
   this.father=this.creo(arr,ele,txt);
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
   Node=(typeof(section)=='string')?document.querySelector(section):section;
   if(point=='first')Node.insertBefore(this.father,Node.firstChild); //Node.insertBefore(this.father, Node.firstChild);
   else if(point=='next')Node.parentNode.insertBefore(this.father,Node.nextSibiling);
   else Node.appendChild(this.father);
   return this;
};
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
   var s,ele;
   var script=document.createElement('script');
   s=document.querySelector('script[data-fons]');
   if(!position)ele=document.getElementsByTagName('head')[0];
   else if(position==='end')ele=document.getElementsByTagName('body')[0];
   if(s)ele.removeChild(s);
   if (sync !== false) script.async = true;
   script.src  = url;script.type="text/javascript";
   if(fons){script.setAttribute('data-fons',fons);}
   ele.appendChild(script);
//   head.parentNode.insertBefore(script, head);
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
      note=window.localStorage?"<ouput id='notice1'>Local <strong class='text-success'>Storage</strong> enabled.</ouput>":"<ouput id='notice1'>No Local <strong class='text-error'>Storage</strong></ouput>";
      note+=window.sessionStorage?"<ouput id='notice2'>Session <strong class='text-success'>Storage</strong> enabled.</ouput>":"<ouput id='notice2'>No Session <strong class='text-error'>Storage</strong></ouput>";
      note+=window.Worker?"<ouput id='notice3'>Multy threading <strong class='text-success'>Worker</strong> enabled.</ouput>":"<ouput id='notice2'>No support for <strong class='text-error'>Multy threading </strong></ouput>";
      note+=window.openDatabase?"<ouput id='notice4'> <strong class='text-success'>WebSql</strong> enabled.</ouput>":"<ouput id='notice2'>No <strong class='text-error'>WebSql</strong></ouput>";
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
   $(':input',_frm).not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
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
/**
 * login validation, once user click login on the form.
 * Validates the user, give session and permanent variable respectively
 * @author fredtma
 * @version 2.9
 * @category json
 */
loginValidation=function(){
   var u,row;
   try{
      u=$('#loginForm #email').val();p=$('#loginForm #password').val();
      $DB("SELECT id,username,firstname||' '||lastname as name FROM users WHERE password=? AND (email=? OR username=?)",[p,u,u],"Attempt Login",function(_results){
         if(_results.rows.length){
            row=_results.rows.item(0);
            sessionStorage.username=row['username'];localStorage.USER_DETAILS=row['name'];
            if($('#loginForm #remeberMe').prop('checked'))localStorage.USER_NAME=JSON.stringify({"operarius":row['username'],"singularis":row['id'],"nominis":row['name']});
            if(row['id']==1||row['id']==4||row['level']=='supper'){localStorage.USER_ADMIN=true;viewAPI(true);} else viewAPI(false);
            $('#userName a').html(localStorage.USER_DETAILS); licentia(row['username']);
            $('#userLogin').modal('hide').remove();
         }else{$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('Failed login attempt...')}
      });
   }catch(err){console.log('ERROR::'+err.message)}
   return false;
}
//============================================================================//
/**
 * login OUT removes all session and some permanent variable
 * creates the login form dynamically as well
 * @author fredtma
 * @version 3.2
 * @category login, dynamic
 */
loginOUT=function(){
   roadCover.loginForm();
   $('#userLogin .alert-info').find('span').append('You have successfully logout.<br/>Enter your username and password below if you wish to login again');
   refreshLook();sessionStorage.removeItem('username');localStorage.removeItem('USER_ADMIN');localStorage.removeItem('USER_NAME');localStorage.removeItem('USER_DETAILS');
}
//============================================================================//
/**
 * refreshes the pages and removes session variable, cleares out some variable
 * this is used in case an error occures
 * @author fredtma
 * @version 3.4
 * @category refresh, clean, safety
 */
refreshLook=function(){
   history.go(0);
//   console.log(history.length);
//   console.log(history.state);
//   console.log(history);
   var tmp=sessionStorage.username;
   $('.search-all').val('');$('footer').removeData();
   sessionStorage.clear();sessionStorage.runTime=0;sessionStorage.startTime=new Date().getTime();sessionStorage.username=tmp;sessionStorage.genesis=0;
   console.log('history:...');
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
      $('#sideBot h3').html("Viewing all Current Members");$('.headRow').html(eternal.form.legend.txt);return true;//pour arreter le system de continuer
   }
   $('footer').data('display',[_iota,_mensa]);console.log(_iota,_mensa,display,'cherche a partir des donner',$('footer').data('display'));
   switch(_mensa){
      case 'dealers':
         get_ajax(localStorage.SITE_SERVICE,{"militia":_mensa+"-display",iota:_iota},null,'post','json',function(_results){
            //change la list du menu et du button avec les dernier donner
            $("#drop_"+_mensa+" .oneDealer").last().parent().remove();$("#tab-customers .dealersList .oneDealer").last().parent().remove();$("#tab-insurance .dealersList .oneDealer").last().parent().remove();
            $anima("#drop_"+_mensa,"li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-"+_mensa,"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('dealer','dealers',this)}
            $anima("#tab-customers .dealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('customer','customers',this,true,'dealers')}
            $anima("#tab-insurance .dealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(_results.company[0].Name,true)).child.onclick=function(){activateMenu('member','insurance',this,true,'dealers')}
            $('#displayMensa').empty();
            if(typeof _results.company[0]!="undefined"&&_results.company[0]!=null)$('#sideBot h3').html(aNumero(_results.company[0].Name,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof _results.company[0]!="undefined"&&_results.company[0]!=null)?"Customers under "+_results.company[0].Name:eternal.form.legend.txt;
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
         get_ajax(localStorage.SITE_SERVICE,{"militia":"salesman-display",iota:_iota},null,'post','json',function(_results){
            //change la list du menu et du button avec les dernier donner
            $("#drop_salesman"+" .oneSalesman").last().parent().remove();$("#tab-customers .salesmanList .oneSalesman").last().parent().remove();$("#tab-insurance .salesmanList .oneSalesman").last().parent().remove();
            $anima("#drop_salesman","li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-salesman","clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('salesman','salesmen',this)};
            $anima("#tab-customers .salesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('customer','customers',this,true,'salesmen')}
            $anima("#tab-insurance .salesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)).child.onclick=function(){activateMenu('member','insurance',this,true,'salesmen')}
            $('#displayMensa').empty();
            if(typeof _results.agent!="undefined"&&_results.agent!=null)$('#sideBot h3').html(aNumero(_results.agent[0].FullNames+' '+_results.agent[0].Surname,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof _results.agent!="undefined"&&_results.agent!=null)?"Customers under "+_results.agent[0].FullNames+' '+_results.agent[0].Surname:eternal.form.legend.txt;
            $('.headRow').html(title);
            var $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/Person","itemscope":""});
            $sideDisplay.novo('#displayList','dt',{},'ID').genesis('dd',{},false,_results.agent[0].IdentificationNumber);
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
function viewAPI(_viewing){if(!_viewing) $('.homeSet0,.setDisplay,.setSystem').hide();else $('.homeSet0,.setDisplay,.setSystem').show();}
//============================================================================//
/**
 * gets the permissions of the user. Note permission are static
 * @author fredtma
 * @version 3.1
 * @category permission, login
 * @param string <var>_nominis</var> the nominis of the user
 */
function licentia(_nominis){
   var len,x,tmp,row;
   var quaerere="SELECT pu.`permission` as permission FROM link_permissions_users pu WHERE `user`=? UNION \
   SELECT pg.`permission` as permission FROM link_permissions_groups pg INNER JOIN link_users_groups ug ON ug.`group`=pg.`group` WHERE ug.user=?";
   $DB(quaerere,[_nominis,_nominis],"Accessing permissions",function(_results){
      len=_results.rows.length;tmp=[];
      for(x=0;x<len;x++){row=_results.rows.item(x);tmp[x]=row['permission'];}
      sessionStorage.licentia=JSON.stringify(tmp);
   });
}
//============================================================================//
/*
 * analyse whether a permission for the user will return true
 * @param {string} <var>_name</var> the prefix of the permission
 * @param {string} <var>_perm</var> the suffix of the permission
 * @returns Boolean
 */
function getLicentia(_name,_perm){
   var name=_name+' '+_perm;
   var tmp=sessionStorage.licentia?JSON.parse(sessionStorage.licentia):[];
   if(localStorage.USER_ADMIN) return true;
   if(tmp.indexOf(name)!=-1) return true;
   return false;
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
function getPage(_page){
   var len,row,tmp,d;
   recHistory(_page,false,false,false,false,true);
   $DB("SELECT id,title,content,date_modified FROM pages WHERE title=?",[_page],"Found page "+_page,function(results){
      len=results.rows.length;row=[];
      if(len){row=results.rows.item(0);$('footer').data('Tau','deLta');$('footer').data('iota',row['id']);}
      else {row['title']=_page;row['content']="Click here to add new content";row['date_modified']=getToday();$('footer').data('Tau','Alpha');$('footer').data('iota',null);}
      $("#body article").empty();tmp=row['date_modified'];d=(tmp.search('0000-00-00')!=-1)?getToday():tmp;
      var d1 = new Date(d);d=tmp=null;
      $anima("#body article","section").vita("header",{},true).vita("h1",{"id":"page_title","contenteditable":true},false,row['title']).vita('h3',{},true).vita("time",{"datetime":d1.format("isoDateTime")},false,'Last modified'+d1.format(localStorage.SITE_DATE));
      $anima("#body article","section",{"id":"page_content","contenteditable":true}).father.innerHTML=row['content'];
      load_async("js/libs/CKEditorMin/ckeditor.js",false,'end',true);
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
//   console.log(_set,'_set',document.querySelector(_set));
//   console.log(getResults,'getResults');
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
   $('#newItem').remove();$('.pagination').remove();$('#verbum').empty();
   $('.search-all').val('').prop('disabled',true);
   $('#link_home').tab('show');
   sessionStorage.genesis=0;//reset each time ur on dashboard
}
//============================================================================//
/*
 * function to activate the dashboard blocks and links of the navTab
 */
function activateMenu(_mensa,_mensula,_set,_script,_tab,_formType){
   _mensula=_mensula||_mensa;
//   console.log(_mensa,'_mensa',history.state);
   var iota=$(_set).data('iota');var narro={};
   if(_formType)sessionStorage.formTypes=_formType;
//   console.log(_mensa,_mensula,_script,'[FORM]',_tab,_formType,sessionStorage.formTypes,'[this is it]',_set,'----------------------',$(_set)[0]);
   recHistory(_mensa,_mensula,_script,_tab,_formType);
   if(!_script)$.getJSON("json/"+_mensa+".json",findJSON).fail(onVituim);
   else load_async("js/agito/"+_mensa+".js",true,'end',true);
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
helpfullLink=function(){
   if(!$('.btnHelp').data('toggle')||$('.btnHelp').data('toggle')==0){$('.btnHelp i').removeClass('icon-white');$('.helpfullLink').popover({"html":true,"trigger":"click"});$('.helpfullLink').popover('show');$('.btnHelp').data('toggle',1);}
   else {$('.btnHelp i').addClass('icon-white');$('.helpfullLink').popover('destroy');$('.btnHelp').data('toggle',0);}
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
//$('#progressBar').hide();