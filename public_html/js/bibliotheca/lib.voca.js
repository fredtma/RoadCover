/*
 * vocation call to menu and pages
 * @see jquery|bootstrap.min|lib.muneris|res.lambda|res.forma|res.notitia|lib.ima.js
 */
addRecord=function(){
   var link,collapse_content;
   var name=eternal.form.field.name;
   var d=new Date().format("isoDateTime");
   var jesua=md5("alpha"+d);
   var r="_new"+Math.floor((Math.random()*100)+1);
   var collapseTo="#collapse_"+name+r;
   var collapse_head=$anima("#acc_"+name,"div",{"clss":"accordion-group class_"+jesua,"data-jesua":jesua},"","first");
   collapse_head.vita("div",{"clss":"accordion-heading","data-jesua":"alpha"},true)
      .vita("a",{"clss":"betaRow","contenteditable":false,"data-toggle":"collapse","data-parent":"#acc_"+name,"href":collapseTo},true);
      var $collapseElement=collapse_head.father;//heading row father
      collapse_head.vita("span",{},false).child.innerHTML="Type "+name+" name here";
   collapse_head.novo(".class_"+jesua+" .accordion-heading","i",{"clss":"betaRight"})
      //EDIT
      var father=collapse_head.father;
      collapse_head.vita("a",{"clss":"accordion-toggle","data-toggle":"collapse","data-parent":"#acc_"+name,"href":collapseTo},true)
      .vita("i",{"clss":"icon icon-color icon-edit"});
      collapse_head.genesis("a",{"href":"javascript:void(0)","clss":"forIcon"},true)
         .vita("i",{"clss":"icon icon-color icon-trash"}).child.onclick=function(){delRecord(this)};
         for(link in eternal.links){
            collapse_head.father=father;//places the element to the level of the fother <i>
            //leave icon black, until insert, value will change
            collapse_head.vita("a",{"href":"javascript:void(0)","clss":"forIcon"},true).vita("i",{"clss":"icon icon-black icon-link","title":"Link "+eternal.links[link][1]});
            $(collapse_head.child).data("ref",0);$(collapse_head.child).data("head",0);//@todo:add the function after the insert has been done
            $(collapse_head.child).data("link",link);$(collapse_head.child).data("links",eternal.links[link]);
            $(collapse_head.child).click(function(){//@note: watchout for toggle, u"ll hv to click twist if u come back to an other toggle.
               $(".accordion-heading .icon-black").removeClass("icon-black").addClass("icon-color");$(this).removeClass("icon-color").addClass("icon-black");
               if($(this).data("ref")!=0)linkTable($(this).data("head"), $(this).data("link"),$(this).data("links"),$(this).data("ref"));
               else $("#displayMensa").empty();
            });
         }
   collapse_content=$anima(".class_"+jesua,"div",{"clss":"accordion-body collapse","id":"collapse_"+name+r,"data-jesua":"alpha"});
   collapse_content.vita("div",{"clss":"accordion-inner"},false,"");
}
edtRecord=function(){var ii;ii=$(this).parents('div').data('iota');DB.beta(3,ii);$('.activeContent').removeClass('activeContent');$(this).parents('.accordion-group').find('.accordion-inner').addClass('activeContent');}
delRecord=function(set){var ii;var DB=new SET_DB();ii=$(set).parents('div').data('jesua');if(ii!="alpha")DB.beta(0,ii);$(set).parents('.accordion-group').hide();}
/*
 * used to the records through the store record stored in the sessionStorage.activeRecord
 */
function navig(set){
   if($(set).parents('li').hasClass('disabled')) return false;
   var page=parseInt($(set).data('goto'))-1;
   if($(set).hasClass('navig'))page=parseInt($(set).data('goto'));//ca cest pour les navigation de deriere et en avant.
   sessionStorage.genesis=(page)*localStorage.DB_LIMIT;
   if(typeof eternal.form.ortus==="undefined"){creoDB=new SET_DB();creoDB.beta();}
   else if(eternal.form.ortus=="server"){theForm=new SET_FORM()._Set("#body article");theForm.setBeta(JSON.parse(sessionStorage.activeRecord));}
}
/*
 * used to the records through the store record stored in the sessionStorage.activeRecord
 */
function navigTable(set){
   if($(set).parents('li').hasClass('disabled')) return false;
   var page=parseInt($(set).data('goto'))-1;//fait attention les page prev & next, il faut pas faire la subtraction
   if($(set).hasClass('navTable'))page=parseInt($(set).data('goto'));//ca cest pour les navigation de deriere et en avant.
   sessionStorage.genesis=(page)*localStorage.DB_LIMIT;
   theForm = new SET_FORM()._Set("#body article");//@todo: ajouter les nombre du total sur la navigation
   theForm.gammaTable(JSON.parse(sessionStorage.activeRecord));
}
//=============================================================================//
$('.btnUser,.profileList').click(function(){activateMenu("profile","home","#link_home");});
$('.profileView,#userName').click(function(){activateMenu("profile","home","#link_home",false,false,"alpha");})
$('.btnGroup').click(function(){activateMenu("group","home","#link_home");});
$('.system4,#btnSysPermission').click(function(){activateMenu("permission","system","#link_system")});
$('.btnDashboard').click(function(){if(!activateMenu("dashboard","home","#link_home",true)){theDashboard();}});//when the script is already loaded call the function
$('.system1,#btnSysClient').click(function(){activateMenu("client","system","#link_system");});
$('#btnHelper,.system3').click(function(){activateMenu("helper","system","#link_system");});
$('#link_customers').click(function(){activateMenu("customer","customers","#link_customers",true);});
$('#link_insurance').click(function(){activateMenu("member","insurance","#link_insurance",true);});
$('#btnFeatures,.system2').click(function(){activateMenu('feature',false,false,false,true);});
$('#footContact').click(function(){getPage('Contact us')});
$('#footHelp').click(function(){getPage('Help?')});
$('#footAbout').click(function(){getPage('About us')});
$("#search_all").focus(function(){this.select();}).typeahead({minLength:0,source:searchAll,updater:searchUpdate});
$('.btnFullScreen,#fullscreen').click(function(){if(!$(this).data('toggle')||$(this).data('toggle')==0){$('#btnFullScreen,#fullscreen').data('toggle',1);enableFullScreen();$('.icon-fullscreen').removeClass('icon-fullscreen').addClass('icon-screenshot');}else{$('#btnFullScreen,#fullscreen').data('toggle',0);exitFullScreen();$('.icon-screenshot').removeClass('icon-screenshot').addClass('icon-fullscreen');}});
$('#userOut,#profileOff').click(loginOUT);
$('.icon-refresh').click(refreshLook);//@todo:add HTML5 history API
$(".btnHelp").click(helpfullLink);
$('#btnTest').click(resetGenesis);