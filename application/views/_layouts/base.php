<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/jquery-1.8.3.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="/assets/js/jquery.scrollTo.min.js"></script>
<script src="/assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/assets/js/jquery.sparkline.js"></script>
<script src="/assets/js/common-scripts.js"></script>

<script type="text/javascript" src="/assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="/assets/js/gritter-conf.js"></script>

<script src="/assets/js/datatables/js/jquery.datatables.min.js"></script>
<script src="/assets/js/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="/assets/js/x-editable/inputs-ext/name/name.js"></script>
<script src="/assets/js/summernote-master/summernote.min.js"></script>
<script>
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
    $(document).ready(function(){
             $('#typeparent').hide();
                $("#cd-type").change(function(){
                var id=$(this).val();
                
                var dataString = 'id='+ id;

                $.ajax
                ({
                type: "POST",
                url: "/ajax/get_child_user_level",
                data: dataString,
               
                cache: false,
                success: function(html)
                {    
                   var $select = $('#cd-type-parent'); 
                   if(html!=''){
                      
                        $('#typeparent').show();
                        $select.find('option').remove();  
                        var jo = $.parseJSON(html);
    
                        $.each(jo, function (i, val) {

                             $select.append('<option value=' + val.id + '>' + val.user_role_type + '</option>');

                        });
                        if(jo==''){
                         $('#typeparent').hide(); 
                     }
                       
                     }
                }
                });

        });

});
</script>