/*
 * application page for the members page
 */
tmp={
   "form": {
      "options":{"readonly":true,"type":"betaTable"},
      "field":{"clss":"form-horizontal","name":"member","data-iota":"0"},
      "fieldset":{"name":"admin-members"},
      "legend":{"txt":localStorage.SITE_NAME+" Member's"},
      "button":{"submit_member":{"value":"Save Change","type":"submit","clss":"btn btn-primary","save":true,"data-loading-text":"Saving..."},"cancel_member":{"value":"Cancel","type":"reset","clss":"btn btn-inverse"}}
   },
   "mensa": "members",
   "quaerere":{"scopo":""},
   "fields": {
      "Dealer":{"header":true},
      "Salesman":{"header":true},
      "Fullname":{"header":true},
      "Name":{"header":true},
      "Period":{"header":true},
      "CollectionMethod":{"header":true,"title":"Collection Method"},
      "TotalAmount":{"header":true,"title":"Total Amount"},
      "DateModified":{"header":true,"title":"Date Modified"},
   }
}
sessionStorage.active=JSON.stringify(tmp);tmp=null;
eternal=typeof eternal!="undefined"?eternal:eternalCall();
get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"iota":sessionStorage.iota},'','post','json',function(_rows){
   sideDisplay(sessionStorage.iota,'dealers');
   sessionStorage.removeItem("iota");
   theForm = new SET_FORM();
   theForm._Set("#body article");
   theForm.gammaTable(JSON.stringify(_rows));
});
//@todo add to the menu the three most recents