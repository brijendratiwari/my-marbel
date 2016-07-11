/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
   var base_url = $('body').find('#base_url').val();
    
     $("#customer-data").dataTable({
              "oLanguage": {
            "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
//         "ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "customer_list", "bDeferRender": true,
        "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0],"sClass":"hidden"},
            {"sClass": "aligncenter text-center", "aTargets": [1],"bSortable": false },
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone", "aTargets": [5]},
            {"sClass": "hidden-phone", "aTargets": [6]},
            {"sClass": "hidden-phone text-center", "aTargets": [7],"bSortable": false},
           
            
        ]}
        );



    /* order list datatable... */
    
     $("#order-data").dataTable({
              "oLanguage": {
            "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
//         "ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "order_list", "bDeferRender": true,
        "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0],"sClass": "hidden"},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone", "aTargets": [5]},
            {"sClass": "hidden-phone", "aTargets": [6]},
            {"sClass": "hidden-phone", "aTargets": [7]},
            {"sClass": "hidden-phone text-center", "aTargets": [8],"bSortable": false },
            
        ]}
        );
    /* shipping list datatable... */
    
    var shipping_data = $("#shipping-data").dataTable({
              "oLanguage": {
            "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
//         "ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "shipping_list", "bDeferRender": true,
         "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0],"sClass": "hidden"},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone", "aTargets": [5]},
            {"sClass": "hidden-phone", "aTargets": [6]},
            {"sClass": "hidden-phone", "aTargets": [7]},
            {"sClass": "hidden-phone", "aTargets": [8]},
            {"sClass": "hidden-phone", "aTargets": [9]},
            {"sClass": "hidden-phone", "aTargets": [10]},
            {"sClass": "hidden-phone text-center", "aTargets": [11],"bSortable": false },
            
        ]}
        );

     /* filter by country */
     $('#country-search').change( function() { 
            shipping_data.fnFilter( $(this).val() ); 
       });
    
       /* shipped list datatable... */
    
     $("#shipped-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "shipped_list", "bDeferRender": true,
         "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0],"sClass": "hidden",},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone", "aTargets": [5]},
            {"sClass": "hidden-phone text-center", "aTargets": [6],"bSortable": false },
            
            
        ]}); 
    
     /* finished list datatable... */
    
     $("#finished-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "services_list?status=finished", "bDeferRender": true,
         "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone text-center", "aTargets": [5],"bSortable": false },
            
            
        ]}); 
       /* inhouse list datatable... */
    $("#inhouse-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "services_list?status=inhouse", "bDeferRender": true,
         "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
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
            
            
        ]}); 
    /* pending list datatable... */
     $("#pending-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "services_list?status=pending", "bDeferRender": true,
         "aLengthMenu": [[10,20,50, 100, -1], [10,20,50, 100,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 50,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]},
            {"sClass": "hidden-phone text-center", "aTargets": [5],"bSortable": false },
            
            
        ]}); 
    
     /* task assign to me datatable... */
     $("#task-assign-to-me-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bFilter": false ,
        "bLengthChange":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "get_task_assign_to_me", "bDeferRender": true,
         "aLengthMenu": [[5,10,20, -1], [5,10,20,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1],"bSortable": false},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [3],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [4],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [5],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [6]},
            {"sClass": "hidden-phone", "aTargets": [7],"bSortable": false},
           
        ]}); 
    /* task assign to me datatable... */
     $("#task-assign-by-me-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        //"ordering": false,
        "bFilter": false ,
        "bLengthChange":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "get_task_assign_by_me", "bDeferRender": true,
         "aLengthMenu": [[5,10,20, -1], [5,10,20,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1],"bSortable": false},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [3],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [4],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [5],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [6]},
            {"sClass": "hidden-phone", "aTargets": [7],"bSortable": false},
            {"sClass": "hidden-phone", "aTargets": [8],"bSortable": false}
           
            
          
              
        ]}); 
    /* task assign to me datatable... */
     $("#task-completed-to-me-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        "ordering": false,
        "bFilter": false ,
        "bLengthChange":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "get_task_completed_to_me", "bDeferRender": true,
         "aLengthMenu": [[5,10,20, -1], [5,10,20,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]}
       
          
              
        ]});
    /* task completed to me datatable... */
     $("#task-completed-to-me-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        "ordering": false,
        "bFilter": false ,
        "bLengthChange":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "get_task_completed_to_me", "bDeferRender": true,
         "aLengthMenu": [[5,10,20, -1], [5,10,20,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]}
       
          
              
        ]});
    /* task completed assign by me datatable... */
     $("#completed_task_assign_by_me-data").dataTable({
        "oLanguage": {
        "sProcessing": "<img width='80px' src='"+base_url+"assets/images/chekout-loading.gif'>"},
        "ordering": false,
        "bFilter": false ,
        "bLengthChange":false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "get_completed_task_assign_by_me", "bDeferRender": true,
         "aLengthMenu": [[5,10,20, -1], [5,10,20,'All', $("#sAll").val()]],
        "sPaginationType": "numbers",
        "iDisplayLength": 10,
        "bDestroy": true, //!!!--- for remove data table warning.
        "aoColumnDefs": [
            {"aTargets": [0]},
            {"sClass": " aligncenter", "aTargets": [1]},
            {"sClass": "eamil_conform aligncenter", "aTargets": [2]},
            {"sClass": "hidden-phone", "aTargets": [3]},
            {"sClass": "hidden-phone", "aTargets": [4]}
       
          
              
        ]});
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
  
