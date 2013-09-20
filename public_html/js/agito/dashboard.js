/*
 * creates the dashboard on the home page
 */
(theDashboard=function(){
   newSection();//rest #body, button, pagination
   if(history.state&&history.state.path=='dashboard')hasNarro=false;
   if(!sessionStorage.narro)hasNarro=false;
   //console.log('consolidates',hasNarro,history.state,sessionStorage.narro);
   if(hasNarro===false){
      $welcome=$anima('#body article','div',{'id':'dashboard'}).vita('div',{clss:'row-fluid'},true);
      $welcome.vita('div',{clss:'span4 alert alert-info dash-module getUser',"href":"#tab-home"},true).vita('h4',{},true,' Administrators ').vita('i',{'clss':'icon-user icon-white'},false,'','first').novo('#dashboard .getUser','p',{},'users content text');
      $welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getGroup',"href":"#tab-home"}).vita('h4',{},true,' Groups').vita('i',{'clss':'icon icon-white icon-users'},false,'','first').novo('#dashboard .getGroup','p',{},'groups content text');
      $welcome.novo('#dashboard .row-fluid:nth-child(1)','div',{clss:'span4 alert alert-info dash-module getPerm',"href":"#tab-system"}).vita('h4',{},true,' Permissions').vita('i',{'clss':'icon-pencil icon-white'},false,'','first').novo('#dashboard .getPerm','p',{},'permission content text');
      $welcome.novo('#dashboard','div',{clss:'row-fluid'});
      $welcome.vita('div',{clss:'span4 alert alert-info dash-module getClient',"href":"#tab-system"},true).vita('h4',{},true,' Clients').vita('i',{'clss':'icon-qrcode icon-white'},false,'','first').novo('#dashboard .getClient','p',{},'clients content text');
      $welcome.novo('#dashboard .row-fluid:nth-child(2)','div',{clss:'span4 alert alert-info dash-module getDealer',"href":"#tab-dealers"}).vita('h4',{},true,' Dealers').vita('i',{'clss':'icon-book icon-white'},false,'','first').novo('#dashboard .getDealer','p',{},'Dealers content text');
      $welcome.novo('#dashboard .row-fluid:nth-child(2)','div',{clss:'span4 alert alert-info dash-module getSalesman',"href":"#tab-salesman"}).vita('h4',{},true,' Salesmen').vita('i',{'clss':'icon-briefcase icon-white'},false,'','first').novo('#dashboard .getSalesman','p',{},'Salesmen content text');
      $welcome.novo('#dashboard','div',{clss:'row-fluid'});
      $welcome.vita('div',{clss:'span4 alert alert-info dash-module getCustomers',"href":"#tab-customers"},true).vita('h4',{},true,' Customers').vita('i',{'clss':'icon-user icon-white'},false,'','first').novo('#dashboard .getCustomers','p',{},'Customer content text');
      $welcome.novo('#dashboard .row-fluid:nth-child(3)','div',{clss:'span4 alert alert-info dash-module getInsurance',"href":"#tab-insurance"}).vita('h4',{},true,' Insurance').vita('i',{'clss':'icon-folder-open icon-white'},false,'','first').novo('#dashboard .getInsurance','p',{},'Insurance content text');
      $welcome.novo('#dashboard','div',{clss:'row-fluid'});

      //@fix: prevents the btn home click from loosing the events attached and the dashboard blocks
      $('.getUser').click(function(){activateMenu('profile','home',this);});
      $('.getGroup').click(function(){activateMenu('group','home',this);});
      $('.getPerm').click(function(){activateMenu('permission','system',this);});
      $('.getClient').click(function(){activateMenu('client','system',this);});
      $('.getDealer').click(function(){activateMenu('dealer','dealers',this);});
      $('.getSalesman').click(function(){activateMenu('salesman','salesmen',this);});
      $('.getCustomers').click(function(){activateMenu('customer','customers',this,true);});
      $('.getInsurance').click(function(){activateMenu('member','insurance',this,true);});
      delete $welcome;
   }
})();