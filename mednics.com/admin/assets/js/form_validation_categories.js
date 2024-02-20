$(function() {
  $("#add-form").validate({

       ignore: 'input[type="hidden"]',
       rules: {
          name: 
          {
            required: true,
                remote: {
                        url: baseUrl+"categories/checkcategoriesAvailability",
                        type: "post",
                        data: {name: function () {
                            return $('#name').val();
                            }
                        }
                    },
          },  
          page_url:
          {
            required: true,
          },
          section:
          {
            required: true,
          },
              
        },
       messages: {
         
        name: {
          required: "Please provide categories name.",
        },  
        page_url:
        {
          required: "Please provide page url.",
        },
        section:
        {
          required: "Please select section.",
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
          section:
          {
            required: true,
          },
          
        },
         messages: {
           
          name: {
            required: "Please provide categories name.",
                   
          },  
          page_url:
          {
            required: "Please provide page url.",
          },
           section:
          {
            required: "Please select section.",
          },
                    
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
            submitHandler:function(form)
            {
                var name=$('#name').val();
               
                url=baseUrl+"categories/checkcategoriesAvailability";
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
                            url1= baseUrl+'categories/edit_categories';
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

 
    function get_category_level(id)
    {
      var category_id = id;
      var zero_val = 0;
        $("#level").val(zero_val);

         $.ajax({
            type: "POST",
            url: baseUrl + "categories/check_category_level",
            data: {category_id : category_id},
             dataType:"json",
            success: function(data) 
            {
              if(data.success==true)
              {
                $("#level").val(data.level);
              }
              else
              {
            
              }
              
            }
          });
    }