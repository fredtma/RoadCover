/*
 * notitia object for creating connection to the local db
 * @uses jquery|lib.muneris
 */

/******************************************************************************/
/* @author fredtma
 * @version 2.9
 * @category dynamic, menu, object, databse
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @return object
 * @todo: add a level three menu step
 * @see: placeObj
 */
function SET_DB(_reset){
   var SET=this;eternal=eternalCall();
   if(eternal){this.name=eternal.form.field.name;
      this.frmName='frm_'+this.name;
      this.frmID='#frm_'+this.name;}
   this.mensaActive=['users,groups,link_users_groups'];
   this.basilia={};
   this.reset=_reset||false;
   var Tau=false,res;
   this.patterns=JSON.parse(localStorage.EXEMPLAR);
   this.creoAgito=function(_quaerere,_params,_msg,callback){
      var quaerere=_quaerere;
      var msg=_msg;
      var params=_params||[];
//      if(!db) db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      db.transaction(function(trans){
         trans.executeSql(quaerere,params,function(trans,results){
            if(msg)console.log('%c Success DB transaction: '+msg, 'background:#222;color:#48b72a;width:100%;');
            console.log('%c'+quaerere,'background:#222;color:#48b72a;width:100%;font-weight:bold;',params);
            var j=$DB2JSON(results);
            if(msg)$('#sideNotice .db_notice').html("Successful: "+msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            if(Tau){
               var procus=localStorage.USER_NAME?JSON.parse(localStorage.USER_NAME):JSON.parse(sessionStorage.USER_NAME);
               var moli=screen.height*screen.width;
               console.log(moli,"/",screen.height,"/",screen.width);
               this.basilia={"eternal":res,"Tau":Tau,"iyona":iyona,"procus":procus.singularis,"moli":moli};
               get_ajax(localStorage.SITE_MILITIA,this.basilia,'','post','json',function(j){console.log(j,'Online');$('#sys_msg').html(j.msg) });Tau=false;
            }
            if(callback)callback(results);
         },function(_trans,_error){
            console.log('Failed DB: '+msg+':'+_error.message);
            console.log('%c ::QUAERERE='+quaerere, 'background:#222;color:#ff0000;font-weight:bold;');
            $('#sideNotice .db_notice').html("<div class='text-error'>"+_error.message+'</div>');
         });
      });
   }
   /*
    * this function will extract info from the form and determine the form action
    * @param {string} _form the name of the form to be setup
    * @param {string} _mensa table name, takent from _form if not mensioned
    * @param {integer} _actum transaction type to remove the record
    * @returns void
    * @todo clean it up
    */
   this.forma=function(_actum,_jesua,callback){
      var precipio='';var actum,ubi,msg,val,alpha;
      var quaerere=[],params=[],set=[];
      var limit=1000;//localStorage.DB_LIMIT||7;
      if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active); else eternal=null;
      if(!eternal){console.log("not found json");return false;}
      var form='#frm_'+eternal.form.field.name;
      var t = new Date().format('isoDateTime');
      var jesua=_jesua;res={"blossom":{"delta":"!@=!#"},"modified":t};
      iyona=eternal.mensa||form.substr(4);
      if(!this.mensaActive.indexOf(iyona)){console.log("not found mensa");return false;}//@todo: arrange et ajoute la securiter
      //======================================================================//GET FIELDS
      if(_actum!==0){
         $('.control-group.error').removeClass('error');$('.error-block').remove();
         $.each(eternal.fields,function(field,properties){
            if(properties.source=='custom') return true;//skip the custom field
            if(properties.field.type=='editor'&&(_actum==2||_actum==1)){val=CKEDITOR.instances[field].getData();}
            else val=$(form+' #'+field).val()||$(form+' [name^='+field+']:checked').val()||$(form+' .active[name^='+field+']').val()||properties.field.value;//field,check,active
            alpha=alpha||val;//la premiere donner pour cree une donner pour jesua
            if(_actum!=3&&typeof _actum!=="undefined"&&_actum){
               if(SET.sanatio(val,field,properties)===false){quaerere=[];return false;}
               if(properties.field.type=='password'&&(_actum==2||_actum==1)){val=md5($(form+' #'+field).val())}
               params.push(val);res[field]=val;set.push("?");
            }
            quaerere.push('`'+field+'`');
         });
         if(quaerere.length==0)return false;//pas de donner trouver, surment une erreur de value
      }//endif_actum!=0
      //======================================================================//
      switch(_actum){
         case 0:
            this.constraintForeignKey(_jesua,iyona);
            actum='DELETE FROM '+iyona+' WHERE jesua=?';
            Tau='oMegA';res['blossom']['alpha']=jesua;
            var creoAgito=this.creoAgito;
            setTimeout(function(){creoAgito(actum,[_jesua],'Deleted record from '+iyona,callback)},15);break;
         case 1:
            var r=Math.floor((Math.random()*179)+1);
            alpha=md5(alpha+t+r);
            quaerere.push('jesua');set.push('?');params.push(alpha);
            quaerere.push('modified');set.push('?');params.push(t);
            $('footer').data('jesua',alpha);//@see: insert it replacesinsertId
            Tau='Alpha';res['blossom']['alpha']=alpha;res['creation']=t;
            actum='INSERT INTO '+iyona+' ('+quaerere.join()+')VALUES('+set.join()+')';
            msg='record added to '+iyona;break;
         case 2:
            val=$(form+' #name').val()||$(form+' #username').val();//get the reference field
            if(val)this.constraintForeignKey(_jesua,iyona,val);//update reference field
            Tau='deLta';res['blossom']['alpha']=jesua;
            actum='UPDATE '+iyona+' SET '+quaerere.join('=?,')+'=? WHERE jesua=?';params.push(jesua);
            msg='record updated in '+iyona;break;
         case 3:
         default:
            params=[];
            ubi=('quaerere' in eternal && 'ubi' in eternal.quaerere)?eternal.quaerere.ubi:'';//wen there is a physical search included
            precipio=('quaerere' in eternal&&'precipio' in eternal.quaerere&&eternal.quaerere.precipio)?" ORDER BY "+eternal.quaerere.precipio:'';//wen there is an order
            if(jesua){
               params.push(jesua);
               ubi=' WHERE jesua=? '+ubi+' '+precipio+' LIMIT '+limit;
            }else{
               ubi=' WHERE 1=1 '+ubi+' '+precipio+' LIMIT '+limit;//ADD the where clasue in both
            }
            quaerere.push('jesua');quaerere.push('id');
            actum='SELECT '+quaerere.join()+' FROM '+iyona+ubi;
            msg='Selected '+iyona;break;
      }
      if(quaerere.length>0)this.creoAgito(actum,params,msg,callback);
   }
   /*
    * the successful return function
    * @see this.forma
    */
   this.alpha=function(_actum,_jesua,_spicio){
      var display,name,row,ii,len,x,first;
      eternal=eternalCall();
      if(!eternal){console.log("not found json");return false;}
      this.name=eternal.form.field.name;
      this.frmName='frm_'+eternal.form.field.name;
      this.frmID='#frm_'+eternal.form.field.name;
      this.forma(_actum,_jesua,function(results){
         iyona=eternal.mensa||SET.frmID.substr(4);
         display=$('#displayMensa');
         var $display;
//         jesua=results.insertId?results.insertId:$(form).data('jesua');
         len=results.rows.length;
         //ASIDE
         if(display.data('mensa')!=iyona){
            display.data('mensa',iyona);//prevent this to fill with the same data table list
            for(x=0;x<len;x++){
               name='';
               row=results.rows.item(x);
               name=SET.fieldDisplay('row',row,true).join(' ');
               $display=$anima('#displayMensa','li',{'data-jesua':row['jesua']}).vita('a',{'href':'javascript:void(0)'},false,name);
               $display.child.onclick=function(e){e.preventDefault();ii=$(this).parent().data('jesua');SET.alpha(3,ii);}
               $display.vita('a',{'href':'#'},true).vita('i',{'clss':'icon icon-color icon-trash'})
                  .child.onclick=function(e){e.preventDefault();ii=$(this).parents('li').data('jesua');SET.alpha(0,ii);$(this).parents('li').hide();}
            }//endfor
            $('#sideBot h3').click(function(e){
               e.preventDefault();
               resetForm(document.getElementById(SET.frmName));
               for (first in eternal.fields)break;
               $(SET.frmID+' #'+first).focus();$(SET.frmID).data('jesua',0);
               $(SET.frmID+' #submit_'+SET.name)[0].onclick=function(e){e.preventDefault();$('#submit_'+SET.name).button('loading');SET.alpha(1);setTimeout(function(){$(SET.frmID+' #submit_'+SET.name).button('reset');}, 500); return false; };
            });//endEvent
            newSection();
            theForm.setAlpha();
            SET.alpha(3,_spicio);
         }//enf if
         //FORM
         if(len==1){
            row=results.rows.item(0);
            $(SET.frmID).data('jesua',row['jesua']);
            SET.fieldDisplay('form',row);
            $(SET.frmID)[0].onsubmit=function(e){e.preventDefault();$('#submit_'+SET.name).button('loading');SET.alpha(2,row['jesua']);setTimeout(function(){$(SET.frmID+' #submit_'+SET.name).button('reset');}, 500); return false;};//make the form to become update
         }
         //UPDATE
         if(_actum===2||_actum===1){
            name='';
            name=SET.fieldDisplay('list',null,true).join(' ');
            if(_actum===2)$('#displayMensa>li[data-jesua='+_jesua+']>a:first-child').html(name).addClass('text-success');
            if(_actum===1){
               var iota=$("footer").data("jesua")||results.insertId;
               $(SET.frmID+' #submit_'+eternal.form.field.name)[0].onclick=function(e){e.preventDefault();SET.alpha(2,iota);};//make the form to become update
               $(SET.frmID).data('jesua',iota);
               $display=$anima('#displayMensa','li',{'data-jesua':iota}).vita('a',{'href':'#'+SET.name},false,name);
               $display.child.onclick=function(e){e.preventDefault();SET.alpha(3,iota);}
               $display.vita('a',{'href':'#'},true).vita('i',{'clss':'icon icon-color icon-trash'})
                  .child.onclick=function(e){e.preventDefault();SET.alpha(0,iota); $(this).parents('li').hide();}
            }//endif
         }//endif
      });//endFunc
   }
   /*
    * queries the db to display in list format
    * @param {integer} <var>_actum</var> the transaction
    * @param {integer} <var>_iota</var> the record identification
    * @returns {undefined}
    */
   this.beta=function(_actum,_jesua){
      var callDB=this;var formTypes,ref,nameList,s,l,x;
      eternal=eternal=eternalCall();
      if(!eternal){console.log("not found json");return false;}
      this.name=eternal.form.field.name;
      this.frmName="frm_"+eternal.form.field.name;
      this.frmID="#frm_"+eternal.form.field.name;
      this.forma(_actum,_jesua,function(results){
         formTypes=(typeof(eternal["form"]["options"])!="undefined")?eternal.form.options.type:0;
         switch(_actum){
            case 0:
               break;
            case 1:
               var iota=$("footer").data("jesua")||results.insertId;
               $("footer").removeData("jesua");
               $(SET.frmID).data("jesua",iota);
               //@todo:potential hack, if code not validated
               ref=$(SET.frmID+" #name").val()||$(SET.frmID+" #username").val();
               nameList="";
               nameList=SET.fieldDisplay("list",null,true);
               $(".accordion-body.in").data("jesua",iota);
               $(".accordion-body.in").parents(".accordion-group").removeClass().addClass('accordion-group class_'+iota);
               $(".accordion-body.in").prev().data("jesua",iota).find(".icon-link").data("head",nameList[0]).data("ref",ref).removeClass("icon-black").addClass("icon-color");
               $(SET.frmID)[0].onsubmit=function(e){
                  e.preventDefault();
                  $("#submit_"+SET.name).button("loading");
                  callDB.beta(2,iota);
                  setTimeout(function(){$("#submit_"+SET.name).button("reset");}, 800);
               }//make the form to become update
               $(SET.frmID+" #cancel_"+SET.name).val("Close...");//@todo
               $("."+iota+" .betaRow").empty();
               $(".class_"+iota+" .betaRow").empty();//enlever tous les donner passer.
               s=$anima(".class_"+iota+" .betaRow","span",{},nameList[0]);
               l=nameList.length;for(x=1;x<l;x++)s.genesis("span",{},true,nameList[x]);
               break;
            case 2:
               $(SET.frmID+" #cancel_"+SET.name).val("Close...");//@todo
               nameList="";
               nameList=SET.fieldDisplay("list",null,true);
               $("."+_jesua+" .betaRow span").each(function(i,v){$(v).html(nameList[i])});
               break;
            case 3:
            default://select all
               if(formTypes==="betaTable") theForm.betaTable(results,_actum,_jesua)
               else theForm.setBeta(results,_actum,_jesua)
               break;
         }//end switch
      });//end anonymous
   }
   /*
    * @param {obeject} <var>_source</var> the source of the object
    * @param {string} <var>_form</var> the name of the form
    * @param {bool} <var>_head</var> only the head to be displayed
    * @returns {array} the list of header
    * @see fieldDisplay in res.forma.js
    * @todo set a single fieldDisplay
    */
   this.fieldDisplay=function(_from,_source,_head){
      var f=eternal.fields;var c=0;var _return=[];
      $.each(f,function(key,property){
         var type=property.field.type;
         if(_head && !property.header) return true;
         switch(type){
            case 'radio':
            case 'bool':
            case 'check':
               if(_from==='form')$(SET.frmID+' [name^='+key+']').each(function(){if($(this).prop('value')==_source[key])$(this).addClass('active').prop('checked',true);else $(this).removeClass('active').prop('checked',false);});
               else if(_from==='list')$(SET.frmID+' [name^='+key+']').each(function(){if($(this).prop('checked')||$(this).hasClass('active'))_return[c]=$(this).prop('value');});
               else _return[c]=_source[key];
               break;
            case 'p':
            case 'span':
               if(_from==='form'&&_source[key])$(SET.frmID+' #'+key).val(_source[key]);
               else _return[c]=_source[key];
               break;
            default:
               if(_from==='form'&&_source[key]){$(SET.frmID+' #'+key).val(_source[key]);if(key=='password'&&document.getElementById('signum'))document.getElementById('signum').value=_source[key]}
               else if(_from==='list')_return[c]=$(SET.frmID+' #'+key).val();
               else _return[c]=_source[key];
               break;
         }//endswitch
         c++;
      });
      return _return;
   }
   /*
    * deletes all references to the primary table
    * @param {number|string} <var>_iota</var>
    * @param {string} <var>_iyona</var>
    * @returns {undefined}
    */
   this.constraintForeignKey = function(_jesua,_iyona,_Tau,_useDelta) {
      var tt,row,l,x,l2,x2,sub;
      var omega=[],alpha=[],delta=[];tt=['users','groups','permissions'];//to speed up process on pf table
      if(tt.indexOf(_iyona)==-1) return false;
      switch (_iyona) {
         case'users':
            omega[0] = "DELETE FROM link_users_groups WHERE user=?";omega[1] = "DELETE FROM link_permissions_users WHERE user=?;";
            alpha[0] = "UPDATE link_users_groups SET user=? WHERE user=?";alpha[1] = "UPDATE link_permissions_users SET user=? WHERE user=?;";
            break;
         case'groups':
            omega[0] = "DELETE FROM link_users_groups WHERE `group`=?";omega[1] = "DELETE FROM link_permissions_groups WHERE `group`=?;";
            alpha[0] = "UPDATE link_users_groups SET `group`=? WHERE `group`=?";alpha[1] = "UPDATE link_permissions_groups SET `group`=? WHERE `group`=?;";
            break;
         case'permissions':
            omega[0] = "DELETE FROM link_permissions_groups WHERE permission=?";omega[1] = "DELETE FROM link_permissions_users WHERE permission=?;";
            alpha[0] = "UPDATE link_permissions_groups WHERE SET permission=? permission=?";alpha[1] = "UPDATE link_permissions_users SET permission=? WHERE permission=?;";
            break;
      }
      switch (_iyona) {
         case'users':
            $DB("SELECT username,id FROM users WHERE jesua=?", [_jesua], 'Selected user', function(results) {
               try {
                  row = results.rows.item(0);

                  if (typeof _Tau==="undefined"||_Tau===false) {l = omega.length;for (x = 0; x < l; x++){$DB(omega[x], [row['username']], "Ref deleted "+row['username']+" from:"+_iyona);}}
                  else if (_Tau) {l = alpha.length;for (x = 0; x < l; x++)$DB(alpha[x], [_Tau, row['username']], "Ref updated "+row['username']+" from:"+_iyona);}
               } catch (err) {console.log("Error selecting reference:" + err.message)}
            });break;
         case'groups':
         case'permissions':
            $DB("SELECT name,id FROM " + _iyona + " WHERE jesua=?", [_jesua], 'Selected ' + _iyona, function(results) {
               try {
                  row = results.rows.item(0);
                  if (typeof _Tau== "undefined"||_Tau===false){
                     l = omega.length;for (x = 0; x < l; x++)$DB(omega[x], [row['name']], "Ref deleted "+row['name']+" from:" + _iyona);
                     //========================================================//deletes child permissions and
                     if(delta){
                        $DB("SELECT id,name,jesua FROM "+_iyona+" WHERE sub=?",[_jesua],'',function(r,j){
                           if(j.rows.length){
                              l2=j.rows.length;
                              for(x2=0;x2<l2;x2++){
                                 sub=j[x2];console.log(j[x2],"j[x2]");
                                 this.constraintForeignKey(sub['jesua'],_iyona,false,true);
                              }//end for
                              $DB("DELETE FROM "+_iyona+" WHERE sub=?", [_jesua], "Child deleted "+sub['name']+" from:" + _iyona);
                           }//endif row
                        });
                     }//endif delta
                     //========================================================//
                  }//endif transaction is delete
                  else if (_Tau) {l = alpha.length;for (x = 0; x < l; x++)$DB(alpha[x], [_Tau, row['name']], "Ref updated "+row['name']+" to "+_Tau+" from:" + _iyona);}
               } catch (err) {console.log("Error selecting reference:" + err.message)}
            });break;
      }//endswith
   }
   /*
    * creats the db
    * @param {object} <var>_option</var> the option for which table is to be reset
    * @returns void
    */
   this.resetDB=function(_option){
      var db,sql,group,link,perm,client,contact,address,dealer,salesman,ver,features,pages;
      if(_option.users)this.creoAgito("DROP TABLE users",[],"DROP table users");
      if(_option.groups)this.creoAgito("DROP TABLE groups",[],"DROP table groups");
      if(_option.ug)this.creoAgito("DROP TABLE link_users_groups",[],"DROP table link_users_groups");
      if(_option.perm)this.creoAgito("DROP TABLE permissions",[],"DROP table permissions");
      if(_option.pg)this.creoAgito("DROP TABLE link_permissions_groups",[],"DROP table link_permissions_groups");
      if(_option.pu)this.creoAgito("DROP TABLE link_permissions_users",[],"DROP table link_permissions_users");
      if(_option.client)this.creoAgito("DROP TABLE clients",[],"DROP table clients");
      if(_option.contact)this.creoAgito("DROP TABLE contacts",[],"DROP table contact");
      if(_option.address)this.creoAgito("DROP TABLE address",[],"DROP table address");
      if(_option.dealer)this.creoAgito("DROP TABLE dealers",[],"DROP table dealer");
      if(_option.salesman)this.creoAgito("DROP TABLE salesmen",[],"DROP table salesmen");
      if(_option.ver)this.creoAgito("DROP TABLE versioning",[],"DROP table versioning");
      if(_option.pages)this.creoAgito("DROP TABLE pages",[],"DROP table pages");
      if(_option.features)this.creoAgito("DROP TABLE features",[],"DROP table features");
      if(_option.db)this.creoAgito("DROP TABLE version_db",[],"DROP table version_db");

      db="CREATE TABLE IF NOT EXISTS version_db (id INTEGER PRIMARY KEY AUTOINCREMENT, ver FLOAT UNIQUE)";
      if(_option.db)this.creoAgito(db,[],'Table version_db created');
      if(_option.db)this.creoAgito("CREATE INDEX db_ver ON version_db(ver)",[],"index version_db");
      if(_option.db)this.creoAgito("INSERT INTO version_db (ver)VALUES(?)",[localStorage.DB_VERSION]);
      sql="CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR(90) NOT NULL UNIQUE, password TEXT NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL,`level` TEXT, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.users)this.creoAgito(sql,[],'Table users created');
      if(_option.users)this.creoAgito("CREATE INDEX user_username ON users(username)",[],"index user_username");
      if(_option.users)this.creoAgito("CREATE INDEX user_email ON users(email)",[],"index user_email");
      if(_option.users)this.creoAgito("CREATE INDEX user_jesua ON users(jesua)",[],"index user_jesua");
      group="CREATE TABLE IF NOT EXISTS groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT UNIQUE, desc TEXT, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.groups)this.creoAgito(group,[],'Table groups created');
      if(_option.groups)this.creoAgito("CREATE INDEX groups_name ON groups(name)",[],'index groups_name');
      if(_option.groups)this.creoAgito("CREATE INDEX group_jesua ON groups(jesua)",[],"index group_jesua");
      link="CREATE TABLE IF NOT EXISTS link_users_groups (id INTEGER PRIMARY KEY AUTOINCREMENT, `user` TEXT NOT NULL, `group` TEXT NOT NULL, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT `fk_user_group` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE ON DELETE CASCADE, CONSTRAINT `fk_group_user` FOREIGN KEY (`group`) REFERENCES `groups` (`name`) ON UPDATE CASCADE ON DELETE CASCADE)";
      if(_option.ug)this.creoAgito(link,[],'Table link to users and groups created');
      if(_option.ug)this.creoAgito("CREATE INDEX link_usergroup_user ON link_users_groups(`user`)",[],'index link_usergroup_user');
      if(_option.ug)this.creoAgito("CREATE INDEX link_usergroup_group ON link_users_groups(`group`)",[],'index link_usergroup_group');
      perm="CREATE TABLE IF NOT EXISTS permissions (id INTEGER PRIMARY KEY AUTOINCREMENT, `name` TEXT NOT NULL UNIQUE, `desc` TEXT NOT NULL, `page` TEXT, `enable` INTEGER DEFAULT 1, `rank` INTEGER DEFAULT 0, `icon` TEXT, `sub` TEXT DEFAULT '-1', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.perm)this.creoAgito(perm,[],'Table permissions created');
      if(_option.perm)this.creoAgito("CREATE INDEX perm_name ON permissions(name)",[],"index perm_name");
      if(_option.perm)this.creoAgito("CREATE INDEX perm_jesua ON permissions(jesua)",[],"index perm_jesua");
      link="CREATE TABLE IF NOT EXISTS link_permissions_groups(id INTEGER PRIMARY KEY AUTOINCREMENT, `permission` TEXT NOT NULL, `group` TEXT NOT NULL, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT `fk_perm_group` FOREIGN KEY (`permission`) REFERENCES `permissions` (`name`) ON UPDATE CASCADE ON DELETE CASCADE, CONSTRAINT `fk_group_perm` FOREIGN KEY (`group`) REFERENCES `groups` (`name`) ON UPDATE CASCADE ON DELETE CASCADE)";
      if(_option.pg)this.creoAgito(link,[],'Table link to permissions to groups created');
      if(_option.pg)this.creoAgito("CREATE INDEX link_permgroup_perm ON link_permissions_groups(`permission`)",[],'index link_permgroup_perm');
      if(_option.pg)this.creoAgito("CREATE INDEX link_permgroup_group ON link_permissions_groups(`group`)",[],'index link_permgroup_group');
      link="CREATE TABLE IF NOT EXISTS link_permissions_users(id INTEGER PRIMARY KEY AUTOINCREMENT, `permission` TEXT NOT NULL, `user` TEXT NOT NULL, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT `fk_perm_user` FOREIGN KEY (`permission`) REFERENCES `permissions` (`name`) ON UPDATE CASCADE ON DELETE CASCADE, CONSTRAINT `fk_user_perm` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE ON DELETE CASCADE)";
      if(_option.pu)this.creoAgito(link,[],'Table link to permissions to users created');
      if(_option.pu)this.creoAgito("CREATE INDEX link_permuser_perm ON link_permissions_users(`permission`)",[],'index link_permuser_perm');
      if(_option.pu)this.creoAgito("CREATE INDEX link_permuser_user ON link_permissions_users(`user`)",[],'index link_permuser_user');
      client="CREATE TABLE IF NOT EXISTS clients(id INTEGER PRIMARY KEY AUTOINCREMENT, company TEXT NOT NULL UNIQUE, code TEXT NOT NULL UNIQUE, about TEXT, email TEXT NOT NULL, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.client)this.creoAgito(client,[],'Table clients created');
      if(_option.client)this.creoAgito("CREATE INDEX client_company ON clients(company)",[],"index client_company");
      if(_option.client)this.creoAgito("CREATE INDEX client_code ON clients(code)",[],"index client_code");
      if(_option.client)this.creoAgito("CREATE INDEX client_jesua ON clients(jesua)",[],"index client_jesua");
      contact="CREATE TABLE IF NOT EXISTS contacts(id INTEGER PRIMARY KEY AUTOINCREMENT,ref_name INTEGER,ref_group INTEGER, `type` TEXT NOT NULL DEFAULT 'tel', contact TEXT NOT NULL, instruction TEXT, ext TEXT, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT `fk_user_contact` FOREIGN KEY (`ref_name`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,CONSTRAINT `fk_client_contact` FOREIGN KEY (`ref_name`) REFERENCES `clients` (`id`) ON UPDATE CASCADE ON DELETE CASCADE)";
      if(_option.contact)this.creoAgito(contact,[],'Table contacts created');
      if(_option.contact)this.creoAgito("CREATE INDEX contact_ref_name ON contacts(ref_name)",[],"index ref_name");
      if(_option.contact)this.creoAgito("CREATE INDEX contact_contact ON contacts(contact)",[],"index contact");
      if(_option.contact)this.creoAgito("CREATE INDEX contact_jesua ON contacts(jesua)",[],"index contact_jesua");
      address="CREATE TABLE IF NOT EXISTS address(id INTEGER PRIMARY KEY AUTOINCREMENT,ref_name INTEGER,ref_group INTEGER, `type` TEXT NOT NULL DEFAULT 'residential', street TEXT NOT NULL, city TEXT NOT NULL, region TEXT DEFAULT 'Gauteng', country TEXT DEFAULT 'South Africa', modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT `fk_user_adr` FOREIGN KEY (`ref_name`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,CONSTRAINT `fk_client_adr` FOREIGN KEY (`ref_name`) REFERENCES `clients` (`id`) ON UPDATE CASCADE ON DELETE CASCADE)";
      if(_option.address)this.creoAgito(address,[],'Table address created');
      if(_option.address)this.creoAgito("CREATE INDEX address_ref_name ON address(ref_name)",[],"index ref_name");
      if(_option.address)this.creoAgito("CREATE INDEX address_jesua ON address(jesua)",[],"index address_jesua");
      dealer="CREATE TABLE IF NOT EXISTS dealers(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, code TEXT NOT NULL, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.dealer)this.creoAgito(dealer,[],'Table dealer created');
      if(_option.dealer)this.creoAgito("CREATE INDEX dealer_name ON dealers(name)",[],"index dealer_name");
      if(_option.dealer)this.creoAgito("CREATE INDEX dealer_jesua ON dealers(jesua)",[],"index dealer_jesua");
      salesman="CREATE TABLE IF NOT EXISTS salesmen(id INTEGER PRIMARY KEY AUTOINCREMENT, dealer INTEGER, firstname TEXT NOT NULL, lastname TEXT NOT NULL, code TEXT NOT NULL, idno TEXT, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT,CONSTRAINT fk_sales_dealer FOREIGN KEY (`dealer`) REFERENCES dealers(`id`) ON DELETE CASCADE ON UPDATE CASCADE)";
      if(_option.salesman)this.creoAgito(salesman,[],'Table salesman created');
      if(_option.salesman)this.creoAgito("CREATE INDEX salesman_firstname ON salesmen(firstname)",[],"index salesman_firstname");
      if(_option.salesman)this.creoAgito("CREATE INDEX salesman_lastname ON salesmen(lastname)",[],"index salesman_lastname");
      if(_option.salesman)this.creoAgito("CREATE INDEX salesman_idno ON salesmen(idno)",[],"index salesman_idno");
      if(_option.salesman)this.creoAgito("CREATE INDEX salesman_dealer ON salesmen(dealer)",[],"index salesman_dealer");
      if(_option.salesman)this.creoAgito("CREATE INDEX salesman_jesua ON salesmen(jesua)",[],"index salesman_jesua");
      ver="CREATE TABLE versioning(id INTEGER PRIMARY KEY AUTOINCREMENT,user INTEGER NOT NULL,content text NOT NULL,iota INTEGER NOT NULL,trans INTEGER NOT NULL,mensa TEXT,modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.ver)this.creoAgito(ver,[],'Version table created');
      if(_option.ver)this.creoAgito("CREATE INDEX ver_jesua ON versioning(jesua)",[],"index ver_jesua");
      features="CREATE TABLE features(id INTEGER PRIMARY KEY AUTOINCREMENT,feature TEXT NOT NULL UNIQUE,description TEXT,category TEXT,filename TEXT,manus TEXT,tab TEXT, modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT)";
      if(_option.features)this.creoAgito(features,[],'Version table created');
      if(_option.features)this.creoAgito("CREATE INDEX features_jesua ON features(jesua)",[],"index features_jesua");
      pages="CREATE TABLE pages(`id` INTEGER PRIMARY KEY AUTOINCREMENT,`page_ref` TEXT ,`title` TEXT NOT NULL UNIQUE, `content` TEXT NOT NULL,`level` TEXT, `type` TEXT,modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, creation TEXT, jesua TEXT, `selector` TEXT, `option` TEXT, `position` TEXT)";
      if(_option.pages)this.creoAgito(pages,[],'Pages table created');
      if(_option.pages)this.creoAgito("CREATE INDEX pages_type ON pages(`type`)",[],"index pages_type");
      if(_option.pages)this.creoAgito("CREATE INDEX pages_selector ON pages(`selector`)",[],"index pages_selector");
      if(_option.pages)this.creoAgito("CREATE INDEX pages_jesua ON pages(jesua)",[],"index pages_jesua");

      if(_option.client){this.novaNotitia("clients","getClients",["id","company","code","about","email","modified","creation","jesua"]);}//endif
      if(_option.features){this.novaNotitia("features","getFeatures",["id","feature","description","category","filename","manus","tab","creation","modified","creation","jesua"]);}//endif
      if(_option.groups){this.novaNotitia("groups","getGroups",["id","name","desc","modified","creation","jesua"]);}//endif
      if(_option.ug){this.novaNotitia("link_users_groups","getUG",["id","user","group"])}//endif
      if(_option.pu){this.novaNotitia("link_permissions_users","getPU",["id","permission","user"])}//endif
      if(_option.pg){this.novaNotitia("link_permissions_groups","getPG",["id","permission","group"])}//endif
      if(_option.pages){this.novaNotitia("pages","getPages",["id","page_ref","title","content","level","type","modified","creation","jesua","selector","option","position"]);}//endif
      if(_option.perm){this.novaNotitia("permissions","getPerm",["id","name","desc","page","enable","sub","modified","creation","jesua"])}//endif
      if(_option.users){this.novaNotitia("users","getUsers",["id","username","password","firstname","lastname","email","gender","level","modified","creation","jesua"]);}//endif
      if(_option.dealer){this.novaNotitia("dealers","getDealer",["name","code","modified","creation","jesua"]);
         $DB("SELECT name,code FROM dealers LIMIT 3",[],"",function(r,j){n='dealers';N=aNumero(n,true);$('#drop_'+n).empty();$('.'+n+'List').empty();$.each(j,function(i,v){if(i=='rows') return true;$anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' oneDealer','data-iota':v[1]},false,aNumero(v[0],true));$anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));$anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'oneDealer','data-iota':v[1]},false,aNumero(v[0],true));});$anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));$anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));$anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'href':'#tab-'+n,'clss':'allDealer','data-iota':'0'},false,'View All '+aNumero(n,true));$('#drop_'+n+' .allDealer,#drop_'+n+' .oneDealer').click(function(){if($(this).hasClass('oneDealer'))$('footer').data('header',true);/*this is for a bug fix. menu links are supposed to display header from the function and not from the form beta */activateMenu('dealer','dealers',this);sessionStorage.genesis=0;});$('#tab-customers .allDealer,#tab-customers .oneDealer').click(function(){activateMenu('customer','customers',this,true,'dealers');sessionStorage.genesis=0;});$('#tab-insurance .allDealer,#tab-insurance .oneDealer').click(function(){activateMenu('member','insurance',this,true,'dealers');sessionStorage.genesis=0;});});
      }//endif
      if(_option.salesman){this.novaNotitia("salesmen","getSaleman",["firstname","lastname","code","modified","creation","jesua"]);
         $DB("SELECT firstname||' '||lastname,code FROM salesmen LIMIT 3",[],"",function(r,j){n='salesman';N=aNumero(n,true);$('#drop_'+n).empty();$('.'+n+'List').empty();$.each(j,function(i,v){if(i=='rows') return true;$anima('#drop_'+n,'li',{}).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':n+i+' one'+N,'data-iota':v[1]},false,aNumero(v[0],true));$anima('#tab-customers .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));$anima('#tab-insurance .'+n+'List','li',{}).vita('a',{'href':'#'+n+i,'clss':'one'+N,'data-iota':v[1]},false,aNumero(v[0],true));});$anima('#drop_'+n,'li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'data-toggle':'tab','href':'#tab-'+n,'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));$anima('#tab-customers .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));$anima('#tab-insurance .'+n+'List','li',{'clss':'divider'}).genesis('li',{},true).vita('a',{'clss':'all'+N,'data-iota':'0'},false,'View All '+aNumero(n,true));$('#drop_'+n+' .allSalesman,#drop_'+n+' .oneSalesman').click(function(){if($(this).hasClass('oneSalesman'))$('footer').data('header',true);activateMenu('salesman','salesmen',this);sessionStorage.genesis=0;});$('#tab-customers .allSalesman,#tab-customers .oneSalesman').click(function(){activateMenu('customer','customers',this,true,'salesmen');sessionStorage.genesis=0;});$('#tab-insurance .allSalesman,#tab-insurance .oneSalesman').click(function(){activateMenu('member','insurance',this,true,'salesmen');sessionStorage.genesis=0;});});
      }//endif


   }//endfunction
   /*
    * validation of db fields
    * @param {string} <var>_val</var> the value of the field
    * @param {string} <var>_field</var> the name of the field
    * @param {object} <var>_properties</var> the properties of the field
    * @returns {bool}
    *
    * */
   this.sanatio=function(_val,_field,_properties){
      var ele=$(this.frmID+' #'+_field)[0]||$('.'+this.frmName+'_'+_field+' .btn-group')[0];
      var type=_properties.field.type;
      var err=creo({"clss":"help-block error-block"},'span');
      var title=_properties.field.title||_properties.title||'';
      var omega=true;var msg;
      if(!_val&&"required" in _properties.field) {msg='Missing `'+_field+'`';omega=false;}
      else if (!sessionStorage.formValidation){
         if(_properties.pattern&&_val.search(this.patterns[_properties.pattern][0])==-1){msg=title+', '+this.patterns[_properties.pattern][1];omega=false;}
         else if(_properties.field.pattern&&_val.search(_properties.field.pattern)==-1){msg=title+', missing a requirment';omega=false;}
         else if(type=="email"&&_val.search(this.patterns["email"][0])==-1){msg=title+', '+this.patterns["email"][1];omega=false;}
         else if(type=="number"&&_val.search(this.patterns["number"][0])==-1){msg=title+', '+this.patterns["number"][1];omega=false;}
         else if(type=="color"&&_val.search(this.patterns["color"][0])==-1){msg=title+', '+this.patterns["color"][1];omega=false;}
         else if(type=="url"&&_val.search(this.patterns["url"][0])==-1){msg=title+', '+this.patterns["url"][1];omega=false;}
         else if(type=="date"&&_val.search(this.patterns["fullDate"][0])==-1){msg=title+', '+this.patterns["fullDate"][1];omega=false;}
      }
      else if(type=="password"&&_val.search(this.patterns["password"][0])==-1){msg=title+', '+this.patterns["password"][1];omega=false;}
      else if(type=="password"&&$('#signum').val()&&_val!==$('#signum').val()){msg=title+' passwords do not match';omega=false;}
      if(omega===false){ele.parentNode.insertBefore(err, ele.nextSibling);err.innerHTML=msg;$('#sideNotice .db_notice').html('<div class="text-error">'+msg+'</div>');$('.control-group.'+this.frmName+'_'+_field).addClass('error');}
      return omega;
   }
   /*
    * short hand insert for data insert
    * @param {string} _mensa le nom de la table a utiliser
    * @param {string} _comamnd le mot qui vas etre passer comme un parametre
    * @param {array} _fields l'object qui contient les donner
    * @returns void
    */
   this.novaNotitia=function(_mensa,_comand,_fields){
      var fields='',values=[],sql;var x,l,f=[],n=[];
      $.ajax({url:localStorage.SITE_SERVICE,data:{militia:_comand},type:"POST",dataType:'json',success:function(json){
         l=_fields.length;
         for(x=0;x<l;x++){f.push('?');n.push('`'+_fields[x]+'`');}
         $.each(json,function(i,v){
            if(i==='rows')return true;
            l=_fields.length;
            for(x=0;x<l;x++){values.push(v[_fields[x]]);}
            if(_comand=="getUsers")v.gender=v.gender=='Male'?'1':'2';
            fields+=fields==''?"SELECT "+f.join():" UNION SELECT "+f.join();
         });
         sql="INSERT INTO "+_mensa+" ("+n.join()+") "+fields;
         $DB(sql,values,"added "+_mensa);
      }}).fail(function(jqxhr,textStatus,error){err=textStatus+','+error;console.log('failed to get json:'+err)});
   }
//$DB("update permissions set sub=17 where id in (1,2,3)");

   if(!db||!localStorage.DB){
      db=window.openDatabase(localStorage.DB_NAME,'',localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      if(!localStorage.DB){
         localStorage.DB=JSON.stringify(db);
         this.resetDB({users:1,groups:1,ug:1,perm:1,pg:1,pu:1,client:1,contact:1,address:1,dealer:1,salesman:1,ver:1,pages:1,features:1,db:1});
      }
   }
   if(false&&db&&localStorage.DB)this.resetDB({users:0,groups:0,ug:0,perm:0,pg:0,pu:0,client:0,contact:0,address:0,dealer:0,salesman:0,ver:0,pages:0,features:0,db:0});
   if(this.reset&&db&&localStorage.DB)this.resetDB(this.reset);
//   if(this instanceof SET_DB)return this; else return new SET_DB();
}
/******************************************************************************/
/**
 * used to measure script execution time
 *
 * It will verify all the variable sent to the function
 * @author fredtma
 * @version 0.5
 * @category iyona
 * @gloabl aboject $db
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @see get_rich_custom_fields(), $iyona
 * @return void|bool
 * @todo finish the function on this page
 * @uses file|element|class|variable|function|
 */
$DB=function(quaerere,params,msg,callback,reading){
   var tmp,res,Tau;var ver={};
   if(!db)db=window.openDatabase(localStorage.DB_NAME,'',localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024,function(){console.log('create a new DB')});
   if(db.version!=localStorage.DB_VERSION&&!$("footer").data("db version")){
      ver.ver=localStorage.DB_VERSION;
      ver.revision={dealer:1};
      db.changeVersion(db.version,localStorage.DB_VERSION,function(trans){version_db(db.version,ver,trans)},function(e){console.log(e.message)},function(e){console.log('PASSED');});
      localStorage.DB=JSON.stringify(db);$("footer").data("db version",1);
   }
   if(!reading){
      db.transaction(function(trans){
         trans.executeSql(quaerere,params,function(trans,results){
            if(msg)console.log('%c Success DB transaction: '+msg, 'background:#000;color:#48b72a;width:100%;');
            console.log('%c'+quaerere,'background:#000;color:#ff9900;width:100%;font-weight:bold;',params);
            var j=$DB2JSON(results);
            if(sessionStorage.quaerere){
               tmp=JSON.parse(sessionStorage.quaerere);
               var procus=localStorage.USER_NAME?JSON.parse(localStorage.USER_NAME):JSON.parse(sessionStorage.USER_NAME);var moli=screen.height*screen.width;
               res=tmp.eternal;Tau=tmp.Tau;iyona=tmp.iyona;
               get_ajax(localStorage.SITE_MILITIA,{"eternal":res,"Tau":Tau,"iyona":iyona,"procus":procus.singularis,"moli":moli},'','post','json',function(j){console.log(j,'Online');$('#sys_msg').html(j.msg) });
               sessionStorage.removeItem('quaerere');Tau=false;
            }
            if(msg)$('#sideNotice .db_notice').html("Successful: "+msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            if(callback)callback(results,j);
         },function(_trans,_error){
            msg=_error.message;
            if(msg.search('no such table')!=-1){
               localStorage.removeItem('DB');//@todo:fix this,ensure u give proper notification and create only missing
               $('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('The application yet to be installed on this machine.<br/> We will run the installation on the next refresh')
            }
            console.log('Failed DB: '+msg+':'+msg);console.log('::QUAERERE='+quaerere);
            msg="The application encounter an error and will try to re-install itself (press F5 to refresh)";
            $('#sideNotice .db_notice').html("<div class='text-error'><strong>"+msg+'</strong></div>');
         });
      });
   } else {
      db.readTransaction(function(trans){
         trans.executeSql(quaerere,params,function(trans,results){
            if(msg)console.log('%c Success DB transaction: '+msg, 'background:#000;color:#48b72a;width:100%;');
            console.log('%c'+quaerere,'background:#000;color:#ff9900;width:100%;font-weight:bold;',params);
            var j=$DB2JSON(results);
            if(msg)$('#sideNotice .db_notice').html("Successful: "+msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            if(callback)callback(results,j);
         },function(_trans,_error){
            msg=_error.message;
            if(msg.search('no such table')!=-1){
               localStorage.removeItem('DB');//@todo:fix this,ensure u give proper notification and create only missing
               $('#userLogin .alert-info').removeClass('alert-info').addClass('alert-error').find('span').html('The application yet to be installed on this machine.<br/> We will run the installation on the next refresh')
            }
            console.log('Failed DB: '+msg+':'+msg);console.log('::QUAERERE='+quaerere);
            msg="The application encounter an error and will try to re-install itself (press F5 to refresh)";
            $('#sideNotice .db_notice').html("<div class='text-error'><strong>"+msg+'</strong></div>');
         });
      });
   }
}
/******************************************************************************/
/**
 * convert either websql or indexdb to json format
 * @author fredtma
 * @version 2.3
 * @category db, convert
 * @param object <var>_results</var> the results from the DB
 * @param integer <var>_type</var> the type pf results
 * @return json
 * @todo add indexdb and any other results type
 */
$DB2JSON=function(_results,_type){
   var j={},row,col,len,x,k;
   switch(_type){
      case 1:break;
      case 2:break;
      default:
         len=_results.rows.length;
         for(x=0;x<len;x++){
//            console.log(_results.rowsAffected);
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
/******************************************************************************/
/**
 * update text in table from a single field
 * @author fredtma
 * @version 4.3
 * @category update, notitia
 * @param object <var>_set</var> the object containing the field to be updated
 * @return void
 */
function deltaNotitia(_set){
   var agrum=_set.className.replace(/col_/,'');
   var jesua=$(_set).parents('tr').data('jesua');
   var name=eternal.form.field.name;
   var valor=$(_set).text();
   var t = new Date().format('isoDateTime');//var jesua=md5(valor+t);
   var delta='UPDATE `'+eternal.mensa+'` SET `'+agrum+'`=?,modified=? WHERE jesua=?';var msg='  Updated field '+agrum;
   var quaerere={};quaerere.eternal={'blossom':{"alpha":jesua,"delta":"!@=!#"},"modified":t};quaerere.eternal[agrum]=valor;
   quaerere.Tau='deLta';quaerere.iyona=eternal.mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
   $DB(delta,[valor,t,jesua],msg,function(){
      $('.table-msg-'+name).html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
   });
}
/******************************************************************************/
/**
 * when a new row is created via a table
 * @author fredtma
 * @version 4.5
 * @category insert, db
 * @param object <var>_row</var> the row containing the default data
 * @param object <var>_tr</var> the new row created
 */
function alphaNotitia(_row,_tr){
   var fields,field;var name=eternal.form.field.name;
   if(eternal.child) {for (fields in eternal.child) break; fields=eternal.child[fields].fields}//child et seulment un seul.
   else fields=eternal.fields;
   var valor = Math.floor((Math.random()*100)+1);
   var t = new Date().format('isoDateTime');var jesua=md5(valor+t);
   var agris=['jesua','modified']; valor=[jesua,t]; var res={"jesua":jesua,"modified":t};
   //get all the fields set in the config, takes value from colums if it exist, other wise from the default config or null
   for(field in fields){agris.push('`'+field+'`');if(_row[field]){val=_row[field]}else{var val=fields[field].value||'';}valor.push(val);res[field]=val;}
   var l=agris.length;var q=[],x; for(x=0;x<l;x++)q.push('?');
   var delta='INSERT INTO `'+eternal.mensa+'` ('+agris+') VALUES ('+q.join()+')';var msg='  New record created ';
   var quaerere={};quaerere.eternal=res;
   quaerere.Tau='Alpha';quaerere.iyona=eternal.mensa;sessionStorage.quaerere=JSON.stringify(quaerere);
   $DB(delta,valor,msg,function(r,j){
      var iota=jesua||r.insertId;
      $(_tr).data('jesua',iota);
      $('.table-msg-'+name).html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
   });
   return true;
}
/******************************************************************************/
/**
 * removes a row from the db and table
 * @author fredtma
 * @version 4.6
 * @category delete, database
 * @param object <var>_set</var> the element cliented
 * @param integer <var>_iota</var>
 */
function omegaNotitia(_set,_jesua){
   var name=eternal.form.field.name;
   var jesua=_jesua||$(_set).parents('tr').data('jesua');
   $(_set).parents('tr').hide();var msg = " Record removed ";
   var quaerere={"eternal":{"blossom":{"alpha":jesua,"delta":"!@=!#"}},"iyona":eternal.mensa,"Tau":"oMegA"};sessionStorage.quaerere=JSON.stringify(quaerere);
   $DB("DELETE FROM "+eternal.mensa+" WHERE jesua=?",[jesua],msg,function(){
      $('.table-msg-'+name).html(msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
   });
};
/******************************************************************************/
/**
 * used to measure script execution time
 *
 * It will verify all the variable sent to the function
 * @author fredtma
 * @version 0.5
 * @category iyona
 * @gloabl aboject $db
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @see get_rich_custom_fields(), $iyona
 * @return void|bool
 * @todo finish the function on this page
 * @uses file|element|class|variable|function|
 */