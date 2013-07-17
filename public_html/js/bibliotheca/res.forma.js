/*
 * creates form inputs and elements.
 * @uses jquery|lib.muneris
 */
/******************************************************************************/
/**
 * the Object to set the form fields
 * @author fredtma
 * @version 2.5
 * @param {string} <var>_name</var> the main name that will be used to distinguish the form
 * @param {string} <var>frmClass</var> global class name
 * @param {string} <var>frmLabel</var> global form label on or off
 * @param {string} <var>frmName</var> the name of the form
 * @param {object} <var>Obj</var> the global object to be customly added
 * @category object, form
 * @return object
 * @see placeObj|
 */
function SET_FORM(_name,_class,_label){
   this.name;
   this.frmClass;
   this.frmLabel;
   this.frmName;
   this.Obj=[];
   /*
    * used to pass variable that will commonly be used everywhere
    * @param {object} _obj the object
    * @returns {object} the object returned
    */
   this._Set=function(_opt){
      if(typeof(_opt)==="string"){this.Obj.addTo=_opt;}
      else {this.Obj = _opt;}
      return this;
   }
   /* This function creates the object based upon the var Attrs
    * @param {object} _obj the object that will be iterated to extract the string value
    * @returns {object} return the object that is to be created
    * @see navTab|btnGroup|btnDropDown
    */
   this.setObject = function(_obj) {
      if (typeof(_obj.items)==='array'||typeof(_obj.items)==='object')
      {
         $.each(_obj.items, function(key1, item){
            if(!item.index){$.each(item,function(table,field){_obj.father(table,field);})}
            else{_obj.mother(key1,item);};
         });/*endeach*/
      }
   }
   /*
    * this function is used to place the object in the set element
    * @param <var>_obj</var> the element to be placed
    * @returns {object}
    */
   this.placeObj=function(_obj){
      if(this.Obj.addTo) $(this.Obj.addTo).append(_obj);
      else if(this.Obj.next) $(this.Obj.next).after(_obj);
   }
   /*
    * The main script will get and set all the fields
    * @param {obejcts} <var>_fields</var> setting of the form has the form name, class, fields, title
    * @returns {undefined}
    */
   this.setFields=function(_fields){
      this.name=_fields.index.name;
      this.title=_fields.index.title?_fields.index.title:aNumero(_fields.index.name,true);
      this.frmClass=_fields.index.class;
      this.frmLabel=_fields.index.label?_fields.index.label:true;
      this.frmName='frm_'+this.name;
      this.setObject({"items":_fields,"father":function(_key,_field){
            theField=_field.field;
            theName=_field.name?_field.name:_key;
            theLabel=_field.title?_field.title:aNumero(theName, true);
            label=(_field.addLabel)?_field.addLabel:this.frmLabel;
            if(label)label=creo({"clss":control-label,"forr":_key},'label');
            placeHolder=((_field.place)===true?theLabel:(_field.place)?_field.place:false);
            if(placeHolder!==false) theField.placeholder=placeHolder;

            if(_field.icon){
               i=creo(_field.icon,'i');
               span=creo({"clss":"add-on"},'span');span.appendChild(i);
               div=creo({"clss":"input-prepend"},'div');div.appendChild(input);
            }
         }
      });
   }
   if(this instanceof SET_DISPLAY)return this;
   else return new SET_DISPLAY();
}
/******************************************************************************/
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

