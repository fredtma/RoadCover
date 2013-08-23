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
function navig(set){
   if($(set).parents('li').hasClass('disabled')) return false;
   page=parseInt($(set).data('goto'))-1;
   if($(set).hasClass('navig'))page=parseInt($(set).data('goto'));//ca cest pour les navigation de deriere et en avant.
   sessionStorage.genesis=(page)*localStorage.DB_LIMIT;
   console.log(sessionStorage.genesis, typeof sessionStorage.genesis, 'sessionStorage.genesis', $(set).data('goto'));
   console.log(eternal.form.ortus,'eternal.form.ortus2');
   if(typeof eternal.form.ortus==="undefined"){creoDB=new SET_DB();creoDB.beta();}
   else if(eternal.form.ortus=="server"){theForm=new SET_FORM()._Set("#body article");theForm.setBeta(JSON.parse(sessionStorage.activeRecord));}
}
function navigTable(set){ console.log(eternal.form.ortus,'eternal.form.ortus3');
   if($(set).parents('li').hasClass('disabled')) return false;
   page=parseInt($(set).data('goto'))-1;//fait attention les page prev & next, il faut pas faire la subtraction
   if($(set).hasClass('navTable'))page=parseInt($(set).data('goto'));//ca cest pour les navigation de deriere et en avant.
   sessionStorage.genesis=(page)*localStorage.DB_LIMIT;
   theForm = new SET_FORM()._Set("#body article");//@todo: ajouter les nombre du total sur la navigation
   theForm.gammaTable(JSON.parse(sessionStorage.activeRecord));
}
//=============================================================================//
$('.btnUser,.profileList').click(function(){$.getJSON("json/profile.json",findJSON).fail(onVituim);});
$('.icon-users').click(function(){$.getJSON("json/group.json",findJSON).fail(onVituim);});
$('.system4,#btnSysPermission').click(function(){$.getJSON("json/permission.json",findJSON).fail(onVituim);});
$('#btnDashboard').click(function(){load_async('js/agito/dashboard.js',true,'end',true)});
//$('.system1,.getClient').click(function(){$.getJSON("json/client.json",findJSON).fail(onVituim);});
$('#link_customers').click(function(){load_async('js/agito/customer.js',true,'end',true)});
$('#link_insurance').click(function(){load_async('js/agito/member.js',true,'end',true)});
$('#btnFeatures').click(function(){activateMenu('features',false,false,false,true);});
$('#footContact').click(function(){getPage('Contact us')});
$('#footHelp').click(function(){getPage('Help?')});
$('#footAbout').click(function(){getPage('About us')});

$('#btnFullScreen,#fullscreen').click(function(){if(!$(this).data('toggle')||$(this).data('toggle')==0){$('#btnFullScreen,#fullscreen').data('toggle',1);enableFullScreen();$('.icon-fullscreen').removeClass('icon-fullscreen').addClass('icon-screenshot');}else{$('#btnFullScreen,#fullscreen').data('toggle',0);exitFullScreen();$('.icon-screenshot').removeClass('icon-screenshot').addClass('icon-fullscreen');}});
$('.icon-refresh').click(function(){
   history.go(0);
   tmp=sessionStorage.username;
   sessionStorage.clear();sessionStorage.runTime=0;sessionStorage.startTime=new Date().getTime();sessionStorage.username=tmp;
   $('footer').removeData();
   console.log('history:...');});//@todo:add HTML5 history API