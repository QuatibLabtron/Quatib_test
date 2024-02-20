$(function() {
   
  $("#add-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          name: 
          {
            required: true,
                remote: {
                        url: baseUrl+"pages/checkpagesAvailability",
                        type: "post",
                        data: {pages: function () {
                            return $('#name').val();
                            }
                        }
                    },
          },  
          page_url:
          {
            required: true,
          },
              
        },
       messages: {
         
        name: {
          required: "Please provide page name.",
        },  
        page_url:
        {
          required: "Please provide page url.",
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
          page_url:
          {
            required: true,
          },
          
        },
         messages: {
           
          name: {
            required: "Please provide page name.",
                   
          },  
          page_url:
          {
            required: "Please provide page url.",
          }
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
            submitHandler:function(form)
            {
                var name=$('#name').val();
               
                url=baseUrl+"pages/checkpagesAvailability";
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
                            alert($('#name').val()+' is already taken.Please try another one.');							   location.reload();
                        }
                        else
                        {
                            url1= baseUrl+'pages/edit_pages';
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
