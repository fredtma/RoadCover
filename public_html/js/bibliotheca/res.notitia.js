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
   var db=null;
   this.mensaActive=['profile'];
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
            console.log('Failed DB transaction: '+msg);
            $('#sideNotice .db_notice').html("<div class='text-error'>"+_error.message+'</div>');
         });
      });
   }

   if(!db){
      db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      localStorage.DB=db;
//      this.creoAgito("COMMIT",[],'commit');
//      sql="CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR(90) NOT NULL, password TEXT NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL)";
//      this.creoAgito(sql,[],'Table users creation');
      if(!localStorage.DB){
         sql="CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR(90) NOT NULL, password TEXT NOT NULL, firstname TEXT NOT NULL, lastname TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL)";
         this.creoAgito(sql,[],'Table users creation');
         this.creoAgito("CREATE INDEX user_username ON users(username)");
         this.creoAgito("CREATE INDEX user_email ON users(email)");
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
      eternal=JSON.parse(sessionStorage.active);
      if(!eternal){console.log("not found json");return false;}
      form='#'+eternal.form.field.id||'#frm_'+eternal.form.field.name;
      iota=_iota;
      iyona=eternal.mensa||form.substr(4);
      if(!this.mensaActive.indexOf(iyona)){console.log("not found mensa");return false;}
      var quaerere=[],params=[],set=[];

      switch(_actum){
         case 0:break;
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
            ubi=iota?' WHERE id='+iota+' LIMIT 5':' LIMIT 5';
            ubi=' FROM '+iyona+ubi;
            msg='Selected '+iyona;break;
      }
      if(_actum!=0){
         x=0;
         iota=iota||$(form).data('iota');
         $.each(eternal.fields,function(field,setting){
            val=$(form+' #'+field).val()||$(form+' [name^='+field+']:checked').val();
            if(isset(val) && _actum!=3){
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
            ubi=(_actum!=1)?ubi:') VALUES ('+set.valueOf()+')';
            if(_actum==3)quaerere.push('id');
            quaerere=actum+' '+quaerere.valueOf()+ubi;
            this.creoAgito(quaerere,params,msg,callback);
         }
         console.log(quaerere);
      }else{
         //@todo:remove record
      }
   }
   /*
    * the successful return function
    * @see this.forma
    */
   this.alpha=function(_actum,_iota){
      this.forma(_actum,_iota,function(results){
//         console.log(_trans);
//         console.log(_result);
         eternal=JSON.parse(sessionStorage.active);
         if(!eternal){console.log("not found json");return false;}
         form='#'+eternal.form.field.id||'#frm_'+eternal.form.field.name;
         iyona=eternal.mensa||form.substr(4);
         display=$('#displayMensa');
//         iota=results.insertId?results.insertId:$(form).data('iota');
//         $(form).data('iota',iota);
         len=results.rows.length;
         if(display.data('mensa')!=iyona){
            display.data('mensa',iyona);//prevent this to fill with the same data table list
            for(x=0;x<len;x++){
               name='';
               row=results.rows.item(x);
               li=creo({'data-iota':row['id']},'li');
               a=creo({'href':'#profile'},'a');
               $.each(eternal.fields,function(k,v){if(v.header)name+=row[k]+' '});
               txt=document.createTextNode(name);
               a.onclick=function(e){e.preventDefault(); i=$(this).parent().data('iota');f=new SET_DB(); f.alpha(3,i)}
               a.appendChild(txt);li.appendChild(a);
               i=creo({'clss':'icon icon-color icon-trash'},'i');
               a=creo({'href':'#'},'a');a.appendChild(i);li.appendChild(a);
               display.append(li);
            }
         }

         if(len==1){
            row=results.rows.item(0);
            console.log(form);
            $(form).data('iota',row['id']);
            $.each(eternal.fields,function(k,v){$(form+' #'+k).val(row[k]);});
            $(form+' #submit_'+eternal.form.name).click(function(){alert('alert');});
         }
      });
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

