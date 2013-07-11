/*
 * creates form inputs and elements.
 * dependent on lib.muneris.ls
 */
//============================================================================//
/**
 * either create a select input fields or append to an existing one.
 * @author fredtma
 * @version 0.3
 * @category input, forms
 * @param string </var>ele</var> the element id to be created or append to
 * @param bool </var>create</var> option to create the element dynamically or not
 * @param array </var>the_list</var> the array containing the option list
 * @param string </var>clss</var> the name of the class to be included in the element
 * @param bool </var>empty</var> wherther the select field will have an empty value at the begining
 * @see cf_fields
 * @return object <var>new_ele</var> the element created
 */
function create_select (ele, create, the_list, clss, empty)
{
   ele = ele.indexOf('#')!=-1?ele.substr(1):ele;
   var select_field  = document.getElementById(ele);

   if (empty) the_list[0] = 'Select...';
   if (create)
   {
      edit_element    = { id:ele, name:ele, clss:clss, onclick:''};
      select_field   = create_element(edit_element,'select');
   }/*end if*/
   optGrp = select_field.getElementsByTagName('optgroup');
   if (optGrp.length > 0 ) for (var i=optGrp.length-1;i>=0;i--) select_field.removeChild(optGrp[i]);
   if (select_field.length > 0)for (x=select_field.length-1; x>=0; x--) select_field.remove(x);

   for (i in the_list)
   {
      if (i=='in_array') continue;/*view the addition of in_array @js.js:158*/
      var option     = document.createElement('option');
      option.value   = i;
      option.text    = the_list[i];
      select_field.add(option,select_field.options[null]);
      /*try {select_field.add(option,select_field.options[null]);} catch(e) { select_field.add(option,null);}*/
   }/*end for*/
   return select_field;
}/*end function*/
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

