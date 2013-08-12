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
      "Fullname":{"header":true},
      "Name":{"header":true},
      "Period":{"header":true},
      "CollectionMethod":{"header":true,"title":"Collection Method"},
      "TotalAmount":{"header":true,"title":"Total Amount"},
      "DateModified":{"header":true,"title":"Date Modified"},
   }
}
sessionStorage.active=JSON.stringify(tmp);tmp=null;
get_ajax(localStorage.SITE_SERVICE,{"militia":"dealer","iota":"1654"},'','post','json',function(_rows){
   theForm = new SET_FORM();
   theForm._Set("#body article");
   theForm.gammaTable(JSON.stringify(_rows));
});