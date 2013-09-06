/*
 * The worker file to process the DB
 */
importScripts('res.notitia.js');
var db,creoDB;
self.addEventListener('message',function(e){
   var data=e.data;
   if("novum" in data) {self.postMessage(data.novum);}
});


