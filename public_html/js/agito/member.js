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
         "Id":{"header":true,"title":"Deal Number"},
         "Dealer":{"header":true},
         "Status":{"header":true},
         "Salesman":{"header":true},
         "Fullname":{"header":true,"search":true},
         "Name":{"header":true, "title":"Agreement"},
         "Period":{"header":true},
         "CollectionMethod":{"header":true,"title":"Collection Method"},
         "TotalAmount":{"header":true,"title":"Total Amount"},
         "DateModified":{"header":true,"title":"Date Modified"},
         "IDno":{"header":false,"search":"Fullname"}
      }
   }
   sessionStorage.setItem('active',JSON.stringify(tmp));
   eternal=tmp;temp=$('footer').data('temp');console.log(temp,"temp");
   get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{1:localStorage.SITE_MONTH}},'','post','json',function(_rows){
      if(typeof temp==="undefined")temp=[0,"dealers"];
      sideDisplay(temp[0],temp[1]);
      var y=new Date().getFullYear(); var d=new Date(y,localStorage.SITE_MONTH-1,1).getMonth();
      if($("#betaInsurance small")[0])$("#betaInsurance small").html(" ___Month of "+dateFormat.i18n.monthNames[d+12]);
      else $("#betaInsurance h2").after("<small> ___Month of "+dateFormat.i18n.monthNames[d+12]+"</small>");
      if(_rows.rows.length){theForm = new SET_FORM();theForm._Set("#body article");theForm.gammaTable(_rows);}
      else $("#body article").html("<ul class='breadcrumb'><li>There is currently no record for the selected "+temp[1]+" for the month of "+dateFormat.i18n.monthNames[d+12]+"</li></ul>");
   });
};agitoScript();
$("#btnSubMonthList2 li").click(function(){//@explain:when the month list is selected, the function is repeated
      var m=this.id;var temp=$('footer').data('temp');
      get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{1:m}},'','post','json',function(_rows){
         if(typeof temp==="undefined")temp=[0,"dealers"];
         sideDisplay(temp[0],temp[1]);
         var y=new Date().getFullYear(); var d=new Date(y,m-1,1).getMonth();
         $("#betaInsurance small").html("for the month of "+dateFormat.i18n.monthNames[d+12]);
         if(_rows.rows.length){theForm = new SET_FORM();theForm._Set("#body article");theForm.gammaTable(_rows);}
         else $("#body article").html("<ul class='breadcrumb'><li>There is currently no record for the selected "+temp[1]+" for the month of "+dateFormat.i18n.monthNames[d+12]+"</li></ul>");
      });
   });
//@todo add to the menu the three most recents