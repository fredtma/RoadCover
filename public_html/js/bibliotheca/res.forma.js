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
      "password":{"type":"password","required":"","pattern":localStorage.PASSPATERN,"Title":"Password requires (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)"},
      "url":{"type":"url","placeholder":"http://www.example.com"},
      "date":{"type":"date"},
      "datetime":{"type":"datetime-local"},
      "time":{"type":"time"},
      "range":{"type":"range","min":"0","max":"100","step":"1"},
      "color":{"type":"color"},
      "tel":{"type":"tel","pattern":"(\(?\d{3}\)?[\-\s]\d{3}[\-\s]\d{4})"},
      "file":{"type":"file","multiple":""},
      "list":{"type":"list","list":"theList"},
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
         global=_obj.items.global||0;
         $.each(_obj.items, function(key1, item){
            if(key1=='fields'){$.each(item,function(table,field){_obj.father(table,field,global);})}
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
      eternal=eternal||eternalCall();
      linkTable=this.linkTable;
      this.name=Name=eternal.form.field.name;
      this.frmName=frmName='frm_'+this.name;
      isReadOnly=(typeof eternal.form.options !=="undefined")?eternal.form.options.readonly:false;
      if(typeof _results.rows.source!=="undefined")sessionStorage.activeRecord=JSON.stringify(_results);
      len=_results.rows.length;
      len=len||1;//this will display the record even when there is no record
      if(!_actum){
         roadCover._Set({"next":".tab-pane.active .libHelp"});
         //@todo fix the header title
         if(!document.getElementById('newItem') && !isReadOnly){
            $('.secondRow').append(creo({},'h2'));
            addbtn=roadCover._Set({"next":".tab-pane.active .libHelp"}).btnCreation("button",{"id":"newItem","name":"btnNew"+this.name,"clss":"btn btn-primary","title":"Create a new "+this.name}," New "+this.name,"icon-plus icon-white");
         }else if (!isReadOnly){
            $('#newItem').attr("name","btnNew"+this.name).attr("title","Create a new "+this.name).html(" <i class='icon-plus icon-white'></i> New "+this.name);
         }
         custHead=['members','customers'];
         if (custHead.indexOf(eternal.mensa)==-1){console.log($('footer').data('header'),custHead.indexOf(eternal.mensa));$('footer').data('header',false);}
         console.log($('footer').data('header'),custHead.indexOf(eternal.mensa));
         if(!$('footer').data('header')){$('#sideBot h3').html(eternal.form.legend.txt);$('#tab-home section h2').text(eternal.form.legend.txt);$('.headRow').html(eternal.form.legend.txt);$('#displayMensa').empty();}//lieu pour maitre le titre
         $(this.Obj.addTo).empty();//main content and side listing
         container=$anima(this.Obj.addTo,'div',{'clss':'accordion','id':'acc_'+this.name});
         if(!isReadOnly)addbtn.onclick=addRecord;
         for(rec=0;rec<len;rec++){//loop record
            if(typeof _results.rows.source!=="undefined"){row=_results[rec];headeName=fieldsDisplay('none',row,true);}
            else if(_results.rows.length){row=_results.rows.item(rec);headeName=fieldsDisplay('none',row,true);}
            else{row={'id':-1};headeName=['Type '+this.name+' name here']}
            ref=row['name']||row['username']||false;
            row['id']=row['id']||rec;
            collapseName='#acc_'+this.name;
            collapse=isReadOnly?'noCollapse':'collapse';
            collapseTo=isReadOnly?'javascript:void(0)':'#collapse_'+this.name+rec;
            collapse_head=$anima(collapseName,'div',{'id':'accGroup'+row['id'],'clss':'accordion-group'});
            collapse_head.vita('div',{'clss':'accordion-heading','data-iota':row['id']},true)
               .vita('a',{'clss':'betaRow','contenteditable':false,'data-toggle':collapse,'data-parent':collapseName,'href':collapseTo},true);//@todo: add save on element
               l=headeName.length;for(x=0;x<l;x++)collapse_head.vita('span',{},false).child.innerHTML=headeName[x]+' ';
            if(!isReadOnly){
             collapse_head.genesis('a',{'clss':'accordion-toggle','data-toggle':'collapse','data-parent':collapseName,'href':collapseTo},true)
               //edit
             .vita('i',{'clss':'icon icon-color icon-edit','title':'Edit '+headeName[0]});
              //FIRE on shown
              $(collapseName).on('shown',function(){if(!$(this).data('toggle_shown')||$(this).data('toggle_shown')==0){$(this).data('toggle_shown',1); ii=$('.accordion-body.in').data('iota');DB.beta(3,ii);} });
              $(collapseName).on('hidden',function(){$(this).data('toggle_shown',0); });
              //delete
              collapse_head.genesis('a',{'href':'#','clss':'forIcon'},true)
              .vita('i',{'clss':'icon icon-color icon-trash','title':'Delete '+headeName[0]}).child.onclick=function(){ii=$(this).parents('div').data('iota');DB.beta(0,ii);$(this).parents('.accordion-group').hide();};
            }else if(isReadOnly==="display"){
               $(collapse_head.father).parents('div').data('code',row['code']);//@explain:set code of the table
               //@event on SHOWN
               $(collapseName).on('hidden',function(){$(this).data('toggle_shown',0); });
            }else{
               $(collapse_head.father).parents('div').data('code',row['code']);//@check: i have change the div to 'div'
               //click on the a link
               collapse_head.father.onclick=function(){sideDisplay($(this).parents('div').data('code'), eternal.mensa);temp[0]=$(this).parents('div').data('code');temp[1]=eternal.mensa;$('footer').data('temp',temp);}//@see lib.voca.js
            }//endif read only
            //APPLY CHANGES TO ADD FUNCTION
            if(typeof eternal.links!="undefined") this.setLinks(eternal.links,collapse_head);
            if(typeof eternal.children!="undefined") this.setChildren(eternal.children,collapse_head,collapse,collapseTo,collapseName);
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
         $(form+' #cancel_'+this.name)[0].value='Cancel';
         $(form+' #cancel_'+this.name).click(function(){$(this).parents('.accordion-body.in').collapse('hide');});
         if((_iota==-1||!_iota)){
            $(form).data('iota',0);
            $(form)[0].onsubmit=function(e){e.preventDefault();$('#submit_'+eternal.form.field.name).button('loading');DB.beta(1);setTimeout(function(){$(form+' #submit_'+this.name).button('reset');}, 1000); return false;}//make the form to become inserted
         }else{
            $(form).data('iota',row['id']);
            fieldsDisplay('form',row);
            $(form)[0].onsubmit=function(e){e.preventDefault();$('#submit_'+eternal.form.field.name).button('loading');DB.beta(2,row['id']);setTimeout(function(){$(form+' #submit_'+this.name).button('reset');}, 1000); return false;}//make the form to become update
         }
         if(eternal.form.file)load_async('js/agito/'+eternal.form.file+'.js',false,'end',true);
      }
//      this.setObject({"items":eternal,"father":function(_key,_field){}});
   }
   /*
    * display the beta form in a table format
    * @param {obejcts} <var>_rows</var> the rows to be displayed in the table
    * @param {string} <var>_child</var> if the source is from a child
    * @param {string} <var>_element</var> the element can be set or the default one
    * @returns {undefined}
    */
   this.gammaTable=function(_rows,_child,_element){
//      for(k in _rows) if(_rows.hasOwnProperty(key))len++;
      eternal=eternalCall();
      this.name=eternal.form.field.name;
      if(!_child){
         if($('header').data('header'))$('#sideBot h3').html(eternal.form.legend.txt);
         addEle=this.Obj.addTo;headers=eternal.fields;allHead=false;_rows=JSON.parse(_rows);cls='table-condensed';
      }else{
         addEle=_element;headers=eternal.children[_child].fields;allHead=true;_rows=_rows;cls='table-bordered table-child';
      }
      $(addEle).empty();
      $table=$anima(addEle,'table',{'id':'table_'+this.name,'clss':'table table-striped table-hover '+cls}).vita('thead',{},true);
      $table.vita('tr',{},true).vita('th',{},false,'#');colspan=0;
      for(k in headers){colspan++;
         th=headers[k];if(th.header==true||allHead){title=th.title||k;$table.vita('th',{},false,title)}
      }//endforeach
      $table.novo('#table_'+this.name,'tbody');
      r1=0;
      for(key in _rows){if(key=="rows")continue;
         row=_rows[key];
         r1++;
         if(r1==1)$table.vita('tr',{},true).vita('td',{},false,r1);//for the first row
         else $table.genesis('tr',{},true).vita('td',{},false,r1);//for the rest
         for(k in headers){
            $table.vita('td',{},false,row[k])
         }//endfor
      }//endfor
      $table.novo('#table_'+this.name,'tfoot',{}).vita('tr',{},true).vita('td',{'colspan':colspan+1},false,'Total:'+r1);
   }
   /*
    * used to display a single form display
    * @param {string} <var>_key</var> the key of the objects
    * @param {object} <var>_field</var> the properties of the object
    * @returns {undefined}
    */
   this.singleForm=function(_key,_field,_global){
      global=_global!=0?_global:null;
      theField=_field.field||_field;
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
      if(!theField.type&&global)theField.type=global.type;
      else if(!theField.type)theField.type='text';
      if(global&&global.complex)_field.complex=global.complex;
      tmpType=theField.type;
      theField=$.extend({},theField,theDefaults[tmpType]);
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
            div=creo({"clss":"form-actions well well-small purgare"},'div');
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
      row=(_iota==-1||!_iota)?{}:_results.rows.item(0);//@todo:check that <var>row</var> is not used and remove it also change the function var
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
            theField=_property.field||{};
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
            if(!theField.type&&typeof _property.complex=="undefined")theField.type='text';
            tmpType=theField.type;
            theField=$.extend({},theField,theDefaults[tmpType]);
            //set the input type textarea|input|select|etc...
            input=(_property.items||_property.complex)?formInput(_key,theField,_property.items,formControl,_property.complex):creo(theField,'input');
            //input with items[] sets will not get icons
            if(_property.icon){
               formFields.novo(formControl,'div',{"clss":"input-prepend"}).vita('span',{"clss":"add-on"},true).vita('i',{"clss":_property.icon});
            }
            formControl.appendChild(input);
         }
      });//end setObject
