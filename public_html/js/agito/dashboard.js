/*
 * creates the dashboard on the home page
 */
$('#body article').empty();
$welcome=$anima('#body article','div',{'id':'dashboard'}).vita('div',{clss:'row-fluid'},true);
$welcome.vita('div',{clss:'span4 alert alert-info dash-module getUser'},true).vita('h4',{},true,' Administrators ').vita('i',{'clss':'icon-user icon-white'},false,'','first').novo('#dashboard .getUser','p',{},'users content text');
$welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getGroup'}).vita('h4',{},true,' Groups').vita('i',{'clss':'icon icon-white icon-users'},false,'','first').novo('#dashboard .getGroup','p',{},'groups content text');
$welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getPerm'}).vita('h4',{},true,' Permissions').vita('i',{'clss':'icon-pencil icon-white'},false,'','first').novo('#dashboard .getPerm','p',{},'permission content text');
$welcome.novo('#dashboard','div',{clss:'row-fluid'});
$welcome.vita('div',{clss:'span4 alert alert-info dash-module getClient'},true).vita('h4',{},true,' Clients').vita('i',{'clss':'icon-qrcode icon-white'},false,'','first').novo('#dashboard .getClient','p',{},'clients content text');
$welcome.novo('#dashboard .row-fluid:nth-child(2)','div',{clss:'span4 alert alert-info dash-module allDealer'}).vita('h4',{},true,' Dealers').vita('i',{'clss':'icon-book icon-white'},false,'','first').novo('#dashboard .allDealer','p',{},'Dealers content text');
$welcome.novo('#dashboard .row-fluid:nth-child(2)','div',{clss:'span4 alert alert-info dash-module allSalesman'}).vita('h4',{},true,' Salesmen').vita('i',{'clss':'icon-briefcase icon-white'},false,'','first').novo('#dashboard .allSalesman','p',{},'Salesmen content text');
$welcome.novo('#dashboard','div',{clss:'row-fluid'});
$welcome.vita('div',{clss:'span4 alert alert-info dash-module getCustomers'},true).vita('h4',{},true,' Customers').vita('i',{'clss':'icon-user icon-white'},false,'','first').novo('#dashboard .getCustomers','p',{},'Customer content text');
$welcome.novo('#dashboard .row-fluid:nth-child(3)','div',{clss:'span4 alert alert-info dash-module getInsurance'}).vita('h4',{},true,' Insurance').vita('i',{'clss':'icon-folder-open icon-white'},false,'','first').novo('#dashboard .getInsurance','p',{},'Insurance content text');
$welcome.novo('#dashboard','div',{clss:'row-fluid'});

//@fix: prevents the btn home click from loosing the events attached and the dashboard blocks
$('.getUser').click(function(){$.getJSON("json/profile.json",findJSON).fail(onVituim);});
$('.getGroup').click(function(){$.getJSON("json/group.json",findJSON).fail(onVituim);});
$('.getPerm').click(function(){$.getJSON("json/permission.json",findJSON).fail(onVituim);$('#nav-main #link_system').tab('show');$(".navLinks").removeClass('active');$("#nav_system").addClass('active');});
$('.system1,.getClient').click(function(){$.getJSON("json/client.json",findJSON).fail(onVituim);$('#nav-main #link_system').tab('show');$(".navLinks").removeClass('active');$("#nav_system").addClass('active');});
$('.getCustomers').click(function(){load_async('js/agito/customer.js',true,'end',true);$('#nav-main #link_customers').tab('show');$(".navLinks").removeClass('active');$("#nav_customers").addClass('active');});
$('.getInsurance').click(function(){load_async('js/agito/member.js',true,'end',true);$('#nav-main #link_insurance').tab('show');$(".navLinks").removeClass('active');$("#nav_insurance").addClass('active');});
SET_DB();
//@todo: test on a new DB if the menu link will appear.
$DB("SELECT name,code FROM dealers LIMIT 3",[],"",function(r,j){
   n='dealers';
   N=aNumero(n,true);
   $('#drop_'+n).empty();
   $('#btnSub'+N+'List').empty();
   $.each(j,function(i,v){
      $anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' oneDealer','data-iota':v[1]},false,v[0])
      $anima('#btnSub'+N+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'oneDealer','data-iota':v[1]},false,v[0])
   });
   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'allDealer','data-iota':'all'},false,'View All '+aNumero(n,true));
   $anima('#btnSub'+N+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'allDealer','data-iota':'all'},false,'View All '+aNumero(n,true));
   //AGITO
   $('.allDealer,.oneDealer').click(function(){$.getJSON("json/dealer.json",findJSON);$('#nav-main #link_dealers').tab('show');$(".navLinks").removeClass('active');$("#nav_dealers").addClass('active');});
});
$DB("SELECT firstname,lastname,code FROM salesmen LIMIT 3",[],"",function(r,j){
   n='salesman';
   N=aNumero(n,true);
   $('#drop_'+n).empty();
   $('#btnSub'+N+'List').empty();
   $.each(j,function(i,v){
      $anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' one'+N,'data-iota':v[1]},false,v[0])
      $anima('#btnSub'+N+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'one'+N,'data-iota':v[1]},false,v[0])
   });
   $anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'all'+N,'data-iota':'all'},false,'View All '+aNumero(n,true));
   $anima('#btnSub'+N+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'all'+N,'data-iota':'all'},false,'View All '+aNumero(n,true));
   //AGITO
   $('.allSalesman,.oneSalesman').click(function(){$.getJSON("json/salesman.json",findJSON);$('#nav-main #link_salesman').tab('show');$(".navLinks").removeClass('active');$("#nav_salesman").addClass('active');});
});




