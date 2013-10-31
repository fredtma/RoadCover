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
   var SET = this;
   this.patterns=JSON.parse(localStorage.EXEMPLAR);
   eternal=eternalCall();
   this.name=eternal.form.field.name;
   this.form;this.form2;
   this.frmName='frm_'+this.name;
   this.frmID='#frm_'+this.name;
   this.frmLabel=typeof eternal.form.label==="boolean"?eternal.form.label:true;
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
      var global;
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
   this.setAlpha=function(){
      var mainLabel, legend,fieldset,container;
      this.frmLabel=mainLabel=eternal.form.label?eternal.form.label:true;
      if(!getLicentia(this.name,'View',true)) return false;
      $('#sideBot h3').html('<a href="javascript:void(0)">Add new '+this.name+'<i class="icon icon-color icon-plus addThis"></i></a>');
      //FORM
      this.form=eternal.form.field;
      this.form.id=this.frmName;
      this.form=creo(this.form,'form');
      if(eternal.form.legend){legend=creo({},'legend');legend.appendChild(document.createTextNode(eternal.form.legend.txt))}
      else legend=undefined;
      if(eternal.form.fieldset){fieldset=creo(eternal.form.fieldset,'fieldset');if(legend)fieldset.appendChild(legend);this.form.appendChild(fieldset);container=fieldset;}
      else container=this.form;
      this.setObject({"items":eternal,"father":this.singleForm});//end setObject
      this.form.appendChild(this.setButton(eternal.form.button));
      this.placeObj(this.form);defaultOnShow();
      return this.form;
   }
   /*
    * The second form list display generation
    * @param {obejcts} <var>_fields</var> setting of the form has the form name, class, fields, title
    * @param {obejcts} <var>_results</var> the results from the db
    * @param {integer} <var>_actum</var> the stage of the transaction
    * @returns {undefined}
    */
   this.setBeta=function(_results,_actum,_jesua,_unum){
      var $collapseElement=null;
      var len=_results.rows.length;
      var Name,navSection,len,addbtn,max,len,ref,row,rec,frm,frmName;var collapseName,collapse,collapseTo,collapse_head,collapse_content,headeName,ii,x,l,first;
      len=len||1;//this will display the record even when there is no record
      var linkTable=this.linkTable;
      if(!getLicentia(this.name,'View',true)) return false;
      this.frmLabel=typeof eternal.form.label=="boolean"?eternal.form.label:true;
      var isReadOnly=(typeof eternal.form.options !=="undefined")?eternal.form.options.readonly:false;
      var recordOption=$("footer").data("record")||{};$("footer").removeData("record");//@fix:stop changes to navigation or activerecord
      if(typeof _results.rows.source!=="undefined"&&recordOption.changeActiveRecord!==false)sessionStorage.activeRecord=JSON.stringify(_results);//change la donner seaulment quand ce náit pas une cherche
      else if(recordOption.changeActiveRecord!==false) this.setActiveRecord(_results,len);//maitre ce si quand la source et du system interne
      navSection=eternal.form.navigation!==true?false:eternal.form.navigation;
      if(!_actum){
         if(recordOption.changeNavigator!==false)this.setNavigation(_results,navSection);
         roadCover._Set({"next":".tab-pane.active .libHelp"});
         //@todo fix the header title
         if(!$('.btnNew').length&&isReadOnly===false&&getLicentia(this.name,'Create')){
            addbtn=roadCover._Set({"next":".homeSet2,.setClient"}).btnCreation("button",{"id":"newItem","name":"btnNew"+this.name,"clss":"btn btn-primary btnNew","title":"Create a new "+this.name}," New "+this.name,"icon-plus icon-white");
            $('.btnNew').click(addRecord);//function call
         }else if (isReadOnly===false&&getLicentia(this.name,'Create')){
            $('.btnNew').attr("name","btnNew"+this.name).attr("title","Create a new "+this.name).html(" <i class='icon-plus icon-white'></i> New "+this.name);
         }
         /*@note:$('footer').data('header') is set from the menu links
          * aliquam: from server or localhost
          * */
         if (eternal.form.aliquam!==true&&$('footer').data('header')!==false){$('footer').data('header',false);}
         if($('footer').data('header')===false){$('#sideBot h3').html(eternal.form.legend.txt);$('.headRow').html(eternal.form.legend.txt);$('#displayMensa').empty();$('#displayMensa').removeData();}//lieu pour maitre le titre
         $(this.Obj.addTo).empty();//main content and side listing
         $(".body article").append(creo({"clss":"ya_procer"},'h2',eternal.form.legend.txt));//add the title which can only be seen on print
         var container=$anima(this.Obj.addTo,'div',{'clss':'accordion','id':'acc_'+this.name});
         if(sessionStorage.genesis=="NaN")sessionStorage.genesis=0;
         max=(parseInt(sessionStorage.genesis)+parseInt(localStorage.DB_LIMIT));
         max=max>len?len:max;//@fix:prevent the last index from occuring
         if(typeof _unum=="number"){sessionStorage.genesis=_unum;len=_unum+1;max=_unum+1;}
         len=len||1;//this will display the record even when there is no record
         max=max||1;
         //LOOP
         for(rec=parseInt(sessionStorage.genesis);rec<len,rec<max;rec++){//loop record
//            console.log(_results,"/",_results.rows,"/",rec,"/",sessionStorage.genesis);
            if(typeof _results.rows.source!=="undefined"){row=_results[rec];headeName=fieldsDisplay("none",row,true);}
            else if(_results.rows.length){row=_results.rows.item(rec);headeName=fieldsDisplay("none",row,true);}
            else{row={"id":-1,"jesua":"alpha"};headeName=["Type "+this.name+" name here"]}
            ref=row["name"]||row["username"]||false;
            row["id"]=row["id"]||rec;
            row["jesua"]=row["jesua"]||rec;
            collapseName="#acc_"+this.name;
            collapse=isReadOnly?"noCollapse":"collapse";
            collapseTo=isReadOnly?"javascript:void(0)":"#collapse_"+this.name+rec;
            collapse_head=$anima(collapseName,"div",{"clss":"accordion-group class_"+row["jesua"],"data-jesua":row["jesua"]});
            collapse_head.vita("div",{"clss":"accordion-heading","data-jesua":row["jesua"]},true)
               .vita("a",{"clss":"betaRow","contenteditable":false,"data-toggle":collapse,"data-parent":collapseName,"href":collapseTo},true);//@todo: add save on element
               $collapseElement=collapse_head.father;//heading row father
               l=headeName.length;for(x=0;x<l;x++)collapse_head.vita("span",{},false).child.innerHTML=headeName[x]+" ";
             //icon holder
             collapse_head.novo(".class_"+row["jesua"]+" .accordion-heading","i",{"clss":"betaRight"});
             var father=collapse_head.father;
            if(isReadOnly===false&&getLicentia(this.name,"Edit")){
             collapse_head.vita("a",{"clss":"accordion-toggle","data-toggle":"collapse","data-parent":collapseName,"href":collapseTo},true)
              //EDIT, quand le button et le lien sont frapper
             .vita("i",{"clss":"icon icon-color icon-edit","title":"Edit "+headeName[0]});
              //FIRE on shown
              $(collapseName).on("shown",function(){if( (!$(this).data("toggle_shown")||$(this).data("toggle_shown")==0)&&!$(".popover").length){//@fix:!$(".popover").length prevent popup to fire this event
                 $(this).data("toggle_shown",1); ii=$(".accordion-body.in").data("jesua");DB.beta(3,ii);} });
              $(collapseName).on("hidden",function(){ if(!$(".popover").length)$(this).data("toggle_shown",0);});
              //DELETE
              if(getLicentia(this.name,"Delete")){
               collapse_head.genesis("a",{"href":"javascript:void(0)","clss":"forIcon"},true)
               .vita("i",{"clss":"icon icon-color icon-trash","title":"Delete "+headeName[0]}).child.onclick=function(){delRecord(this);}
              }//endif
            }else if(isReadOnly==="display"){
               $(collapse_head.father).parents("div").data("code",row["code"]);//@explain:set code of the table
               //@event on SHOWN @see script form
               $(collapseName).on("hidden",function(){$(this).data("toggle_shown",0); });
            }else{//WHEN on read only do not collapse
               var temp=[];
               $(collapse_head.father).parents("div").data("code",row["code"]);//@check: i have change the div to "div"
               //click on the a link
               $collapseElement.onclick=function(){
                  temp[0]=$(this).parents("div").data("code");temp[1]=eternal.mensa;$("footer").data("temp",temp);
                  sideDisplay($(this).parents("div").data("code"), eternal.mensa);
               }//@see lib.voca.js
            }//endif read only
            collapse_head.father=father;//places the element to the level of the fother <i>
            //APPLY CHANGES TO ADD FUNCTION
            if(typeof eternal.links!="undefined") this.setLinks(eternal.links,collapse_head,headeName[0],ref);
            if(typeof eternal.children!="undefined") this.setChildren(eternal.children,collapse_head,collapse,collapseTo,collapseName);
            collapse_content=$anima(".class_"+row["jesua"],"div",{"clss":"accordion-body collapse","id":"collapse_"+this.name+rec,"data-jesua":row["jesua"]});
            collapse_content.vita("div",{"clss":"accordion-inner"},false);
         }//end for
         this.callForm(_results,_jesua);
         if(typeof _unum=="number"){sessionStorage.genesis=0}
      }else if (_actum==3){
         row=(_jesua=="alpha"||!_jesua)?{}:_results.rows.item(0);
         frm=document.getElementById(this.frmName);resetForm(frm);
         //check and add editor. you need to chk it exist & remove it b4 you append the form
         var callEditor=$('footer').data('lateCall');
         if(callEditor){l=callEditor.length;for(x=0;x<l;x++){console.log(callEditor,"callEditor",CKEDITOR.instances);if(CKEDITOR.instances[callEditor[x]]){CKEDITOR.instances[callEditor[x]].destroy(true);}}}//endif
         document.querySelector(".accordion-body.in .accordion-inner").appendChild(frm);
         if(callEditor){l=callEditor.length;for(x=0;x<l;x++){var config={};config.removePlugins='save,autosave,sourcedialog,savecontent';CKEDITOR.replace(callEditor[x],config);}}//endif
         //get the first field to focus om
         for (first in eternal.fields)break;$("#"+first,frm).focus();
         frm.style.display="block";
         $(this.frmID+" #cancel_"+this.name)[0].value="Cancel";
         $(this.frmID+" #cancel_"+this.name).click(function(){$(this).parents(".accordion-body.in").collapse("hide");});
         //REFerence child table
         if(eternal.child)this.setChild(_jesua);
         if((_jesua=="alpha"||!_jesua)){ console.log($(".noField"),"hello world");
            $(this.frmID).data("jesua","alpha");$(".noField").show();//fileds that only display on insert
            $(this.frmID)[0].onsubmit=function(e){e.preventDefault();$("#submit_"+SET.name).button("loading");DB.beta(1);setTimeout(function(){$(SET.frmID+" #submit_"+SET.name).button("reset");}, 500); return false;}//make the form to become inserted
            if(!getLicentia(this.name,"Create")) $("#submit_"+SET.name).addClass("disabled");
         }else{
            $(this.frmID).data("jesua",row["jesua"]);$(".noField").hide();//fileds that only display on insert
            fieldsDisplay("form",row);
            $(this.frmID)[0].onsubmit=function(e){e.preventDefault();$("#submit_"+SET.name).button("loading");DB.beta(2,row["jesua"]);setTimeout(function(){$(SET.frmID+" #submit_"+SET.name).button("reset");}, 500); return false;}//make the form to become update
            if(!getLicentia(this.name,"Edit")) $("#submit_"+SET.name).addClass("disabled");
         }//endif
         if(eternal.form.file){var agitoScript=load_async("js/agito/"+eternal.form.file+".js",false,"end",true);
            if(agitoScript===false&&typeof onShowForm==="function"){
               var event = new Event('onShowForm');
               document.querySelector(this.frmID).addEventListener("onShowForm",onShowForm,false);
               document.querySelector(this.frmID).dispatchEvent(event);
            }else{onShowForm=function(){return true;}}}
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
   this.gammaTable=function(_rows,_child,_element,_unum,_legend,_foreign,_functions){
      var addEle,len,headers,$table,r1,max,len,k,th,title,allHead,cls,colspan,row,rec,ref,tmp,theContent;
      var recordOption=$("footer").data("record")||{};$("footer").removeData("record");//@fix:stop changes to navigation or activerecord
      if(_rows.hasOwnProperty('rows')&&_rows.rows.hasOwnProperty('source')&&recordOption.changeActiveRecord!==false){sessionStorage.activeRecord=JSON.stringify(_rows);}
      else if(typeof _rows.source!=="undefined"&&recordOption.changeActiveRecord!==false){sessionStorage.activeRecord=JSON.stringify(_rows);}
      len=_rows['length']||_rows.rows['length'];
      console.log(recordOption,"/",len);
      if(getLicentia(this.name,'View')===false) {$('.db_notice').html("<strong class='text-error'>You do not have permission to view "+this.name+"</strong>");return false;}
      if(!_foreign&&recordOption.changeNavigator!==false)this.setNavigation(_rows,true,'navTable');
      if(!_child){
         if($('header').data('header'))$('#sideBot h3').html(eternal.form.legend.txt);
         addEle=this.Obj.addTo;headers=eternal.fields;allHead=false;cls='table-condensed';
      }else{
         var reference=eternal.children||eternal.child;
         allHead=(reference[_child].hasOwnProperty('global')&&reference[_child].global.hasOwnProperty('header'))?reference[_child].global.header:true;
         addEle=_element;headers=reference[_child].fields;cls='table-bordered table-child';
      }
      if(!_legend)$(addEle).empty();
      $(".body article").append(creo({"clss":"ya_procer"},'h2',eternal.form.legend.txt));//add the title which can only be seen on print
      $table=$anima(addEle,'table',{'id':'table_'+this.name,'clss':'table table-striped table-hover '+cls}).vita('thead',{},true);
      $table.vita('tr',{},true).vita('th',{},false,'#');colspan=0;
      for(k in headers){
         th=headers[k];if(th.header==true||allHead){colspan++;title=th.title||k;$table.vita('th',{"clss":"col"+colspan},false,title)}
      }//endforeach
      if(_functions)$table.vita('th',{"clss":"col"+(colspan+1)},false,"Functions");
      $table.novo('#table_'+this.name,'tbody');
      r1=0;
      max=(parseInt(sessionStorage.genesis)+parseInt(localStorage.DB_LIMIT));
      max=max>len?len:max;//@fix:prevent the last index from occuring
      //si il'ya une recherche
      if(typeof _unum=="number"){sessionStorage.genesis=_unum;len=_unum+1;max=_unum+1;}
      var editable=_functions;
      if(getLicentia(this.name,'Edit')===false) editable = false;
      rec=(_child)?0:parseInt(sessionStorage.genesis);//child always has a zero start
      for(;rec<len,rec<max;rec++){
         row=_rows[rec];
         r1++;
         $table.father=document.querySelector('#table_'+this.name+' tbody');
         $table.vita('tr',{'data-jesua':row['jesua'],'clss':'row-'+row['id']},true).vita('td',{},false,r1);
         for(k in headers){ if(!headers[k].header&&!allHead) continue;
            $table.vita('td',{'contenteditable':editable,'clss':'col_'+k},false,row[k]);
            $table.child.onfocus=function(){theContent=$(this).text();}
            $table.child.onblur=function(){if(theContent!=$(this).text())deltaNotitia(this);}
         }//endfor
         if(_functions){
            tmp=$table.vita('td',{},true).father;
            if(getLicentia(this.name,'Delete')===true)$table.vita('a',{'href':'javascript:void(0)','clss':'forIcon'},true).vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=function(){omegaNotitia(this);}
            ref=row['name']||row['username']||false;
            $table.father=tmp;
            if(typeof eternal.links!="undefined") this.setLinks(eternal.links,$table,row[0],ref);
         }//endif
      }//endfor
      if(typeof _unum=="number"){sessionStorage.genesis=0}//re maitre a zero quand on fait une recherche
      $table.novo('#table_'+this.name,'tfoot',{}).vita('tr',{'clss':this.name+'Foot'},true).vita('td',{'colspan':colspan+2},true,'Total:').vita('span',{'clss':this.name+'Total'},false,r1).vita('strong',{'clss':'text-success table-msg-'+this.name});
   }
   /*
    * creates a single additional row to the table
    * @param {object} <var>_row</var> the db result
    * @param {string} <var>_child</var> the name of the child to be search in the eternal.child
    * @param {boolean} <var>_functions</var> whether to include functions or not
    * @returns {undefined}
    */
   this.newTableRow=function(_row,_child,_functions){
      var headers,cls,allHead,$table,k,theContent,val;
      var father=document.querySelector('#table_'+this.name+' tbody');//avoir le pere du body
      var lastRow=parseInt(document.querySelector('.'+this.name+'Total').innerHTML)+1;lastRow=lastRow||1;
      document.querySelector('.'+this.name+'Total').innerHTML=lastRow;
      if(!_child){
         headers=eternal.fields;allHead=false;cls='table-condensed';
      }else{
         var reference=eternal.children||eternal.child;
         allHead=(reference[_child].hasOwnProperty('global')&&reference[_child].global.hasOwnProperty('header'))?reference[_child].global.header:true;
         headers=reference[_child].fields;cls='table-bordered table-child';
      }
      $table=$anima(father,'tr',{'data-jesua':0}).vita('td',{},false,lastRow);var tr=$table.father;
      for(k in headers){ if(!headers[k].header&&!allHead) continue;
         $table.father=tr;$table.vita('td',{'contenteditable':true,'clss':'col_'+k},false,_row[k]);
         $table.child.onfocus=function(){theContent=$(this).text();}
         $table.child.onblur=function(){if(theContent!=$(this).text())deltaNotitia(this);
            //place the new text in the icon data, so that link will be assosiated with the new link
            val=$(this).text(); $('.icon-link',tr).each(function(i){$(this).data('ref',val).data('head',ref); console.log($(this)[0],"||",$(this).data('ref'),$(this).data('head')); } );}
      }//endfor
      if(_functions){
         father=$table.vita('td',{},true).father;
         $table.vita('a',{'href':'javascript:void(0)','clss':'forIcon'},true).vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=function(){omegaNotitia(this);}
         var ref=_row['name']||_row['username']||false;
         $table.father=father;
         if(typeof eternal.links!="undefined") this.setLinks(eternal.links,$table,_row[0],ref);
      }//endif
      if(reference[_child].fields.hasOwnProperty('sub'))_row.sub=$(this.frmID).data('jesua');//pour donner la valuer de referenc
      alphaNotitia(_row,tr);
   }
   /*
    * used to display a single form display
    * @param {string} <var>_key</var> the key of the objects
    * @param {object} <var>_field</var> the properties of the object
    * @returns {undefined}
    */
   this.singleForm=function(_key,_field,_global){
      var global,theField,theName,legend,div,theLabel,label,placeHolder,fieldset,div1,tmpType,input,i,span,div2,container;
      global=_global!=0?_global:null;//global variable to give default value
      theField=SET.setField(_key,_field);
//      theField=_field.field||_field;//@error:this has been disabled, re-enable if cause error
      theName=theField.name?theField.name:_key;
      container=SET.form2||SET.form;//to place in the second form.
      var hiddenField='';
      if(theField.type=="hidden"){hiddenField='hiddenField';}
      if(theField.required=="new"){hiddenField='noField';}
      //FIELDSET
      if(_field.legend){legend=creo({},'legend');legend.appendChild(document.createTextNode(_field.legend.txt))}
      if(_field.fieldset){fieldset=creo(_field.fieldset,'fieldset');if(legend)fieldset.appendChild(legend);SET.form.appendChild(fieldset);container=fieldset;}
      div=creo({"clss":"control-group "+SET.frmName+"_"+_key+" "+hiddenField},'div');
      //LABEL
      theLabel=_field.title?_field.title:aNumero(theName, true);
      theLabel=aNumero(theLabel,true);
      label=null;
      label=(isset(_field.addLabel))?_field.addLabel:SET.frmLabel;
      if(theField.type=="hidden")label=false;
      if(label) {label=creo({"clss":"control-label","forr":_key},'label'); label.appendChild(document.createTextNode(theLabel)); div.appendChild(label);}
      div1=creo({"clss":"controls "+(_field.clss||'')},'div');
      //PLACEHODER
      placeHolder=((_field.place)===true?theLabel:(_field.place)?_field.place:false);
      if(placeHolder!==false) theField.placeholder=placeHolder;
      //INNER DIV
      if(!theField.type&&global)theField.type=global.type;
      else if(!theField.type)theField.type='text';
      if(global&&global.complex)_field.complex=global.complex;
      tmpType=theField.type;
      theField=$.extend({},theField,SET.defaultFields[tmpType]);
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
      var div,button;
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
   this.callForm=function(_results,_jesua){
      var l,x,row,mainLabel,theDefaults,theField,theName,formFields,theLabel,label,formControl,placeHolder,tmpType,input,formContent,hiddenField;var lateCall=[];
      row=(_jesua=="alpha"||!_jesua)?{}:_results.rows.item(0);//@todo:check that <var>row</var> is not used and remove it also change the function var
      this.frmLabel=mainLabel=eternal.form.label?eternal.form.label:true;
      theDefaults=this.defaultFields;
      //FORM
      this.form=eternal.form.field;
      this.form.id=this.frmName;
      var $form=$anima(this.Obj.addTo,'form',this.form);
      this.form=$form.father;
      if(eternal.form.fieldset)$form.vita('fieldset',eternal.form.fieldset,true);
      if(eternal.form.legend)$form.vita('legend',{},false,eternal.form.legend.txt);
      formContent=$form.father;
      this.setObject({"items":eternal,"father":function(_key,_property){
            hiddenField='';
            theField=SET.setField(_key,_property);
            theName=theField.name?theField.name:_key;
            if(theField.type=='editor')lateCall.push(_key);
            if(theField.type=="hidden"){hiddenField='hiddenField';}
            if(theField.required=="new"){hiddenField='noField';}
            //FIELDSET
            if(_property.fieldset){
               formFields=$anima(formContent,'fieldset',eternal.form.fieldset,'','next');
               if(_property.legend){formFields.vita('legend',{},false,eternal.form.legend.txt);}
               formFields.vita('div',{"clss":"control-group "+SET.frmName+"_"+_key+" "+hiddenField});
            }else{
               formFields=$anima(formContent,'div',{"clss":"control-group "+SET.frmName+"_"+_key+" "+hiddenField});
            }
//            var controlGroup=formFields.father;//holder of the group?
            //LABEL
            theLabel=_property.title?_property.title:theName;
            theLabel=aNumero(theLabel,true);
            label=null;
            label=(isset(_property.addLabel))?_property.addLabel:mainLabel;
            if(theField.type=="hidden")label=false;
            if(label) {formFields.vita('label',{"clss":"control-label "+_key,"forr":_key},true,theLabel);formControl=formFields.genesis('div',{"clss":"controls "+(_property.clss||'')},true).father;}
            else formControl=formFields.vita('div',{"clss":"controls "+(_property.clss||'')},true).father;
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
      formContent.parentNode.insertBefore(this.setButton(eternal.form.button), formContent.nextSibling);
      document.getElementById(this.frmName).style.display='none';
      $('footer').data('lateCall',lateCall);
      defaultOnShow();
   }
   /*
    * add validation and key fields to the current field
    * @param {string} <var>_key</var> the id and key field of the field
    * @param {object} <var>_prop</var> all the properties of the field
    * @returns {object}
    */
   this.setField=function(_key,_prop){
      var theField=_prop.field||{};
      theField.id=_key;
      var title=theField.title||_prop.title||'';//@todo::after performance check use @onblur validation
      if(_prop.pattern){theField.pattern=this.patterns[_prop.pattern][0];theField.title=title+"\n"+this.patterns[_prop.pattern][1];}
      else if("field"in _prop&&"type"in _prop.field&&_prop.field.type=="password")
      {theField.pattern=this.patterns["password"][0];theField.title=title+"\n"+this.patterns["password"][1];}
      return theField;
   }
   /*
    * function to link the selected table in a gerund
    * @param {string} <var>_name</var> list of name associated with the link
    * @param {string} <var>_mensa</var> the gerund
    * @param {array} <var>_agrum</var> the field to quaerere
    * @param {integer} <var>_iota</var> groups iota
    * @returns {undefined}
    */
   this.linkTable=function(_name,_mensa,_agrum,_ratio,_jesua){
      var agris1,agris2,quaerere,len,x,x1,row,$displayMensa
      eternal=eternal||eternalCall();
      var puerum=eternal.child||false;
      var unus=_agrum[1];//main table
      var duo=_agrum[2]||_agrum[0];//second table[with an `s`] that will need to be removed
      var tribus=_agrum[3]||_agrum[0];//the field
      _agrum=_agrum[0];
      if(!$('#displayMensa').data('listed')||$('#displayMensa').data('listed')!=unus+_ratio){
         $('#displayMensa').data('listed',unus+_ratio);
         $('#displayMensa').empty();$('#displayMensa').removeData();
         agris1=unus.slice(0,-1);//get the field remove the 's'
         agris2=duo.slice(0,-1);
         $('#sideBot h3').html('Associate '+agris2+' to a '+unus);
         quaerere="SELECT a.id,a.jesua,"+_agrum+",a.`"+tribus+"`,b.`"+agris2+"` FROM `"+unus+"` a LEFT OUTER JOIN `"+_mensa+"` b ON b.`"+agris1+"`=a."+tribus+" AND b.`"+agris2+"`='"+_ratio+"' GROUP BY a.`id` ORDER BY "+_agrum;
         $DB(quaerere,[],"Listing "+unus,function(results){
         len=results.rows.length;
            for(x=0;x<len;x++){
               row=results.rows.item(x);
               $displayMensa=$anima('#displayMensa','li',{'data-jesua':row['jesua']}).vita('a',{'href':'javascript:void(0)'},true,aNumero(row[_agrum],true)+' ').vita('i',{'clss':'icon icon-color icon-unlink'});
               $($displayMensa.child).data('tribus',row[tribus]);
               if(_ratio==row[agris2]){$($displayMensa.child).removeClass('icon-unlink').addClass('icon-link');$($displayMensa.child).parent().addClass('text-success');}
               $displayMensa.child.onclick=function(){
                  quaerere={};quaerere.eternal={};quaerere.eternal[agris1]={};quaerere.eternal[agris2]={};var set=this;
                  if($(this).hasClass('icon-unlink')){
                     $(this).data('toggle',1);$(this).addClass('icon-link').removeClass('icon-unlink');
                     var d=new Date().format('isoDateTime');
                     quaerere.eternal[agris1]=$(this).data('tribus');quaerere.eternal[agris2]=_ratio;quaerere.Tau='Alpha';quaerere.iyona=_mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
                     $DB("INSERT INTO "+_mensa+" (`"+agris1+"`,`"+agris2+"`,`creation`) VALUES (?,?,?)",[$(this).data('tribus'),_ratio,d],"Linked "+_name+" to "+row[_agrum]);
                     if(puerum){//pour donner toute les permission
                        var f=(duo=='users')?'user':'name';//la column de reference
                        $DB("SELECT `"+f+"` FROM "+duo+" WHERE sub=?",[_jesua],"Selecting children",function(r,j){//prend toutes les donner de priviledge
                           for(x1=0;x1<j.rows.length;x1++) savingGrace(x1,j,set,f,_mensa,agris1,agris2,d);
                        });//end quaerere
                     }//endif
                  }else{
                     $(this).data('toggle',0);$(this).addClass('icon-unlink').removeClass('icon-link');
                     quaerere.eternal[agris1].alpha=$(this).data('tribus');quaerere.eternal[agris1].delta="!@=!#";
                     quaerere.eternal[agris2].alpha=_ratio;quaerere.eternal[agris2].delta=" AND !@=!#";
                     quaerere.Tau='oMegA';quaerere.iyona=_mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
                     $DB("DELETE FROM "+_mensa+" WHERE `"+agris1+"`=? AND `"+agris2+"`=?",[$(this).data('tribus'),_ratio],"unLinked "+_name+" to "+row[_agrum]);
                     if(puerum){//pour donner toute les permission
                        var f=(duo=='users')?'user':'name';//la column de reference
                        $DB("SELECT `"+f+"` FROM "+duo+" WHERE sub=?",[_jesua],"Selecting children",function(r,j){//prend toutes les donner de priviledge
                           for(x1=0;x1<j.rows.length;x1++) savingGrace(x1,j,set,f,_mensa,agris1,agris2,d,true);
                        });//end quaerere
                     }//endif
                  }//endif
               };//end anonymous
            }//end for
         });//end callback
      }//endfi
   }
   /*
    * set the links for the beta form
    * @param {object} <var>_children</var> the links list
    * @param {object} <var>_collapse_head</var> the node to the element
    * @param {string} )<var>_headKey</var> the name of the header that will be used as a key
    * @returns none
    */
   this.setLinks=function(_children,_collapse_head,_headKey,_ref){
      var link,theLink,temp,tmp,reference,file,loadAgito;
      tmp=_collapse_head.father;
      for(link in _children){
         reference=reference||link;//the value received from the custom json file, will store the first value
         if(_children[link]===true)continue;//because the first field is an option field
         if($.isArray(eternal.links[link]))theLink=eternal.links[link][1];
         else if(typeof eternal.links[link]==="object")theLink=link;
         if(!getLicentia(this.name,'Link '+theLink)) continue;
         _collapse_head.father=tmp;
         var icon=eternal.links[link]['icons']||'icon icon-color icon-link';
         _collapse_head.vita('a',{'href':'javascript:void(0)','clss':'forIcon'},true).vita('i',{'clss':icon,'title':'Link '+theLink});
         if(reference!='reference'){
            $(_collapse_head.child).data('ref',_ref);$(_collapse_head.child).data('head',_headKey);
            $(_collapse_head.child).data('link',link);$(_collapse_head.child).data('links',eternal.links[link]);
            $(_collapse_head.child).click(function(){//@note: watchout for toggle, u'll hv to click twist if u come back to an other toggle.
               $('.accordion-heading .icon-black,#table_'+SET.name+' .icon-black').removeClass('icon-black').addClass('icon-color');$(this).removeClass('icon-color').addClass('icon-black');
               var jesua=$(this).parents('div').data('jesua')||$(this).parents('tr').data('jesua');
               console.log($(this).data('ref'),"//",$(this).data('head'));
               SET.linkTable($(this).data('head'), $(this).data('link'),$(this).data('links'),$(this).data('ref'),jesua);
            });
         }else{//esle reference. LINK
            temp=[];
            file=eternal.links[link]["file"]||eternal.links[link]["cera"];
            loadAgito=(eternal.links[link]["file"])?"script":(eternal.links[link]["cera"])?"cera":"json";
            $(_collapse_head.child).data('loadAgito',loadAgito);
            $(_collapse_head.child).data('file',file);
            $(_collapse_head.child).data('theLink',theLink);
            _collapse_head.child.onclick=function(){
               var theLink=$(this).data('theLink');var file=$(this).data('file');var loadAgito=$(this).data("loadAgito");
               temp[0]=$(this).parents('div').data('code');temp[1]=eternal.mensa;$('footer').data('temp',temp);
               $('#nav-main #link_'+theLink).tab('show');$(".navLinks").removeClass('active');$("#nav_"+theLink).addClass('active');//maitre que le menu puisse ce fair voir
               if(loadAgito=="script"){
                  var scriptValue=load_async(file,true,'end',true);
                  if(scriptValue===false&&typeof agitoScript==="function")agitoScript();
               }else if (loadAgito=="cera") {
                  activateMenu(theLink,file,this,"cera");
               }
            };
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
      var key,tmp;
      var father=_collapse_head.father;
      for(key in _children){tmp=_children[key];
         _collapse_head.father=father;
         _collapse_head.vita('a',{'clss':'forIcon','data-toggle':_collapse,'data-parent':_collapseName,'href':_collapseTo},true)
         .vita('i',{'clss':'memberIcon '+tmp.icon,'title':'Link '+tmp.title,'data-agilis':key});//@event:customer.js
      }//endfor
   }
   /*
    * creates the parent->child form
    * @param {integer} <var>_iota</var> the parents IDref
    */
   this.setChild=function(_jesua){
      var childName;for(childName in eternal.child)break;var child=eternal.child[childName];
      var ubi=child.quaerere.ubi+"=?";
      var childFields=[];var field;
      for(field in child.fields){childFields.push(field);}
      childFields=childFields.join();
      var opto="SELECT id,"+childFields+",jesua FROM "+childName+" WHERE "+ubi;
      $(this.frmID+2).remove();
      var setEle=document.querySelector(this.frmID+' fieldset');
      var container=$anima(this.frmID,'fieldset',{'clss':'half-form formReader','id':this.frmName+2}).vita('legend',{},false,aNumero(child.title)).father;
      setEle.parentNode.insertBefore(container,setEle.nextSibling);//place the new fields set next to the old one
      $DB(opto,[_jesua],"Find child",function(r,j){
         theForm.gammaTable(j,childName,SET.frmID+2,false,true,true,true);
      });
   }
   /*
    * setup the navigation according to the size of the quaerere
    * @param {object} <var>_results</var> the quaerere results from websql
    * @param {string} <var>_pos</var> the position for the pagination
    * @returns {void}
    */
   this.setNavigation=function(_results,_pos,_class){
      var len,x,srch,found,y,row,c,f,examiner,value,pages,pagination;
      $('.pagination').remove();
      if(sessionStorage.activePage!=this.name){sessionStorage.genesis=0;sessionStorage.activePage=this.name;}//@alert:ne pas maitre deux form avec le meme nom.
      len=_results.length||_results.rows.length;$('input[name=s]').val('');
      console.log(_pos,"_pos",len);
      if(len>1){//parce que si cest un seul retour de base, cela c'est pour une recherche trouver
         srch=[];c=0;examiner=[];
         for(f in eternal.fields){if(eternal.fields[f].search){srch[c]=f;c++;}}//trouve les lieux qui on la cherche
         for(x=0;x<len;x++){found='';for(y=0;y<c;y++){row=_results[x]||_results.rows.item(x);found+=row[srch[y]]+'$ ';}examiner[x]=found;}//pour maitre se que on a trouver dans le variable examiner
         $('input[name=s]').each(function(i){//@fix:this has to be set as below for each search has it own typeahead.
            if(typeof $(this).data('typeahead')!=="undefined")$(this).data('typeahead').source=examiner;
         });
         //@fix:this resolve the issue of moving pages. it use to store the var `examiner` of prev page
         $("footer").data("examiner",examiner);
         //@fix: this is a fix to store the original records before the search
         //the activeSearch will store the records that have more than one row
         //this is done once, only upon the form being displayed
         sessionStorage.activeSearch=sessionStorage.activeRecord;
         $('input[name=s]').val('').prop('disabled',false).typeahead({source:examiner,minLength:3,
            highlighter:function(item){var regex = /\$(.+)/;return item.replace(regex,"<span class='none'>$1</span>");},
            updater:function(item){
               var examiner=$("footer").data("examiner");
               value=examiner.indexOf(item);
               theForm = new SET_FORM()._Set("#body article");
               var activeSearch=JSON.parse(sessionStorage.activeSearch);
               if(eternal.form.options&&eternal.form.options.type=="betaTable")theForm.gammaTable(activeSearch,false,false,value);
               else theForm.setBeta(activeSearch,false,false,value);
               console.log("call once---------",typeof reDraw);
               if(typeof reDraw ==="function")setTimeout(reDraw,100);//use on reDraw the search result. necessary on some form e.g. customer
               return item.replace(/\$(.+)/,'');
         }});
      }//endIF
      _class=!_class?'navig':_class;
      if(len>localStorage.DB_LIMIT){
         $(".recCount").remove();//@fix: pour ne pas avoir des duplication
         pages=Math.ceil(len/localStorage.DB_LIMIT);
         var pageMax=parseInt(sessionStorage.genesis)+parseInt(localStorage.DB_LIMIT);
         var recTotal=creo({"clss":"pull-right recCount"},"a","Record:"+(sessionStorage.genesis)+"-"+pageMax+" of "+len);
         if(!_pos){
            pagination=roadCover._Set({"next":"#tab-home section .homeSet2"}).pagiNation({"clss1":"pagination","clss2":_class,"pages":pages,"total":len,"link":"#"+this.name}).cloneNode(true);
            $('#tab-system .pagNav').append(pagination);$('#tab-system .secondRow').append(recTotal);
         }else{
            roadCover._Set(".tab-pane.active .pagNav").pagiNation({"clss1":"pagination","clss2":_class,"pages":pages,"total":len,"link":"#"+this.name});
            $('.tab-pane.active .secondRow').append(recTotal);
         }
      }
      if(_class=="navig")$('.navig a').click(function(){navig(this)});
      else $('.navTable a').click(function(){navigTable(this)});
   }
   /*
    * set the local rec into the session activeRecord
    * @param {object} <var>_results</var> the result from local
    * @param {integer} <var>_len</var> the size of the rec
    * @returns {undefined}
    */
   this.setActiveRecord=function(_results,_len){
      var tmp;
      _len=_results.rows.length;
      tmp={};tmp["rows"]={'length':_len,'source':'generated'};for(x=0;x<_len;x++){tmp[x]=_results.rows.item(x);}
      sessionStorage.activeRecord=JSON.stringify(tmp);tmp=null;
   }
//   if(this instanceof SET_FORM)return this; else return new SET_FORM();
}//END CLASS
/******************************************************************************/
/*
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
   var optGrp,x,i;
   ele = ele.indexOf('#')!=-1?ele.substr(1):ele;
   var select_field  = document.getElementById(ele);

   if (empty) the_list[0] = 'Select...';
   if (create)
   {
      edit_element    = { id:ele, name:ele, clss:clss, onclick:''};
      select_field   = creo(edit_element,'select');
   }/*end if*/
   optGrp = select_field.getElementsByTagName('optgroup');
   if (optGrp.length > 0 ) for (i=optGrp.length-1;i>=0;i--) select_field.removeChild(optGrp[i]);
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
}
/******************************************************************************/
/*
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
   var ele,c,b,label,input,listName,x,span;
   var theType=_field.type||_complex;
   var l=(isset(_items))?_items.length:0;
   var cnt=0;
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
      case 'link':
      case 'a':ele=creo(_field,"a",_field.title);
         break;
      case 'local-list':
         var len,got,getResults,revertetur;
         _field.type='text';
         ele=creo(_field,'input');
         $(ele).typeahead({minLength:0,source:function(_query,_process){
               if(_items.revertetur)revertetur=","+_items.revertetur;
               $DB("SELECT "+_items.agrum+revertetur+" FROM "+_items.mensa+" WHERE "+_items.agrum+" LIKE ?",['%'+_query+'%'],"searching "+_query,function(_results,results){
                  len=results.rows.length;got=[];getResults={};
                  for(x=0;x<len;x++){got[x]=results[x][_items.agrum];if(revertetur){getResults[got[x]]=results[x][_items.revertetur];}}
                  _process(got);
               });
            },updater:function(item){return getResults[item]||item;}
         });break;
      case 'editor': //load_async("js/libs/CKEditorCus/ckeditor.js",true,"end",false);//setTimeout(function(){CKEDITOR.replace(_field.id);},100);//mait un compteur, pour que la scripte charge
      case 'text': ele=creo(_field,'textarea'); break;
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
   var tmp,type,key2;
   var f=!_reference?eternal.fields:eternal.children[_reference].fields;
   var frmID='#frm_'+eternal.form.field.name;
   if(_reference)frmID=frmID+2;
   var c=0;
   var _return=[];
   if(typeof _source==="number"){tmp=JSON.parse(sessionStorage.activeRecord);_source=tmp[_source];}
   $.each(f,function(key,property){
      key2=key.replace(/\s/ig,'');//removes spaces
      if(_reference) type=property.type||eternal.children[_reference].global.type;
      else type=(property.field&&property.field.type)?property.field.type:(property.complex)?property.complex:'';
      if(_head && !property.header) return true;
      switch(type){
         case 'radio':
         case 'bool':
         case 'check':
            if(_from==='form')$(frmID+' [name^='+key2+']').each(function(){if($(this).val()==_source[key]||$(this).text()==_source[key])$(this).addClass('active').prop('checked',true);else $(this).removeClass('active').prop('checked',false);});
            else if(_from==='list')$(frmID+' [name^='+key2+']').each(function(){if($(this).prop('checked')||$(this).hasClass('active'))_return[c]=$(this).addClass('active').prop('value');});
            else _return[c]=_source[key2];
            break;
         case 'p':
         case 'span':
            if(_from==='form'&&_source[key])$(frmID+' #'+key2).html(_source[key]);
            else _return[c]=_source[key];
            break;
         case 'password':$(frmID+' #'+key2).prop("required",false);$(frmID+' #signum').prop("required",false);break;
         default:
//            console.log(c,"/",key2,"/",_return[c],"/",_source[key2],"/",_return,_source);
            if(_from==='form'&&_source[key]){$(frmID+' #'+key2).val(_source[key]);if(key2=='password'&&document.getElementById('signum'))document.getElementById('signum').value=_source[key]}
            else if(_from==='list')_return[c]=$(frmID+' #'+key2).val();
            else _return[c]=_source[key2];
            break;
      }//endswitch
      c++;
   });
   return _return;
}
/******************************************************************************/
/*
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

