/*
 * application page for the members page
 */
tmp={
   "form": {
      "options":{"readonly":true,"type":"betaTable"},
      "field":{"clss":"form-horizontal","name":"member","data-iota":"0"},
      "fieldset":{"name":"admin-members"},
      "legend":{"txt":localStorage.SITE_NAME+" Member's"},
      "button":{"submit_member":{"value":"Save Change","type":"submit","clss":"btn btn-primary","save":true,"data-loading-text":"Saving..."},"cancel_member":{"value":"Cancel","type":"reset","clss":"btn btn-inverse"}},
      "ortus":"server",
      "aliquam":true,
      "navigation":true
   },
   "mensa": "members",
   "quaerere":{"scopo":""},
   "fields": {
      "Dealer":{"header":true},
      "Salesman":{"header":true},
      "Fullname":{"header":true,"search":true},
      "Name":{"header":true},
      "Period":{"header":true},
      "CollectionMethod":{"header":true,"title":"Collection Method"},
      "TotalAmount":{"header":true,"title":"Total Amount"},
      "DateModified":{"header":true,"title":"Date Modified"},
      "IDno":{"header":false,"search":"Fullname"}
   }
}
sessionStorage.setItem('active',JSON.stringify(tmp));
eternal=tmp;temp=$('footer').data('temp');
get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{1:localStorage.SITE_MONTH}},'','post','json',function(_rows){
   if(typeof temp==="undefined")temp=[0,"dealers"];
   sideDisplay(temp[0],temp[1]);
   var y=new Date().getFullYear(); var d=new Date(y,localStorage.SITE_MONTH-1,1).getMonth();$("#betaInsurance h2").append("<small> ___Month of "+dateFormat.i18n.monthNames[d+12]+"</small>");
   theForm = new SET_FORM();theForm._Set("#body article");theForm.gammaTable(_rows);
   delete temp;delete tmp;
});
$("#btnSubMonthList2 li").click(function(){//@explain:when the month list is selected, the function is repeated
      var m=this.id;var temp=$('footer').data('temp');
      get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{1:m}},'','post','json',function(_rows){
         if(typeof temp==="undefined")temp=[0,"dealers"];
         sideDisplay(temp[0],temp[1]);
         var y=new Date().getFullYear(); var d=new Date(y,m-1,1).getMonth();$("#betaInsurance h2").append("<small> for the month of "+dateFormat.i18n.monthNames[d+12]+"</small>");
         theForm = new SET_FORM();theForm._Set("#body article");theForm.gammaTable(_rows);
      });
   });
//@todo add to the menu the three most recents