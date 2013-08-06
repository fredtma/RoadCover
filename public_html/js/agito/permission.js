/*
 * single file for the permission page
 */

//$('#body article').on('click','#frm_permission #page',function(){console.log('Thank You Lord');});
//$('#body article').on('click','#frm_permission button[name^=default]',function(){$('#frm_permission #name').val($(this).val());});
$('#frm_permission #page').blur(function(){});
$('#frm_permission button[name^=default]').click(function(){txt=$('#frm_permission #page').val()+' '+$(this).val();console.log(txt);$('#frm_permission #name').val(txt);});


atest=function (){console.log('passing');};