//      formContent.appendChild(this.setButton(eternal.form.button));
      formContent.parentNode.insertBefore(this.setButton(eternal.form.button), formContent.nextSibling);
      document.getElementById(this.frmName).style.display='none';
   }
   /*
    * function to link the selected table in a gerund
    * @param {string} <var>_name</var> list of name associated with the link
    * @param {string} <var>_mensa</var> the gerund
    * @param {array} <var>_agrum</var> the field to quaerere
    * @param {integer} <var>_iota</var> groups iota
    * @returns {undefined}
    */
   this.linkTable=function(_name,_mensa,_agrum,_ratio){
      eternal=eternal||eternalCall();
      unus=_agrum[1];
      duo=_agrum[2]||_agrum[0];
      tribus=_agrum[3]||_agrum[0];
      _agrum=_agrum[0];
      if(!$('#displayMensa').data('listed')||$('#displayMensa').data('listed')!=unus+_ratio){
         $('#displayMensa').data('listed',unus+_ratio);
         $('#displayMensa').empty();
         agris1=unus.slice(0,-1);
         agris2=duo.slice(0,-1);
         $('#sideBot h3').html('Associate '+_name+' to a '+unus);
         quaerere="SELECT a.id,"+_agrum+",a.`"+tribus+"`,b.`"+agris2+"` FROM `"+unus+"` a LEFT OUTER JOIN `"+_mensa+"` b ON b.`"+agris1+"`=a."+tribus+" GROUP BY a.id ORDER BY "+_agrum;
         DB.creoAgito(quaerere,[],"Listing "+unus,function(results){
         len=results.rows.length;
            for(x=0;x<len;x++){
               row=results.rows.item(x);
               displayMensa=$anima('#displayMensa','li',{'data-iota':row['id']}).vita('a',{'href':'#link_'+unus},true,aNumero(row[_agrum],true)+' ').vita('i',{'clss':'icon icon-color icon-unlink'});
               $(displayMensa.child).data('tribus',row[tribus]);
               displayMensa.child.onclick=function(){
                  if(!$(this).data('toggle')||$(this).data('toggle')==0){
                     $(this).data('toggle',1);$(this).addClass('icon-link').removeClass('icon-unlink');
                     d=new Date().format('isoDateTime');
                     DB.creoAgito("INSERT INTO "+_mensa+" (`"+agris1+"`,`"+agris2+"`,`creation`) VALUES (?,?,?)",[$(this).data('tribus'),_ratio,d],"Linked "+_name+" to "+row[_agrum]);
                  }else{
                     $(this).data('toggle',0);$(this).addClass('icon-unlink').removeClass('icon-link');
                     DB.creoAgito("DELETE FROM "+_mensa+" WHERE "+agris1+"=? AND "+agris2+"=?",[$(this).data('tribus'),_ratio],"unLinked "+_name+" to "+row[_agrum]);
                  }//endif
               };//end anonymous
               if(_ratio==row[agris2])$(displayMensa.child).removeClass('icon-unlink').addClass('icon-link');
            }//end for
         });//end callback
      }//endfi
   }
   /*
    * set the links for the beta form
    * @param {object} _children the links list
    * @param {object} _collapse_head the node to the element
    * @returns none
    */
   this.setLinks=function(_children,_collapse_head){
      for(link in _children){
         theLink=eternal.links[link][1];
         _collapse_head.genesis('a',{'href':'#','clss':'forIcon'},true).vita('i',{'clss':'icon icon-color icon-link','title':'Link #'+theLink});
         if(link!='reference'){
            $(_collapse_head.child).data('ref',ref);$(_collapse_head.child).data('head',headeName[0]);$(_collapse_head.child).data('link',link);$(_collapse_head.child).data('links',eternal.links[link]);
            $(_collapse_head.child).click(function(){//@note: watchout for toggle, u'll hv to click twist if u come back to an other toggle.
               $('.accordion-heading .icon-black').removeClass('icon-black').addClass('icon-color');$(this).removeClass('icon-color').addClass('icon-black');
               linkTable($(this).data('head'), $(this).data('link'),$(this).data('links'),$(this).data('ref'));
            });
         }else{//esle reference. LINK
            temp=[];
            $(_collapse_head.child).click(function(){
               temp[0]=$(this).parents('div').data('code');temp[1]=eternal.mensa;$('footer').data('temp',temp);
               $('#nav-main #link_'+theLink).tab('show');$(".navLinks").removeClass('active');$("#nav_"+theLink).addClass('active');//maitre que le menu puisse ce fair voir
               load_async(eternal.links[link][0],true,'end',true);
            });
         }//endif
      }//endfor links
   }
   /*
    * set the icons for the beta form to display the linked tables
    * @param {object} _children contains all the reference table details
    * @param {object} _collapse_head the element to be added next to
    * @param {string} _collapse if it is to be a collapse or not
    * @param {string} _collapseTo collapse to
    * @param {string} _collapseName the name of the collapse to collapse to
    * @returns {undefined}
    */
   this.setChildren=function(_children,_collapse_head,_collapse,_collapseTo,_collapseName){
      for(key in _children){tmp=_children[key];
         _collapse_head.genesis('a',{'clss':'forIcon','data-toggle':_collapse,'data-parent':_collapseName,'href':_collapseTo},true)
         .vita('i',{'clss':'memberIcon '+tmp.icon,'title':'Link '+tmp.title,'data-agilis':key});//@event:customer.js
      }//endfor
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
   theType=_field.type||_complex;
   l=(isset(_items))?_items.length:0;
   cnt=0;
   _key=_key.replace(/\s/ig,'');
   _field.id=_field.id.replace(/\s/ig,'');
   switch(theType){
      case 'bool':
         ele=creo({'clss':'btn-group','data-toggle':'buttons-radio'},'div');
         for(x=0;x<2;x++){b=creo({'type':'button','clss':'btn',"id":_key+cnt,"name":_key+"[]","value":x},'button',x?' Yes':' No');ele.appendChild(b);cnt++;}break;
         for(x=0;x<2;x++){input=creo({"id":_key+cnt,"name":_key+"[]","value":x,"type":"radio"},'input');label=creo({"forr":_key+cnt,"clss":"checkbox inline"},'label');label.appendChild(input);label.appendChild(document.createTextNode(x?' Yes':' No'));ele=label;_holder.appendChild(label);cnt++;}break;
      case 'check':
      case 'radio':
         c=theType=='check'?'checkbox':theType;
         ele=creo({'clss':'btn-group','data-toggle':'buttons-'+c},'div');
         $.each(_items,function(id,value){if(value=='')return true;
            b=creo({'type':'button','clss':'btn',"id":_key+cnt,"name":_key+"[]","value":id},'button',value);
            ele.appendChild(b);cnt++;
         });
         if(false){$.each(_items,function(id,value){input=creo({"id":_key+cnt,"name":_key+"[]","value":id,"type":theType},'input');label=creo({"forr":_key+cnt,"clss":"checkbox inline"},'label');label.appendChild(input);label.appendChild(document.createTextNode(' '+value));_holder.appendChild(label);ele=label;cnt++;});}
         break;
      case 'list':
         _field.type='text';
         listName='list_'+_field.id;_field.list=listName;
         span=creo({},'span');
         ele=$anima(span,'input',_field).genesis('datalist',{'id':listName},true);
         for(x=0;x<l;x++) ele.vita('option',{'value':_items[x]})
         ele=span;
         break;
      case 'text': ele=creo(_field,'textarea');break;//@todo make the default a complex one
      case 'select': ele=create_select (_key, true, _items, _field.clss);break;
      default: ele=creo(_field,theType); break;//@check: changed <var>theType</var> it use to be 'input', check that it does not affect other form item
   }
   return ele;
}
/******************************************************************************/
/*
 * used to place content in the input fields and display heading
 * @param {obeject} <var>_source</var> the source of the object
 * @param {string} <var>_form</var> the name of the form
 * @param {bool} <var>_head</var> only the head to be displayed
 * @param {bool} <var>_reference</var> used to search either the main table or reference child table
 * @returns {array} the list of header
 * @todo add radio and check return
 */
