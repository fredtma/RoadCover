/*
 * web workers function support with minimun cloning of original
 * @todo:version_db
 */
var set_version,db;
var SITE_MILITIA='http://197.96.139.19/minister/inc/notitia.php';
var SITE_SERVICE='http://197.96.139.19/minister/inc/services.php';
function $DB(_quaerere,params,_msg,callback,reading,_eternal){
   var res,Tau,ver={};
   var VERSION="2.95";
   if(!db)db=openDatabase("road_cover","","The internal DB version",15*1024*1024,function(){});
   if(db.version!=VERSION&&!set_version){
      ver.ver=VERSION;
      ver.revision={};
//@todo: implement db version change
//      db.changeVersion(db.version,VERSION,function(trans){version_db(db.version,ver,trans)},function(e){console.log(e.message)},function(e){console.log('PASSED');});
      set_version=true;
   }
   if(!reading){
      db.transaction(function(trans){
         trans.executeSql(_quaerere,params,function(trans,results){
            var j=$DB2JSON(results);
            if(_eternal){//@todo:eternal function
               res=_eternal.eternal;Tau=_eternal.Tau;var iyona=_eternal.iyona;
               get_ajax(SITE_MILITIA,{"eternal":res,"Tau":Tau,"iyona":iyona},'','post','json',function(j){});
            }
            if(callback)callback(results,j);
         },function(_trans,_error){
            _msg=_msg+"::"+_error.message;
         });
      });
   } else {
      db.readTransaction(function(trans){
         trans.executeSql(_quaerere,params,function(trans,results){
            var j=$DB2JSON(results);
            if(callback)callback(results,j);
         },function(_trans,_error){
            _msg=_msg+"::"+_error.message;
         });
      });
   }
}
//============================================================================//
function $DB2JSON(_results,_type){
   var j={},row,col,len,x,k;
   switch(_type){
      case 1:break;
      case 2:break;
      default:
         len=_results.rows.length;
         for(x=0;x<len;x++){
            row=_results.rows.item(x);
            col=0;
            for(k in row){row[col]=row[k];col++;}
            j[x]=row;
         }//endfor
         j['rows']={"length":len,"source":"generated"}
         break;
   }//endswith
   return j;
 }
//============================================================================//
function aSync(options,data,callback){//www, var, object, method, format, call_success
   var settings={"method":"post","format":"json"};

   if(typeof options === "object")for(var att in options)settings[att]=options[att];
   else {settings.www=options;settings.var=data;settings.callback=callback;}

   var xhr=new XMLHttpRequest();
   xhr.responseType=settings.format;
   xhr.open(settings.method,settings.www,true);
   xhr.onreadystatechange=function(e){
      if(this.readyState==4 && this.status==200){
         var response=this.response;
         if(typeof settings.callback==="function")settings.callback(response);
      }
   }
   if(settings.var&&typeof settings.var==="object") {
      var params=new FormData();
      for (var key in settings.var)params.append(key,settings.var[key]);
   }else{
      params=settings.var;
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//      xhr.setRequestHeader("Content-length", params.length);xhr.setRequestHeader("Connection","close");
   }
   xhr.onerror=function(e){e;}
   xhr.send(params);
}
//============================================================================//
function iyona(){
   var l=arguments.length;
   for(var x=0;x<l;x++)WORK.postMessage(arguments[x]);
}
//============================================================================//


