/*
 * script to execute on first page
 */
//LOGIN
//@todo: set the title on other tabs
timeFrame('Login');
//licentia();
roadCover = new SET_DISPLAY(localStorage.SITE_NAME,"",1);
(function(){
//============================================================================//TOP NAV
//timeFrame('index');
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
   roadCover._Set("#tab-dealers section");
//   menuDisplay=roadCover.btnGroup({"key":"setDisplay","btn":{"btnListOn":{"title":"Display List","icon":"icon-list icon-white"},"btnListOff":{"title":"Remove List","icon":"icon-align-justify icon-white"},"btnList":{"title":"Return to List","icon":"icon-tasks icon-white"},"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"}}}).cloneNode(true);
   menuDisplay=roadCover.btnGroup({"key":"setDisplay","btn":{"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"},"btnPrint":{"title":"Print page","icon":"icon-print icon-white","clss":"printPage"}}}).cloneNode(true);
   $('#tab-dealers section').append(menuHome);
   roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-dealer","name":"s","type":"search","placeholder":"Search Dealer","form":"frm_search"}});
   homeSection=homeSection.cloneNode(true);homeSection.id="betaDealer";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//SALEMAN
//timeFrame('saleman');
   roadCover._Set("#tab-salesman section");
   $('#tab-salesman section').append(menuDisplay);
   $('#tab-salesman section').append(menuHome.cloneNode(true));
   roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-salesman","name":"s","type":"search","placeholder":"Search Salesman","form":"frm_search"}});
   homeSection=homeSection.cloneNode(true);homeSection.id="betaSalesman";
   roadCover.placeObj(pagNav.cloneNode(true));roadCover.placeObj(homeSection);
//============================================================================//CUSTOMER
//timeFrame('customer');
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
   roadCover._Set('#tab-insurance section');
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
   mother={"clss":"dropdown-menu bottom-up pull-right","children":{"footContact":{"href":"javascript:void(0)","txt":"Contact us"},"footHelp":{"href":"javascript:void(0)","txt":"Help"},"footAbout":{"href":"javascript:void(0)","txt":"About us"}}};
   roadCover._Set({"next":"#copyRight"}).setList({"clss":"nav","items":{"userName":{"href":"javascript:void(0)","txt":'@user'},"sysAbout":{"href":"javascript:void(0)","clss1":"dropdown","txt":"About Us","clss2":"dropdown-toggle","data-toggle":"dropdown","caret":"caret bottom-up","sub":mother},"userOut":{"href":"javascript:void(0)","txt":"Logout"} }});
   roadCover.userLogin();
}());
//============================================================================//FORM
$('#sideNotice').append(creo({'clss':'db_notice'},'div'));
$('#sideNotice').append(creo({"id":"sys_msg"},'div','...'));
//timeFrame('welcome');
//============================================================================//SETUP
if(!window.openDatabase){$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').append('Your browser dooes not have support for websql,<br/> Recomended broswer for this application are Chrome, Opera and Safari');}
SET_DB();//@todo: regard pourquoi ce si coure deux foi.
//@todo: test on a new DB if the menu link will appear.
$DB("SELECT name,code FROM dealers ",[],"",function(r,j){
   var n='dealers';var cnt=0;
   var N=aNumero(n,true);
   $('.'+n+'List').empty();
   $.each(j,function(i,v){if(i=='rows') return true;cnt++;
//      if(cnt<=3)$anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' oneDealer','data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));
   });
//   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   //AGITO
//   $('#drop_'+n+' .allDealer,#drop_'+n+' .oneDealer').click(function(){if($(this).hasClass('oneDealer'))$('footer').data('header',true);/*@fix. menu links are supposed to display header from the function and not from the form beta */activateMenu('dealer','dealers',this);sessionStorage.genesis=0;});//ce qui sont sous le menu
   $('#tab-customers .allDealer,#tab-customers .oneDealer').click(function(){activateMenu('customer','customers',this,true,'dealers');sessionStorage.genesis=0;});//ce qui sur le button
   $('#tab-insurance .allDealer,#tab-insurance .oneDealer').click(function(){activateMenu('member','insurance',this,true,'dealers');sessionStorage.genesis=0;});//ce qui sur le button
});
$DB("SELECT firstname||' '||lastname,code FROM salesmen",[],"",function(r,j){
   var n='salesman';var cnt=0;
   var N=aNumero(n,true);
   $('.'+n+'List').empty();
   $.each(j,function(i,v){if(i=='rows') return true;cnt++;
//      if(cnt<=3)$anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'javascript:void(0)','clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
   });
//   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   //AGITO
//   $('#drop_'+n+' .allSalesman,#drop_'+n+' .oneSalesman').click(function(){if($(this).hasClass('oneSalesman'))$('footer').data('header',true);/*this is for a bug fix. menu links are supposed to display header from the function and not from the form beta */activateMenu('salesman','salesmen',this);sessionStorage.genesis=0;});
//   $('.'+n+'List .allSalesman,.'+n+'List .oneSalesman').click(function(){activateMenu('customer','customers',this,true,'salesmen')});//what it was before
   $('#tab-customers .allSalesman,#tab-customers .oneSalesman').click(function(){activateMenu('customer','customers',this,true,'salesmen');sessionStorage.genesis=0;});
   $('#tab-insurance .allSalesman,#tab-insurance .oneSalesman').click(function(){activateMenu('member','insurance',this,true,'salesmen');sessionStorage.genesis=0;});
});
//============================================================================//end
console.log('Cash::'+objectSize($.cache));
if(history.state)hasNarro=true;
timeFrame('OMEGA',true);
//============================================================================//EVENT
$(window).on('popstate',function(e){
   var narro = {},page;
   if(sessionStorage.narro)narro=JSON.parse(sessionStorage.narro);
   else return false;
   page = (history.state)?history.state.path:null;
   if(!page) return false;
//   console.log(narro,'narro',history.state, narro.table,page);
   narro=narro[history.state.path];
   if(narro.table) var set = narro.table.indexOf('#link_')!=-1?narro.table:"#link_"+narro.table;
   else var set = "#link_home";
   set = set.indexOf('sales')!=-1?'.allSalesman,.salesman5':set.indexOf('dealer')!=-1?'.allDealer,.dealers4':set.indexOf('system')!=-1?'.system0':set;
//   console.log(narro,'narro2',narro.table,set,page);
   if(narro.store)page=narro.store;//when the key has changed use the stored key, which is also the filename
   if(narro.page) getPage(page);
   else if (page) activateMenu(page,narro.table,set,narro.manus,narro.tab,narro.type);
});
//============================================================================//WORKERS.
if(window.Worker&&localStorage.USER_NAME)readWorker();
//RESET
delete menuHome,delete menuUser,delete menuSearch,delete menuDisplay,delete menuDealers,delete menuSalesmen,delete menuCustSrch,delete mother;