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
 * @todo add hidden
 */
function SET_FORM(_name,_class,_label){
   var DB = new SET_DB();//to enable db access
   this.name;
   this.frmClass;
   this.frmLabel;
   this.frmName;
   this.Obj=[];
   this.defaultFields={
      "text":{"type":"text"},
      "email":{"type":"email"},
      "password":{"type":"password","required":""},
      "url":{"type":"url","placeholder":"http://www.example.com"},
      "date":{"type":"date"},
      "datetime":{"type":"datetime-local"},
      "time":{"type":"time"},
      "range":{"type":"range","min":"0","max":"100","step":"1"},
      "color":{"type":"color"},
      "tel":{"type":"tel","pattern":"(\(?\d{3}\)?[\-\s]\d{3}[\-\s]\d{4})"},
      "file":{"type":"file","multiple":""},
      "list":{"type":"text","list":"theList"},
   };
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
            if(key1=='fields'){$.each(item,function(table,field){_obj.father(table,field);})}
            else if(_obj.mother){_obj.mother(key1,item);};
         });/*endeach*/
      }
   }
   /*
    * this function is used to place the object in the set element
    * @param <var>_obj</var> the element to be placed
    * @returns {object}
    */
   this.placeObj=function(_obj){
      if(this.Obj.addTo) document.querySelector(this.Obj.addTo).appendChild(_obj);
      else if(this.Obj.next) document.querySelector(this.Obj.next).parentNode.insertBefore(_obj, document.querySelector(this.Obj.next).nextSibling);
   }

   /*
    * The first form type display generation
    * @param {obejcts} <var>_fields</var> setting of the form has the form name, class, fields, title
    * @returns {undefined}
    */
   this.setAlpha=function(_fields){
      this.name=_fields.form.field.name;
      $('#sideBot h3').html('<a href="#">Add new '+this.name+'<i class="icon icon-color icon-plus addThis"></i></a>');
      this.frmLabel=mainLabel=_fields.form.label?_fields.form.label:true;
      this.frmName='frm_'+this.name;
      theDefaults=this.defaultFields;
      //FORM
      form=_fields.form.field;
      form.id=this.frmName;
      form=creo(form,'form');
      if(_fields.form.legend){legend=creo({},'legend');legend.appendChild(document.createTextNode(_fields.form.legend.txt))}
      else legend=undefined;
      if(_fields.form.fieldset){fieldset=creo(_fields.form.fieldset,'fieldset');if(legend)fieldset.appendChild(legend);form.appendChild(fieldset);container=fieldset;}
      else container=form;
      this.setObject({"items":_fields,"father":this.singleForm});//end setObject
      form.appendChild(this.setButton(_fields.form.button));
      this.placeObj(form);
      return form;
   }
   /*
    * The second form list display generation
    * @param {obejcts} <var>_fields</var> setting of the form has the form name, class, fields, title
    * @param {obejcts} <var>_results</var> the results from the db
    * @param {integer} <var>_actum</var> the stage of the transaction
    * @returns {undefined}
    */
   this.setBeta=function(_results,_actum,_iota){
      eternal=eternal||this.eternalCall();
      linkTable=this.linkTable;
      this.name=eternal.form.field.name;
      len=_results.rows.length;
      len=len||1;//this will display the record even when there is no record
      if(!_actum){
         $('#sideBot h3').html('<a href="#">Add new '+this.name+'<i class="icon icon-color icon-plus addThis"></i></a>');
         //@todo: check that the button does not duplicate
         $('.secondRow').append(creo({},'h2'));
         $('#tab-home section h2').text(eternal.form.legend.txt);
         addbtn=roadCover._Set({"next":".tab-pane.active .libHelp"}).btnCreation("button",{"name":"btnNew"+this.name,"clss":"btn btn-primary","title":"Create a new "+this.name}," New "+this.name,"icon-plus icon-white");
         container=$anima(this.Obj.addTo,'div',{'clss':'accordion','id':'acc_'+this.name});
         addbtn.onclick=addRecord;
         for(rec=0;rec<len;rec++){//loop record
            if(_results.rows.length){row=_results.rows.item(rec);headeName=fieldDisplay('none',row,true);}else{row={'id':-1};headeName=['Type '+this.name+' name here']}
            collapse_head=$anima('#acc_'+this.name,'div',{'id':'accGroup'+row['id'],'clss':'accordion-group'});
            collapse_head.vita('div',{'clss':'accordion-heading','data-iota':row['id']},true)
                    .vita('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+this.name,'href':'#collapse_'+this.name+rec},true,headeName[0])//@todo: add save on element
                    .genesis('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+this.name,'href':'#collapse_'+this.name+rec},true,headeName[1])
                    .genesis('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+this.name,'href':'#collapse_'+this.name+rec},true,headeName[2])
                    .genesis('a',{'clss':'accordion-toggle','data-toggle':'collapse','data-parent':'#acc_'+this.name,'href':'#collapse_'+this.name+rec,},true)
                    .vita('i',{'clss':'icon icon-color icon-edit'});
                     //FIRE on shown//@todo verify why multiple triger are fired on new elements
                     $('#acc_'+this.name).on('shown',function(){ii=$('.accordion-body.in').data('iota');DB.beta(3,ii);});
            collapse_head.genesis('a',{'href':'#','clss':'forIcon'},true)
                    .vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=function(){ii=$(this).parents('div').data('iota');DB.beta(0,ii);$(this).parents('.accordion-group').hide();};
            for(link in eternal.links){
               collapse_head.genesis('a',{'href':'#','clss':'forIcon'},true).vita('i',{'clss':'icon icon-color icon-link'});
               $(collapse_head.child).click(function(){
                  if(!$(this).data('toggle')||$(this).data('toggle')==0){$(this).data('toggle',1);
                     $(this).addClass('icon-unlink').removeClass('icon-link');
                     linkTable(true, link, eternal.links[link][0], eternal.links[link][1]);
                  }else{$(this).data('toggle',0);
                     $(this).addClass('icon-link').removeClass('icon-unlink');
                     linkTable(false);
                  }
               });
            }
            collapse_content=$anima('#accGroup'+row['id'],'div',{'clss':'accordion-body collapse','id':'collapse_'+this.name+rec,'data-iota':row['id']});
            collapse_content.vita('div',{'clss':'accordion-inner'},false);
         }//end for
         this.callForm(_results,_iota);
      }else if (_actum==3){
         row=(_iota==-1||!_iota)?{}:_results.rows.item(0);
         frm=document.getElementById(this.frmName);
         resetForm(frm);
         document.querySelector('.accordion-body.in .accordion-inner').appendChild(frm);
         for (first in eternal.fields)break;
         $('#'+first,frm).focus();
         frm.style.display='block';
         $(form+' #cancel_'+this.name)[0].value='Cancel';//@todo
         $(form+' #cancel_'+this.name).click(function(){$(this).parents('.accordion-body.in').collapse('hide');});
         console.log('++'+_iota);
         if((_iota==-1||!_iota)){
            $(form).data('iota',0);
            $(form+' #submit_'+this.name)[0].onclick=function(e){e.preventDefault();$('#submit_'+eternal.form.field.name).button('loading');DB.beta(1);setTimeout(function(){$(form+' #submit_'+this.name).button('reset');}, 1000)}//make the form to become inserted
         }else{
            $(form).data('iota',row['id']);
            fieldDisplay('form',row);
            $(form+' #submit_'+this.name)[0].onclick=function(e){e.preventDefault();$('#submit_'+eternal.form.field.name).button('loading');DB.beta(2,row['id']);setTimeout(function(){$(form+' #submit_'+this.name).button('reset');}, 1000)}//make the form to become update
         }
      }
      this.setObject({"items":eternal,"father":function(_key,_field){}});
   }
   /*
    * used to display a single form display
    * @param {string} <var>_key</var> the key of the objects
    * @param {object} <var>_field</var> the properties of the object
    * @returns {undefined}
    */
   this.singleForm=function(_key,_field){
      theField=_field.field;
      theField.id=_key;
      theName=theField.name?theField.name:_key;
      //FIELDSET
      if(_field.legend){legend=creo({},'legend');legend.appendChild(document.createTextNode(_field.legend.txt))}
      if(_field.fieldset){fieldset=creo(_field.fieldset,'fieldset');if(legend)fieldset.appendChild(legend);form.appendChild(fieldset);container=fieldset;}
      div=creo({"clss":"control-group "+_key},'div');
      //LABEL
      theLabel=_field.title?_field.title:aNumero(theName, true);
      theLabel=aNumero(theLabel,true);
      label=null;
      label=(isset(_field.addLabel))?_field.addLabel:mainLabel;
      if(label) {label=creo({"clss":"control-label","forr":_key},'label'); label.appendChild(document.createTextNode(theLabel)); div.appendChild(label);}
      div1=creo({"clss":"controls"},'div');
      //PLACEHODER
      placeHolder=((_field.place)===true?theLabel:(_field.place)?_field.place:false);
      if(placeHolder!==false) theField.placeholder=placeHolder;
      //INNER DIV
      if(!theField.type)theField.type='text';
      tmpType=theField.type;
      theField=$.extend({},theDefaults[tmpType],theField);
      //set the input type textarea|input|select|etc...
      input=(_field.items||_field.complex)?formInput(_key,theField,_field.items,div1,_field.complex):creo(theField,'input');
      //input with items[] sets will not get icons
      if(_field.icon){
         i=creo({"clss":_field.icon},'i');
         span=creo({"clss":"add-on"},'span');
         div2=creo({"clss":"input-prepend"},'div');
         span.appendChild(i);div2.appendChild(span);div2.appendChild(input);div1.appendChild(div2);
      }else if(input.tagName!='label'){
         div1.appendChild(input);
      }//endif
      div.appendChild(div1);container.appendChild(div);
   }//end function
   /*
    *
    * @param {object} <var>_btn</var> the set of buttons to be added
    * @param {string} <var>_layout</var> the button layout option
    * @returns {object} return the form with appended buttons
    * @todo add a new layout
    */
   this.setButton=function(_btn,_layout){
      switch(_layout){
         default:
            div=creo({"clss":"form-actions well well-small"},'div');
            $.each(_btn,function(id,btn){btn.id=id;button=creo(btn,'input');div.appendChild(button);div.appendChild(document.createTextNode('   '));});
            return div;
            break;
      }//end switch
   }
   /*
    * calls the form in an invisible innitial state
    * @param {object} _results the db result
    * @param {integer} _iota the identification of the record
    * @returns {undefined}
    */
   this.callForm=function(_results,_iota){
      console.log(_iota);
      row=(_iota==-1||!_iota)?{}:_results.rows.item(0);
      this.frmLabel=mainLabel=eternal.form.label?eternal.form.label:true;
      this.frmName='frm_'+this.name;
      theDefaults=this.defaultFields;
      //FORM
      form=eternal.form.field;
      form.id=this.frmName;
      form=$anima(this.Obj.addTo,'form',form);
      if(eternal.form.fieldset)form.vita('fieldset',eternal.form.fieldset,true);
      if(eternal.form.legend)form.vita('legend',{},false,eternal.form.legend.txt);
      formContent=form.father;
      this.setObject({"items":eternal,"father":function(_key,_property){
            theField=_property.field;
            theField.id=_key;
            theName=theField.name?theField.name:_key;
            //FIELDSET
            if(_property.fieldset){
               formFields=$anima(formContent,'fieldset',eternal.form.fieldset,'','next');
               if(_property.legend){formFields.vita('legend',{},false,eternal.form.legend.txt);}
               formFields.vita('div',{"clss":"control-group "+_key});
            }else{
               formFields=$anima(formContent,'div',{"clss":"control-group "+_key});
            }
            //LABEL
            theLabel=_property.title?_property.title:theName;
            theLabel=aNumero(theLabel,true);
            label=null;
            label=(isset(_property.addLabel))?_property.addLabel:mainLabel;
            if(label) {formFields.vita('label',{"clss":"control-label "+_key,"forr":_key},true,theLabel);}
            formControl=formFields.genesis('div',{"clss":"controls"},true).father;
            //PLACEHODER
            placeHolder=((_property.place)===true?theLabel:(_property.place)?_property.place:false);
            if(placeHolder!==false) theField.placeholder=placeHolder;
            //INNER DIV
            if(!theField.type)theField.type='text';
            tmpType=theField.type;
            theField=$.extend({},theDefaults[tmpType],theField);
            //set the input type textarea|input|select|etc...
            input=(_property.items||_property.complex)?formInput(_key,theField,_property.items,formControl,_property.complex):creo(theField,'input');
            //input with items[] sets will not get icons
            if(_property.icon){
               formFields.vita('div',{"clss":"input-prepend"},true).vita('span',{"clss":"add-on"},true).vita('i',{"clss":_property.icon});
            }
            formControl.appendChild(input);
         }
      });//end setObject
      formContent.appendChild(this.setButton(eternal.form.button));
      document.getElementById(this.frmName).style.display='none';
   }
   /*
    * function to link the selected table in a gerund
    * @param {bool} <var>_state</var> the state to show or not show the links
    * @returns {undefined}
    */
   this.linkTable=function(_state,_mensa,_unus,_duo){
      eternal=eternal||this.eternalCall();
      quaerere="SELECT "+_unus+" FROM "+_duo+" ORDER BY "+_unus;
      DB.creoAgito(quaerere,[],"Selected "+_duo,function(results){
         len=results.rows.length;
         for(x=0;x<len;x++){
            row=results.rows.item(x);
            console.log(row[_unus]);
         }
      });
   }
   this.eternalCall=function(){
      if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);else eternal=null;
      return eternal;
   }
   if(this instanceof SET_FORM)return this;
   else return new SET_FORM();
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
      select_field   = creo(edit_element,'select');
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
 * creates a form input field
 * @author fredtma
 * @version 2.5
 * @category form, dynamic, input
 * @param string <var>_key</var> the name of the field id
 * @param object <var>_field</var> the data containing the field
 * @param array <var>_items</var> the list of items value
 * @param object <var>_holder</var> the DOM element to insert into
 * @param mixed <var>_complex</var> option for complex objects
 * @return object
 */
function formInput(_key,_field,_items,_holder,_complex){
   theType=_field.type;
   l=(isset(_items))?_items.length:0;
   cnt=0;
   switch(theType){
      case 'bool':
         for(x=0;x<2;x++){
            input=creo({"id":_key+'-'+cnt,"name":_key+"[]","value":x,"type":"radio"},'input');
            label=creo({"forr":_key+'-'+cnt,"clss":"checkbox inline"},'label');
            label.appendChild(input);
            label.appendChild(document.createTextNode(x?' Yes':' No'));
            ele=label;
            _holder.appendChild(label);
            cnt++;
         }break;
      case 'check':
      case 'radio':
         $.each(_items,function(id,value){
            input=creo({"id":_key+'-'+cnt,"name":_key+"[]","value":id,"type":theType},'input');
            label=creo({"forr":_key+'-'+cnt,"clss":"checkbox inline"},'label');
            label.appendChild(input);
            label.appendChild(document.createTextNode(' '+value));
            _holder.appendChild(label);
            ele=label;
            cnt++;
         });break;
      case 'text': ele=creo(_field,'textarea');break;//@todo make the default a complex one
      case 'select': ele=create_select (_key, true, _items, _field.clss);break;
      default: ele=creo(_field,'input'); break;
   }
   return ele;
}
/******************************************************************************/
/*
 * used to place content in the input fields and display heading
 * @param {obeject} <var>_source</var> the source of the object
 * @param {string} <var>_form</var> the name of the form
 * @param {bool} <var>_head</var> only the head to be displayed
 * @returns {array} the list of header
 * @todo add radio and check return
 */
fieldDisplay=function(_from,_source,_head){
   f=eternal.fields;
   c=0;
   _return=[];
   $.each(f,function(key,property){
      type=property.field.type;
      if(_head && !property.header) return true;
      switch(type){
         case 'radio':
         case 'check':
            if(_from==='form')$(form+' [name^='+key+']').each(function(){if($(this).prop('value')==_source[key])$(this).prop('checked',true);});
            if(_from==='list')$(form+' [name^='+key+']').each(function(){if($(this).prop('checked'))_return[c]=$(this).prop('value');});
            break;
         default:
            if(_from==='form')$(form+' #'+key).val(_source[key]);
            else if(_from==='list')_return[c]=$(form+' #'+key).val();
            else _return[c]=_source[key];
            break;
      }//endswitch
      c++;
   });
   return _return;
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

