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
           .vita('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r},true,'Type '+name+' name here')
           .genesis('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r},true,'')
           .genesis('a',{'clss':'headeditable','contenteditable':false,'data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r},true,'')
           .genesis('a',{'clss':'accordion-toggle','data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+r,},true)
           .vita('i',{'clss':'icon icon-color icon-edit'});
   collapse_heade.genesis('a',{'href':'#'},true)
           .vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=delRecord;
   collapse_content=$anima('#accGroup'+d,'div',{'clss':'accordion-body collapse','id':'collapse_'+name+r,'data-iota':d});
   collapse_content.vita('div',{'clss':'accordion-inner'},false,'');
}
edtRecord=function(){ii=$(this).parents('div').data('iota');DB.beta(3,ii);$('.activeContent').removeClass('activeContent');$(this).parents('.accordion-group').find('.accordion-inner').addClass('activeContent');}
delRecord=function(){DB=DB||new SET_DB();ii=$(this).parents('div').data('iota');DB.beta(0,ii);$(this).parents('.accordion-group').hide()}
$('.btnUser,.icon-user,.profileList').click(function(){$.getJSON("json/profile.json",findJSON);});
$('.icon-users').click(function(){$.getJSON("json/group.json",findJSON);});
loginValidation=function(){
   try{
      u=$('#loginForm #email').val();
      p=$('#loginForm #password').val();
      DB=new SET_DB();
      console.log(p+'-'+u);
      $DB("SELECT id FROM users WHERE password=? AND (email=? OR username=?)",[p,u,u],"Attempt Login",function(results){
         if(results.rows.length){$('#hiddenElements').modal('hide');}
         else{$('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('Failed login attempt...')}
      });
   }catch(err){console.log('ERROR::'+err.message)}
   return false;
}

