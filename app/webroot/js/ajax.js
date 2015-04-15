$(document).ready(function(){
    
    $(document).on('click','.submitt',function(event){
        
        $.ajax({
            type:"GET",
            url:"sight",
            data: $(this).parent().parent().serializeArray(),
            datatype : "json",
            success:function(data){
                $('#contenu').html(data);
            },
            error:function (xhr, ajaxOptions, thrownError) {
                 $('#contenu').html(xhr.responseText);
                alert(thrownError);
              }
           
        });
        return false;
    });
    
     $(function() {

         $( document ).tooltip({ content: function() {return $(this).attr("title")}});
     });

     $('#diary').dataTable({
        "order": [[ 1, "desc" ]]
    } );
    $('#svn').dataTable({
        "order": [[ 0, "desc" ]]
    } );
    $('.datable').dataTable({
        "order": [[0, "desc"]],
        "paging": false,
        "ordering": false,
        "info": false,
        "sDom": ''
    });


});



