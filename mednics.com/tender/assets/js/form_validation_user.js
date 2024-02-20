$(function() 
{

  $("#add-form").validate(
  {
    ignore: 'input[type="hidden"]',
    rules: {
      prs_name:{
        required:true,
      },
      prs_email: 
        {
          email: true,
          required:true,
          remote: {
                  url: baseUrl + "user/remote_email_exists",
                  type: "post",
                  data: {prs_email: function () {
                          return $('#prs_email').val();
                      }
                  }
              },
        },    
      },
      prs_emilpwd:{
        required:true,
      },
      prs_currency:{
        required:true,
      },
      prs_password:{
        required:true,
      },
      prs_password1:{
        required:true,
        equalTo: "#prs_password"
      },
    messages: {
      prs_name:{
        required:"Please provide name.",
      },
      prs_email: {
        required: "Please provide email address.",
        email: "Please provide valid email address.",
        remote:"Email Id already registered",
      },
      prs_emilpwd:{
        required:"Please provide valid email password.",
      },
      prs_currency:{
        required:"Please select currency.",
      },
       prs_password:{
        required:"Please enter password",
      },
      prs_password1:{
        required:"Please re-enter password",
        equalTo:"Retype correct password",
      },
    },
    errorPlacement: function(error, element){ error.appendTo( element.next('.text-danger') );  },
    submitHandler: function(form)  
    {
      document.getElementById("form_submit").style.display="none";
      document.getElementById("processing").style.display="inline-block";
      var prs_name      = document.getElementById('prs_name').value; 
      var prs_mob       = document.getElementById('prs_mob').value;
      var prs_email     = document.getElementById('prs_email').value; 
      var prs_password  = document.getElementById('prs_password').value;
      var prs_dpt_id    = document.getElementById('prs_dpt_id').value;
      var prs_emilpwd   = document.getElementById('prs_emilpwd').value;
      var prs_skypeid   = document.getElementById('prs_skypeid').value;
      var prs_tnc       = document.getElementById('prs_tnc').value;
      var prs_currency  = document.getElementById('prs_currency').value;
      var prs_host      = document.getElementById('prs_host').value;
      var prs_port      = document.getElementById('prs_port').value;
      data =
          {
            prs_name:prs_name,
            prs_mob:prs_mob,
            prs_email:prs_email,
            prs_password:prs_password,
            prs_dpt_id:prs_dpt_id,
            prs_emilpwd:prs_emilpwd,
            prs_skypeid:prs_skypeid,
            prs_tnc:prs_tnc,
            prs_currency:prs_currency,
            prs_host:prs_host,
            prs_port:prs_port
          }
      $.ajax({
        type: "POST",
        url:baseUrl+ "user/add_user",
        data: data,
        dataType:"json",
        beforeSend: function()
        {
          $("#form_submit").html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Connecting');
        },
        success: function(response)
        {
         if(response.success==true)
          {
            alert(response.message);
            window.location.href=response.linkn;
          }
          else
          { 
             $('#error').css('display','block');
             document.getElementById("error").innerHTML=response.message;
             $("#form_submit").html(' Submit');
          }
        }    
      });
    }
  });
     
  $("#edit-form").validate(
  {
    ignore: 'input[type="hidden"]',
    rules: {
      prs_name: {
        required: true,
      },  
    },
    messages: {
      prs_name: {
        required: "Please provide name.",
      },        
    },
    errorPlacement: function(error, element) { error.appendTo( element.next('.text-danger'));},
    submitHandler:function(form)
    {
      var prs_id        = document.getElementById('prs_id').value;
      var prs_name      = document.getElementById('prs_name').value; 
      var prs_mob       = document.getElementById('prs_mob').value;
      var prs_email     = document.getElementById('prs_email').value; 
      var prs_username  = document.getElementById('prs_username').value;
      var prs_dpt_id    = document.getElementById('prs_dpt_id').value;
      var prs_emilpwd   = document.getElementById('prs_emilpwd').value;
      var prs_skypeid   = document.getElementById('prs_skypeid').value;
      var prs_tnc       = document.getElementById('prs_tnc').value;
      var prs_currency  = document.getElementById('prs_currency').value;
      var prs_host      = document.getElementById('prs_host').value;
      var prs_port      = document.getElementById('prs_port').value;
      data =
        {
          prs_id:prs_id,
          prs_name:prs_name,
          prs_mob:prs_mob,
          prs_email:prs_email,
          prs_username:prs_username,
          prs_dpt_id:prs_dpt_id,
          prs_emilpwd:prs_emilpwd,
          prs_skypeid:prs_skypeid,
          prs_tnc:prs_tnc,
          prs_currency:prs_currency,
          prs_host:prs_host,
          prs_port:prs_port
        }
            
        $.ajax({
             type: "POST",
             url:baseUrl+ "user/edit_user/" +prs_username,
             data: data,
             dataType:"json",
             beforeSend: function(){
              $("#form_submit").html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Connecting');
            },
            success: function(response){
             if(response.success==true)
             {
              alert(response.message);
              window.location.href=response.linkn;
            }
            else
            { 
             $('#error').css('display','block');
             document.getElementById("error").innerHTML=response.message;
             $("#form_submit").html(' Submit');
           }
         }    
       });
    }
  });

  $("#password_update_form").validate(
  {
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
      var prs_id = document.getElementById('prs_id').value; //alert(prs_id);
      var usr_ref = document.getElementById('usr_ref').value; // alert(usr_ref);
      var password = document.getElementById('password').value; //alert(password);
      var old_password = document.getElementById('old_password').value;// alert(old_password);
      data = {
            prs_id:prs_id,
            usr_ref:usr_ref,
            old_password:old_password,
            password:password
        }
        $.ajax({
          type: "POST",
          url:baseUrl + "user/changepassword", 
          data : data,
          dataType:"json",
          success: function(response)
          {
            if(response.success==true)
            { 
              document.getElementById("submit-button_pwd").style.display="inline-block";
              document.getElementById("processing_pwd").style.display="none";
              alert(response.message);
              window.location.href=response.linkn;
            }
            else
            {
              document.getElementById("submit-button_pwd").style.display="inline-block";
              document.getElementById("processing_pwd").style.display="none";
              alert(response.message);
              location.reload();
            }
          
          }
        })
    }
  });

 });

function validateUsername(username)
{
  if(username!='')
  {
    var usr_id = $('#usr_id').val(); 
    data=
      {
        username:username,
        usr_id:usr_id,
      }
    $.ajax(
    {
      type: "POST",
      url:baseUrl+ "user/validateUsernameEdit",
      data :data,
      dataType:"json",
      success: function(response)
      {
        if(response.success==true)
        {
          $('#error').css('display','none');
          document.getElementById("error").innerHTML='';
        }
        else
        { 
          $('#error').css('display','block');
          document.getElementById("error").innerHTML=response.message;
        }
      }    
    });
  }   
}
 