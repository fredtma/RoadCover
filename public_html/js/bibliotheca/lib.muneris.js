/*
 * numeris is a functional set of script
 * @todo: user $.remove() to remove from DOM all generated code. $.removeData() removes $.data() use with $.detach() removes element not the handler. Check $.cache
 */
//DEFINITION
sessionStorage.startTime=new Date().getTime();
sessionStorage.runTime=new Date().getTime();
localStorage.SITE_NAME="Road Cover Title";
localStorage.SITE_DATE='fullDate';
localStorage.SITE_TIME='mediumTime';
localStorage.SITE_URL='http://localhost/RoadCover/public_html/';
localStorage.MAIL_SUPPORT='support@roadcover.co.za';
localStorage.DB;
localStorage.URL_IMG=localStorage.SITE_URL+'img/';
localStorage.URL_LIB=localStorage.SITE_URL+'js/';
localStorage.URL_JSON=localStorage.SITE_URL+'json/';

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
      else attr=key;
      if (!skip) the_element.setAttribute(attr, arr[key]);
   }/*end for each*/
   return the_element;
}/*end function*/
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
function load_async(url, sync){
   var script  = document.createElement('script'),
   head        = document.getElementsByTagName('head')[0];
   if (sync !== false) script.async = true;
   script.src  = url;
   head.appendChild(script);
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

    var objectList = [];
    var stack = [ object ];
    var bytes = 0;

    while ( stack.length ) {
        var value = stack.pop();

        if ( typeof value === 'boolean' ) {
            bytes += 4;
        }
        else if ( typeof value === 'string' ) {
            bytes += value.length * 2;
        }
        else if ( typeof value === 'number' ) {
            bytes += 8;
        }
        else if
        (
            typeof value === 'object'
            && objectList.indexOf( value ) === -1
        )
        {
            objectList.push( value );
            for( i in value ) {
                stack.push( value[ i ] );
            }
        }
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
   fram=endTime-sessionStorage.runTime;
   elapse=endTime-sessionStorage.startTime;
   console.log('TimeFrame:'+_from+' '+fram);
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
   the_str   = the_str.replace(/[^A-Za-z0-9]*/ig,'');
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
var progress=0;
function isOnline(){
   var myAppCache = window.applicationCache;
   msg=navigator.onLine?"Status: <strong class='text-success'>Online</strong>":"Status: Working <strong class='txt-error'>Offline</strong>";
   msg+=window.localStorage?", Local <strong class='text-success'>Storage</strong>":", No Local <strong class='text-error'>Storage</strong>";
   msg+=window.sessionStorage?", Session <strong class='text-success'>Storage</strong>":", No Session <strong class='text-error'>Storage</strong>";
   switch (myAppCache.status) {
     case myAppCache.UNCACHED:msg+=', UNCACHED'; break;//status 0 no cache exist
     case myAppCache.IDLE:msg+=', IDLE'; break;//status 1 most common, all uptodate
     case myAppCache.CHECKING:msg+=', CHECKING';break;//status 2 browser reading manifest
     case myAppCache.DOWNLOADING:msg+=', DOWNLOADING';break;//status 3 new or updated resource dwlding
     case myAppCache.UPDATEREADY:msg+=', UPDATEREADY';break;//status 4 file has been updated
     case myAppCache.OBSOLETE:msg+=', OBSOLETE';break;//status 5 missing manifest, re dwld
     default: msg+=', UKNOWN CACHE STATUS';break;
   };
   $('#statusbar').html(msg);
   var appCache = window.applicationCache;
//   console.log(appCache);
   appCache.addEventListener('checking', function(e) {
      $('#side-notice').html("Checking for application update<BR>");
   }, false);
   appCache.addEventListener('cached', function(e) {
      $('#side-notice').html("Application cached<BR>");
   }, false);
   appCache.addEventListener('noupdate', function(e) {
      $('#side-notice').html("No application update found<BR>");
   }, false);
   appCache.addEventListener('obsolete', function(e) {
      $('#side-notice').html("Application obsolete<BR>");
   }, false);
   appCache.addEventListener('error', function(e) {
      $('#side-notice').html("Application cache error<BR>");
   }, false);
   appCache.addEventListener('downloading', function(e) {
      $('#side-notice').html("Downloading application update<BR>");
   }, false);
   appCache.addEventListener('progress', function(e) {
      $('#progress').attr('value',progress+10);
      $('#side-notice').html("Application Cache progress<BR>");
   }, false);
   appCache.addEventListener('updateready', function(e) {
      forceRefresh(false);
      $('#side-notice').html("Application update ready<BR>");
   }, false);
   $('#progress').hide();
}
/******************************************************************************/
/**
 * forces the manifest file to reload and refresh
 * @author fredtma
 * @version 0.2
 * @category manifest
 */
function forceRefresh(_refresh){
   if(window.applicationCache.status==window.applicationCache.UPDATEREADY && _refresh===true){
      window.applicationCache.swapCache();
      window.location.reload();
   }
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
isOnline();
setInterval(isOnline,5000);
