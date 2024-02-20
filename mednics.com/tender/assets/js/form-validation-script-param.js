var Script = function () {
//alert('addnewparameter');
    $.validator.setDefaults({
        submitHandler: function() {
            var gen_id = document.getElementById('gen_id').value;
          //  alert('gen_id');
           var gen_name = document.getElementById('gen_name').value;
          // alert('gen_name');
           // var FLA_value = document.getElementById('FLA_value').value;
            var gen_group = document.getElementById('gen_group').value;
           // alert('gen_group');
           var gen_order = document.getElementById('gen_order').value;
            //alert('gen_order');
           // var FLA_status = document.getElementById('FLA_status').value;
           
            

              data = {
                gen_id:gen_id,
                  gen_name:gen_name,
                  // FLA_value:FLA_value,
                  gen_group:gen_group,
                  gen_order:gen_order,
                  // FLA_status:FLA_status,
                 
    }
     $.ajax({
        type: "POST",
       // url: base_url + "MFS/savefree_trial", 
      url: "parameter/paraminserts", 
        data : data,
        dataType:"json",
        success: function(response){

          var i = -1;
          var toastCount = 0;
          var $toastlast;

          
          if(response.success==true){



             document.getElementById("add_param").reset()
             alert(response.message);
           location.reload();
          }else{
            alert(response.message);




           
          }
          
        }
    });
    return false; 
        }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#add_param").validate();

        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",
                agree: "Please accept our policy"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();