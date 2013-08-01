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
function SET_DB(){
   this.mensaActive=['users,groups,link_users_groups'];
   this.creoAgito=function(_quaerere,_params,_msg,callback){
      var quaerere=_quaerere;
      var msg=_msg;
      var params=_params||[];
//      if(!db) db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      db.transaction(function(trans){
         trans.executeSql(quaerere,params,function(trans,results){
            console.log('%c Success DB transaction: '+msg, 'background:#222;color:#48b72a;width:100%;');
            console.log('%c'+quaerere, 'background:#222;color:#48b72a;width:100%;font-weight:bold;');
            j=$DB2JSON(results);
            $('#sideNotice .db_notice').html("Successful: "+msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            if(callback)callback(results);
         },function(_trans,_error){
            console.log('Failed DB: '+msg+':'+_error.message);
            console.log('%c ::QUAERERE='+quaerere, 'background:#222;color:#ff0000;font-weight:bold;');
            $('#sideNotice .db_notice').html("<div class='text-error'>"+_error.message+'</div>');
         });
      });
   }
   if(!db){
      console.log('NEW DB:'+db);
      db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      this.creoAgito("DELETE FROM link_permissions_groups",[],"Truncated table link_permissions_groups");
      this.creoAgito("DELETE FROM link_permissions_users",[],"Truncated table link_permissions_users");
//      this.creoAgito("DROP TABLE link_users_groups",[],"DROP table");
      if(!localStorage.DB){
         localStorage.DB=db;
         sql="CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR(90) NOT NULL UNIQUE, password TEXT NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(sql,[],'Table users created');
         this.creoAgito("CREATE INDEX user_username ON users(username)",[],"index user_username");
         this.creoAgito("CREATE INDEX user_email ON users(email)",[],"index user_email");
         group="CREATE TABLE IF NOT EXISTS groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT UNIQUE, desc TEXT, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(group,[],'Table groups created');
         this.creoAgito("CREATE INDEX groups_name ON groups(name)",[],'index groups_name');
         link="CREATE TABLE IF NOT EXISTS link_users_groups (id INTEGER PRIMARY KEY AUTOINCREMENT, `user` TEXT NOT NULL, `group` TEXT NOT NULL, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(link,[],'Table link to users and groups created');
         this.creoAgito("CREATE INDEX link_usergroup_user ON link_users_groups(`user`)",[],'index link_usergroup_user');
         this.creoAgito("CREATE INDEX link_usergroup_group ON link_users_groups(`group`)",[],'index link_usergroup_group');
         perm="CREATE TABLE IF NOT EXISTS permissions (id INTEGER PRIMARY KEY AUTOINCREMENT, `name` TEXT NOT NULL UNIQUE, `desc` TEXT NOT NULL, `page` TEXT, `enable` INTEGER DEFAULT 1, `rank` INTEGER DEFAULT 0, `icon` TEXT, `sub` INTEGER DEFAULT 0, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(perm,[],'Table permissions created');
         this.creoAgito("CREATE INDEX perm_name ON permissions(name)",[],"index perm_name");
         link="CREATE TABLE IF NOT EXISTS link_permissions_groups(id INTEGER PRIMARY KEY AUTOINCREMENT, `permission` TEXT NOT NULL, `group` TEXT NOT NULL, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(link,[],'Table link to permisions to groups created');
         this.creoAgito("CREATE INDEX link_permgroup_perm ON link_permissions_groups(`permission`)",[],'index link_permgroup_perm');
         this.creoAgito("CREATE INDEX link_permgroup_group ON link_permissions_groups(`group`)",[],'index link_permgroup_group');
         link="CREATE TABLE IF NOT EXISTS link_permissions_users(id INTEGER PRIMARY KEY AUTOINCREMENT, `permission` TEXT NOT NULL, `user` TEXT NOT NULL, creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
         this.creoAgito(link,[],'Table link to permisions to users created');
         this.creoAgito("CREATE INDEX link_permuser_perm ON link_permissions_users(`permission`)",[],'index link_permuser_perm');
         this.creoAgito("CREATE INDEX link_permuser_user ON link_permissions_users(`username`)",[],'index link_permuser_user');
      }
   }
   /*
    * this function will extract info from the form and determine the form action
    * @param {string} _form the name of the form to be setup
    * @param {string} _mensa table name, takent from _form if not mensioned
    * @param {integer} _actum transaction type to remove the record
    * @returns void
    * @todo clean it up
    */
   this.forma=function(_actum,_iota,callback){
      reference=[];
      //protect and accept only valid table
      if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);
      else eternal=null;
      if(!eternal){console.log("not found json");return false;}
      form='#frm_'+eternal.form.field.name;
      iota=_iota;
      iyona=eternal.mensa||form.substr(4);
      if(!this.mensaActive.indexOf(iyona)){console.log("not found mensa");return false;}
      var quaerere=[],params=[],set=[];
      limit=localStorage.LIMIT||7;
      switch(_actum){
         case 0:
            switch(iyona){
               case'users':reference[0]="DELETE FROM link_users_groups WHERE user=?";reference[1]="DELETE FROM link_permissions_users WHERE user=?;";break;
               case'groups':reference[0]="DELETE FROM link_users_groups WHERE `group`=?";reference[1]="DELETE FROM link_permissions_groups WHERE `group`=?;";break;
               case'permissions':reference[0]="DELETE FROM link_permissions_groups WHERE permission=?";reference[1]="DELETE FROM link_permissions_users WHERE permission=?;";break;
            }
            this.referenceDelete(reference,iota,iyona);
            actum='DELETE FROM '+iyona+' WHERE id=?';
            creoAgito=this.creoAgito;
            setTimeout(function(){creoAgito(actum,[_iota],'Deleted record from '+iyona,callback)},15);break;
         case 1:
            ubi='';
            actum='INSERT INTO '+iyona+' (';msg='Inserted '+iyona;break;
         case 2:
            ubi=' WHERE id='+iota;
            actum='UPDATE '+iyona+' SET';msg='Updated '+iyona;break;
         case 3:
         default:
            _actum=3;
            actum='SELECT';
            ubi=iota?' WHERE id='+iota+' LIMIT '+limit:' LIMIT '+limit;
            ubi=' FROM '+iyona+ubi;
            msg='Selected '+iyona;break;
      }
      if(_actum!=0){
         x=0;
         iota=iota||$(form).data('iota');
         $.each(eternal.fields,function(field,properties){
            if(properties.source=='custom') return true;//skip the field
            val=$(form+' #'+field).val()||$(form+' [name^='+field+']:checked').val();
            if(_actum!=3){
               if(!val) {quaerere=[];$('#sideNotice .db_notice').html('<div class="text-error">Missing '+field+'</div>');$('.control-group.'+field).addClass('error'); return false;}//@todo add validation, this is manual validation
               quaerere[x]=(iota)?field+'= ?':field;
               set[x]='?';
               params[x]=val;
               x++;
            } else if((_actum==3)) {//select fields
               quaerere[x]=field;
               x++;
            }
         });
         if(quaerere.length>0){
            $('.control-group.error').removeClass('error');
            ubi=(_actum!=1)?ubi:') VALUES ('+set.toString()+')';
            if(_actum==3)quaerere.push('id');
            quaerere=actum+' '+quaerere.toString()+ubi;
            this.creoAgito(quaerere,params,msg,callback);
         }
      }
   }
   /*
    * the successful return function
    * @see this.forma
    */
   this.alpha=function(_actum,_iota){
      fieldDisplay=this.fieldDisplay;
      this.forma(_actum,_iota,function(results){
         if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);
         else eternal=null;
         if(!eternal){console.log("not found json");return false;}
         form='#frm_'+eternal.form.field.name;
         iyona=eternal.mensa||form.substr(4);
         display=$('#displayMensa');
//         iota=results.insertId?results.insertId:$(form).data('iota');
         len=results.rows.length;
         //ASIDE
         if(display.data('mensa')!=iyona){
            display.data('mensa',iyona);//prevent this to fill with the same data table list
            for(x=0;x<len;x++){
               name='';
               row=results.rows.item(x);
               li=creo({'data-iota':row['id']},'li');
               a=creo({'href':'#profile'},'a');
               name=fieldDisplay('row',row,true).join(' ');
               txt=document.createTextNode(name);
               a.onclick=function(e){e.preventDefault();ii=$(this).parent().data('iota');creoDB.alpha(3,ii)}
               a.appendChild(txt);li.appendChild(a);
               i=creo({'clss':'icon icon-color icon-trash'},'i');
               a=creo({'href':'#'},'a');a.appendChild(i);li.appendChild(a);
               a.onclick=function(e){e.preventDefault();ii=$(this).parent().data('iota');creoDB.alpha(0,ii); $(this).parent().hide();}
               display.append(li);
            }
            $('#sideBot h3 a').click(function(e){
               e.preventDefault();
               $(form+' #submit_'+eternal.fields[0]);
               for (first in eternal.fields)break;
               $(form+' #'+first).focus();
               $(form+' #submit_'+eternal.form.field.name)[0].onclick=function(e){e.preventDefault();creoDB.alpha(1);};
               $(form).data('iota',0);
               $(':input',form).not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
               $('type[checkbox],type[radio]',form).prop('checked',false).prop('selected',false);
            });
         }
         //FORM
         if(len==1){
            row=results.rows.item(0);
            $(form).data('iota',row['id']);
            fieldDisplay('form',row);
            $(form+' #submit_'+eternal.form.field.name)[0].onclick=function(e){e.preventDefault();creoDB.alpha(2,row['id']);};//make the form to become update
            $(form+' #cancel_'+eternal.form.field.name).click(function(){});//@todo
         }
         //UPDATE
         if(_actum===2||_actum===1){
            name='';
            name=fieldDisplay('list',null,true).join(' ');
            if(_actum===2)$('#displayMensa>li[data-iota='+_iota+']>a:first-child').html(name).addClass('text-success');
            if(_actum===1){
               $(form+' #submit_'+eternal.form.field.name)[0].onclick=function(e){e.preventDefault();creoDB.alpha(2,results.insertId);};//make the form to become update
               $(form).data('iota',results.insertId);
               li=creo({'data-iota':results.insertId},'li');
               a=creo({'href':'#'+eternal.form.field.name},'a',name);
               a.onclick=function(e){e.preventDefault(); creoDB.alpha(3,results.insertId)}
               li.appendChild(a);
               a=creo({'href':'#'},'a');
               a.onclick=function(e){e.preventDefault();creoDB.alpha(0,results.insertId); $(this).parent().hide();}
               i=creo({'clss':'icon icon-color icon-trash'},'i');
               a.appendChild(i);
               li.appendChild(a);
               document.getElementById('displayMensa').appendChild(li);
            }
         }
      });
   }
   /*
    * queries the db to display in list format
    * @param {integer} <var>_actum</var> the transaction
    * @param {integer} <var>_iota</var> the record identification
    * @returns {undefined}
    */
   this.beta=function(_actum,_iota){
      callDB=this;
      fieldDisplay=this.fieldDisplay;
      this.forma(_actum,_iota,function(results){
         if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);else eternal=null;
         this.name=eternal.form.field.name;
         switch(_actum){
            case 0:
               break;
            case 1:
               $(form).data('iota',results.insertId);
               //@todo:potential hack, if code not validated
               ref=$(form+' #name').val()||$(form+' #username').val();
               nameList='';
               nameList=fieldDisplay('list',null,true);
               $('.accordion-body.in').data('iota',results.insertId);
               $('.accordion-body.in').parents('.accordion-group').attr('id','accGroup'+results.insertId);
               $('.accordion-body.in').prev().data('iota',results.insertId).find('.icon-link').data('head',nameList[0]).data('ref',ref).removeClass('icon-black').addClass('icon-color');
               $(form+' #submit_'+this.name)[0].onclick=function(e){e.preventDefault();$('#submit_'+eternal.form.field.name).button('loading');callDB.beta(2,results.insertId);setTimeout(function(){$('#submit_'+this.name).button('reset');}, 1000)}//make the form to become update
               $(form+' #cancel_'+this.name).val('Done...');//@todo
               $('#accGroup'+results.insertId+' .betaRow').empty();
               s=$anima('#accGroup'+results.insertId+' .betaRow','span',{},nameList[0]);
               l=nameList.length;for(x=1;x<l;x++)s.genesis('span',{},true,nameList[x]);
               break;
            case 2:
               $(form+' #cancel_'+this.name).val('Done...');//@todo
               nameList='';
               nameList=fieldDisplay('list',null,true);
               $('#accGroup'+_iota+' .betaRow span').each(function(i,v){$(v).html(nameList[i])});
               break;
            case 3:
            default://select all
               theForm.setBeta(results,_actum,_iota)
               break;
         }//end switch
      });//end anonymous
   }
   /*
    *
    * @param {obeject} <var>_source</var> the source of the object
    * @param {string} <var>_form</var> the name of the form
    * @param {bool} <var>_head</var> only the head to be displayed
    * @returns {array} the list of header
    * @todo add radio and check return
    */
   this.fieldDisplay=function(_from,_source,_head){
      f=eternal.fields;
      c=0;
      _return=[];
      $.each(f,function(key,property){
         type=property.field.type;
         if(_head && !property.header) return true;
         switch(type){
            case 'radio':
            case 'check':
               if(_from==='form')$(form+' [name^='+key+']').each(function(){if($(this).prop('value')==_source[key])$(this).prop('checked',true);});
               if(_from==='list')$(form+' [name^='+key+']').each(function(){if($(this).prop('checked'))_return[c]=$(this).prop('value');});
               break;
            default:
               if(_from==='form')$(form+' #'+key).val(_source[key]);
               else if(_from==='list')_return[c]=$(form+' #'+key).val();
               else _return[c]=_source[key];
               break;
         }//endswitch
         c++;
      });
      return _return;
   }
   /*
    * deletes all references to the primary table
    * @param {array|string} <var>_quaerere</var>
    * @param {number|string} <var>_iota</var>
    * @param {string} <var>_iyona</var>
    * @returns {undefined}
    */
   this.referenceDelete=function(_quaerere,_iota,_iyona){
      switch(_iyona){
         case'users':
            $DB("SELECT username,id FROM users WHERE id=?",[_iota],'Selected user',function(results){
//               try{
                  row=results.rows.item(0);
                  l=_quaerere.length; for(x=0;x<l;x++)$DB(_quaerere[x],[row['username']],"Reference Deleted "+row['username']+" from:"+_iyona);
//               }catch(err){console.log("Error selecting reference:"+err.message)}
            });
            break;
         case'groups':
         case'permissions':
            $DB("SELECT name,id FROM "+_iyona+" WHERE id=?",[_iota],'Selected '+_iyona,function(results){
               try{
                  row=results.rows.item(0);
                  l=_quaerere.length; for(x=0;x<l;x++)$DB(_quaerere[x],[row['name']],"Reference Deleted "+row['name']+" from:"+_iyona);
               }catch(err){console.log("Error selecting reference:"+err.message)}
            });
            break;
      }//endswith
   }
   if(this instanceof SET_DB)return this;
   else return new SET_DB();
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
var $DB=function(quaerere,params,msg,callback){
   if(db){
      db.transaction(function(trans){
         trans.executeSql(quaerere,params,function(trans,results){
            console.log('Success DB transaction: '+msg);
            console.log(quaerere);
            j=$DB2JSON(results);
            $('#sideNotice .db_notice').html("Successful: "+msg).animate({opacity:0},200,"linear",function(){$(this).animate({opacity:1},200);});
            if(callback)callback(results);
         },function(_trans,_error){
            console.log('Failed DB: '+msg+':'+_error.message);
            console.log('::QUAERERE='+quaerere);
            $('#sideNotice .db_notice').html("<div class='text-error'>"+_error.message+'</div>');
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
   var j={};
   switch(_type){
      case 1:break;
      case 2:break;
      default:
         len=_results.rows.length;
         for(x=0;x<len;x++){
            console.log(_results.rowsAffected);
            row=_results.rows.item(x);
            col=0;
            for(k in row){row[col]=row[k];col++;}
            j[x]=row;
         }//endfor
         break;
   }//endswith
   return j;
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

