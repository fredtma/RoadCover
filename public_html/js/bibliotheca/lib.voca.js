/*
 * vocation call to menu and pages
 * @see jquery|bootstrap.min|lib.muneris|res.lambda|res.forma|res.notitia|lib.ima.js
 */
addRecord=function(){
   name=eternal.form.field.name;
   d=-1;
   collapse_heade=$anima('#acc_'+name,'div',{'id':'accGroup'+d,'clss':'accordion-group'},'','before');
   collapse_heade.vita('div',{'clss':'accordion-heading','data-iota':d},true)
           .vita('a',{'clss':'headeditable','contenteditable':true},true,'Type '+name+' name here')
           .genesis('a',{'clss':'headeditable','contenteditable':true},true,'')
           .genesis('a',{'clss':'headeditable','contenteditable':true},true,'')
           .genesis('a',{'clss':'accordion-toggle','data-toggle':'collapse','data-parent':'#acc_'+name,'href':'#collapse_'+name+d,},true)
           .vita('i',{'clss':'icon icon-color icon-edit'}).child.onclick=edtRecord;
   collapse_heade.genesis('a',{'href':'#'},true)
           .vita('i',{'clss':'icon icon-color icon-trash'}).child.onclick=delRecord;
   collapse_content=$anima('#accGroup'+d,'div',{'clss':'accordion-body collapse','id':'collapse_'+name+d});
   collapse_content.vita('div',{'clss':'accordion-inner'},false,'Content');
}
edtRecord=function(){
//   creoDB.beta(3,_iota);
   ii=$(this).parents('div').data('iota');
   DB.beta(3,ii);
   $('.activeContent').removeClass('activeContent');
   $(this).parents('.accordion-group').find('.accordion-inner').addClass('activeContent');
}
delRecord=function(){
   ii=$(this).parents('div').data('iota');
   DB.beta(0,ii);
}
