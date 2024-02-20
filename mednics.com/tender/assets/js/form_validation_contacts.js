$(function() {
  
  $("#add-form").validate({
       ignore: 'input[type="hidden"]',
       rules: {
          cont_firstname: 
          {
            required: true,
          },
          cont_primaryemail: 
          {
            required: true,
            remote: {
                    url: baseUrl+"contacts/checkcontactsEmailAvailability",
                    type: "post",
                    data: {cont_primaryemail: function () {
                        return $('#cont_primaryemail').val();
                        }
                    }
                },
          }, 
          cont_mobilephone:
            {
              alpha_numeric:true,
            }, 
          cont_altphone:
            {
              alpha_numeric:true,
            },   
          
              
        },
       messages: {
         
        cont_firstname: {
          required: "Please provide contacts name.",
        },  
         cont_primaryemail: {
          required: "Please provide primary email.",
        },  
         cont_mobilephone:
            {
              alpha_numeric: "Enter valid number.",
            }, 
          cont_altphone:
            {
              alpha_numeric: "Enter valid number.",
            },  
        
       },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      }
     });
      jQuery.validator.addMethod("alpha_numeric", function(value, element) {
        return this.optional(element) ||  /^((\+)|0|-?)?[0-9]\d{9,11}$/g.test(value);
      });
     
    $("#edit-form").validate({
         ignore: 'input[type="hidden"]',
         rules: {
            cont_firstname: 
            {
              required: true,
             
            },
            cont_primaryemail: 
            {
              required: true,
            },
             cont_mobilephone:
            {
              alpha_numeric:true,
            }, 
          cont_altphone:
            {
              alpha_numeric:true,
            },  
          
        },
         messages: {
           
            cont_firstname: {
              required: "Please provide contacts name.",
            },  
           cont_primaryemail: {
              required: "Please provide categories name.",
            },
            cont_mobilephone:
            {
              alpha_numeric: "Enter valid number.",
            }, 
            cont_altphone:
            {
              alpha_numeric: "Enter valid number.",
            },  
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
            submitHandler:function(form)
            {
               var cont_primaryemail=$('#cont_primaryemail').val();
               url2=baseUrl+"contacts/checkcontactsEmailAvailability";
                $.ajax({
                    type:"POST",
                    url:url2,
                    data:{cont_primaryemail:$('#cont_primaryemail').val(),cont_id:$('#cont_id').val()},
                    dataType:"json",
                    success:
                    function(data)
                    {
                        if(data != true)
                        {
                            alert('please enter another primary email');
                        }
                        else
                        {
                              url1= baseUrl+'contacts/edit_contacts';
                              dataString = $('#edit-form').serialize();
                             
                            $.ajax({
                                    type: "POST",
                                    url:url1,
                                    data: dataString,
                                    dataType: "json",
                                    success:
                                    function(response)
                                    {
                                      
                                        if(response.success==true)
                                        {
                                          alert(response.message);
                                          window.location.href=response.linkn;
                                        }
                                        else
                                        {
                                          
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
     jQuery.validator.addMethod("alpha_numeric", function(value, element) {
      return this.optional(element) ||  /^((\+)|0|-?)?[0-9]\d{9,11}$/g.test(value);
      });
 });