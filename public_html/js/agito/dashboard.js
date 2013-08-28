/*
 * creates the dashboard on the home page
 */
$('#body article').empty();
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
$('.system1,.getClient').click(function(){activateMenu('client','system',this);});
$('.getDealer').click(function(){activateMenu('dealer','dealers',this);});
$('.getSalesman').click(function(){activateMenu('salesman','salesmen',this);});
$('.getCustomers').click(function(){activateMenu('customer','customers',this,true);});
$('.getInsurance').click(function(){activateMenu('member','insurance',this,true);});
if(!window.openDatabase){$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').append('Your browser dooes not have support for websql,<br/> Recomended broswer for this application are Chrome, Opera and Safari');}
SET_DB();//@todo: regard pourquoi ce si coure deux foi.
if(!sessionStorage.lecentia)licentia(localStorage.USER_NAME);//si il'ya pas de session pour l'utilisateur
//@todo: test on a new DB if the menu link will appear.
$DB("SELECT name,code FROM dealers LIMIT 3",[],"",function(r,j){
   n='dealers';
   N=aNumero(n,true);
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
   n='salesman';
   N=aNumero(n,true);
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
/*
 * function to activate the dashboard blocks and links of the navTab
 */
function activateMenu(_mensa,_mensula,_set,_script,_tab){
   _mensula=_mensula||_mensa;
   iota=$(_set).data('iota');
   if(!_script)$.getJSON("json/"+_mensa+".json",findJSON).fail(onVituim);//avec json
   else load_async("js/agito/"+_mensa+".js",true,'end',true);//sans json mait avec une script
   if(_mensa=='salesman')_mensula='salesman';//ce si cest pour les sales seulment
   if(!_tab){console.log(_set,'_set');
      $(_set).tab('show');
      $(".navLinks").removeClass('active');
      $("#nav_"+_mensula).addClass('active');}//montre la tab et le menu
   else{
      _mensula=_tab;
      if(iota!=0)$('footer').data('temp',[iota,_tab])//montre seulment les list qui on des uniter iota
      else {$('footer').removeData('temp');$('footer').removeData('display');}//change les deux, pour raison de afficher un neauvaux titre
   }//change de nom pour les button, pour avoir access aux menu des dealer & des salesman
   if(_mensa=='salesman')_mensula='salesmen';
   if(iota){sideDisplay(iota,_mensula);}//fair apparaitre la table si une existance de parametre iota exists.
}