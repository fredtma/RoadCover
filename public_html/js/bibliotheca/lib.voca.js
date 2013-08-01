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
//=============================================================================//
$('.btnUser,.icon-user,.profileList').click(function(){$.getJSON("json/profile.json",findJSON);});
$('.icon-users').click(function(){$.getJSON("json/group.json",findJSON);});
$('.system4,#btnSysPermission').click(function(){$.getJSON("json/permission.json",findJSON);});
$('#btnFullScreen,#fullscreen').click(function(){if(!$(this).data('toggle')||$(this).data('toggle')==0){$('#btnFullScreen,#fullscreen').data('toggle',1);enableFullScreen();$('.icon-fullscreen').removeClass('icon-fullscreen').addClass('icon-screenshot');}else{$('#btnFullScreen,#fullscreen').data('toggle',0);exitFullScreen();$('.icon-screenshot').removeClass('icon-screenshot').addClass('icon-fullscreen');}});
