chrome.app.runtime.onLaunched.addListener(function(){
   chrome.app.window.create('index.html',{
      'bounds':{
         'width':1600,
         'height':1024
      },
      minWidth:800, minHeight:600
   });
});