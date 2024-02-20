$(function() {
   
  
  $("#add-form").validate({
       ignore: 'input[type="hidden"]',
       rules: {
          org_name: 
          {
            required: true,
            remote: {
                    url: baseUrl+"organisations/checkorganisationsAvailability",
                    type: "post",
                    data: {org_name: function () {
                        return $('#org_name').val();
                        }
                    }
                },
          },
          org_primaryemail: 
          {
            required: true,
            remote: {
                    url: baseUrl+"organisations/checkorganisationsEmailAvailability",
                    type: "post",
                    data: {org_primaryemail: function () {
                        return $('#org_primaryemail').val();
                        }
                    }
                },
          },  
          
              
        },
       messages: {
         
        org_name: {
          required: "Please provide organisations name.",
        },  
         org_primaryemail: {
          required: "Please provide primary email.",
        },  
        
        
       },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      }
     });
     
    $("#edit-form").validate({
         ignore: 'input[type="hidden"]',
         rules: {
            org_name: 
            {
              required: true,
             
            },
            org_primaryemail: 
            {
              required: true,
            },  
          },
         messages: {
           
            org_name: {
            required: "Please provide organisations name.",
          },  
           org_primaryemail: {
            required: "Please provide categories name.",
          },  
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
        submitHandler:function(form) 
        {
            var org_name=$('#org_name').val();
           
            url=baseUrl+"organisations/checkorganisationsAvailability";
            $.ajax({
                type:"POST",
                url:url,
                data:{org_name:$('#org_name').val(),org_id:$('#org_id').val()},
                dataType:"json",
                success:
                function(data)
                {
                  if(data != true)
                  {
                      alert('please enter another organisation name');
                  }
                  else
                  {
                   var org_primaryemail=$('#org_primaryemail').val();
                   url2=baseUrl+"organisations/checkorganisationsEmailAvailability";
                    $.ajax({
                        type:"POST",
                        url:url2,
                        data:{org_primaryemail:$('#org_primaryemail').val(),org_id:$('#org_id').val()},
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
                                  url1= baseUrl+'organisations/edit_organisations';
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
                }
            });
        }
       });
 });

    function copy_to_shipping()
    {
        $("#org_shippingadd").empty();
        $("#org_shippingpob").empty();
        $("#org_shippingcity").empty();
        $("#org_shippingstate").empty();
        $("#org_shippingpoc").empty();
        var billing_address = $("#org_billingadd").val();
        var billing_pob     = $("#org_billingpob").val();
        var billing_city    = $("#org_billingcity").val();
        var billing_state   = $("#org_billingstate").val();
        var billing_poc     = $("#org_billingpoc").val();
        var billing_country = $("#org_billingcountry").val();
        $("#org_shippingadd").val(billing_address);
        $("#org_shippingpob").val(billing_pob);
        $("#org_shippingcity").val(billing_city);
        $("#org_shippingstate").val(billing_state);
        $("#org_shippingpoc").val(billing_poc);
        $('#org_shippingcountry').val(billing_country);
        $('#org_shippingcountry').trigger('change.select2');
       
    }
    function copy_to_billing()
    {
        $("#org_billingadd").empty();
        $("#org_billingpob").empty();
        $("#org_billingcity").empty();
        $("#org_billingstate").empty();
        $("#org_billingpoc").empty();
        var shipping_address = $("#org_shippingadd").val();
        var shipping_pob     = $("#org_shippingpob").val();
        var shipping_city    = $("#org_shippingcity").val();
        var shipping_state   = $("#org_shippingstate").val();
        var shipping_poc     = $("#org_shippingpoc").val();
        var shipping_country = $("#org_shippingcountry").val();
        
        $("#org_billingadd").val(shipping_address);
        $("#org_billingpob").val(shipping_pob);
        $("#org_billingcity").val(shipping_city);
        $("#org_billingstate").val(shipping_state);
        $("#org_billingpoc").val(shipping_poc);
         $('#org_billingcountry').val(shipping_country);
        $('#org_billingcountry').trigger('change.select2');
       
    }