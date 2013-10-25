/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @see:res.forma 204, this script is no longer needed.
 */

$(document).ready(function(){
//   if(CKEDITOR.instances['content']);
//   CKEDITOR.instances['content'].destroy(true);
});
(function(){
   var editor;
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
})();





