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
var db;
/******************************************************************************/
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
   var key;
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
$anima=function(section,ele,arr,txt,point){
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
/******************************************************************************/
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
/******************************************************************************/
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
/******************************************************************************/
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
    var objectList=[];var stack=[object];var bytes=0;cnt=0;
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
/******************************************************************************/
/**
 * measure two time frame from the begining of the script TimeElapse
 * for the current script TimeFrame
 * @author fredtma
 * @version 0.8
 * @category performance
 */
function timeFrame(_from,_total){
   endTime=new Date().getTime();
   from=endTime-sessionStorage.runTime;
   elapse=endTime-sessionStorage.startTime;
   console.log('TimeFrame:'+_from+' '+from);
   if(_total)console.log('TimeElapse:'+_from+' '+elapse);
   sessionStorage.runTime=endTime;
}
/******************************************************************************/
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
/******************************************************************************/
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
function isOnline(_display){
   var myAppCache = window.applicationCache;
   msg=navigator.onLine?"Status: Working <strong class='text-success'>Online</strong>":"Status: Working <strong class='txt-error'>Offline</strong>";
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
      note=window.localStorage?"<div id='notice1'>Local <strong class='text-success'>Storage</strong> enabled</div>":"<div id='notice1'>, No Local <strong class='text-error'>Storage</strong></div>";
      note+=window.sessionStorage?"<div id='notice2'>Session <strong class='text-success'>Storage</strong> enabled</div>":"<div id='notice2'>, No Session <strong class='text-error'>Storage</strong></div>";
      $('#sideNotice').append(note);
   }
}
/******************************************************************************/
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
/******************************************************************************/
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
loginValidation=function(){
   try{
      u=$('#loginForm #email').val();p=$('#loginForm #password').val();
      $DB("SELECT id,username FROM users WHERE password=? AND (email=? OR username=?)",[p,u,u],"Attempt Login",function(_results){
         if(_results.rows.length){
            row=_results.rows.item(0);
            $('#hiddenElements').modal('hide');
            sessionStorage.username=row['username'];
            if($('#loginForm #remeberMe').prop('checked'))localStorage.USER_NAME=row['username'];
            if(row['id']==1||row['id']==4)localStorage.USER_ADMIN=true;
            else viewAPI(false);
            licentia(row['username']);
         }else{$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('Failed login attempt...')}
      });
   }catch(err){console.log('ERROR::'+err.message)}
   return false;
}
enableFullScreen=function(elem){
   elem=elem||'fullBody';
   elem=document.getElementById(elem);
   if(elem.webkitRequestFullscreen){console.log('webKit FullScreen');elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);}
   else if(elem.mozRequestFullScreen){console.log('moz FullScreen');elem.mozRequestFullScreen();}
   else if(elem.requestFullscreen) {console.log('FullScreen');elem.requestFullscreen();}
   var fullscreenElement = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;//the element in fullscreen
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
}
exitFullScreen=function(){
   if(document.cancelFullScreen)document.cancelFullScreen();else if(document.mozCancelFullScreen)document.mozCancelFullScreen();else if(document.webkitCancelFullScreen)document.webkitCancelFullScreen();
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
   if(fullscreenEnabled){if(document.webkitExitFullscreen)document.webkitExitFullscreen();else if(document.mozCancelFullscreen)document.mozCancelFullscreen();else if(document.exitFullscreen)document.exitFullscreen();}
}
/*
    *
    * @param {integer} <var>_iota</var> the single indentifier
    * @param {string} <var>_mensa</var> the table name
    * @returns {undefined}
    */
sideDisplay=function(_iota,_mensa){
   var display=$('footer').data('display');var adrType;
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
            $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/LocalBusiness","itemscope":""});
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
            $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/Person","itemscope":""});
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
/******************************************************************************/
/**
 * this function sets the viewing option of the API
 * @author fredtma
 * @version 2.5
 * @category permission
 * @param boolean <var>_viewing</var> set the viewing option
 * @return void
 * @todo add all the permission options
 */
function viewAPI(_viewing){
   if(!_viewing){
     $('.homeSet0,.setDisplay,.setSystem').hide();
   }
}
/******************************************************************************/
/**
 * gets the permissions of the user. Note permission are static
 * @author fredtma
 * @version 3.1
 * @category permission, login
 * @param string <var>_nominis</var> the nominis of the user
 */
function licentia(_nominis){
   quaerere="SELECT pu.`permission` as permission FROM link_permissions_users pu WHERE `user`=? UNION \
   SELECT pg.`permission` as permission FROM link_permissions_groups pg INNER JOIN link_users_groups ug ON ug.`group`=pg.`group` WHERE ug.user=?";
   $DB(quaerere,[_nominis,_nominis],"Accessing permissions",function(_results){
      len=_results.rows.length;tmp=[];
      for(x=0;x<len;x++){row=_results.rows.item(x);tmp[x]=row['permission'];}
      sessionStorage.lecentia=JSON.stringify(tmp);
   });
}
/*
 * analyse whether a permission for the user will return true
 * @param {string} <var>_name</var> the prefix of the permission
 * @param {string} <var>_perm</var> the suffix of the permission
 * @returns Boolean
 */
function getLicentia(_name,_perm){
   name=_name+' '+_perm;
   tmp=JSON.parse(sessionStorage.lecentia);
   if(localStorage.USER_ADMIN) return true;
   if(tmp.indexOf(name)!=-1) return true;
   return false;
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
function getPage(_page){
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
/******************************************************************************/
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
   set=this;set.shown=true;_query=_query||'%';
   $DB("SELECT feature,category,filename FROM features WHERE feature LIKE ?",[_query+'%'],"searching "+_query,function(_results,results){
      len=results.rows.length;got=[];getResults={};
      for(x=0;x<len;x++){got[x]=results[x]['feature'];getResults[results[x]["feature"]]={"cat":results[x]["category"],"file":results[x]["filename"]};sessionStorage.tempus=JSON.stringify(getResults);}
      _process(got);
      set.$menu[0].style.top='auto';
   });
}
/******************************************************************************/
/**
 * typeahead search result upon click function
 * This will also change the page according to the result selected
 * @author fredtma
 * @version 2.3
 * @param string <var>item</var> the value clicked upon
 * @return object
 */
function searchUpdate(item){
   var _mensa,_mensula,_set,_script=false;sessionStorage.genesis=0;
   getResults=JSON.parse(sessionStorage.tempus);
   getResults=getResults[item];
   _mensula=getResults.filename||'home';
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
   _mensa=aNumero(item);console.log(_set,'_set',document.querySelector(_set));
   activateMenu(_mensa,_mensula,_set,_script,_tab);
   return item;
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
isOnline(true);
setInterval(isOnline,50000);//5min
//$('#progressBar').hide();