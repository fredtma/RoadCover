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
   this.creoAgito=function(_sql,_params,_msg){
      var sql=_sql;
      var params=_params||[];
      db.transaction(function(trans,_msg){
         trans.executeSql(sql,params,dbSuccess,dbError);
      });
   }

   if(!db){
      db=window.openDatabase(localStorage.DB_NAME,localStorage.DB_VERSION,localStorage.DB_DESC,localStorage.DB_SIZE*1024*1024);
      localStorage.DB=db;
      sql="CREATE TABLE IF NOT EXISTS users (id INTERGER PRIMARY KEY, username VARCHAR(90), password TEXT, firstname TEXT, lastname TEXT, email TEXT, gender TEXT)";
      this.creoAgito(sql,[],'Table users created');
      if(!localStorage.DB){
         this.creoAgito("CREATE INDEX user_username ON users(username)");
         this.creoAgito("CREATE INDEX user_email ON users(email)");
      }
   }
   if(this instanceof SET_DB)return this;
   else return new SET_DB();
}
/******************************************************************************/
/**
 * logs a successfull message from the db
 * @author fredtma
 * @version 1.6
 * @category log, success, db
 */
dbSuccess=function(_trans,_data){
   console.log('Success Db transaction');
   $('#sideNotice').append("<div class='db_notice'>Successful transaction</div>");
}
/******************************************************************************/
/**
 * logs an error from the db
 * @author fredtma
 * @version 1.5
 * @category db, error, log
 * @param object <var>_trans</var> the transaction variable from the db
 * @param object <var>_error</var> the error variable from the db
 */
dbError=function(_trans,_error){
   console.log('Failed Db transaction');
   $('#sideNotice').append("<div class='db_notice'>"+_error.message+'</div>');
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

