onShowForm=function(){
   var found=$('#frm_permission').data('jesua');found=found=='alpha'?false:found;
   $('#page').blur(function(){$('#name').val($(this).val()); if(!$('#desc').val()&&$(this).val())$('#desc').val("Permission to access the "+$(this).val()+" features"); });
   if(!found)$('.frm_permission_default').hide();
   else $('.frm_permission_default').show();
   $('#frm_permission').submit(function(){setTimeout(function(){
      found=$('#frm_permission').data('jesua');found=found=='alpha'?false:found;
      if(found){$('.frm_permission_default').show();}
   },100)});
};
//$("#acc_"+eternal.form.field.name).on("shown",function(){onShowForm();});onShowForm();
onShowForm();
document.querySelector('#frm_permission').addEventListener("onShowForm",onShowForm,false);
$('.frm_permission_default button').click(function(){
   var n = $('#page').val()+' '+$(this).val();
   var d = 'Permission to '+$(this).val()+' '+$('#page').val();
   if(!$(this).data('toggle')||$(this).data('toggle')==0){$(this).data('toggle',1);theForm.newTableRow({"name":n,"desc":d,"page":n},'permissions',true);}
   else{$(this).data('toggle',0);$(this).removeClass('active');}
});