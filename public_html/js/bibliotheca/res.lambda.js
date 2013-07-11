/*
 * lamdba is a set of dynamically created elements
 * @uses jquery|lib.muneris
 */

/******************************************************************************/
/**
 * object to create a tab menu
 * @author fredtma
 * @version 0.8
 * @category dynamic, menu
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @return object
 * @todo: add a level three menu step
 */
function SET_DISPLAY()
{

   this.navTab = function(_menu) {
      if (typeof _menu === 'array'||typeof _menu === 'object')
      {
         $.each(_menu, function(key, val){
            console.log('key='+key+' val='+val+' len='+val.length+' size='+$(val).size()+' typof='+typeof(val));
            if (typeof(val)==='string')console.log('row1'+val);
            else $.each(val, function(key2, val2){ console.log('key='+key2+' val='+val2);});
         });/*endeach*/
      }
   }/*end function*/
}/*end OBJECT*/
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