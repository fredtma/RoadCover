/*
 * lamdba is a set of dynamically created elements
 * @uses jquery|lib.muneris
 */

/******************************************************************************/
/**
 * object to create a tab menu
 * @author fredtma
 * @version 2.8
 * @category dynamic, menu, object
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @return object
 * @todo: add a level three menu step
 * @see: placeObj
 */
function SET_DISPLAY(_title,_subTitle,_pageNumber)
{
   this.Obj={};
   d=new Date();
   $('#mainHead h1').text(_title);
   $('title').text(_title);
   $('#mainHead h2').text(_subTitle);
   $('#sideTop time').html(d.format(localStorage.SITE_DATE)+' '+d.format(localStorage.SITE_TIME));
   this.pageNumber=_pageNumber;
   /*
    * the number of menu name will also be the number of container
    * @type array
    */
   var mainMenu = [];
   var parentAttr, childAttr;
   /*
    * used to pass variable that will commonly be used everywhere
    * @param {object} _obj the object
    * @returns {object} the object returned
    */
   this._Set=function(_opt){
      if(typeof(_opt)==="string"){this.addTo=_opt;}
      else {this.Obj = _opt;this.addTo=_opt.addTo}
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
            if(!item.sub){_obj.father(key1,item);}
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
      if(this.addTo) $(this.addTo).append(_obj);
      else if(this.Obj.next) $(this.Obj.next).after(_obj);
   }
   /* this function set the navagion object and the values of the Attrs variables
    * @param {type} _menu
    * @returns {undefined}
    */
   this.navTab = function(_obj) {
      var ul=creo({"clss":"nav nav-tabs"},"ul");/*the first element created ul, for the list*/
      this.setObject({"items":_obj,/*the menu is passed as the first obj*/
         "father":function(key,item){/*the parent will be the second obj and a function*/
            mainMenu.push(key);
            cl=item.clss?item.clss:'';
            txt=document.createTextNode(' '+item.txt);
            li=creo({"clss":cl},"li");
            a=creo({"data-toggle":"tab","href":"#tab-"+key},"a");
            if(item.icon) {i=creo({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(txt);li.appendChild(a);ul.appendChild(li);
      },"mother":function(key,item){
            li=creo({"clss":"dropdown"},"li");
            a=creo({"data-toggle":"dropdown","href":"#","clss":"dropdown-toggle"},"a");
            if(item.icon) {i=creo({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(document.createTextNode(item.txt));
            b=creo({"clss":"caret"},"b");
            a.appendChild(b);li.appendChild(a);
            ul2=creo({"clss":"dropdown-menu"},"ul");
            $.each(item.sub,function(index,val){
               li2=creo({},"li");a2=creo({"data-toggle":"tab","href":"#tab-"+key},"a");txt=document.createTextNode(val);
               if(val=='hr'){li2.className="divider";txt=document.createTextNode('')}
               a2.appendChild(txt);li2.appendChild(a2);ul2.appendChild(li2);
            });
            ul2.appendChild(li2);li.appendChild(ul2);ul.appendChild(li);
      }});
      this.placeObj(ul);
   }/*end function*/
   /*
    * created a button group
    * @param {type} _obj
    * @returns {undefined}
    */
   this.btnGroup=function(_obj){
      var div=creo({"clss":"btn-group"},"div");
      var innerClass=this.Obj.clss;
      this.setObject({"items":_obj,"father":function(key,item){
         btn=creo({"title":item.title,"id":key,"clss":innerClass},"button");
         i=creo({"clss":item.icon},"i");btn.appendChild(i);div.appendChild(btn);
      }});
      this.placeObj(div);
      return div;
   }/*end function*/
   /*
    * create two buttons as one entity with a drop down
    * @param {object} _obj the object with all the paramated to descripb the button
    * @returns {object} the html content of the object
    */
   this.btnDropDown=function(_obj){
      var div=creo({"clss":"btn-group"},"div");
      this.setObject({
         "items":_obj,
         "father":function(key,item){
            dataToggle=item['data-toggle']?item['data-toggle']:'nono';
            a=creo({"data-toggle":dataToggle,"id":dataToggle,"clss":item.clss,"href":item.href},"a");
            i=creo({"clss":item.icon},"i");
            txt=document.createTextNode(' '+item.txt);
            /*rest the element i and the text when the item is a caret*/
            if(item.caret) {i=creo({"clss":"caret"},'span');txt=document.createTextNode('');}
            a.appendChild(i);a.appendChild(txt);div.appendChild(a);
         },"mother":function(key,item){
            ul=creo({"clss":item.clss,"id":key},'ul');
            $.each(item.sub,function(index,val){
               li=creo({'id':index},'li');
               a=creo({"href":val.href},'a');
               i=creo({"clss":val.icon},'i');
               txt=document.createTextNode(' '+val.txt);
               if(val.divider){li.className="divider";txt=document.createTextNode('');i=creo({},'i');}
               a.appendChild(i);a.appendChild(txt);li.appendChild(a);ul.appendChild(li);div.appendChild(ul);
            });
         }
      });
      this.placeObj(div);
      return div;
   }/*end function*/
   /*
    * creates a tree list
    * @param {object} _obj the object representing the setting for the list
    * @returns {object}
    */
   this.setList=function(_obj){
      var ul=creo({"clss":_obj.clss},'ul');

      this.setObject({items:_obj.items,"father":function(key,item){
            li=creo({"id":key},'li');
            a=creo({"href":item.href},'a');
            txt=document.createTextNode(item.txt);
            a.appendChild(txt);li.appendChild(a);ul.appendChild(li);
         },"mother":function(key,item){
            li=creo({'id':key,"clss":item.clss1},'li');
            a=creo({"href":item.href,"clss":item.clss2,"data-toggle":item['data-toggle']},'a');
            txt=document.createTextNode(item.txt+' ');
            a.appendChild(txt);if(item.caret){b=creo({"clss":item.caret},'b');a.appendChild(b)}li.appendChild(a);
            if(item.sub){
               ul2=creo({"clss":item.sub.clss},"ul");
               $.each(item.sub.children,function(index,val){
                  li2=creo({"id":index},"li");a2=creo({"href":val.href},"a");txt=document.createTextNode(val.txt);
                  if(val.txt=='hr'){li2.className="divider";txt=document.createTextNode('')}
                  a2.appendChild(txt);li2.appendChild(a2);ul2.appendChild(li2);
               });
               li.appendChild(ul2);
            }
            ul.appendChild(li);
         }
      });
      this.placeObj(ul);
      return ul;
   }
   /*SINGLE ELEMENT************************************************************/
   /*
    * create Button
    * @param {object} _obj
    * @returns {object}
    */
   this.btnCreation=function(_ele,_btn,_txt,_icon){
      btn=creo(_btn,_ele,_txt);
      if(_icon){i=creo({"clss":_icon},'i');$(btn).prepend(i)}
      this.placeObj(btn);
      return btn;
   }/*end function*/
   /*
    * this places a formless search
    * @param {object} <var>_obj</var> holds the definition of the div holder,label and search input
    * @returns {object}
    */
   this.inputSearch=function(_obj){
      div=creo({"clss":_obj.div.clss},"div");
      span=creo({"clss":_obj.label.clss},"span");
      i=creo({"clss":_obj.label.icon},"i");
      input=creo(_obj.input,"input");
      span.appendChild(i);div.appendChild(span);div.appendChild(input);
      this.placeObj(div);
      return div;
   }/*end function*/
   /*
    * Creates a three level/element menu
    * @param {object} <var>_obj</var> holds the three classes of the holders and the sets of items for the pagination
    * @returns {object}
    * @todo add the page variable
    */
   this.pagiNation=function(_obj){
      var page=1;
      div=creo({"clss":_obj.clss1},"div");
      ul=creo({"clss":_obj.clss2},"ul");
      prv=document.createTextNode("Prev");
      nxt=document.createTextNode("Next");
      a=creo({"href":_obj.link,"data-goto":page-1},"a");
      li=creo({},"li");
      a.appendChild(prv);li.appendChild(a);ul.appendChild(li);
      for(x=1;x<=_obj.total;x++){
         txt=document.createTextNode(x);
         a=creo({"href":_obj.link,"data-goto":x},"a");
         li=creo({},"li");
         a.appendChild(txt);li.appendChild(a);ul.appendChild(li);
      }
      a=creo({"href":_obj.link,"data-goto":page+1},"a");
      li=creo({},"li");
      a.appendChild(nxt);li.appendChild(a);ul.appendChild(li);div.appendChild(ul);
      this.placeObj(div);
      return div;
   }/*end function*/
   /*
    * create an advert set element for display
    * @param {object} _adr the variable containing all the address setting
    * @returns {object} the object containing all the address details
    */
   this.setAddress=function(_adr){
      address=creo({"itemscope":"","itemtype":"http://schema.org/LocalBusiness","clss":"muted add"},"address");
      $.each(_adr,function(index,val){
         space = document.createTextNode(" ");
         abbr=creo({"title":val.title},"abbr");
         txt=document.createTextNode(index);
         abbr.appendChild(txt);
         a=creo({"href":val.href,"itemprop":val.prop},"a");
         txt=document.createTextNode(val.txt);
         a.appendChild(txt);txt=document.createTextNode(":");
         address.appendChild(abbr);address.appendChild(txt);address.appendChild(a);address.appendChild(space);
      });
      this.placeObj(address);
      return address;
   }/*end function*/

   if(this instanceof SET_DISPLAY)return this;
   else return new SET_DISPLAY();
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