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
   this.creoAgito=function(_sql,_params,_msg,callback){
      var sql=_sql;
      var msg=_msg;
      var params=_params||[];
//      if(!db) db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      db.transaction(function(trans){
         trans.executeSql(sql,params,function(trans,results){
            console.log('Success DB transaction: '+msg);
            $('#sideNotice .db_notice').html("Successful transaction: "+msg);
            if(callback)callback(results);
         },function(_trans,_error){
            console.log('Failed DB transaction: '+msg+':'+_error.message);
            $('#sideNotice .db_notice').html("<div class='text-error'>"+_error.message+'</div>');
         });
      });
   }
   console.log('db='+db);
   if(!db){
      db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      d=new Date();
      d=d.format('isoDate');
      if(!localStorage.DB){
         localStorage.DB=db;
         sql="CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR(90) NOT NULL, password TEXT NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL, creation TEXT DEFAULT '"+d+"')";
         this.creoAgito(sql,[],'Table users creation');
         this.creoAgito("CREATE INDEX user_username ON users(username)");
         this.creoAgito("CREATE INDEX user_email ON users(email)");
         group="CREATE TABLE IF NOT EXISTS groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, desc TEXT, creation TEXT)";
         this.creoAgito(group,[],'Table groups created');
         this.creoAgito("CREATE INDEX groups_name ON groups(name)",[],'index groups_name');
         link="CREATE TABLE IF NOT EXISTS link_users_groups (id INTEGER PRIMARY KEY AUTOINCREMENT, `user` INTEGER, `group` INTEGER, creation TEXT DEFAULT '"+d+"')";
         this.creoAgito(link,[],'Table link to users and groups created');
         this.creoAgito("CREATE INDEX link_usergroup_user ON link_users_groups(`user`)",[],'index link_usergroup_user');
         this.creoAgito("CREATE INDEX link_usergroup_group ON link_users_groups(`group`)",[],'index link_usergroup_group');
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
            actum='DELETE FROM '+iyona+' WHERE id=?';
            this.creoAgito(actum,[_iota],'Deleted record from '+iyona,callback);break;
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
         $.each(eternal.fields,function(field,setting){
            console.log(form+' #'+field);
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
      console.log(quaerere);
   }
   /*
    * the successful return function
    * @see this.forma
    */
   this.alpha=function(_actum,_iota){
      fieldDisplay=this.fieldDisplay;
      this.forma(_actum,_iota,function(results){
//         console.log(_trans);
         console.log(results);
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
      this.forma(_actum,_iota,function(results){
         if(sessionStorage.active)eternal=JSON.parse(sessionStorage.active);else eternal=null;
         switch(_actum){
            case 0:
               break;
            case 1:
               break;
            case 2:
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

