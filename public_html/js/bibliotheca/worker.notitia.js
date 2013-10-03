/*
 * The worker file to process the DB
 */
importScripts('parva.muneris.js');
var db,creoDB;
var WORK = self;
self.addEventListener('message',function(e){
   var data=e.data;
   if("novum" in data) {self.postMessage(data.novum);}
   else if("procus" in data) {
      aSync(SITE_SERVICE,"militia=ipse&ipse="+data.procus+"&moli="+data.moli,function(result){
         iyona(result);
      });
   }
});


