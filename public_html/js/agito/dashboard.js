/*
 * creates the dashboard on the home page
 */
$('#body article').empty();
$welcome=$anima('#body article','div',{'id':'dashboard'}).vita('div',{clss:'row-fluid'},true);
$welcome.vita('div',{clss:'span4 alert alert-info dash-module getUser'},true).vita('h4',{},true,' Administrators ').vita('i',{'clss':'icon-user icon-white'},false,'','first').novo('#dashboard .getUser','p',{},'users content text');
$welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getGroup'}).vita('h4',{},true,' Groups').vita('i',{'clss':'icon icon-white icon-users'},false,'','first').novo('#dashboard .getGroup','p',{},'groups content text');
$welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getPerm'}).vita('h4',{},true,' Permissions').vita('i',{'clss':'icon-pencil icon-white'},false,'','first').novo('#dashboard .getPerm','p',{},'groups content text');
$welcome.novo('#dashboard','div',{clss:'row-fluid'});
$welcome.vita('div',{clss:'span4 alert alert-info dash-module getClient'},true).vita('h4',{},true,' Clients').vita('i',{'clss':'icon-qrcode icon-white'},false,'','first').novo('#dashboard .getClient','p',{},'clients content text');
//@fix: prevents the btn home click from loosing the events attached.
//$('.btnUser,.profileList,.getUser').click(function(){$.getJSON("json/profile.json",findJSON);});
//$('.icon-users,.getGroup').click(function(){$.getJSON("json/group.json",findJSON);});
//$('.system4,#btnSysPermission,.getPerm').click(function(){$.getJSON("json/permission.json",findJSON);});
//$('#btnDashboard').click(function(){load_async('js/agito/dashboard.js',true,'end',true)});
//$('.system1,.getClient').click(function(){$.getJSON("json/client.json",findJSON);});
//$('#link_customers').click(function(){load_async('js/agito/member.js',true,'end',true)});

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
   $('.allDealer,.oneDealer').click(function(){$.getJSON("json/dealer.json",findJSON)});
});
SET_DB();



