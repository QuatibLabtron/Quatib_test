$(function() {
   
  $("#add-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          section: 
          {
            required: true,
                remote: {
                        url: baseUrl+"section/checksectionAvailability",
                        type: "post",
                        data: {section: function () {
                            return $('#section').val();
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
         
        section: {
          required: "Please provide section name.",
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
          section: {
            required: true,
                    
          },  
          page_url:
          {
            required: true,
          },
          
        },
         messages: {
           
          section: {
            required: "Please provide section name.",
                   
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
                var section=$('#section').val();
               
                url=baseUrl+"section/checksectionAvailability";
                $.ajax({
                    type:"POST",
                    url:url,
                    data:{section:$('#section').val(),id:$('#id').val()},
                    dataType:"json",
                    success:
                    function(data)
                    {
                        if(data != true)
                        {
                            alert($('#section').val()+' is already taken.Please try another one.');							   location.reload();
                        }
                        else
                        {
                            url1= baseUrl+'section/edit_section';
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

    $("#import-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          
          importfile:
          {
            required: true,
          },
              
        },
       messages: {
         
       
        importfile:
        {
          required: "Please select file to import.",
        },
        
       },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      }
     });

 });
