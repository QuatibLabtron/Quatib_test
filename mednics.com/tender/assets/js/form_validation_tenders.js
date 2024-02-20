$(function() {
  
  $("#add-form").validate({
         ignore: 'input[type="hidden"]',
         rules: {
            tdr_name: 
            {
              required: true,
            },
             tdr_subject: 
            {
              required: true,
            },
            tdr_grandtotal: 
            {
              required: true,
            },
            tdr_contacts: 
            {
              required: true,
            }
          },
         messages: {
           
          tdr_name: {
            required: "Please provide tender name.",
          },
           tdr_subject: 
            {
              required: "Please provide tender subject.",
            },
         tdr_grandtotal: 
          {
            required: " ",
          },
          tdr_contacts: 
          {
            required: "Please select contact name.",
          }
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        }
       });
    
  $("#edit-form").validate({
         ignore: 'input[type="hidden"]',
         rules: {
            tdr_name: 
            {
              required: true,
            },
             tdr_subject: 
            {
              required: true,
            },
            tdr_grandtotal: 
            {
              required: true,
            },
            tdr_contacts: 
            {
              required: true,
            }
          },
         messages: {
           
          tdr_name: {
            required: "Please provide tender name.",
          },
           tdr_subject: 
            {
              required: "Please provide tender subject.",
            },
         tdr_grandtotal: 
          {
            required: " ",
          },
          tdr_contacts: 
          {
            required: "Please select contact name.",
          }
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        }
       }); 
  $("#tdr_name").bind("keyup change", function(e) {
         url= baseUrl+'tenders/checktendersAvailability';
          var tdr_name =  $('#tdr_name').val(); 
          data = 
          {
              tdr_name:tdr_name
          }
          $.ajax({
                  type: "POST",
                  url: url,
                  data: data,
                  dataType: "json",
                  success:
                  function(response)
                  {
                    
                      if(response !== true)
                      {
                         alert(response);
                      }
                  }
              });
    });
  $("#add-org-form").validate({
      ignore: 'input[type="hidden"]',
      rules: 
      {
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
      messages: 
      {
       
        org_name: 
          {
            required: "Please provide organisations name.",
          },  
         org_primaryemail: {
          required: "Please provide primary email.",
        },  
      
      
      },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      },
      submitHandler: function(form)
        {
            try
            {
                 var formData = new FormData();
                  formData.append("org_name"            , $("#org_name").val());
                  formData.append("org_primaryemail"    , $("#org_primaryemail").val());
                  formData.append("org_billingadd"      , $("#org_billingadd").val());
                  formData.append("org_billingpob"      , $("#org_billingpob").val());
                  formData.append("org_billingcity"     , $("#org_billingcity").val());
                  formData.append("org_billingstate"    , $("#org_billingstate").val());
                  formData.append("org_billingpoc"      , $("#org_billingpoc").val());
                  formData.append("org_billingcountry"  , $("#org_billingcountry").val());
                callUrl = 'tenders/add_new_organisation';
                $.ajax(
                {
                    type: "POST",
                    url: baseUrl + callUrl,
                    data: formData,
                    dataType: "json",
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function(response)
                    {
                      $("#add_org").modal('hide');
                        if (response.success == true)
                        {
                           var select2url = baseUrl+'tenders/';
                           $('.organisation-select2').select2();
                           $('.organisation-select2').select2({
                              width:'resolve',
                              placeholder:"Please Select Organisations",
                               ajax: 
                                  {
                                    url: select2url+'getOrganisationDropdown',
                                    dataType: 'json',
                                  }
                              });
                            $('#tdr_organisationid').val(response.id);
                            $('#tdr_organisationid').trigger('change.select2');
       
                            swal(
                            {
                                title: "Done",
                                text: response.message,
                                type: "success",
                                icon: "success",
                                button: true,
                            });
                          
                        }
                        else
                        {
                            
                            swal(
                            {
                                title: "Opps",
                                text: "Something Went wrong",
                                type: "error",
                                icon: "error",
                                button: true,
                            });
                        }
                    }
                });
            }
            catch (e)
            {
                console.log(e);
            }
        }
   });
  $("#add-cont-form").validate({
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
        
            
                
          },
         messages: {
           
          cont_firstname: {
            required: "Please provide contacts name.",
          },  
           cont_primaryemail: {
            required: "Please provide primary email.",
          },  
          
         },
         errorPlacement: function(error, element){
          error.appendTo( element.next('.text-danger') );
        },
        submitHandler: function(form)
          {
            try
            {
                  var formData                  = new FormData();
                  formData.append("cont_orgid"          , $("#tdr_organisationid").val());
                  formData.append("cont_sal"            , $("#cont_sal").val());
                  formData.append("cont_firstname"      , $("#cont_firstname").val());
                  formData.append("cont_lastname"       , $("#cont_lastname").val());
                  formData.append("cont_primaryemail"   , $("#cont_primaryemail").val());
                callUrl = 'tenders/add_new_contact';
                $.ajax(
                {
                    type: "POST",
                    url: baseUrl + callUrl,
                    data: formData,
                    dataType: "json",
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function(response)
                    {
                      $("#add_cont").modal('hide');
                        if (response.success == true)
                        {
                            var contact_id = response.id;
                            var org_id                    = $("#tdr_organisationid").val();
                            if(org_id =='')
                            {
                                org_id = 1;
                            }
                           $('.contacts-select2').select2();
                           $('.contacts-select2').select2({
                                width:'resolve',
                                /*placeholder:"Select Contact",*/
                                 ajax: 
                                    {
                                      url: baseUrl+'tenders/getContactDropdown/'+org_id,
                                      dataType: 'json',
                                    }
                                });
                            $('#tdr_contacts').val(contact_id);
                            $('#tdr_contacts').trigger('change.select2');
                           // alert(contact_id);
                            swal(
                            {
                                title: "Done",
                                text: response.message,
                                type: "success",
                                icon: "success",
                                button: true,
                            });
                          
                        }
                        else
                        {
                            
                            swal(
                            {
                                title: "Opps",
                                text: "Something Went wrong",
                                type: "error",
                                icon: "error",
                                button: true,
                            });
                        }
                    }
                });
            }
            catch (e)
            {
                console.log(e);
            }
        }
     });
    
 $("#send-email-form").validate({
     ignore: 'input[type="hidden"]',
       rules: {
          tde_to: 
          {
            required: true,
          },
          tde_subject: 
          {
            required: true,
          }, 
          tde_content:
          {
            required: true,
          }
        },
       messages: {
         
        tde_to: 
        {
          required: "Please provide contacts email.",
        },
        tde_subject: 
        {
          required: "Please provide mail subject.",
        }, 
        tde_content:
        {
           required: "Please provide mail content.",
        }
       },
       errorPlacement: function(error, element){
        error.appendTo( element.next('.text-danger') );
      }
   });
 });


