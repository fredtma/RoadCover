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
   this.Obj='p';
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
   this.commonSet=function(_obj){
      this.Obj = _obj;
      return this;
   }
   /* This function creates the object based upon the var Attrs
    * @param {object} _obj the object that will be iterated to extract the string value
    * @returns {object} return the object that is to be created
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
   /* this function set the navagion object and the values of the Attrs variables
    * @param {type} _menu
    * @returns {undefined}
    */
   this.navTab = function(_menu) {
      var ul=create_element({"clss":"nav nav-tabs"},"ul");/*the first element created ul, for the list*/
      this.setObject({"items":_menu,/*the menu is passed as the first obj*/
         "father":function(key,item){/*the parent will be the second obj and a function*/
            mainMenu.push(key);
            cl=item.clss?item.clss:'';
            txt=document.createTextNode(item.txt);
            li=create_element({"clss":cl},"li");
            a=create_element({"data-toggle":"tab","href":"#tab-"+key},"a");
            if(item.icon) {i=create_element({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(txt);li.appendChild(a);ul.appendChild(li);
      },"mother":function(key,item){
            li=create_element({"clss":"dropdown"},"li");
            a=create_element({"data-toggle":"dropdown","href":"#","clss":"dropdown-toggle"},"a");
            if(item.icon) {i=create_element({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(document.createTextNode(item.txt));
            b=create_element({"clss":"caret"},"b");
            a.appendChild(b);li.appendChild(a);
            ul2=create_element({"clss":"dropdown-menu"},"ul");
            $.each(item.sub,function(index,val){
               li2=create_element({},"li");a2=create_element({"data-toggle":"tab","href":"#tab-"+key},"a");txt=document.createTextNode(val);
               if(val=='hr'){li2.className="divider";txt=document.createTextNode('')}
               a2.appendChild(txt);li2.appendChild(a2);ul2.appendChild(li2);
            });
            ul2.appendChild(li2);li.appendChild(ul2);ul.appendChild(li);
      }});
      document.getElementById("nav-main").appendChild(ul);
   }/*end function*/
   this.btnGroup=function(_obj){
      var div=create_element({"clss":"btn-group"},"div");console.log(this);
      var innerClass=this.Obj.clss;
      this.setObject({"items":_obj,"father":function(key,item){
         btn=create_element({"title":item.title,"id":key,"clss":innerClass},"button");
         i=create_element({"clss":item.icon},"i");btn.appendChild(i);div.appendChild(btn);
      }});
      console.log(div);
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