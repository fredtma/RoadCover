(function(){
   //Section 1 : Code to execute when the toolbar button is pressed
   var a= {
      exec:function(editor){
         /*
         var theSelectedText = editor.getSelection().getNative();
         CallCfWindow(theSelectedText);*/
         editor.destroy();
         saveData();
      }
   },
   //Section 2 : Create the button and add the functionality to it
   b='savecontent';
   CKEDITOR.plugins.add(b,{
      init:function(editor){
         editor.addCommand(b,a);
         editor.ui.addButton('savecontent',{
            label:'Save Content',
            icon: '../../../img/save.png',
            command:b
         });
      }
   });
})();