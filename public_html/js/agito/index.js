/*
 * script to execute on first page
 */

tmp = new SET_DISPLAY();
tmp.navTab({"home":{"txt":"Home","icon":"icon-home","clss":"active"},"dealers":{"txt":"Dealers","icon":"icon-book","sub":["First Dealer","Second Dealer","Third Dealer","Fourth Dealer","hr","View All Dealers"]},"salesman":{"txt":"Salesman","icon":"icon-briefcase","sub":["First Salesman","Second Salesman","Third Salesman","Fourth Salesman","hr","View All Salesman"]},"customers":{txt:"Customers","icon":"icon-user"},"insurance":{"txt":"Insurance","icon":"icon-folder-open"},"system":{"txt":"System","icon":"icon-cog","sub":["View Logs","View Clients","Run Import","View Reports","Setup Permission"]}});
tmp.commonSet({"clss":"btn btn-primary"}).btnGroup({
   "btn-notify":{"title":"My Notification","icon":"icon-inbox icon-white"},
   "btn-print":{"title":"Print Page","icon":"icon-print icon-white"},
   "btn-email":{"title":"Email page","icon":"icon-envelope icon-white"},
   "btn-word":{"title":"Convert to MS Word","icon":"icon-th-large icon-white"},
   "btn-excel":{"title":"Convert to MS Excel","icon":"icon-th icon-white"}
});


