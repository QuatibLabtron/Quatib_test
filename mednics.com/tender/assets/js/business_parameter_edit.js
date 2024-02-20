 $(document).ready(function() {


    $("#bsnParmEdit").validate({

        errorClass: "myErrorClass",
        // Specify the validation error messages
        submitHandler: function(form) {

            try
            {
                var bpm_value = document.getElementById('bpm_value').value;
                var bpm_id =document.getElementById('bpm_id').value;

                  data = {


                     bpm_value:bpm_value,
                     bpm_id:bpm_id,

                    }


                  $.ajax({
                        type: "POST",
                       url:baseUrl+ "parameter/businessParameter_update",
                       data : data,
                        dataType:"json",
                        success: function(response){

                            if(response.success==true)
                            {
                              alert('Business Parameter Updated');
                              window.location.href=response.linkn;
                            }
                            else
                            {
                              alert('something went wrong');
                            }
                    }
              });

            }catch(e){
              console.log(e);
            }


        },
        errorPlacement: function(error, element){
         error.appendTo( element.next('.help-block') );
       }
    });




  });
