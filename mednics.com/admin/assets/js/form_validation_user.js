$(function() {
   
   $("#add-form").validate({  
        ignore: 'input[type="hidden"]',
         rules: {
          prs_name: {
            required: true,
          },
           prs_email: {
            required: true,
            email : true,
          },
          prs_dpt_id: {
            required: true,
          },
          
        },
         messages: {
           
          prs_name: {
            required: "Please provide name.",  
          }, 
          prs_email: {
            required: "Please provide email id.",
            email : "Invalid email address", 
          },
          prs_dpt_id: {
            required: "Please select department name.", 
          },
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        }
     });


      $("#user_edit").validate({
        ignore: 'input[type="hidden"]',
         rules: {
          prs_name: {
            required: true,
          },
           prs_email: {
            required: true,
            email : true,
          },
          prs_dpt_id: {
            required: true,
          },
          
        },
         messages: {
           
          prs_name: {
            required: "Please provide name.",  
          }, 
          prs_email: {
            required: "Please provide email id.",
            email : "Invalid email address", 
          },
          prs_dpt_id: {
            required: "Please select department name.", 
          },
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        }
    });

    $("#password_update_form").validate({
        rules: {
         
          old_password: {
                    required: true,
                    minlength: 6
                },
          password: {
                    required: true,
                    minlength: 6,
                   
                },
          cnfm_password: {
                    required: true,
                    // minlength: 6,
                    equalTo: "#password"
                },
          },
          messages: {
                old_password: {
                    required: "Please provide a password",
                    // minlength: "Your password must be at least 6 characters long"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
                cnfm_password: {
                    required: "Please provide a password",
                    // minlength: "Your password must be at least 6 characters long",
                    equalTo: "Please enter the same password as above"
                },
        },
        submitHandler: function(form)
        {
              
          document.getElementById("submit-button_pwd").style.display="none";
          document.getElementById("processing_pwd").style.display="inline-block";
          var prs_id        = document.getElementById('prs_pass_id').value;
          var usr_ref       = document.getElementById('prs_pass_username').value;  
          var password      = document.getElementById('password').value;
          var old_password  = document.getElementById('old_password').value;
          
            data = 
            {
              prs_id:prs_id,
              usr_ref:usr_ref,
              old_password:old_password,
              password:password
            }
            $.ajax({
              type: "POST",
              url:base_url + "user/changepassword", 
              data : data,
              dataType:"json",
              success: function(response)
              {
                if(response.success==true)
                {
                    alert(response.message);
                    window.location.href=response.linkn;
                    }else{
                    alert(response.message);
                    location.reload();
                }
              }
          })
        }
      });

 });