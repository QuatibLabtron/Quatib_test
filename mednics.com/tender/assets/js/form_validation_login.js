$(function() {

  // Setup form validation on the #register-form element
  $("#login_form").validate({  

      // Specify the validation rules

      // Specify the validation error messages
      submitHandler: function(form) {
        
        var usr_username = document.getElementById('usr_username').value; 
        var usr_password = document.getElementById('usr_password').value;
        if(document.getElementById('rememberme').checked) 
        {
         var rememberme=1;
       }
       else
       {
        var rememberme=0;
      }
      var ref =  $('#ref').val(); 

      data = {
       usr_username:usr_username,
       usr_password:usr_password,
       rememberme:rememberme,
       ref:ref
     }
     

     $.ajax({
      type: "POST",
      url:base_url+ "login/checklogin",
      data: data,
      dataType:"json",
      beforeSend: function(){
       $("#form_submit1").html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Connecting');
     },

     success: function(response){
      if(response.success==true)
      {

       console.log(response);
     //window.location.href=response.linkn; 
    window.location.href = base_url+ "googleAuth?value="+$.trim(response.email);

     }
     else
       {  $("#form_submit1").html(' Sign In');
     alert(response.message);
   }
   
 }    
});

     
   }
 });

});