fieldsDisplay=function(_from,_source,_head,_reference){
   f=!_reference?eternal.fields:eternal.children[_reference].fields;
   form='#frm_'+eternal.form.field.name;
   if(_reference)form=form+2;
   c=0;
   _return=[];
   if(typeof _source==="number"){tmp=JSON.parse(sessionStorage.activeRecord);_source=tmp[_source];}
   $.each(f,function(key,property){
      key2=key.replace(/\s/ig,'');//removes spaces
      if(_reference) type=property.type||eternal.children[_reference].global.type;
      else type=property.field.type||property.complex;
      if(_head && !property.header) return true;
      switch(type){
         case 'radio':
         case 'bool':
         case 'check':
            if(_from==='form')$(form+' [name^='+key2+']').each(function(){if($(this).prop('value')==_source[key])$(this).addClass('active').prop('checked',true);});
            if(_from==='list')$(form+' [name^='+key2+']').each(function(){if($(this).prop('checked'))_return[c]=$(this).addClass('active').prop('value');});
            break;
         case 'p':
         case 'span':
            if(_from==='form')$(form+' #'+key2).html(_source[key]);
            else _return[c]=_source[key];
            break;
         default:
            if(_from==='form')$(form+' #'+key2).val(_source[key]);
            else if(_from==='list')_return[c]=$(form+' #'+key2).val();
            else _return[c]=_source[key2];
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

