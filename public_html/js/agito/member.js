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
sessionStorage.setItem('active',JSON.stringify(tmp));
eternal=tmp;temp=$('footer').data('temp');
get_ajax(localStorage.SITE_SERVICE,{"militia":temp[1],"iota":temp[0]},'','post','json',function(_rows){
   sideDisplay(temp[0],'dealers');
   theForm = new SET_FORM();
   theForm._Set("#body article");
   theForm.gammaTable(JSON.stringify(_rows));
});
//@todo add to the menu the three most recents