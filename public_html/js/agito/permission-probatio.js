$('#page').blur(function(){$('#name').val($(this).val()); $('#desc').val("Permission to access the "+$(this).val()+" features"); });
if(!$('#frm_permission').data('jesua'))$('.frm_permission_default').hide();
if($('#frm_permission').data('jesua'))$('.frm_permission_default').show();
$('#frm_permission').submit(function(){setTimeout(function(){
   if($('#frm_permission').data('jesua')){$('.frm_permission_default').show();}
},100)});

$('.frm_permission_default button').click(function(){
   var n = $('#page').val()+' '+$(this).val();
   var d = 'Permission to '+$(this).val()+' '+$('#page').val();
   if(!$(this).data('toggle')||$(this).data('toggle')==0){$(this).data('toggle',1);theForm.newTableRow({"name":n,"desc":d,"page":n},'permissions',true);}
   else{$(this).data('toggle',0);$(this).removeClass('active');}
});
