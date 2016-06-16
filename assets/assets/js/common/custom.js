/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
   var base_url = $('body').find('#base_url').val();
    
     $("#customer-data").dataTable({
//              "oLanguage": {
//            "sProcessing": "<img src='"+base_url+"../assets/img/ajax-loader.gif'>"},
//         "ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "customer_list", "bDeferRender": true,
        "aLengthMenu": [[50, 100, -1], [50, 100,200, $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone", "aTargets": [5]},
            {"sClass": "hidden-phone text-center", "aTargets": [6],"bSortable": false },
            
        ]}
        );
    
    
})

   // JavaScript Document

        startList = function() {
        if (document.all&&document.getElementById) {
        navRoot = document.getElementById("nav");
        for (i=0; i<navRoot.childNodes.length; i++) {
        node = navRoot.childNodes[i];
        if (node.nodeName=="LI") {
        node.onmouseover=function() {
        this.className+=" over";
          }
          node.onmouseout=function() {
          this.className=this.className.replace(" over", "");
           }
           }
          }
         }
        }
window.onload=startList;
$(function(){
          // Your event
        $('.child-li').click(function(){
               // Get the ID for the element that was clicked
               var childId = $(this).attr('id');
               var parentId = $(this).parents('li').attr('id');
               $('input[name="cd-type"').val(childId);
                $('input[name="cd-parent"').val(parentId);
                $("#parentlevel").html($('#'+parentId).clone().children().remove().end().text());
                $("#childlevel").html($(this).text());
          });
           $('.parent-li').on('click',function(){
            if($(this).children().length == 0){
                  
                   var currentId = $(this).attr('id');
                 $('input[name="cd-type"').val(currentId);
                 $('input[name="cd-parent"').val(currentId);
                  $("#parentlevel").html($(this).text());
                    $("#childlevel").html($(this).text());
              }
              
          })
       
     });
  