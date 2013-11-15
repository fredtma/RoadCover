/*
 * script to execute on first page
 */
//LOGIN
//@todo: set the title on other tabs
timeFrame('Login');
//licentia();
roadCover = new SET_DISPLAY(dynamisGet("SITE_NAME",true),"",1);
roadCover.userLogin();
//============================================================================//SETUP
$('#sideNotice').append(creo({'clss':'db_notice'},'div'));
$('#sideNotice').append(creo({"id":"sys_msg"},'div','...'));
if(!window.openDatabase){$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').append('Your browser dooes not have support for websql,<br/> Recomended broswer for this application are Chrome, Opera and Safari');}
SET_DB();//@todo: regard pourquoi ce si coure deux foi.
//============================================================================//end
console.log('Cash::'+objectSize($.cache));
if(history.state)hasNarro=true;
//============================================================================//HISTORY EVENT
$(window).on('popstate',function(e){
   var narro = {},page,link=false;
   if(sessionStorage.narro)narro=JSON.parse(sessionStorage.narro);
   else return false;
   page = (history.state)?history.state.path:null;
   if(!page) return false;
//  console.log(narro,'narro',history.state, narro.table,page);
   narro=narro[history.state.path];
   if(narro.table) var set = narro.table.indexOf('#link_')!=-1?narro.table:"#link_"+narro.table;
   else var set = "#link_home";
   set = set.indexOf('salesmen')!=-1?'#link_salesman':set.indexOf('system')!=-1?'.system0':set;
//  console.log(narro,'narro2',narro.table,set,page);//@useful
   if(narro.store)page=narro.store;//when the key has changed use the stored key, which is also the filename
   if(narro.page) {if(narro.table){$(set).tab('show');$("#nav_"+narro.table).addClass('active'); link=true;} getPage(page,link);}
   else if (page) activateMenu(page,narro.table,set,narro.manus,narro.tab,narro.type);
});
//============================================================================//WORKERS.
(function(){
   if(window.Worker&&impetroUser()){
      var notitiaWorker=new Worker("js/bibliotheca/worker.notitia.js");
      (function(procus){var moli=screen.height*screen.width;
         if(procus){notitiaWorker.postMessage({"procus":procus.singularis,"moli":moli,"reprehendo":true});}
      })(impetroUser());
   }
   if(window.Worker&&impetroUser())readWorker(notitiaWorker);
})();