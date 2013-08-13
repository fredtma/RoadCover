/*
 * the customer's page script
 */
tmp={
   "form": {
      "options":{"readonly":"display","type":"betaTable","from":"server"},
      "field":{"clss":"form-horizontal form-tight","name":"customer","data-iota":"0"},
      "fieldset":{"name":"admin-customers","clss":"half-form"},
      "label":false,
      "legend":{"txt":"Road Cover Customers"},
      "button":{"close_customer":{"value":"Close","type":"button","clss":"btn btn-inverse"}}
   },
   "mensa": "customers",
   "quaerere":{"scopo":"","ubi":true,"finis":10},
   "fields": {
      "Fullnames":{"header":true,"complex":"span","title":"Customer name","field":{"clss":"formReader"}},
      "DateCreated":{"header":true,"complex":"span","title":"Date Created","field":{"clss":"formReader"}},
      "IDno":{"header":true,"complex":"span","title":"ID Number","field":{"clss":"formReader"}},
      "code":{"complex":"span","title":"code","field":{"clss":"formReader"}},
   },
   "children":{
      "details":{"icon":"icon-user ","title":"View customer's details","quaerere":{"scopo":"","ubi":true,"finis":10},"fields":{}},
      "expenses":{"icon":"icon-tag ","title":"View customer's expenses","quaerere":{"scopo":""},"fields":{}},
      "vehicle":{"icon":"icon-tags ","title":"View customer's vehicle details","quaerere":{"scopo":""},"fields":{}},
      "payment":{"icon":"icon-road ","title":"View customer's finances","quaerere":{"scopo":""},"fields":{}},
      "cover":{"icon":"icon-download-alt ","title":"View customer's cover","quaerere":{"scopo":""},"fields":{}}
   }
}
sessionStorage.setItem('active',JSON.stringify(tmp));
eternal=tmp;
get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa},'','post','json',function(results){
   theForm=new SET_FORM()._Set("#body article");
   theForm.setBeta(results);
//   $('.memberIcon').tooltip();
   $('.memberIcon').click(function(){
      tmp=$(this).data('agilis');
      $(this).parents('.accordion-heading').data('activated',tmp);
   });
});