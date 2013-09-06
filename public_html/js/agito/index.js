/*
 * script to execute on first page
 */
//LOGIN
//@todo: set the title on other tabs
timeFrame('Login');
roadCover = new SET_DISPLAY(localStorage.SITE_NAME,"",1);
//============================================================================//TOP NAV
//timeFrame('index');
roadCover._Set("#nav-main").navTab({"home":{"txt":"Home","icon":"icon-home","clss":"active"},"dealers":{"txt":"Dealers","icon":"icon-book","sub":['Dealer One','Dealer Two','Dealer Three','hr','View All Dealers']},"salesman":{"txt":"Salesman","icon":"icon-briefcase","sub":["First Salesman","Second Salesman","Third Salesman","Fourth Salesman","hr","View All Salesman"]},"customers":{txt:"Customers","icon":"icon-user"},"insurance":{"txt":"Insurance","icon":"icon-folder-open"},"system":{"txt":"System","icon":"icon-cog","sub":["System Confuguration","View Clients","Run Import","View Reports","Setup Permission"]}});
roadCover._Set({"addTo":"#tab-home section","clss":"btn btn-primary"}).btnGroup({"key":"homeSet0","btn":{"btnNotify":{"title":"My Notification","icon":"icon-inbox icon-white"},"btnPrint":{"title":"Print Page","icon":"icon-print icon-white"},"btnEmail":{"title":"Email page","icon":"icon-envelope icon-white"},"btnWord":{"title":"Convert to MS Word","icon":"icon-th-large icon-white"},"btnExcel":{"title":"Convert to MS Excel","icon":"icon-th icon-white"}}});
menuHome=roadCover.btnGroup({"key":"homeSet1","btn":{"btnReload":{"title":"Reload page","icon":"icon-refresh icon-white"},"btnDashboard":{"title":"Enter Dashboard","icon":"icon-home icon-white"},"btnFullScreen":{"title":"Enter or exit fullscreen","icon":"icon-fullscreen icon-white"}}}).cloneNode(true);
menuUser=roadCover.btnDropDown({"btnUser":{"clss":"btn btn-primary btnUser","href":"javascript:void(0)","icon":"icon-user icon-white","txt":"User"},"btnUserCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubUserList":{"clss":"dropdown-menu","sub":{"profileView":{"href":"#","icon":"icon-pencil","clss":"profileView","txt":"My profile"},"profileNew":{"href":"#","icon":"icon-plus","clss":"profileNew","txt":"Create profile"},"profileList":{"href":"#","clss":"profileList","icon":"icon-map-marker","txt":"Admin List"},"profileDiv":{"divider":true},"profileOff":{"href":"#","icon":"icon-ban-circle","clss":"logOff","txt":"Logoff"}}}});
roadCover.btnGroup({"key":"homeSet2","btn":{"btnGroup":{"title":"Access all group","icon":"icon icon-white icon-users","clss":"btnGroup"},"btnHelp":{"title":"Help","icon":"icon-question-sign icon-white","clss":"btnHelp"},"btnTest":{"title":"Testing feature","icon":"icon-info-sign icon-white"} }});
menuSearch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right searchAll"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-all","name":"s","type":"search","placeholder":"Search page","form":"frm_search"}}).cloneNode(true);
//roadCover.pagiNation({"clss1":"pagination pull-right","clss2":"disabled","total":5,"link":"#home"});
homeSection=creo({'clss':'clearfix secondRow'},'div');homeSection.appendChild(creo({},'h2'));
roadCover.placeObj(homeSection);homeSection=null;
//============================================================================//DEALERS
//timeFrame('dealers');
roadCover._Set("#tab-dealers section");
menuDisplay=roadCover.btnGroup({"key":"setDisplay","btn":{"btnListOn":{"title":"Display List","icon":"icon-list icon-white"},"btnListOff":{"title":"Remove List","icon":"icon-align-justify icon-white"},"btnList":{"title":"Return to List","icon":"icon-tasks icon-white"}}}).cloneNode(true);
$('#tab-dealers section').append(menuHome);
roadCover.placeObj(creo({'clss':'headRow'},'h2'));
roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-dealer","name":"s","type":"search","placeholder":"Search Dealer","form":"frm_search"}});
//menuAddr=roadCover.setAddress({"Addr":{"txt":"79 Street, Suburb, City, Code, Country","title":"Physicall address","prop":"address","href":"http://maps.google.com/?q=79+Street,+Suburb,+City,+Code,+Country"},"Tel":{"txt":"(011) 808-9000","title":"Telephone Number","prop":"telephone","href":"tel:+27118089000"},"Fax":{"txt":"(011) 808-7000","title":"Fax Number","prop":"faxNumber","href":"tel:+27118087000"},"Email":{"txt":"namesurname@email.com","title":"Email address","prop":"email","href":"maito:namesurname@email.com"}}).cloneNode(true);
//============================================================================//SALEMAN
//timeFrame('saleman');
roadCover._Set("#tab-salesman section");
$('#tab-salesman section').append(menuDisplay);
$('#tab-salesman section').append(menuHome.cloneNode(true));
roadCover.placeObj(creo({'clss':'headRow'},'h2'));
roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-salesman","name":"s","type":"search","placeholder":"Search Salesman","form":"frm_search"}});
//$('#tab-salesman section').append(menuAddr);
//============================================================================//CUSTOMER
//timeFrame('customer');
menuDealers=roadCover._Set('#tab-customers section').btnDropDown({"btnDealer":{"clss":"btn btn-primary","href":"#","icon":"icon-book icon-white","txt":"All Dealers"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubDealersList":{"clss":"dropdown-menu dealersList","sub":{"dealerOne":{"href":"#","txt":"Dealer One"},"dealerTwo":{"href":"#","txt":"Dealer Two"},"dealerThree":{"href":"#","txt":"Dealer Three"},"dealerDiv":{"divider":true},"dealerAll":{"href":"#","txt":"All Dealers"}}}}).cloneNode(true);
menuSalesmen=roadCover.btnDropDown({"btnDealer":{"clss":"btn btn-primary","href":"#","icon":"icon-book icon-white","txt":"All Salesman"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubSalesmanList":{"clss":"dropdown-menu salesmanList","sub":{"salesmanOne":{"href":"#","txt":"Salesman One"},"salesmanTwo":{"href":"#","txt":"Salesman Two"},"salesmanThree":{"href":"#","txt":"Salesman Three"},"salesmanDiv":{"divider":true},"salesmanAll":{"href":"#","txt":"All Salesman"}}}}).cloneNode(true);
$('#tab-customers section').append(menuDisplay.cloneNode(true));
roadCover._Set("#tab-customers section").btnGroup({"btnCustomerExpense":{"title":"Customer's Expense","icon":"icon-tag icon-white"},"btnCustomerPayment":{"title":"Payment Details","icon":"icon-tags icon-white"},"btnCustomerVehecle":{"title":"Vehicle Details","icon":"icon-road icon-white"},"btnCustomerCover":{"title":"Customer's Cover","icon":"icon-download-alt icon-white"}});
menuCustSrch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-customer","name":"s","type":"search","placeholder":"Search Customer","form":"frm_search","autocomplete":"off"}}).cloneNode(true);
roadCover.placeObj(creo({'clss':'headRow'},'h2'));
//============================================================================//INSURANCE
//timeFrame('insurance');
$('#tab-insurance section').append(menuDealers);
$('#tab-insurance section').append(menuSalesmen);
$('#tab-insurance section').append(menuDisplay.cloneNode(true));
$('#tab-insurance section').append(menuCustSrch);
$('#tab-insurance section').append(creo({'clss':'headRow'},'h2'));
//============================================================================//SYSTEM
//timeFrame('system');
roadCover._Set("#tab-system section").btnGroup({"key":"setSystem","btn":{"btnSysLog":{"title":"View Logs","icon":"icon-list-alt icon-white"},"btnSysReport":{"title":"View Reports","icon":"icon-book icon-white"},"btnSysImport":{"title":"Run Import","icon":"icon icon-white icon-archive"},"btnSysQuery":{"title":"Single Query","icon":"icon-search icon-white"},"btnSysPermission":{"title":"Setup Permission","icon":"icon-pencil icon-white"},"btnFeatures":{"title":"View/Add System features","icon":"icon-wrench icon-white"} }});
$('#tab-system section').append(menuUser.cloneNode(true));
roadCover.btnGroup({"key":"setClient","btn":{"btnSysClient":{"title":"View Clients","icon":"icon-qrcode icon-white getClient"},"btnHelp":{"title":"Help system","icon":"icon-question-sign icon-white","clss":"btnHelp"},}});
$('#tab-system section').append(menuSearch);
$('#tab-system section').append(creo({'clss':'headRow'},'h2'));
//============================================================================//FOOTER
mother={"clss":"dropdown-menu bottom-up pull-right","children":{"footContact":{"href":"#","txt":"Contact us"},"footHelp":{"href":"#","txt":"Help"},"footAbout":{"href":"#","txt":"About us"}}};
roadCover._Set({"next":"#copyRight"}).setList({"clss":"nav","items":{"userName":{"href":"#","txt":'@user'},"sysAbout":{"href":"#","clss1":"dropdown","txt":"About Us","clss2":"dropdown-toggle","data-toggle":"dropdown","caret":"caret bottom-up","sub":mother},"userOut":{"href":"#","txt":"Logout"} }});
roadCover.userLogin();
//============================================================================//FORM
$('#sideNotice').append(creo({'clss':'db_notice'},'div'));
$('#sideNotice').append(creo({"id":"sys_msg"},'div','...'));
//timeFrame('welcome');
//============================================================================//SETUP
if(!window.openDatabase){$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').append('Your browser dooes not have support for websql,<br/> Recomended broswer for this application are Chrome, Opera and Safari');}
SET_DB();//@todo: regard pourquoi ce si coure deux foi.
//@todo: test on a new DB if the menu link will appear.
$DB("SELECT name,code FROM dealers LIMIT 3",[],"",function(r,j){
   var n='dealers';
   var N=aNumero(n,true);
   $('#drop_'+n).empty();
   $('.'+n+'List').empty();
   $.each(j,function(i,v){if(i=='rows') return true;
      $anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' oneDealer','data-iota':v[1]},false,aNumero(v[0],true))
      $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true))
      $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true))
   });
   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));
   //AGITO
   $('#drop_'+n+' .allDealer,#drop_'+n+' .oneDealer').click(function(){if($(this).hasClass('oneDealer'))$('footer').data('header',true);/*this is for a bug fix. menu links are supposed to display header from the function and not from the form beta */activateMenu('dealer','dealers',this);sessionStorage.genesis=0;});//ce qui sont sous le menu
   $('#tab-customers .allDealer,#tab-customers .oneDealer').click(function(){activateMenu('customer','customers',this,true,'dealers');sessionStorage.genesis=0;});//ce qui on le button
   $('#tab-insurance .allDealer,#tab-insurance .oneDealer').click(function(){activateMenu('member','insurance',this,true,'dealers');sessionStorage.genesis=0;});//ce qui on le button
});
$DB("SELECT firstname||' '||lastname,code FROM salesmen LIMIT 3",[],"",function(r,j){
   var n='salesman';
   var N=aNumero(n,true);
   $('#drop_'+n).empty();
   $('.'+n+'List').empty();
   $.each(j,function(i,v){if(i=='rows') return true;
      $anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
      $anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));
   });
   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   $anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));
   //AGITO
   $('#drop_'+n+' .allSalesman,#drop_'+n+' .oneSalesman').click(function(){if($(this).hasClass('oneSalesman'))$('footer').data('header',true);/*this is for a bug fix. menu links are supposed to display header from the function and not from the form beta */activateMenu('salesman','salesmen',this);sessionStorage.genesis=0;});
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
//   console.log(narro,'narro');
   narro=narro[history.state.path];
   var set = narro.table.indexOf('#link_')!=-1?narro.table:"#link_"+narro.table;
   set = set.indexOf('sales')!=-1?'.allSalesman,.salesman5':set.indexOf('dealer')!=-1?'.allDealer,.dealers4':set.indexOf('system')!=-1?'.system0':set;
//   console.log(narro,'narro2',narro.table,set);
   if(narro.store)page=narro.store;//when the key has changed use the stored key, which is also the filename
   if(narro.page) getPage(narro.page);
   else if (page) activateMenu(page,narro.table,set,narro.manus,narro.tab,narro.type);
});
//WORKERS.
//notitiaWorker.addEventListener('message',function(e){console.log('Worker on Notitia:', e.data);},false);
//notitiaWorker.addEventListener('error',onError,false)
//RESET
delete menuHome,delete menuUser,delete menuSearch,delete menuDisplay,delete menuDealers,delete menuSalesmen,delete menuCustSrch,delete mother;