$(document).ready(function(){
   $(".prd_indv_direct_disc_value").hide();  
   $(".prd_indv_percent_disc_value").hide();  
   var select2url = baseUrl+'tenders/';
  if ($(".organisation-select2").length > 0) { 
   $('.organisation-select2').select2({
      width:'resolve',
      placeholder:"Please Select Organisations",
       ajax: 
          {
            url: select2url+'getOrganisationDropdown',
            dataType: 'json',
          }
      });
 }
    
/*
      $('.tender_product').select2({
        width:'resolve',
        placeholder:"Please Select Product",
         ajax: 
            {
              url: select2url+'getProductDropdown',
              dataType: 'json',
            }
        });*/
        
    
});
  function checkbox_check(name)
  {
        var index    = get_index_value(name);
        var tdp_spec_show = $("[name='purordlist["+index+"][tdp_spec_show]']").val();
        if(tdp_spec_show == 2 || tdp_spec_show == 0){
             $("[name='purordlist["+index+"][tdp_spec_show]']").val(1);
          }
          else
          {
            $("[name='purordlist["+index+"][tdp_spec_show]']").prop('checked', false);
            $("[name='purordlist["+index+"][tdp_spec_show]']").val(2);
          }
  }
  
  function getContactDetails(org_id)
  {
    $("#country").val('');
    $("#voltage").val('');
    $("#frequency").val('');
    $("#plug_type").val('');
      if(org_id > 1) 
      {
        callUrl = 'tenders/get_voltage_details';
        $.ajax(
        {
            type: "POST",
            url: baseUrl + callUrl,
            data: {org_id:org_id},
            dataType: "json",
           
            success: function(response)
            {
                $("#country").val(response.country);
                $("#voltage").val(response.voltage);
                $("#frequency").val(response.frequency);
                $("#plug_type").val(response.plug_type);
            }
        });
      }
  
     $('.contacts-select2').select2({
        width:'resolve',
        /*placeholder:"Select Contact",*/
         ajax: 
            {
              url: baseUrl+'tenders/getContactDropdown/'+org_id,
              dataType: 'json',
            }
        });
    }
  function increaseprdtCount()
  {
    var count = document.getElementById('theValue').value;
    var newCount= parseFloat(count)+1;
    document.getElementById('theValue').value = newCount;
  }
  function decreaseprdCount()
  {
    var count=document.getElementById('theValue').value;
    var newCount=parseFloat(count)-1;
    document.getElementById('theValue').value=newCount;
    var new_name = "purordlist["+newCount+"][tdp_prd_id]";
    calculate_invoice_total(new_name);
  }
  function get_index_value(name)
  {
      var start_pos     = name.indexOf('[') + 1;
      var end_pos       = name.indexOf(']',start_pos);
      var index         = name.substring(start_pos,end_pos);
      return index;
  }  
  function get_product_details(name)
  {
      var theValue = document.getElementById('theValue').value;
      var index    = get_index_value(name);
      var product_id = $("[name='purordlist["+index+"][tdp_prd_id]']").val();
      $("[name='purordlist["+index+"][tdp_desc]']").val('');
      $("[name='purordlist["+index+"][tdp_sku]']").val('');
      $("[name='purordlist["+index+"][tdp_price]']").val(0);
        callUrl = 'tenders/get_product_details';
          $.ajax(
          {
              type: "POST",
              url: baseUrl + callUrl,
              data: {prd_id:product_id},
              dataType: "json",
             
              success: function(response)
              { 
                  $("[name='purordlist["+index+"][tdp_desc]']").summernote('code',response.tdp_desc);
                  $("[name='purordlist["+index+"][tdp_sku]']").val(response.tdp_sku);
                  $("[name='purordlist["+index+"][tdp_name]']").val(response.tdp_name);
                  var price = 0;
                  if(response.tdp_price != '' && response.tdp_price > 0)
                  {
                    price = response.tdp_price;
                  }
                  
                    $("[name='purordlist["+index+"][tdp_price]']").val(price);
                  //$("[name='purordlist["+index+"][tdp_price]']").val(response.tdp_price);
                  $("[name='purordlist["+index+"][tdp_quantity]']").val(1);
                  $("[name='purordlist["+index+"][tdp_spec_show]']").val(1);
                  $("[name='purordlist["+index+"][tdp_spec_show]']").prop('checked', true);
                  prd_indv_zero_disc(name);
                  calculate_indv_prd_amount(name);
              }
          });
  }
  
  function get_product_desc(index)
  {
      var index    = index;
      var product_id = $("[name='purordlist["+index+"][tdp_id]']").val();
      $("[name='purordlist["+index+"][tdp_desc]']").val('');
        callUrl = 'tenders/get_product_desc';
          $.ajax(
          {
              type: "POST",
              url: baseUrl + callUrl,
              data: {prd_id:product_id},
              dataType: "json",
             
              success: function(response)
              {
                
                $("[name='purordlist["+index+"][tdp_desc]']").summernote('code',response.tdp_desc);
                  var tdp_discounttype            = $("[name='purordlist["+index+"][tdp_discounttype]']").val();
                  var tdp_indv_disc_direct        = $("[name='purordlist["+index+"][tdp_indv_disc_direct]']").val();
                  var tdp_indv_disc_percent       = $("[name='purordlist["+index+"][tdp_indv_disc_percent]']").val();
                  
                  if(tdp_discounttype == 2 || tdp_discounttype == 4)
                  { 
                   
                    $("[name='purordlist["+index+"][prd_indv_direct_disc]']").prop('checked', true);
                     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").val(tdp_indv_disc_direct);
                     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").show();
                  }
                  if(tdp_discounttype == 3 || tdp_discounttype == 5)
                  { 
                   
                    $("[name='purordlist["+index+"][prd_indv_percent_disc]']").prop('checked', true);
                    $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").val(tdp_indv_disc_percent);
                    $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").show();
                  }
               
              }
          });
  }
  function get_quantity_discount(name)
  {
    var theValue     = document.getElementById('theValue').value;
    var index        = get_index_value(name);
    var product_sku  = $("[name='purordlist["+index+"][tdp_sku]']").val();
    var product_qty  = $("[name='purordlist["+index+"][tdp_quantity]']").val();
    callUrl = 'tenders/get_quantity_discount';
      $.ajax(
      {
          type: "POST",
          url: baseUrl + callUrl,
          data: {prd_sku:product_sku,prd_qty:product_qty},
          dataType: "json",
         
          success: function(response)
          { 
              console.log(response);
              $("[name='purordlist["+index+"][tdp_qty_disc]']").val(response.tdp_qty_disc);
              calculate_indv_prd_amount(name);
          }
      });
  }
  function individual_product_click(name)
  {
      var theValue      = document.getElementById('theValue').value;
      var index        = get_index_value(name);
      $("[name='purordlist["+index+"][product_discount_modal]']").modal('show');
  }
  function prd_indv_direct_disc(name)
  {
     var index                 = get_index_value(name);
     $("[name='purordlist["+index+"][zero_prd_discount]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_percent_disc]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").hide();
     $("[name='purordlist["+index+"][tdp_indv_disc_percent]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").show();
      calculate_indv_prd_amount(name);
  }
  function prd_indv_percent_disc(name)
  { 
     var index                 = get_index_value(name);
     $("[name='purordlist["+index+"][zero_prd_discount]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_direct_disc]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").hide();
     $("[name='purordlist["+index+"][tdp_indv_disc_direct]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").show();
      calculate_indv_prd_amount(name);
  }
  function prd_indv_zero_disc(name)
  {
    var index                 = get_index_value(name);
     $("[name='purordlist["+index+"][prd_indv_direct_disc]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").hide();
     $("[name='purordlist["+index+"][tdp_indv_disc_direct]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_percent_disc]']").prop('checked', false);
     $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").val(0);
     $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").hide();
     $("[name='purordlist["+index+"][tdp_indv_disc_percent]']").val(0);
      calculate_indv_prd_amount(name);
  }
  function individual_product_discount(name , type)
  {
   
      var index                 = get_index_value(name);
      var tdp_indv_disc_percent = 0;
      var tdp_indv_disc_direct  = 0;
      console.log("in>>disc");
  
      if(type == 'perct_disc')
      {
          console.log("in>>type1");
          tdp_indv_disc_percent = $("[name='purordlist["+index+"][prd_indv_percent_disc_value]']").val();
          var price             = $("[name='purordlist["+index+"][tdp_price]']").val();
          tdp_indv_disc_percent = ((tdp_indv_disc_percent/100)*price);
            console.log("in>>type1");
            console.log("in>>tdp_indv_disc_percent"+tdp_indv_disc_percent);
          $("[name='purordlist["+index+"][tdp_indv_disc_percent]']").val(tdp_indv_disc_percent);
      }
      else if(type == 'dirct_disc')
      {
         tdp_indv_disc_direct = $("[name='purordlist["+index+"][prd_indv_direct_disc_value]']").val();
         $("[name='purordlist["+index+"][tdp_indv_disc_direct]']").val(tdp_indv_disc_direct);
      }
      calculate_indv_prd_amount(name);
  }
  function calculate_indv_prd_amount(name)
  {
     console.log("in>>calculate_indv_prd_amount");
      var theValue      = document.getElementById('theValue').value;
      var index          = get_index_value(name);
      var product_price               = 0;
      var product_qty_disc            = 0;
      var product_indv_disc_direct    = 0;
      var product_indv_disc_percent   = 0;
      var total_product_price         = 0;
      product_price                   = ($("[name='purordlist["+index+"][tdp_price]']").val());
      product_qty                     = ($("[name='purordlist["+index+"][tdp_quantity]']").val());
      total_product_price             = product_price * product_qty;
      product_qty_disc                = ($("[name='purordlist["+index+"][tdp_qty_disc]']").val());
      product_indv_disc_direct        = ($("[name='purordlist["+index+"][tdp_indv_disc_direct]']").val());
      product_indv_disc_percent       = ($("[name='purordlist["+index+"][tdp_indv_disc_percent]']").val());
      var product_discount_total_amt  = 0;
      var product_item_total          = 0;
      var product_indv_disc           = 0;
       console.log("in>>product_indv_disc_percent"+product_indv_disc_percent);
      if(product_indv_disc_direct > 0)
      {
        product_indv_disc = product_indv_disc_direct;
      }else if(product_indv_disc_percent > 0){
        product_indv_disc = product_indv_disc_percent;
      }else{
        product_indv_disc = 0;
      }
        console.log("in>>product_indv_disc"+product_indv_disc);
        switch(true)
        {
          case (product_qty_disc > 0 && product_indv_disc > 0):
            product_item_total = total_product_price - product_qty_disc;
            product_item_total = product_item_total - product_indv_disc;
            break;
          case (product_qty_disc <= 0 && product_indv_disc > 0):
               product_item_total = total_product_price - product_indv_disc;
            break;
          case (product_qty_disc > 0 && product_indv_disc <= 0):
                product_item_total = total_product_price - product_qty_disc;
            break;
          default :
            product_item_total = total_product_price;
        }
      product_discount_total_amt = + + product_qty_disc + + product_indv_disc;
        console.log("in>>product_item_total"+product_item_total);
        console.log("in>>product_discount_total_amt"+product_discount_total_amt);
      $("[name='purordlist["+index+"][tdp_discount_total_amt]']").val(product_discount_total_amt);
      $("[name='purordlist["+index+"][tdp_item_total]']").val(product_item_total);
      calculate_invoice_total();
  }
  function calculate_invoice_total()
  {
      var tdr_item_total            = 0;
      var tdr_discount              = $("#tdr_discount").val();
      var tdr_shipping_charges      = $("#tdr_shipping_charges").val();
      var tdr_bank_charges          = $("#tdr_bank_charges").val();
      var tdr_pretax_total          = 0;
      var tdr_tax                   = $("#tdr_tax").val();
      var tdr_tax_shipping_charges  = $("#tdr_tax_shipping_charges").val();
      var tdr_adjustment_type       = $("#tdr_adjustment_type").val();
      var tdr_adjustment            = $("#tdr_adjustment").val();
      var tdr_grandtotal            = 0;
      var theValue = document.getElementById('theValue').value;
      for(i=0;i<=theValue;i++)
      {
          console.log('tdr_item_total = '+$("[name='purordlist["+i+"][tdp_item_total]']").val());
          tdr_item_total  += +($("[name='purordlist["+i+"][tdp_item_total]']").val());
      }
       tdr_grandtotal = + +tdr_item_total;
     
       if((tdr_item_total > 3000) && (tdr_bank_charges < 1))
       {
          tdr_bank_charges = 0;
          $("#tdr_bank_charges").val(tdr_bank_charges);
       }
       if(tdr_discount)
       {
          tdr_grandtotal = + +tdr_grandtotal - tdr_discount;
       }
       if(tdr_shipping_charges)
       {
          tdr_grandtotal = + +tdr_grandtotal + +tdr_shipping_charges;
       }
       if(tdr_bank_charges)
       {
          tdr_grandtotal = + +tdr_grandtotal + +tdr_bank_charges;
          
       }
       tdr_pretax_total   = + +tdr_grandtotal;
       if(tdr_tax)
       {
          tdr_grandtotal = + +tdr_grandtotal + +tdr_tax;
       }
       if(tdr_tax_shipping_charges)
       {
           tdr_grandtotal = + +tdr_grandtotal + +tdr_tax_shipping_charges;
       }
       if(tdr_adjustment_type == 1)
       {
          tdr_grandtotal = + +tdr_grandtotal + +tdr_adjustment;
       }
       if(tdr_adjustment_type == 2)
       {
          tdr_grandtotal = + +tdr_grandtotal - tdr_adjustment;
       }
       $("#tdr_item_total").val(tdr_item_total);
       $("#tdr_pretax_total").val(tdr_pretax_total);
       $("#tdr_grandtotal").val(tdr_grandtotal);
  }
  function invoice_direct_disc()
  {
     $(".zero_invoice_discount").prop('checked', false);
     $(".invoice_percent_disc").prop('checked', false);
     $("#invoice_percent_disc_value").val(0);
     $("#invoice_percent_disc_value").hide();
     $("#tdr_discount").val(0);
     $("#tdr_discounttype").val(2);
     $("#invoice_direct_disc_value").show();
      calculate_invoice_total();
  }
  function invoice_percent_disc()
  { 
     $(".zero_invoice_discount").prop('checked', false);
     $(".invoice_direct_disc").prop('checked', false);
     $("#invoice_direct_disc_value").val(0);
     $("#invoice_direct_disc_value").hide();
     $("#tdr_discount").val(0);
     $("#tdr_discounttype").val(1);
     $("#invoice_percent_disc_value").show();
      calculate_invoice_total();
  }
  function invoice_zero_disc()
  {
     $("#tdr_discount").val(0);
     $("#tdr_discounttype").val(3);
     $(".invoice_direct_disc").prop('checked', false);
     $("#invoice_direct_disc_value").val(0);
     $("#invoice_direct_disc_value").hide();
  
     $(".invoice_percent_disc").prop('checked', false);
     $("#invoice_percent_disc_value").val(0);
     $("#invoice_percent_disc_value").hide();
      calculate_invoice_total();
  }
  function invoice_disc_value(value,type)
  { 
      var invoice_percent_disc_value = 0;
      var invoice_direct_disc_value  = 0;
      var tdr_discount               = 0;
      console.log("in>>disc");
      $("#tdr_discount_percent").val(0);
    
      if(type == 'perct_disc')
      {
         console.log("in>>type1");
          invoice_percent_disc_value  = $("#invoice_percent_disc_value").val();
          $("#tdr_discount_percent").val(invoice_percent_disc_value);
          var price                   = $("#tdr_grandtotal").val();
          tdr_discount                = ((invoice_percent_disc_value/100)*price);
           console.log("in>>type1");
            console.log("in>>invoice_percent_disc_value"+tdr_discount);
          $("#tdr_discount").val(tdr_discount);
      }
      else if(type == 'dirct_disc')
      {
         invoice_direct_disc_value = $("#invoice_direct_disc_value").val();
         $("#tdr_discount").val(invoice_direct_disc_value);
      }
      calculate_invoice_total();
  }
   function inv_adjust_type_click(type)
  {
      var tdr_adjustment_type = $("#tdr_adjustment_type").val();;
      var tdr_adjustment      = $("#tdr_adjustment").val();;
      var tdr_grandtotal      = $("#tdr_grandtotal").val();
      if(type == 'add_adj')
      {
         $(".tdr_adjustment_sub_click").prop('checked', false);
        $("#tdr_adjustment_type").val(1);
        $("#tdr_adjustment").val(0);
        calculate_invoice_total();
      }
      else if(type == 'sub_adj')
      {
        $(".tdr_adjustment_add_click").prop('checked', false);
        $("#tdr_adjustment_type").val(2);
          $("#tdr_adjustment").val(0);
        calculate_invoice_total();
      }
      else
      {
        $("#tdr_adjustment_type").val(0);
        $("#tdr_adjustment").val(0);
        calculate_invoice_total();
      }
  }
  function inv_adjust()
  {
    var tdr_adjustment_type = $("#tdr_adjustment_type").val();;
    var tdr_adjustment      = $("#tdr_adjustment").val();;
    var tdr_grandtotal      = $("#tdr_grandtotal").val();
    
    if(tdr_adjustment_type = 1)
    {
      tdr_grandtotal =  + +tdr_grandtotal + +tdr_adjustment; 
      $("#tdr_grandtotal").val(tdr_grandtotal);
      calculate_invoice_total();
    }
    else if(tdr_adjustment_type = 2)
    {
      tdr_grandtotal =  + +tdr_grandtotal - tdr_adjustment; 
      $("#tdr_grandtotal").val(tdr_grandtotal);
      calculate_invoice_total();
    }
    else
    {
      $("#tdr_adjustment_type").val(0);
      $("#tdr_adjustment").val(0);
      calculate_invoice_total();
    }
  }
  $('#calculate_tender').click(function()
 {
    calculate_invoice_total();
     document.getElementById("calculate_tender").style.display="none";
     document.getElementById("form_submit").style.display="block";
 });
    