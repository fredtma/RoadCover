/*
 * numeris is a functional set of script
 */
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
create_element = function (arr, ele, txt)
{
   var key;
   var skip = false;
   var the_element   = document.createElement(ele);
   if (txt)
   {
      txt = document.createTextNode(txt);
      the_element.appendChild(txt);
   }

   for (key in arr)
   {
      if (key=='clss') {attr='class'; the_element.className = arr[key]; skip=true;}
      else if (key=='forr')attr='for';
      else if (key=='id') {the_element.id=arr[key]; skip=true;}
      else if (key=='type') {the_element.type=arr[key]; skip=true;}
      else if (key=='name') {the_element.name=arr[key]; skip=true;}
      else if (key=='onclick') {the_element.onclick=arr[key]; skip=true;}
//      else if (key=='style') {the_element.style=arr[key]; skip=true;}
      else attr=key;
      if (!skip) the_element.setAttribute(attr, arr[key]);
   }//end for each
   return the_element;
}//end function
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
function load_async(url, sync){
   var script  = document.createElement('script'),
   head        = document.getElementsByTagName('head')[0];
   if (sync !== false) script.async = true;
   script.src  = url;
   head.appendChild(script);
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

