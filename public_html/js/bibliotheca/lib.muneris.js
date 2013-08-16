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
localStorage.DB_SIZE=5;
localStorage.LIMIT=9;
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
   $('type[checkbox],type[radio]',form).prop('checked',false).prop('selected',false);
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
/******************************************************************************/
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