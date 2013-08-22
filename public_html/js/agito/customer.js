/*
 * the customer's page script
 */
tmp={
   "form": {
      "options":{"readonly":"display","type":"","from":"server"},
      "field":{"clss":"form-horizontal form-tight","name":"customer","data-iota":"0"},
      "fieldset":{"name":"admin-customers","clss":"half-form"},
      "label":false,
      "legend":{"txt":"Road Cover Customers"},
      "button":{"close_customer":{"value":"Close","type":"button","clss":"btn btn-inverse"}},
      "ortus":"server"
   },
   "mensa": "customers",
   "quaerere":{"scopo":"","ubi":true,"finis":10},
   "fields": {
      "Title":{"complex":"span","field":{"clss":"formReader"}},
      "Fullnames":{"header":true,"search":true,"complex":"span","title":"Customer name","field":{"clss":"formReader"}},
      "Race":{"complex":"span","field":{"clss":"formReader"}},
      "Gender":{"complex":"span","field":{"clss":"formReader"}},
      "Nationality":{"complex":"span","field":{"clss":"formReader"}},
      "EthnicGroup":{"complex":"span","title":"EthnicGroup","field":{"clss":"formReader"}},
      "DateCreated":{"header":true,"complex":"span","title":"Date Created","field":{"clss":"formReader"}},
      "IDno":{"header":true,"search":true,"complex":"span","title":"ID Number","field":{"clss":"formReader"}},
      "code":{"complex":"span","title":"code","field":{"clss":"formReader"}},
   },
   "children":{
      "address":{"icon":"icon-user ","title":"View customer's address","quaerere":{"scopo":"","ubi":true,"finis":10},"global":{"complex":true,"type":"span"},"fields":{"Email":{"title":""},"Tel":{"title":""},"Cell":{"title":""},"Address":{"title":""},"City":{"title":""},"Province":{"title":""},"Code":{"title":""},"PostAddress":{"title":"Postal Address"}}},
      "brief":{"icon":"icon-briefcase ","title":"View customer's details","quaerere":{"scopo":"","ubi":true,"finis":10},"global":{"complex":true,"type":"span"},"fields":{"RegistrationNumber":{"title":"Registration Number"},"Description":{"title":"Vahicle"},"FirstDebitDate":{"title":"First Debit Date"},"MonthlyDebitDay":{"title":""},"Deposit":{"title":""},"PrincipalDebt":{"title":"Principal Debt"},"FSPFees":{"title":"FSP Fees"},"HandlinFees":{"title":"Handling Fees"},"ServiceAndDelivery":{"title":"Service And Delivery"},"Vaps":{"title":""}}},
      "expenses":{"icon":"icon-book ","title":"View customer's expenses","quaerere":{"scopo":""},"global":{"complex":"table"},"fields":{"Group":{},"Category":{},"Description":{},"Amounts":{}}},
      "vehicle":{"icon":"icon-road ","title":"View customer's vehicle details","global":{"complex":true,"type":"span"},"fields":{"Vehicle":{},"MotorVehicleType":{"title":"Motor Vehicle Type"},"EngineNumber":{"title":"Engine Number"},"FirstRegistrationDate":{"title":"First Registration Date"},"HasImmobiliser":{"title":"Has Immobiliser"},"RegistrationNumber":{"title":"Registration Number"},"VINNumber":{"title":"VIN Number"},"Year":{},"ItemType":{"title":"Item Type"},"PurchaseDate":{"title":"Purchase Date"},"IsNew":{"title":"Is New"},"IsDemo":{"title":"Is Demo"},"UseType":{"title":"Use Type"},"PurchaseDate":{"title":"Purchase Date"},"StockNumber":{"title":"Stock Number"},"Amount":{}}},
      "payment":{"icon":"icon-tags ","title":"View customer's finances","global":{"complex":true,"type":"span"},"fields":{"AccountType_cd":{"title":"Account Type"},"BankAccountNo":{"title":"Bank Account No"},"FirstDebitDate":{"title":"First Debit Date"},"MonthlyDebitDay":{"title":"Monthly Debit Day"},"ApplicationType_cd":{"title":"Application Type"},"PurchasePurpose_cd":{"title":"Purchase Purpose"},"CustomerType_cd":{"title":"Customer Type"},"RequestedInterestRate":{"title":"Requested Interest Rate"},"PaymentFrequency_cd":{"title":"Payment Frequency"},"ContractPeriod":{"title":"Contract Period"},"RateType_cd":{"title":"Rate Type"},"RequestedResidual":{"title":"Requested Residual"},"RequestedResidualPercentage":{"title":"Requested Residual Percentage"},"FinanceHouse_cd":{"title":"Finance House"},"ConsentCreditBuro":{"title":"Consent Credit Buro"},"ConfirmLOAReceived":{"title":"Confirm LOA Received"},"SourceOfDeposit_cd":{"title":"Source Of Deposit"},"Deposit":{"title":""},"Discount":{"title":""},"PrincipalDebt":{"title":"Principal Debt"}}},
      "cover":{"icon":"icon-download-alt ","title":"View customer's cover","global":{"complex":true,"type":"span"},"fields":{"Is Not Completed Time Constraint":{},"Is Not Completed Client Request":{},"Is FinanceOffered":{},"Accept No Short Term Cover":{},"Accept No Scratch And Dent":{},"Accept No Add Cover":{},"Accept No Deposit Cover":{},"Accept No Warranty":{},"Accept No Service Plan":{},"Accept No Maintenance Plan":{},"Accept No Credit Life":{},"Requires Service Plan":{},"Requires Warranty":{},"Amount Willing To Spend On Vaps":{}}}
   }
}
sessionStorage.setItem('active',JSON.stringify(tmp));
eternal=tmp;temp=$('footer').data('temp');console.log(temp,'temp');
get_ajax(localStorage.SITE_SERVICE,{"militia":eternal.mensa,'quaerere':temp},'','post','json',function(results){
   if(temp)sideDisplay(temp[0],temp[1]);
   theForm=new SET_FORM()._Set("#body article");
   theForm.setBeta(results);
//   $('.memberIcon').tooltip();
   Name=eternal.form.field.name;
   frmId='#frm_'+Name;
   frmName='frm_'+Name;
   collapseName='#acc_'+Name;
   $('.memberIcon').click(function(){
      tmp=$(this).data('agilis');$(this).parents('.accordion-heading').data('activated',tmp);
      tmp=$(this).parents('div').data('iota');$("#collapse_customer"+tmp).collapse('show');tmp=null;
      if($('.accordion-body.in')[0]){
         onShow(false);
      }
   });
   $('.betaRow').click(function(){tmp=$(this).parents('div').data('iota');$("#collapse_customer"+tmp).collapse('toggle');tmp=null;});//@row clicked collapse
   $(frmId+' #close_'+Name).click(function(){$('.accordion-body.in').collapse('hide');});//@button CLOSE collapse
   $(collapseName).on('shown',function(){//@onShown
      if(!$(this).data('toggle_shown')||$(this).data('toggle_shown')==0){
         $(this).data('toggle_shown',1);
         onShow(true);
      }//endif
   });//@onShown
   $(collapseName).on('hidden',function(){$(this).data('toggle_shown',0); });//@onHidden
});//@getAjax
function onShow(on){
   ii=$('.accordion-body.in').data('iota');
   if(on){
      frm=document.getElementById(frmName);
      resetForm(frm);
      document.querySelector('.accordion-body.in .accordion-inner').appendChild(frm);
      frm.style.display='block';
      fieldsDisplay('form',ii);
   }//endif
   //SET CHILD FORM
   active=$('.accordion-heading[data-iota="'+ii+'"]').data('activated');
   code=$('.accordion-heading[data-iota="'+ii+'"]').data('code');//@explain:get the code of the table it's like iota
   if(typeof active!=="undefined"){
      get_ajax(localStorage.SITE_SERVICE,{'militia':eternal.mensa+'-'+active,iota:code},'','get','json',function(results){
         reference=eternal.children[active];console.log(reference,active);
         setEle=document.querySelector(frmId+' fieldset');
         if(!document.querySelector(frmId+2))container=$anima(frmId,'fieldset',{'clss':'half-form formReader','id':frmName+2}).father;
         else container=document.querySelector(frmId+2);
         $(container).empty();
         $anima(container,'legend',{},aNumero(eternal.children[active].title));
         setEle.parentNode.insertBefore(container,setEle.nextSibling);//place the new fields set next to the old one
         if(reference.global.complex=="table"){
            theForm.gammaTable(results,active,frmId+2);
         }else{//endif
            theForm.setObject({"items":reference,"father":theForm.singleForm});//end setObject
            fieldsDisplay('form',results[0],false,active);
         }//endif
      });
   }//ednif
   tmp=code=null;
}