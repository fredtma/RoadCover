/*
 * The worker file to process the DB
 */
importScripts('parva.muneris.js');
var db,creoDB;
var WORK = self;
self.addEventListener('message',function(e){
   var data=e.data,isLecentia=false;
   if("novum" in data) {self.postMessage(data.novum);}
   else if("procus" in data) {
      aSync(SITE_SERVICE,"militia=ipse&ipse="+data.procus+"&moli="+data.moli,function(result){
         if(typeof result!=="object"){iyona("Not result found.");return false;}
         iyona(result);
         for(var mensa in result){
            for(var ver in result[mensa]){
               var quaerere=[],params=[],set=[],actum,jesua,trans,field;
               for(trans in result[mensa][ver]) break;
               for(field in result[mensa][ver][trans]){if(field=='id')continue;
                  quaerere.push('`'+field+'`');params.push(result[mensa][ver][trans][field]);set.push('?');
                  jesua=result[mensa][ver][trans]['jesua']}
               switch(trans){
                  case "1":actum='INSERT INTO '+mensa+' ('+quaerere.join()+')VALUES('+set.join()+')';break;
                  case "2":actum='UPDATE '+mensa+' SET '+quaerere.join('=?,')+'=? WHERE jesua=?';params.push(jesua);break;
               }//endswitch
               var eternal="eternal[ver]="+ver+"&eternal[user]="+data.procus+"&eternal[DEVICE]="+data.moli+"&iyona=version_control&Tau=Alpha&procus=0";
               $DB(actum,params,"Synced "+mensa,function(result,j){},false,eternal);
               switch(isLecentia){case'link_permissions_groups':case'link_permissions_users':isLecentia=true;break;}
            }//for ver
            if(isLecentia)WORK.postMessage('licentia');//run the permission function
         }//endfor mensa in result
      });//aSync
   }//if procus in data
});//evenlistener for message


