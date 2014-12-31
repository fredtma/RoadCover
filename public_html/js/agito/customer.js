/*
 * the customer's page script
 */
agitoScript=function(){
   var tmp={
      "form": {
         "options":{"readonly":"display","type":"","from":"server"},
         "field":{"clss":"form-horizontal form-tight","name":"customer","data-iota":"0"},
         "fieldset":{"name":"admin-customers","clss":"half-form"},
         "label":true,
         "legend":{"txt":"Road Cover Customers"},
         "button":{"close_customer":{"value":"Close","type":"button","clss":"btn btn-inverse"}},
         "ortus":"server",
         "aliquam":true,
         "navigation":true
      },
      "mensa": "customers",
      "quaerere":{"scopo":"","ubi":true,"finis":10},
      "fields": {
         "Title":{"complex":"span","field":{"clss":"formReader"}},
         "Customer":{"header":true,"search":true,"complex":"span","title":"Customer name","field":{"clss":"formReader"}},
         "Race":{"complex":"span","field":{"clss":"formReader"}},
         "Gender":{"complex":"span","field":{"clss":"formReader"}},
         "Nationality":{"complex":"span","field":{"clss":"formReader"}},
         "EthnicGroup":{"complex":"span","title":"EthnicGroup","field":{"clss":"formReader"}},
         "Start Date":{"header":true,"complex":"span","title":"Date Modified","field":{"clss":"formReader"}},
         "IDno":{"header":true,"search":true,"complex":"span","title":"ID Number","field":{"clss":"formReader"}},
         "dealer":{"complex":"span","title":"Dealer Name","field":{"clss":"formReader"}},
         "salesman":{"complex":"span","title":"Sales Person","field":{"clss":"formReader"}},
         "code":{"complex":"span","title":"Customer Number","field":{"clss":"formReader"}},
         "deal_number":{"complex":"span","title":"Deal Number","field":{"clss":"formReader"}},
      },
      "children":{
         "address":{"icon":"icon-user ","title":"View customer's address","quaerere":{"scopo":"","ubi":true,"finis":10},"global":{"complex":true,"type":"span"},"fields":{"Email":{"title":""},"Tel":{"title":""},"Cell":{"title":""},"Address":{"title":""},"City":{"title":""},"Province":{"title":""},"Code":{"title":""},"PostAddress":{"title":"Postal Address"}}},
         "brief":{"icon":"icon-briefcase ","title":"View customer's details","quaerere":{"scopo":"","ubi":true,"finis":10},"global":{"complex":true,"type":"span"},"fields":{"RegistrationNumber":{"title":"Registration Number"},"Description":{"title":"Vahicle"},"FirstDebitDate":{"title":"First Debit Date"},"MonthlyDebitDay":{"title":""},"Deposit":{"title":""},"PrincipalDebt":{"title":"Principal Debt"},"FSPFees":{"title":"FSP Fees"},"HandlinFees":{"title":"Handling Fees"},"ServiceAndDelivery":{"title":"Service And Delivery"},"Vaps":{"title":""}}},
         "expenses":{"icon":"icon-book ","title":"View customer's expenses","quaerere":{"scopo":""},"global":{"complex":"table"},"fields":{"Group":{},"Category":{},"Description":{},"Amounts":{}}},
         "quote":{"icon":"icon-bullhorn ","title":"View customer's quoute","quaerere":{"scopo":""},"global":{"complex":"table"},"fields":{"Description":{},"Current Amount":{},"Amount":{},"Sub Code":{}}},
         "vehicle":{"icon":"icon-road ","title":"View customer's vehicle details","global":{"complex":true,"type":"span"},"fields":{"Vehicle":{},"MotorVehicleType":{"title":"Motor Vehicle Type"},"EngineNumber":{"title":"Engine Number"},"FirstRegistrationDate":{"title":"First Registration Date"},"HasImmobiliser":{"title":"Has Immobiliser"},"RegistrationNumber":{"title":"Registration Number"},"VINNumber":{"title":"VIN Number"},"Year":{},"ItemType":{"title":"Item Type"},"PurchaseDate":{"title":"Purchase Date"},"IsNew":{"title":"Is New"},"IsDemo":{"title":"Is Demo"},"UseType":{"title":"Use Type"},"PurchaseDate":{"title":"Purchase Date"},"StockNumber":{"title":"Stock Number"},"Amount":{}}},
         "payment":{"icon":"icon-tags ","title":"View customer's finances","global":{"complex":true,"type":"span"},"fields":{"AccountType_cd":{"title":"Account Type"},"BankAccountNo":{"title":"Bank Account No"},"FirstDebitDate":{"title":"First Debit Date"},"MonthlyDebitDay":{"title":"Monthly Debit Day"},"ApplicationType_cd":{"title":"Application Type"},"PurchasePurpose_cd":{"title":"Purchase Purpose"},"CustomerType_cd":{"title":"Customer Type"},"RequestedInterestRate":{"title":"Requested Interest Rate"},"PaymentFrequency_cd":{"title":"Payment Frequency"},"ContractPeriod":{"title":"Contract Period"},"RateType_cd":{"title":"Rate Type"},"RequestedResidual":{"title":"Requested Residual"},"RequestedResidualPercentage":{"title":"Requested Residual Percentage"},"FinanceHouse_cd":{"title":"Finance House"},"ConsentCreditBuro":{"title":"Consent Credit Buro"},"ConfirmLOAReceived":{"title":"Confirm LOA Received"},"SourceOfDeposit_cd":{"title":"Source Of Deposit"},"Deposit":{"title":""},"Discount":{"title":""},"PrincipalDebt":{"title":"Principal Debt"}}},
         "cover":{"icon":"icon-download-alt ","title":"View customer's cover","global":{"complex":true,"type":"span"},"fields":{"Is Not Completed Time Constraint":{},"Is Not Completed Client Request":{},"Is FinanceOffered":{},"Accept No Short Term Cover":{},"Accept No Scratch And Dent":{},"Accept No Add Cover":{},"Accept No Deposit Cover":{},"Accept No Warranty":{},"Accept No Service Plan":{},"Accept No Maintenance Plan":{},"Accept No Credit Life":{},"Requires Service Plan":{},"Requires Warranty":{},"Amount Willing To Spend On Vaps":{}}},
         "history":{"icon":"icon-time ","title":"View customer's history","global":{"complex":"table"},"fields":{"Product Name":{},"DateModified":{},"Status":{},"Start Date":{},"End Date":{},"Premium":{},"Commission":{}}},
         "view":{"icon":"icon-home ","title":"Customer's Details","global":{"complex":true,"type":"span"},"fields":{"Title":{},"Customer":{},"Race":{},"Gender":{},"Nationality":{},"EthnicGroup":{},"Start Date":{},"IDno":{},"dealer":{},"salesman":{},"code":{},"code":{},"deal_number":{} }}
      }
   }
   var temp=$("footer").data("temp"), cust = $("footer").data("customer");
   sessionStorage.setItem("active",JSON.stringify(tmp));eternal=tmp;
   if(cust!==0){//not for zero customer
      if(typeof cust!=="undefined" && cust>0)temp=[cust,"customer"];//if there is a value in customer, seek to search that customer.
      var selection=$("footer").data("selection")||'';
      if(typeof selection=="object"){var txt;
         txt=$(".dealersList a[data-iota="+selection.dealers+"]").first().text();if(txt)$(".allDealer .theTXT").text(txt);txt='';
         txt=$(".salesmanList a[data-iota="+selection.salesman+"]").first().text(); if(txt)$(".allSalesman .theTXT").text(txt);txt='';
         txt=$(".monthList a[data-iota="+selection.month+"]").first().text();if(txt)$(".monthDrop .theTXT").text(txt);
      }
      var m=$("footer").data("selection")?$("footer").data("selection").month:localStorage.SITE_MONTH;
      var y=localStorage.SITE_YEAR;
      get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,"quaerere":temp,"luna":{0:y,1:m}},"","post","json",function(results,j){
         if(typeof temp==="undefined")temp=[0,"dealers"];
         sideDisplay(temp[0],temp[1]);
         var y=new Date().getFullYear(); var d=new Date(y,localStorage.SITE_MONTH-1,1).getMonth();
         if($("#betaCustomer small")[0])$("#betaCustomer small").html(" ___Month of "+dateFormat.i18n.monthNames[d+12]);
         else $("#betaCustomer h2").after("<small> ___Month of "+dateFormat.i18n.monthNames[d+12]+"</small>");
         if(results.rows.length){theForm=new SET_FORM()._Set("#body article");theForm.setBeta(results);reDraw();}
         else $("#body article").html("<ul class='breadcrumb'><li>There is currently no record for the selected "+temp[1]+" for the month of "+dateFormat.i18n.monthNames[d+12]+"</li></ul>");
      });//@getAjax
   }//endif
};agitoScript();
function onShow(on){
   var Name=eternal.form.field.name;
   var frmId='#frm_'+Name;
   var frmName='frm_'+Name;
   var ii=$('.accordion-body.in').data('jesua');var frm,active,code,reference,setEle,container,tmp;
   if(on){
      frm=document.getElementById(frmName);
      resetForm(frm);
      document.querySelector('.accordion-body.in .accordion-inner').appendChild(frm);
      frm.style.display='block';
      fieldsDisplay('form',ii);
   }//endif
   //SET CHILD FORM
   active=$('.accordion-heading[data-jesua="'+ii+'"]').data('activated');
   code=$('.accordion-heading[data-jesua="'+ii+'"]').data('code');//@explain:get the code of the table it's like jesua
   //retirer la deuxieme form ici
   if(!document.querySelector(frmId+2))container=$anima(frmId,"fieldset",{"clss":"half-form formReader","id":frmName+2}).father;
   else container=document.querySelector(frmId+2);
   $(container).empty();
   if(typeof active!=="undefined"){
      get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa+"-"+active,iota:code},"","post","json",function(results){
         reference=eternal.children[active];
         setEle=document.querySelector(frmId+" fieldset");
         $anima(container,"legend",{},aNumero(eternal.children[active].title));
         setEle.parentNode.insertBefore(container,setEle.nextSibling);//place the new fields set next to the old one
         if(reference.global.complex=="table"){
            theForm.gammaTable(results,active,frmId+2);
         }else{//endif
            theForm.form2=container;//to place in the second form
            theForm.setObject({"items":reference,"father":theForm.singleForm});//end setObject
            fieldsDisplay("form",results[0],false,active);
         }//endif
      });
   }//ednif
   tmp=code=null;
}
reDraw=function(){
   var collapseName,tmp;
   var Name=eternal.form.field.name;
   var frmId="#frm_"+Name;
   var frmName="frm_"+Name;
   collapseName="#acc_"+Name;
   $("#txtSrchCust").focus(function(){var set=this;setTimeout(function(set){set.select();},100) });
   $(".memberIcon").click(function(){
      if($(".popover").length) return false;
      $("footer").data("record",{"changeActiveRecord":false,"changeNavigator":false});
      tmp=$(this).data("agilis");$(this).parents(".accordion-heading").data("activated",tmp);
      if($(".accordion-body.in")[0]){onShow(false);}//@fix:order is important. over here the .in will not appear yet becos show is not fired
      tmp=$(this).parents("div").data("jesua");$("#collapse_customer"+tmp).collapse("show");tmp=null;
   });
   $(".betaRow").click(function(){tmp=$(this).parents("div").data("jesua");$("#collapse_customer"+tmp).collapse("toggle");tmp=null;});//@row clicked collapse
   $(frmId+" #close_"+Name).click(function(){$(".accordion-body.in").collapse("hide");});//@button CLOSE collapse
   $(collapseName).on("shown",function(){//@onShown
      if(!$(this).data("toggle_shown")||$(this).data("toggle_shown")==0){
         $(this).data("toggle_shown",1);
         onShow(true);
      }//endif
   });//@onShown
   $(collapseName).on("hidden",function(){$(this).data("toggle_shown",0); });//@onHidden
}
