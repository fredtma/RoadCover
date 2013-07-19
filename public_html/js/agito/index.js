/*
 * script to execute on first page
 */
timeFrame('index');
roadCover = new SET_DISPLAY(localStorage.SITE_NAME,"Sub title",1);
roadCover._Set("#nav-main").navTab({"home":{"txt":"Home","icon":"icon-home","clss":"active"},"dealers":{"txt":"Dealers","icon":"icon-book","sub":["First Dealer","Second Dealer","Third Dealer","Fourth Dealer","hr","View All Dealers"]},"salesman":{"txt":"Salesman","icon":"icon-briefcase","sub":["First Salesman","Second Salesman","Third Salesman","Fourth Salesman","hr","View All Salesman"]},"customers":{txt:"Customers","icon":"icon-user"},"insurance":{"txt":"Insurance","icon":"icon-folder-open"},"system":{"txt":"System","icon":"icon-cog","sub":["View Logs","View Clients","Run Import","View Reports","Setup Permission"]}});
roadCover._Set({"addTo":"#tab-home section","clss":"btn btn-primary"}).btnGroup({"btn-notify":{"title":"My Notification","icon":"icon-inbox icon-white"},"btn-print":{"title":"Print Page","icon":"icon-print icon-white"},"btn-email":{"title":"Email page","icon":"icon-envelope icon-white"},"btn-word":{"title":"Convert to MS Word","icon":"icon-th-large icon-white"},"btn-excel":{"title":"Convert to MS Excel","icon":"icon-th icon-white"}});
menuUser=roadCover.btnDropDown({"btn-user":{"clss":"btn btn-primary","href":"#","icon":"icon-user icon-white","txt":"User"},"btn-user-caret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btn-sub-user-list":{"clss":"dropdown-menu","sub":{"profile-view":{"href":"#","icon":"icon-pencil","txt":"My profile"},"profile-new":{"href":"#","icon":"icon-plus","txt":"Create profile"},"profile-see":{"href":"#","icon":"icon-map-marker","txt":"Admin List"},"profile-div":{"divider":true},"profile-off":{"href":"#","icon":"icon-ban-circle","txt":"Logoff"}}}}).cloneNode(true);
menuHelp=roadCover.btnCreation("button",{"name":"btn-help","clss":"btn btn-primary","title":"Help"},"","icon-question-sign icon-white").cloneNode(true);
menuSearch=roadCover.inputSearch({"div":{"clss":"btn-cust input-prepend pull-right"},"label":{"clss":"add-on","icon":"icon-search icon-white"},"input":{"clss":"input-medium search-all","name":"s","type":"search","placeholder":"Search page","form":"frm_search"}}).cloneNode(true);
roadCover.pagiNation({"clss1":"pagination pull-right","clss2":"disabled","total":5,"link":"#home"});
//DEALERS
timeFrame('dealers');
roadCover._Set("#tab-dealers section").btnDropDown({"btn-dealer":{"clss":"btn btn-primary","href":"#","icon":"icon-book icon-white","txt":"All Dealers"},"btn-dealer-caret":{"clss":"btn btn-primary dropdown-toggle","href":"#","data-toggle":"dropdown","caret":"span"},"btn-sub-dealer-list":{"clss":"dropdown-menu","sub":{"dealer-one":{"href":"#","txt":"Dealer One"},"dealer-two":{"href":"#","txt":"Dealer Two"},"dealer-three":{"href":"#","txt":"Dealer Three"},"dealer-div":{"divider":true},"dealer-all":{"href":"#","txt":"All Dealers"}}}});
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
roadCover._Set("#tab-system section").btnGroup({"btnSysLog":{"title":"View Logs","icon":"icon-list-alt icon-white"},"btnSysClient":{"title":"View Clients","icon":"icon-user icon-white"},"btnSysReport":{"title":"View Reports","icon":"icon-book icon-white"},"btnSysImport":{"title":"Run Import","icon":"icon-share-alt icon-white"},"btnSysQuery":{"title":"Single Query","icon":"icon-search icon-white"},"btnSysPermission":{"title":"Setup Permission","icon":"icon-pencil icon-white"}});
$('#tab-system section').append(menuUser);
$('#tab-system section').append(menuHelp);
$('#tab-system section').append(menuSearch);
//FOOTER
username="Frederick Tshimanga"
mother={"clss":"dropdown-menu bottom-up pull-right","children":{"footContact":{"href":"#","txt":"Contact us"},"footHelp":{"href":"#","txt":"Help"},"footAbout":{"href":"#","txt":"About us"}}};
roadCover._Set({"next":"#copyRight"}).setList({"clss":"nav","items":{"userName":{"href":"#","txt":username},"sysAbout":{"href":"#","clss1":"dropdown","txt":"About Us","clss2":"dropdown-toggle","data-toggle":"dropdown","caret":"caret bottom-up","sub":mother},"userOut":{"href":"#","txt":"Logout"} }});
//FROM
timeFrame('form',true);
$.getJSON("json/profile.json",findJSON);
function findJSON(data){
   profileForm = new SET_FORM();
   profileForm._Set("#tmp").setAlpha(data);
}
console.log(objectSize($.cache));
//RESET
roadCover=null;menuAddr=null;menuDisplay=null;username=null;mother=null;
var JSONprofile;