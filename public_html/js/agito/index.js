/*
 * script to execute on first page
 */
//LOGIN
//@todo: set the title on other tabs
timeFrame('Login');
roadCover = new SET_DISPLAY(localStorage.SITE_NAME,"",1);
roadCover.userLogin();
//TOP NAV
timeFrame('index');
roadCover._Set("#nav-main").navTab({"home":{"txt":"Home","icon":"icon-home","clss":"active"},"dealers":{"txt":"Dealers","icon":"icon-book","sub":['Dealer One','Dealer Two','Dealer Three','hr','View All Dealers']},"salesman":{"txt":"Salesman","icon":"icon-briefcase","sub":["First Salesman","Second Salesman","Third Salesman","Fourth Salesman","hr","View All Salesman"]},"customers":{txt:"Customers","icon":"icon-user"},"insurance":{"txt":"Insurance","icon":"icon-folder-open"},"system":{"txt":"System","icon":"icon-cog","sub":["View Logs","View Clients","Run Import","View Reports","Setup Permission"]}});
roadCover._Set({"addTo":"#tab-home section","clss":"btn btn-primary"}).btnGroup({"btnNotify":{"title":"My Notification","icon":"icon-inbox icon-white"},"btnPrint":{"title":"Print Page","icon":"icon-print icon-white"},"btnEmail":{"title":"Email page","icon":"icon-envelope icon-white"},"btnWord":{"title":"Convert to MS Word","icon":"icon-th-large icon-white"},"btnExcel":{"title":"Convert to MS Excel","icon":"icon-th icon-white"}});
roadCover.btnGroup({"btnReload":{"title":"Reload page","icon":"icon-refresh icon-white"},"btnDashboard":{"title":"Enter Dashboard","icon":"icon-home icon-white"},"btnFullScreen":{"title":"Enter or exit fullscreen","icon":"icon-fullscreen icon-white"},"btnGroup":{"title":"Access all group","icon":"icon icon-white icon-users"}});
menuUser=roadCover.btnDropDown({"btnUser":{"clss":"btn btn-primary btnUser","href":"#","icon":"icon-user icon-white","txt":"User"},"btnUserCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubUserList":{"clss":"dropdown-menu","sub":{"profileView":{"href":"#","icon":"icon-pencil profileView","txt":"My profile"},"profileNew":{"href":"#","icon":"icon-plus profileNew","txt":"Create profile"},"profileList":{"href":"#","clss":"profileList","icon":"icon-map-marker","txt":"Admin List"},"profileDiv":{"divider":true},"profileOff":{"href":"#","icon":"icon-ban-circle logOff","txt":"Logoff"}}}}).cloneNode(true);
menuHelp=roadCover.btnCreation("button",{"name":"btn-help","clss":"btn btn-primary libHelp space","title":"Help"},"","icon-question-sign icon-white").cloneNode(true);
menuSearch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-all","name":"s","type":"search","placeholder":"Search page","form":"frm_search"}}).cloneNode(true);
roadCover.pagiNation({"clss1":"pagination pull-right","clss2":"disabled","total":5,"link":"#home"});
roadCover.placeObj(creo({'clss':'clearfix secondRow'},'div'));
//DEALERS
timeFrame('dealers');
roadCover._Set("#tab-dealers section").btnDropDown({"btnDealer":{"clss":"btn btn-primary","href":"#","icon":"icon-book icon-white","txt":"All Dealers"},"btnDealerCaret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btnSubDealersList":{"clss":"dropdown-menu","sub":{"dealerOne":{"href":"#","txt":"Dealer One"},"dealerTwo":{"href":"#","txt":"Dealer Two"},"dealerThree":{"href":"#","txt":"Dealer Three"},"dealerDiv":{"divider":true},"dealerAll":{"href":"#","txt":"All Dealers"}}}});
menuDisplay=roadCover.btnGroup({"btnListOn":{"title":"Display List","icon":"icon-list icon-white"},"btnListOff":{"title":"Remove List","icon":"icon-align-justify icon-white"},"btnList":{"title":"Return to List","icon":"icon-tasks icon-white"}}).cloneNode(true);
roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-dealer","name":"s","type":"search","placeholder":"Search Dealer","form":"frm_search"}});
menuAddr=roadCover.setAddress({"Addr":{"txt":"79 Street, Suburb, City, Code, Country","title":"Physicall address","porp":"address","href":"http://maps.google.com/?q=79+Street,+Suburb,+City,+Code,+Country"},"Tel":{"txt":"(011) 808-9000","title":"Telephone Number","porp":"telephone","href":"tel:+27118089000"},"Fax":{"txt":"(011) 808-7000","title":"Fax Number","porp":"faxNumber","href":"tel:+27118087000"},"Email":{"txt":"namesurname@email.com","title":"Email address","porp":"email","href":"maito:namesurname@email.com"}}).cloneNode(true);
//SALEMAN
timeFrame('saleman');
roadCover._Set("#tab-salesman section").btnDropDown({"btn-dealer":{"clss":"btn btn-primary","href":"#","icon":"icon-book icon-white","txt":"All Salesman"},"btn-dealer-caret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btn-sub-salesman-list":{"clss":"dropdown-menu","sub":{"salesman-one":{"href":"#","txt":"Salesman One"},"salesman-two":{"href":"#","txt":"Salesman Two"},"salesman-three":{"href":"#","txt":"Salesman Three"},"salesman-div":{"divider":true},"salesman-all":{"href":"#","txt":"All Salesman"}}}});
$('#tab-salesman section').append(menuDisplay);
roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-salesman","name":"s","type":"search","placeholder":"Search Salesman","form":"frm_search"}});
$('#tab-salesman section').append(menuAddr);
//CUSTOMER
timeFrame('customer');
$('#tab-customers section').append(menuDisplay.cloneNode(true));
roadCover._Set("#tab-customers section").btnGroup({"btnCustomerExpense":{"title":"Customer's Expense","icon":"icon-tag icon-white"},"btnCustomerPayment":{"title":"Payment Details","icon":"icon-tags icon-white"},"btnCustomerVehecle":{"title":"Vehicle Details","icon":"icon-road icon-white"},"btnCustomerCover":{"title":"Customer's Cover","icon":"icon-download-alt icon-white"}});
menuCustSrch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-cutomer","name":"s","type":"search","placeholder":"Search Customer","form":"frm_search"}}).cloneNode(true);
//INSURANCE
timeFrame('insurance');
$('#tab-insurance section').append(menuDisplay.cloneNode(true));
$('#tab-insurance section').append(menuCustSrch);
//SYSTEM
timeFrame('system');
roadCover._Set("#tab-system section").btnGroup({"btnSysLog":{"title":"View Logs","icon":"icon-list-alt icon-white"},"btnSysClient":{"title":"View Clients","icon":"icon-qrcode icon-white getClient"},"btnSysReport":{"title":"View Reports","icon":"icon-book icon-white"},"btnSysImport":{"title":"Run Import","icon":"icon icon-white icon-archive"},"btnSysQuery":{"title":"Single Query","icon":"icon-search icon-white"},"btnSysPermission":{"title":"Setup Permission","icon":"icon-pencil icon-white"}});
$('#tab-system section').append(menuUser);
$('#tab-system section').append(menuHelp);
$('#tab-system section').append(menuSearch);
//FOOTER
username="Frederick Tshimanga"
mother={"clss":"dropdown-menu bottom-up pull-right","children":{"footContact":{"href":"#","txt":"Contact us"},"footHelp":{"href":"#","txt":"Help"},"footAbout":{"href":"#","txt":"About us"}}};
roadCover._Set({"next":"#copyRight"}).setList({"clss":"nav","items":{"userName":{"href":"#","txt":username},"sysAbout":{"href":"#","clss1":"dropdown","txt":"About Us","clss2":"dropdown-toggle","data-toggle":"dropdown","caret":"caret bottom-up","sub":mother},"userOut":{"href":"#","txt":"Logout"} }});
//FORM
db_notice=creo({'clss':'db_notice'},'div');
$('#sideNotice').append(db_notice);
timeFrame('welcome');
console.log('Cash::'+objectSize($.cache));
timeFrame('OMEGA',true);
//RESET
menuAddr=null;menuDisplay=null;username=null;mother=null;//creoDB=null;
var JSONprofile;