/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var editor;
$(document).ready(function(){
//   if(CKEDITOR.instances['content']);
//   CKEDITOR.instances['content'].destroy(true);
});
   var Name=eternal.form.field.name;
   var collapseName="#acc_"+Name;
   var config={};
   config.removePlugins='savecontent';
   if(!editor)editor = CKEDITOR.replace('content',config,'');
   $(collapseName).on("shown",function(){
      if(!editor)editor = CKEDITOR.replace('content',config,'');
   });
   $(collapseName).on("hidden",function(){
      editor.destroy();editor=null;
   });






