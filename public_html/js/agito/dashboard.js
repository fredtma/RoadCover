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
$('.btnUser,.icon-user,.profileList,.getUser').click(function(){$.getJSON("json/profile.json",findJSON);});
$('.icon-users,.getGroup').click(function(){$.getJSON("json/group.json",findJSON);});
$('.system4,#btnSysPermission,.getPerm').click(function(){$.getJSON("json/permission.json",findJSON);});
$('.system1,.getClient').click(function(){$.getJSON("json/client.json",findJSON);});



