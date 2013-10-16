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
onShowForm();
   $('.frm_permission_default button').click(function(){//@note: moving the function in onShowForm() will make the function execute x2
      var n = $('#page').val()+' '+$(this).val();
      var d = 'Permission to '+$(this).val()+' '+$('#page').val();
      var set=this;
      if(!$(this).data('toggle')||$(this).data('toggle')==0){$(this).data('toggle',1);theForm.newTableRow({"name":n,"desc":d,"page":n},'permissions',true);}
      else{$(this).data('toggle',0);setTimeout(function(){$(set).removeClass('active').blur();},500);}
   });
