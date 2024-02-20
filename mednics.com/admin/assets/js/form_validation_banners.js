$(function() {
   
  

  $("#add-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          name: 
          {
            required: true,
                remote: {
                        url: baseUrl+"banners/checkbannersAvailability",
                        type: "post",
                        data: {name: function () {
                            return $('#name').val();
                            }
                        }
                    },
          },  
              
        },
       messages: {
         
        name: {
          required: "Please provide banners name.",
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
            required: "Please provide banners name.",
                   
          },  
         
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
            submitHandler:function(form)
            {
                var name=$('#name').val();
               
                url=baseUrl+"banners/checkbannersAvailability";
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
                            alert('please enter another banners name');
                        }
                        else
                        {
                            url1= baseUrl+'banners/edit_banners';
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

