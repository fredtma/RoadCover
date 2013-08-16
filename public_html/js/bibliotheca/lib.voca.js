/*
 * vocation call to menu and pages
 * @see jquery|bootstrap.min|lib.muneris|res.lambda|res.forma|res.notitia|lib.ima.js
 */
addRecord=function(){
   name=eternal.form.field.name;
   d=-1;
   r='_new'+Math.floor((Math.random()*100)+1);
   collapse_heade=$anima('#acc_'+name,'div',{'id':'accGroup'+d,'clss':'accordion-group'},'','first');
   collapse_heade.vita('div',{'clss':'accordion-heading','data-iota':d},true)
           .vita('a',{'clss':'betaRow','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r},true)
           .vita('span',{},false,'Type '+name+' name here');
           collapse_head.genesis('a',{'clss':'accordion-toggle','data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r,},true)
           .vita('i',{'clss':'icon icon-color icon-edit'});
   collapse_heade.genesis('a',{'href':'#'},true)
           .vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=delRecord;
            for(link in eternal.links){
               collapse_head.genesis('a',{'href':'#','clss':'forIcon'},true).vita('i',{'clss':'icon icon-black icon-link','title':'Link '+eternal.links[link][1]});
               $(collapse_head.child).data('ref',0);$(collapse_head.child).data('head',0);
               $(collapse_head.child).data('link',link);$(collapse_head.child).data('links',eternal.links[link]);
               $(collapse_head.child).click(function(){//@note: watchout for toggle, u'll hv to click twist if u come back to an other toggle.
                  $('.accordion-heading .icon-black').removeClass('icon-black').addClass('icon-color');$(this).removeClass('icon-color').addClass('icon-black');
                  if($(this).data('ref')!=0)linkTable($(this).data('head'), $(this).data('link'),$(this).data('links'),$(this).data('ref'));
                  else $('#displayMensa').empty();
               });
            }
   collapse_content=$anima('#accGroup'+d,'div',{'clss':'accordion-body collapse','id':'collapse_'+name+r,'data-iota':d});
   collapse_content.vita('div',{'clss':'accordion-inner'},false,'');
}
edtRecord=function(){ii=$(this).parents('div').data('iota');DB.beta(3,ii);$('.activeContent').removeClass('activeContent');$(this).parents('.accordion-group').find('.accordion-inner').addClass('activeContent');}
delRecord=function(){DB=new SET_DB();ii=$(this).parents('div').data('iota'); if(ii!=-1)DB.beta(0,ii);$(this).parents('.accordion-group').hide()}
loginValidation=function(){
   try{
      u=$('#loginForm #email').val();p=$('#loginForm #password').val();
      $DB("SELECT id FROM users WHERE password=? AND (email=? OR username=?)",[p,u,u],"Attempt Login",function(results){
         if(results.rows.length){$('#hiddenElements').modal('hide'); if($('#loginForm #remeberMe').val()==1)sessionStorage.username=u}
         else{$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('Failed login attempt...')}
      });
   }catch(err){console.log('ERROR::'+err.message)}
   return false;
}
enableFullScreen=function(elem){
   elem=elem||'fullBody';
   elem=document.getElementById(elem);
   if(elem.webkitRequestFullscreen){console.log('webKit FullScreen');elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);}
   else if(elem.mozRequestFullScreen){console.log('moz FullScreen');elem.mozRequestFullScreen();}
   else if(elem.requestFullscreen) {console.log('FullScreen');elem.requestFullscreen();}
   var fullscreenElement = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;//the element in fullscreen
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
}
exitFullScreen=function(){
   if(document.cancelFullScreen)document.cancelFullScreen();else if(document.mozCancelFullScreen)document.mozCancelFullScreen();else if(document.webkitCancelFullScreen)document.webkitCancelFullScreen();
   var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;//is the view in fullscreen?
   if(fullscreenEnabled){if(document.webkitExitFullscreen)document.webkitExitFullscreen();else if(document.mozCancelFullscreen)document.mozCancelFullscreen();else if(document.exitFullscreen)document.exitFullscreen();}
}

/*
    *
    * @param {integer} <var>_iota</var> the single indentifier
    * @param {string} <var>_mensa</var> the table name
    * @returns {undefined}
    */
sideDisplay=function(_iota,_mensa){
   var display=$('footer').data('display');var adrType;
   console.log(display,'display');
   if(typeof display!="undefined" || display==false){//pour aider le system a ne pas trop travailler
      if(display[0]==_iota&&display[1]==_mensa) return true;else $('footer').data('display',[_iota,_mensa]);
   }
   $('footer').data('header',true);console.log('Header set');
   if(_iota==0){
      $('#sideBot h3').html("Viewing all Current Members");$('.headRow').html(eternal.form.legend.txt);return true;//pour arreter le system de continuer
   }
   $('footer').data('display',[_iota,_mensa]);console.log(_iota,_mensa,display,'cherche a partir des donner',$('footer').data('display'));
   switch(_mensa){
      case 'dealers':
         get_ajax(localStorage.SITE_SERVICE,{"militia":_mensa+"-display",iota:_iota},null,'post','json',function(results){
            //change la list du menu et du button avec les dernier donner
            $("#drop_"+_mensa+" .oneDealer").last().parent().remove();$("#btnSubDealersList .oneDealer").last().parent().remove();
            $anima("#drop_"+_mensa,"li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-"+_mensa,"clss":"oneDealer","data-iota":_iota},false,aNumero(results.company[0].Name,true)).father.onclick=function(){activateMenu('dealer','dealers',this)}
            $anima("#tab-customers #btnSubDealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(results.company[0].Name,true)).father.onclick=function(){activateMenu('customer','customers',this,true,'dealers')}
            $anima("#tab-insurance #btnSubDealersList ","li",{},false,'first').vita("a",{"clss":"oneDealer","data-iota":_iota},false,aNumero(results.company[0].Name,true)).father.onclick=function(){activateMenu('member','insurance',this,true,'dealers')}
            $('#displayMensa').empty();
            if(typeof results.company[0]!="undefined"&&results.company[0]!=null)$('#sideBot h3').html(aNumero(results.company[0].Name,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof results.company[0]!="undefined"&&results.company[0]!=null)?"Customers under "+results.company[0].Name:eternal.form.legend.txt;
            $('.headRow').html(title);
            $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/LocalBusiness","itemscope":""});
            for(key in results.address){
               switch(results.address[key].Type){
                  case 'Dns.Sh.AddressBook.EmailAddress':if(results.address[key].Address)$sideDisplay.novo('#displayList','dt',{},'Email').genesis('dd',{'itemprop':'email'},false).child.innerHTML="<a href='mailto:"+results.address[key].Address+"' target='_blank'>"+results.address[key].Address+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FaxNumber':$sideDisplay.novo('#displayList','dt',{},'Fax').genesis('dd',{"itemprop":"faxNumber"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'>"+'('+results.address[key].AreaCode+')'+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FixedLineNumber':$sideDisplay.novo('#displayList','dt',{},'Tel').genesis('dd',{"itemprop":"telephone"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'> "+'('+results.address[key].AreaCode+')'+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.MobileNumber':$sideDisplay.novo('#displayList','dt',{},'Cell').genesis('dd',{"itemprop":"cellphone"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'>"+results.address[key].AreaCode+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.PostalAddress': adrType='Postal';
                  case 'Dns.Sh.AddressBook.PhysicalAddress':
                     $sideDisplay.novo('#displayList','dt',{},'Address '+adrType).genesis('dd',{},false,results.address[key].Line1);
                     if(results.address[key].Line2!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Line2);
                     if(results.address[key].UnitName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].UnitName);
                     if(results.address[key].UnitNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].UnitNumber);
                     if(results.address[key].StreetName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].StreetName);
                     if(results.address[key].StreetNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].StreetNumber);
                     if(results.address[key].Province_cd!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Province_cd);
                     if(results.address[key].Suburb!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Suburb);
                     if(results.address[key].City!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].City);
                     if(results.address[key].Code!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Code);
                     break;
               }//end swith
            }//end for
         });
         break;
      case 'salesmen':
         get_ajax(localStorage.SITE_SERVICE,{"militia":"salesman-display",iota:_iota},null,'post','json',function(results){
            //change la list du menu et du button avec les dernier donner
            $("#drop_salesman"+" .oneSalesman").last().parent().remove();$("#btnSubSalesmanList .oneSalesman").last().parent().remove();
            $anima("#drop_salesman","li",{},false,'first').vita("a",{"data-toggle":"tab","href":"#tab-salesman","clss":"oneSalesman","data-iota":_iota},false,aNumero(results.agent[0].FullNames+' '+results.agent[0].Surname,true)).father.onclick=function(){activateMenu(_mensa,'salesmen',this)};
            $anima("#tab-customers #btnSubSalesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(results.agent[0].FullNames+' '+results.agent[0].Surname,true)).father.onclick=function(){activateMenu('customer','customers',this,true,'salesmen')}
            $anima("#tab-insurance #btnSubSalesmanList ","li",{},false,'first').vita("a",{"clss":"oneSalesman","data-iota":_iota},false,aNumero(results.agent[0].FullNames+' '+results.agent[0].Surname,true)).father.onclick=function(){activateMenu('member','insurance',this,true,'salesmen')}
            $('#displayMensa').empty();
            if(typeof results.agent!="undefined"&&results.agent!=null)$('#sideBot h3').html(aNumero(results.agent[0].FullNames+' '+results.agent[0].Surname,true)+' details');
            else if(eternal.mensa==="members")$('#sideBot h3').html("Current Members");
            title=(typeof results.agent!="undefined"&&results.agent!=null)?"Customers under "+results.agent[0].FullNames+' '+results.agent[0].Surname:eternal.form.legend.txt;
            $('.headRow').html(title);
            $sideDisplay=$anima('#displayMensa','dl',{"clss":"dl-horizontal","id":"displayList","itemtype":"http://schema.org/Person","itemscope":""});
            $sideDisplay.novo('#displayList','dt',{},'ID').genesis('dd',{},false,results.agent[0].IdentificationNumber);
            for(key in results.address){
               switch(results.address[key].Type){
                  case 'Dns.Sh.AddressBook.EmailAddress':if(results.address[key].Address)$sideDisplay.novo('#displayList','dt',{},'Email').genesis('dd',{'itemprop':'email'},false).child.innerHTML="<a href='mailto:"+results.address[key].Address+"' target='_blank'>"+results.address[key].Address+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FaxNumber':$sideDisplay.novo('#displayList','dt',{},'Fax').genesis('dd',{"itemprop":"faxNumber"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'>"+'('+results.address[key].AreaCode+')'+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.FixedLineNumber':$sideDisplay.novo('#displayList','dt',{},'Tel').genesis('dd',{"itemprop":"telephone"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'> "+'('+results.address[key].AreaCode+')'+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.MobileNumber':$sideDisplay.novo('#displayList','dt',{},'Cell').genesis('dd',{"itemprop":"cellphone"},false).child.innerHTML="<a href='tel:"+results.address[key].AreaCode+results.address[key].Number+"'>"+results.address[key].AreaCode+results.address[key].Number+"</a>"; break;
                  case 'Dns.Sh.AddressBook.PostalAddress': adrType='Postal';
                  case 'Dns.Sh.AddressBook.PhysicalAddress':
                     $sideDisplay.novo('#displayList','dt',{},'Address '+adrType).genesis('dd',{},false,results.address[key].Line1);
                     if(results.address[key].Line2!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Line2);
                     if(results.address[key].UnitName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].UnitName);
                     if(results.address[key].UnitNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].UnitNumber);
                     if(results.address[key].StreetName!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].StreetName);
                     if(results.address[key].StreetNumber!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].StreetNumber);
                     if(results.address[key].Province_cd!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Province_cd);
                     if(results.address[key].Suburb!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Suburb);
                     if(results.address[key].City!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].City);
                     if(results.address[key].Code!='')$sideDisplay.novo('#displayList','dt',{},'').genesis('dd',{},false,results.address[key].Code);
                     break;
               }//end swith
            }//end for
         });
         break;
   }//switch
}
//=============================================================================//
$('.btnUser,.profileList').click(function(){$.getJSON("json/profile.json",findJSON).fail(onVituim);});
$('.icon-users').click(function(){$.getJSON("json/group.json",findJSON).fail(onVituim);});
$('.system4,#btnSysPermission').click(function(){$.getJSON("json/permission.json",findJSON).fail(onVituim);});
$('#btnDashboard').click(function(){load_async('js/agito/dashboard.js',true,'end',true)});
//$('.system1,.getClient').click(function(){$.getJSON("json/client.json",findJSON).fail(onVituim);});
$('#link_customers').click(function(){load_async('js/agito/customer.js',true,'end',true)});
$('#link_insurance').click(function(){load_async('js/agito/member.js',true,'end',true)});


$('#btnFullScreen,#fullscreen').click(function(){if(!$(this).data('toggle')||$(this).data('toggle')==0){$('#btnFullScreen,#fullscreen').data('toggle',1);enableFullScreen();$('.icon-fullscreen').removeClass('icon-fullscreen').addClass('icon-screenshot');}else{$('#btnFullScreen,#fullscreen').data('toggle',0);exitFullScreen();$('.icon-screenshot').removeClass('icon-screenshot').addClass('icon-fullscreen');}});
$('.icon-refresh').click(function(){
   history.go(0);
   tmp=sessionStorage.username;
   sessionStorage.clear();sessionStorage.runTime=0;sessionStorage.startTime=new Date().getTime();sessionStorage.username=tmp;
   $('footer').removeData();
   console.log('history:...');});//@todo:add HTML5 history API