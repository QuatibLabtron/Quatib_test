$(function() {
   
  $("#add-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          name: 
          {
            required: true,
                remote: {
                        url: baseUrl+"entities/checkentitiesAvailability",
                        type: "post",
                        data: {entities: function () {
                            return $('#name').val();
                            }
                        }
                    },
          },  
         
              
        },
       messages: {
         
        name: {
          required: "Please provide page name.",
        }, 
        
       },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      }
     });
     


    $("#edit-form").validate({
         ignore: 'input[type="hidden"]',
         rules: {
          name: {
            required: true,
                    
          }, 
          
        },
         messages: {
           
          name: {
            required: "Please provide page name.",
                   
          }, 
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
            submitHandler:function(form)
            {
                var name=$('#name').val();
               
                url=baseUrl+"entities/checkentitiesAvailability";
                $.ajax({
                    type:"POST",
                    url:url,
                    data:{name:$('#name').val(),id:$('#id').val()},
                    dataType:"json",
                    success:
                    function(data)
                    {
                        if(data != true)
                        {
                            alert('please enter another page name');
                        }
                        else
                        {
                            url1= baseUrl+'entities/edit_entities';
                              dataString = $('#edit-form').serialize();

                            $.ajax({
                                    type: "POST",
                                    url:url1,
                                    data: dataString,
                                    dataType: "json",
                                    success:
                                    function(response)
                                    {
                                      
                                        if(response.success==true){
                                                    alert(response.message);
                                                    window.location.href=response.linkn;
                                            }else{
                                              
                                                   alert(response.message);
                                                   location.reload();
                                        }
                                    }
                                });
                        }
                    }

                });

            }
       });

 });
