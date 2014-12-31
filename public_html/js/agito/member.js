/*
 * application page for the members page
 */
agitoScript=function(){
   var tmp={
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
         "deal_number":{"header":true,"title":"Deal Number"},
         "Dealer":{"header":true},
         "Status":{"header":true},
         "Salesman":{"header":true},
         "Customer":{"header":true,"search":true},
         "product_name":{"header":true, "title":"Product"},
         "quot_period":{"header":true,"title":"Period"},
         "quot_collection":{"header":true,"title":"Collection Method"},
         "TotalAmount":{"header":true,"title":"Total Amount"},
         "date_start":{"header":true,"title":"Start Date"},
         "idno":{"header":false,"search":"Fullname"}
      }
   }
   var selection=$("footer").data("selection")||'';
   if(typeof selection=="object"){var txt;
      txt=$(".dealersList a[data-iota="+selection.dealers+"]").first().text();if(txt)$(".allDealer .theTXT").text(txt);txt='';
      txt=$(".salesmanList a[data-iota="+selection.salesman+"]").first().text(); if(txt)$(".allSalesman .theTXT").text(txt);txt='';
      txt=$(".monthList a[data-iota="+selection.month+"]").first().text();if(txt)$(".monthDrop .theTXT").text(txt);
   }
   sessionStorage.setItem('active',JSON.stringify(tmp));
   eternal=tmp;temp=$('footer').data('temp');//get deafault dealer
   var m=$("footer").data("selection")?$("footer").data("selection").month:localStorage.SITE_MONTH;//default month
   var y=localStorage.SITE_YEAR;
   get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{0:y,1:m}},'','post','json',function(_rows){
      if(typeof temp==="undefined")temp=[0,"dealers"];
      sideDisplay(temp[0],temp[1]);
      var y=new Date().getFullYear(); var d=new Date(y,localStorage.SITE_MONTH-1,1).getMonth();
      if($("#betaInsurance small")[0])$("#betaInsurance small").html(" ___Month of "+dateFormat.i18n.monthNames[d+12]);
      else $("#betaInsurance h2").after("<small> ___Month of "+dateFormat.i18n.monthNames[d+12]+"</small>");
      if(_rows.rows.length){theForm = new SET_FORM();theForm._Set("#body article");theForm.gammaTable(_rows);}
      else $("#body article").html("<ul class='breadcrumb'><li>There is currently no record for the selected "+temp[1]+" for the month of "+dateFormat.i18n.monthNames[d+12]+"</li></ul>");
   });
};agitoScript();
