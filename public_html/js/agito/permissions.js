/*
 * single file for the permission page
 */

document.querySelector('#frm_permission #page').onclick=function(){console.log('thank you Jesus')};
//$('#body article').on('click','#frm_permission #page',function(){console.log('Thank You Lord');});
//$('#body article').on('click','#frm_permission button[name^=default]',function(){$('#frm_permission #name').val($(this).val());});
$('#frm_permission #page').blur(function(){txt=$('#frm_permission #name').val()+' '+$(this).val();$('#frm_permission #name').val(txt)});


atest=function (){console.log('passing');};