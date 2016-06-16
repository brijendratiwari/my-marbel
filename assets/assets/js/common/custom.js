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