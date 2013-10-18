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
   var d=new Date();
   $('#mainHead h1').text(_title);
   $('title').text(_title);
   $('#mainHead h2').text(_subTitle);
   $('#sideTop time').attr("datetime",d.format("isoDateTime")).html(d.format(localStorage.SITE_DATE)+' '+d.format(localStorage.SITE_TIME));
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
      var li,a,b,ul2,li2,a2,cl,txt,i;
      var ul=creo({"clss":"nav nav-tabs"},"ul");/*the first element created ul, for the list*/
      this.setObject({"items":_obj,/*the menu is passed as the first obj*/
         "father":function(key,item){/*the parent will be the second obj and a function*/
            if(item.licentia&&getLicentia(item.licentia,"View")===false)return true;
            mainMenu.push(key);
            cl=item.clss?item.clss:'';
            txt=document.createTextNode(' '+item.txt);
            li=creo({"clss":cl+" navLinks","id":"nav_"+key},"li");
            a=creo({"data-toggle":"tab","href":"#tab-"+key,'id':'link_'+key},"a");
            if(item.icon) {i=creo({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(txt);li.appendChild(a);ul.appendChild(li);
      },"mother":function(key,item){
            li=creo({"clss":"dropdown navLinks","id":"nav_"+key},"li");
            a=creo({"data-toggle":"dropdown","href":"#","clss":"dropdown-toggle",'id':'link_'+key},"a");
            if(item.icon) {i=creo({"clss":item.icon},"i");a.appendChild(i)}/*add icon if it exist*/
            a.appendChild(document.createTextNode(item.txt));
            b=creo({"clss":"caret"},"b");
            a.appendChild(b);li.appendChild(a);
            ul2=creo({"clss":"dropdown-menu",'id':'drop_'+key},"ul");
            $.each(item.sub,function(index,val){
               if(getLicentia(item.licentia[index],"View")===false)return true;
               li2=creo({},"li");a2=creo({"data-toggle":"tab","href":"#tab-"+key,"clss":key+index},"a");txt=document.createTextNode(val);
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
      var btn,i;
      var div=creo({"clss":"btn-group "+_obj.key},"div");
      var innerClass=this.Obj.clss;
      this.setObject({"items":_obj.btn,"father":function(key,item){
         if(item.lecentia&&!getLicentia(item.lecentia,"View")) return true;
         var tmp_clss=item.clss||'';
         btn=creo({"title":item.title,"id":key,"clss":innerClass+' '+tmp_clss},"button");
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
      var ul,li,a,txt,i,dataToggle,theTXT,iota;
      var div=creo({"clss":"btn-group"},"div");
      this.setObject({
         "items":_obj,
         "father":function(key,item){
            dataToggle=item['data-toggle']?item['data-toggle']:'nono';
            iota=item.iota||"0";
            a=creo({"data-toggle":dataToggle,"id":dataToggle,"clss":item.clss,"href":item.href,"data-iota":iota},"a");
            i=creo({"clss":item.icon},"i");
            txt=document.createTextNode(' '+item.txt);
            /*rest the element i and the text when the item is a caret*/
            if(item.caret) {i=creo({"clss":"caret"},'span');theTXT=document.createTextNode('');}
            else {theTXT=creo({'clss':'theTXT'},'span');theTXT.appendChild(txt);}//to add a wraper around the text content
            a.appendChild(i);a.appendChild(theTXT);div.appendChild(a);
         },"mother":function(key,item){
            ul=creo({"clss":item.clss,"id":key},'ul');
            $.each(item.sub,function(index,val){
               val.href=val.href=='#'?"javascript:void(0)":val.href;
               li=creo({'id':index},'li');val.clss=val.clss||'';iota=val.iota||'';
               a=creo({"href":val.href,"clss":val.clss,"data-iota":iota},'a');
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
      var ul,li,a,txt,i,ul2,li2,a2,b;;
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
      var btn=creo(_btn,_ele,_txt),i;
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
      var div,span,i,input;
      div=creo({"clss":_obj.div.clss},"div");
      span=creo({"clss":_obj.label.clss},"span");
      i=creo({"clss":_obj.label.icon},"i");
      input=creo(_obj.input,"input");
      span.appendChild(i);div.appendChild(span);div.appendChild(input);
      this.placeObj(div);
      return div;
   }/*end function*/
   this.searchForm=function(_obj){
      _obj=_obj||{form:{"name":"srchAllCust"},text:{},btn:{}};
      _obj.form.clss=_obj.form.clss||'pull-right';
      _obj.btn.clss=_obj.btn.clss||'';
      _obj.text.name=_obj.text.name||'txtSrchCust';
      _obj.text.clss=_obj.text.clss||'';
      _obj.text.place=_obj.text.place||'Search All';
      _obj.btn.name=_obj.btn.name||'btnSrchCust';
      _obj.btn.type=_obj.btn.type||'button';
      _obj.btn.txt=_obj.btn.txt||'Customers';
      var $form=creo({"name":_obj.form.name,"id":_obj.form.name,"clss":"form-search frmReduced "+_obj.form.clss},"form");
      $anima($form)
         .vita("div",{"clss":"input-append"},true)
         .vita("input",{"type":"text","clss":"input-medium search-query "+_obj.text.clss,"id":_obj.text.name,"name":_obj.text.name,"placeholder":_obj.text.place})
         .vita("button",{"type":_obj.btn.type,"clss":"btn "+_obj.btn.clss,"id":_obj.btn.name,"name":_obj.btn.name},false,_obj.btn.txt);
      this.placeObj($form);return $form;
   }
   /*
    * Creates a three level/element menu
    * @param {object} <var>_obj</var> holds the three classes of the holders and the sets of items for the pagination
    * @returns {object}
    * @todo add the page variable
    */
   this.pagiNation=function(_obj){
      var div,dsbl,a,x,tmp,actv,ul,li;
      var curr=Math.floor(parseInt(sessionStorage.genesis)/localStorage.DB_LIMIT);
      var prev=parseInt(sessionStorage.genesis)==0?0:curr-1;
      var next=curr>=_obj.pages-1?_obj.pages-1:curr+1;
      curr=curr==0?1:(((_obj.pages)-curr)>=4)?curr:(_obj.pages)-4;
      curr=curr<1?1:curr;
      var max=curr+4;
      div=creo({"clss":_obj.clss1},"div");ul=creo({"clss":_obj.clss2},"ul");
      dsbl=_obj.pages<3?"disabled":"";
      a=creo({"href":_obj.link,"data-goto":prev,"clss":_obj.clss2},"a","Prev");li=creo({"clss":dsbl},"li");li.appendChild(a);ul.appendChild(li);
      for(x=curr;x<=max;x++){
         dsbl=_obj.pages<max&&x>_obj.pages?"disabled":"";
         tmp=(parseInt(x)-1)*localStorage.DB_LIMIT;
         actv="";if(tmp==sessionStorage.genesis)actv=" active";
         a=creo({"href":_obj.link,"data-goto":x},"a",x);li=creo({"clss":dsbl+actv},"li");li.appendChild(a);ul.appendChild(li);
      }
      dsbl=_obj.pages<3?"disabled":"";
      a=creo({"href":_obj.link,"data-goto":next,"clss":_obj.clss2},"a","Next");li=creo({"clss":dsbl},"li");li.appendChild(a);ul.appendChild(li);
      div.appendChild(ul);
      this.placeObj(div);
      return div;
   }/*end function*/
   /*
    * create an advert set element for display
    * @param {object} _adr the variable containing all the address setting
    * @returns {object} the object containing all the address details
    */
   this.setAddress=function(_adr){
      var abbr,space,a,txt,address;
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
   this.userLogin=function(){
      if(!impetroUser().nominis){
         this.loginForm();
      } else {
         licentia();hauriret();
         if(!sessionStorage.USER_ADMIN) viewAPI(false);
      }//end if
      profectus('@login');
   }//end function
   this.loginForm=function(){
      $anima('#hiddenElements','div',{'clss':'modal','id':'userLogin','role':'dialog'})
      .vita('div',{'clss':'modal-header'},true).vita('button',{'clss':'close','aria-hidden':true},true).vita('i',{'clss':'icon icon-color icon-close'}).genesis('h2',{},false,'Welcome to '+localStorage.SITE_NAME)
      .novo('#userLogin','div',{'clss':'modal-body'}).vita('div',{'clss':'alert alert-info'},true)
         .vita('h4',{},false,'Login Details').vita('span')
         .novo('#userLogin .modal-body','form',{'clss':'form-signin','id':'loginForm','method':'post'}).vita('div',{'clss':'input-prepend fullWidth'},true).vita('span',{'clss':'add-on'},true).vita('i',{'clss':'icon-user'}).genesis('input',{'id':'email','type':'text','placeholder':'username or email','clss':'input-block-level','required':'','autofocus':""})
         .novo('#userLogin .form-signin','div',{'clss':'input-prepend fullWidth'}).vita('span',{'clss':'add-on'},true).vita('i',{'clss':'icon-lock'}).genesis('input',{'id':'password','type':'password','clss':'input-block-level','required':'','placeholder':'password'})
         .novo('#userLogin .form-signin','label',{'name':'remember','for':'remeberMe','clss':'checkbox inline'},'Remember me').vita('input',{'type':'checkbox','value':1,'id':'remeberMe'})
         .genesis('label',{'name':'remember','for':'fullscreen','clss':'checkbox inline'},true,'Run in fullscreen?').vita('input',{'type':'checkbox','value':1,'id':'fullscreen'})
      .novo('#userLogin','div',{'clss':'modal-footer'}).vita('button',{'clss':'btn btn-primary','form':'loginForm'},false,'Login');
      $('#userLogin').modal({'backdrop':'static','keyboard':true,'show':true});
      document.getElementById('loginForm').onsubmit=function(){loginValidation(); return false;};
   }

//   if(this instanceof SET_DISPLAY)return this; else return new SET_DISPLAY();
}/*end OBJECT*/
//============================================================================//DESINNER
hauriret=function(){
//============================================================================//TOP NAV
//timeFrame('index');
   profectus('@hauriret');
   var menuHome,menuUser,menuSearch,homeSection,menuDisplay,menuDealers,menuCustSrch,menuSalesmen,menuMonths,pagNav;
   roadCover._Set("#nav-main").navTab({"home":{"txt":"Home","icon":"icon-home","clss":"active"},"dealers":{"txt":"Dealers","icon":"icon-book","licentia":"dealer"},"salesman":{"txt":"Salesman","icon":"icon-briefcase","licentia":"salesman"},"customers":{txt:"Customers","icon":"icon-user","licentia":"customer"},"insurance":{"txt":"Insurance","icon":"icon-folder-open","licentia":"member"},"system":{"txt":"System","icon":"icon-cog","sub":["System Confuguration","View Clients","System features","Help system","Setup Permission"],"licentia":[true,"Clients","Features","Helper","permission"]}});
   roadCover._Set({"addTo":"#tab-home section","clss":"btn btn-primary"}).btnGroup({"key":"homeSet0","btn":{"btnNotify":{"title":"My Notification","icon":"icon-inbox icon-white"},"btnEmail":{"title":"Email page","icon":"icon-envelope icon-white"},"btnWord":{"title":"Convert to MS Word","icon":"icon-th-large icon-white"},"btnExcel":{"title":"Convert to MS Excel","icon":"icon-th icon-white"}}});
   menuHome=roadCover.btnGroup({"key":"homeSet1","btn":{"btnReload":{"title":"Reload page","icon":"icon-refresh icon-white","clss":"btnReload"},"btnDashboard":{"title":"Enter Dashboard","icon":"icon-home icon-white","clss":"btnDashboard"},"btnFullScreen":{"title":"Enter or exit fullscreen","icon":"icon-fullscreen icon-white","clss":"btnFullScreen"}}}).cloneNode(true);
   menuUser=roadCover.btnDropDown({"btnUser":{"clss":"btn btn-primary btnUser","href":"javascript:void(0)","icon":"icon-user icon-white","txt":"User"},"btnUserCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubUserList":{"clss":"dropdown-menu","sub":{"profileView":{"href":"#","icon":"icon-pencil","clss":"profileView","txt":"My profile"},"profileNew":{"href":"#","icon":"icon-plus","clss":"profileNew","txt":"Create profile"},"profileList":{"href":"#","clss":"profileList","icon":"icon-map-marker","txt":"Admin List"},"profileDiv":{"divider":true},"profileOff":{"href":"#","icon":"icon-ban-circle","clss":"logOff","txt":"Logoff"}}}});
   roadCover.btnGroup({"key":"homeSet2","btn":{"btnGroup":{"title":"Access all group","icon":"icon icon-white icon-users","clss":"btnGroup"},"btnPrint":{"title":"Print page","icon":"icon-print icon-white","clss":"printPage"},"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"},"btnReset":{"title":"Reset System","icon":"icon-off icon-white"} }});
   menuSearch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right searchAll"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-all","name":"s","type":"search","placeholder":"Search page","form":"frm_search"}}).cloneNode(true);
   homeSection=creo({'clss':'clearfix secondRow',"id":"bataHome"},'div');homeSection.appendChild(creo({"clss":"headRow"},'h2'));
   pagNav=creo({"clss":"pagNav pull-right"},"nav");roadCover.placeObj(pagNav);roadCover.placeObj(homeSection);
//============================================================================//DEALERS
//timeFrame('dealers');
   roadCover._Set("#tab-dealers section");profectus("@hauriret:dealers");
//   menuDisplay=roadCover.btnGroup({"key":"setDisplay","btn":{"btnListOn":{"title":"Display List","icon":"icon-list icon-white"},"btnListOff":{"title":"Remove List","icon":"icon-align-justify icon-white"},"btnList":{"title":"Return to List","icon":"icon-tasks icon-white"},"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"}}}).cloneNode(true);
   menuDisplay=roadCover.btnGroup({"key":"setDisplay","btn":{"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"},"btnPrint":{"title":"Print page","icon":"icon-print icon-white","clss":"printPage"}}}).cloneNode(true);
   $('#tab-dealers section').append(menuHome);
   roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-dealer","name":"s","type":"search","placeholder":"Search Dealer","form":"frm_search"}});
   homeSection=homeSection.cloneNode(true);homeSection.id="betaDealer";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//SALEMAN
//timeFrame('saleman');
   roadCover._Set("#tab-salesman section");profectus("@hauriret:salesman");
   $('#tab-salesman section').append(menuDisplay);
   $('#tab-salesman section').append(menuHome.cloneNode(true));
   roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-salesman","name":"s","type":"search","placeholder":"Search Salesman","form":"frm_search"}});
   homeSection=homeSection.cloneNode(true);homeSection.id="betaSalesman";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//CUSTOMER
//timeFrame('customer');
   profectus("@hauriret:customer");
   menuDealers=roadCover._Set('#tab-customers section').btnDropDown({"btnDealer":{"clss":"btn btn-primary allDealer","href":"javascript:void(0)","iota":"0","icon":"icon-book icon-white","txt":"All Dealers"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubDealersList":{"clss":"dropdown-menu dealersList","sub":{"dealerOne":{"href":"#","txt":"Dealer One"},"dealerTwo":{"href":"#","txt":"Dealer Two"},"dealerThree":{"href":"#","txt":"Dealer Three"},"dealerDiv":{"divider":true},"dealerAll":{"href":"#","txt":"All Dealers"}}}}).cloneNode(true);
   menuSalesmen=roadCover.btnDropDown({"btnDealer":{"clss":"btn btn-primary allSalesman","href":"javascript:void(0)","iota":"0","icon":"icon-briefcase icon-white","txt":"All Salesman"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubSalesmanList":{"clss":"dropdown-menu salesmanList","sub":{"salesmanOne":{"href":"#","txt":"Salesman One"},"salesmanTwo":{"href":"#","txt":"Salesman Two"},"salesmanThree":{"href":"#","txt":"Salesman Three"},"salesmanDiv":{"divider":true},"salesmanAll":{"href":"#","txt":"All Salesman"}}}}).cloneNode(true);
   menuMonths=roadCover.btnDropDown({"btnMonths":{"clss":"btn btn-primary","href":"javascript:void(0)","icon":"icon-calendar icon-white","txt":"Months"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubMonthList":{"clss":"dropdown-menu monthList","sub":{1:{"href":"#","txt":"January"},2:{"href":"#","txt":"Febraury"},3:{"href":"#","txt":"March"},4:{"href":"#","txt":"April *"},5:{"href":"#","txt":"May *"},6:{"href":"#","txt":"June *"},7:{"href":"#","txt":"July *"},8:{"href":"#","txt":"August *"},9:{"href":"#","txt":"September *"},10:{"href":"#","txt":"October"},11:{"href":"#","txt":"November"},"12":{"href":"#","txt":"December"}}}}).cloneNode(true);
   roadCover.searchForm();
   $('#tab-customers section').append(menuDisplay.cloneNode(true));
   roadCover._Set("#tab-customers section").btnGroup({"btnCustomerExpense":{"title":"Customer's Expense","icon":"icon-tag icon-white"},"btnCustomerPayment":{"title":"Payment Details","icon":"icon-tags icon-white"},"btnCustomerVehecle":{"title":"Vehicle Details","icon":"icon-road icon-white"},"btnCustomerCover":{"title":"Customer's Cover","icon":"icon-download-alt icon-white"}});
   menuCustSrch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-customer","name":"s","type":"search","placeholder":"Search Customer","form":"frm_search","autocomplete":"off"}}).cloneNode(true);
   homeSection=homeSection.cloneNode(true);homeSection.id="betaCustomer";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//INSURANCE
//timeFrame('insurance');
   roadCover._Set('#tab-insurance section');profectus("@hauriret:insurance");
   menuMonths.id="btnSubMonthList2";
   $('#tab-insurance section').append(menuDealers);
   $('#tab-insurance section').append(menuSalesmen);
   $('#tab-insurance section').append(menuMonths);
   $('#tab-insurance section').append(menuDisplay.cloneNode(true));
   $('#tab-insurance section').append(menuCustSrch);
   homeSection=homeSection.cloneNode(true);homeSection.id="betaInsurance";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//SYSTEM
//timeFrame('system');
   menuUser=menuUser.cloneNode(true);menuUser.className += ' duplex';
   roadCover._Set("#tab-system section").btnGroup({"key":"setSystem","btn":{"btnSysLog":{"title":"View Logs","icon":"icon-list-alt icon-white","lecentia":"Logs"},"btnSysReport":{"title":"View Reports","icon":"icon-book icon-white", "lecentia":"Reports"},"btnSysImport":{"title":"Run Import","icon":"icon icon-white icon-archive","lecentia":"Import"},"btnSysQuery":{"title":"Single Query","icon":"icon-search icon-white","lecentia":"Query"},"btnSysPermission":{"title":"Setup Permission","icon":"icon-pencil icon-white","lecentia":"Permission"},"btnFeatures":{"title":"View/Add System features","icon":"icon-wrench icon-white","lecentia":"Features"},"btnHelper":{"title":"Add/Edit help content","icon":"icon-info-sign icon-white","lecentia":"page"} }});
   $('#tab-system section').append(menuUser);
   roadCover.btnGroup({"key":"setClient","btn":{"btnSysClient":{"title":"View Clients","icon":"icon-qrcode icon-white getClient"},"btnPrint":{"title":"Print page","icon":"icon-print icon-white","clss":"printPage"},"btnHelp":{"title":"Help system","icon":"icon-question-sign icon-white","clss":"btnHelp"},}});
   $('#tab-system section').append(menuSearch);
   homeSection=homeSection.cloneNode(true);homeSection.id="betaSystem";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//FOOTER
   var mother={"clss":"dropdown-menu bottom-up pull-right","children":{"footContact":{"href":"javascript:void(0)","txt":"Contact us"},"footHelp":{"href":"javascript:void(0)","txt":"Help"},"footAbout":{"href":"javascript:void(0)","txt":"About us"}}};
   roadCover._Set({"next":"#copyRight"}).setList({"clss":"nav","items":{"userName":{"href":"javascript:void(0)","txt":'@user'},"sysAbout":{"href":"javascript:void(0)","clss1":"dropdown","txt":"About Us","clss2":"dropdown-toggle","data-toggle":"dropdown","caret":"caret bottom-up","sub":mother},"userOut":{"href":"javascript:void(0)","txt":"Logout"} }});
   $('#userName a').html(impetroUser().nominis);
//============================================================================//LIST ADD DEALER AND SALESMAN
   $DB("SELECT name,code FROM dealers ",[],"",function(r,j){
      var n='dealers';var cnt=0;
      var N=aNumero(n,true);
      $('.'+n+'List').empty();
      $.each(j,function(i,v){if(i=='rows') return true;cnt++;
         $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));
         $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));
      });
      $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
      $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
      //AGITO$('#tab-customers .allDealer,#tab-customers .oneDealer').click(function(){activateMenu('customer','customers',this,true,'dealers');sessionStorage.genesis=0;});//ce qui sur le button
      $('#tab-insurance .allDealer,#tab-insurance .oneDealer').click(function(){activateMenu('member','insurance',this,true,'dealers');sessionStorage.genesis=0;});//ce qui sur le button
   });
   $DB("SELECT firstname||' '||lastname,code FROM salesmen",[],"",function(r,j){
      var n='salesman';var cnt=0;
      var N=aNumero(n,true);
      $('.'+n+'List').empty();
      $.each(j,function(i,v){if(i=='rows') return true;cnt++;
         $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
         $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
      });
      $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
      $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
      //AGITO$('#tab-customers .allSalesman,#tab-customers .oneSalesman').click(function(){activateMenu('customer','customers',this,true,'salesmen');sessionStorage.genesis=0;});
      $('#tab-insurance .allSalesman,#tab-insurance .oneSalesman').click(function(){activateMenu('member','insurance',this,true,'salesmen');sessionStorage.genesis=0;});
   });profectus("@hauriret:list dealer&salesman");
//============================================================================//SETUP
   timeFrame('OMEGA',true);
};
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