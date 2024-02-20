<!-- END QUICK NAV -->
<!--[if lt IE 9]>
<script src="<?php echo base_url()?>assets/global/plugins/respond.min.js<?php echo $global_asset_version; ?>"></script>
<script src="<?php echo base_url()?>assets/global/plugins/excanvas.min.js<?php echo $global_asset_version; ?>"></script> 
<script src="<?php echo base_url()?>assets/global/plugins/ie8.fix.min.js<?php echo $global_asset_version; ?>"></script> 
<![endif]-->
		
<!-- BEGIN CORE PLUGINS -->  
<script src="//code.jquery.com/jquery-1.11.1.js<?php echo $global_asset_version; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js<?php echo $global_asset_version; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js<?php echo $global_asset_version; ?>"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap/js/bootstrap.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/layouts/layout/scripts/summernote.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/js.cookie.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.blockui.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/js/module_common.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- END CORE PLUGINS -->
<script type="text/javascript" >
  var baseUrl = '<?php echo base_url();?>';
  $('.page-content-white').addClass('page-sidebar-closed');
  $('.page-header-fixed').addClass('page-sidebar-menu-closed');
  function myChangeToggler(x) 
  {
     x.classList.toggle("change-toggler");
  }  
</script>
<script type="text/javascript">
  $('#cancel').click(function() 
  {
    if(confirm("Are you sure you want to navigate away from this page?"))
    {
      history.go(-1);
    }        
    return false;
  });

  function check_form()
  {
   if($('#add-form').valid()) {
     $('#add-form').click();
     document.getElementById("form_submit").style.display="none";
     document.getElementById("processing").style.display="inline-block";
    } else {
       document.getElementById("form_submit").style.display="block";
      document.getElementById("processing").style.display="none";
   }
  }

  function check_form_edit()
  {
     if($('#edit-form').valid()) {
       $('#edit-form').click();
       document.getElementById("form_submit").style.display="none";
       document.getElementById("processing").style.display="inline-block";
      } else {
         document.getElementById("form_submit").style.display="block";
        document.getElementById("processing").style.display="none";
     }
  }

  function check_form_import()
  {
     if($('#import-form').valid()) {
       $('#import-form').click();
       document.getElementById("form_submit").style.display="none";
       document.getElementById("processing").style.display="inline-block";
      } else {
         document.getElementById("form_submit").style.display="block";
        document.getElementById("processing").style.display="none";
     }
  }

  $('#form_submit').click(function()
  {
    var $form = $('#form_submit').closest('form');
    var formid = $form.attr('id');
    console.log($("#"+formid));
    if($("#"+formid).valid())
    {
      if(confirm("Are you sure you want to save the form?"))
      {
        $("#form_submit").addClass('disabled');
        $("#form_submit").html('<i class="fa fa-spinner fa-spin" style="font-size:18px"></i> Processing');
        return true;
      }
    }
    return false;
  });

  $('.desc_editor').summernote();
</script>
<script type="text/javascript">
  <?php if($this->session->flashdata('success')){ ?>
      toastr.success("<?php echo $this->session->flashdata('success'); ?>");
  <?php }else if($this->session->flashdata('error')){  ?>
      toastr.error("<?php echo $this->session->flashdata('error'); ?>");
  <?php }else if($this->session->flashdata('warning')){  ?>
      toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
  <?php }else if($this->session->flashdata('info')){  ?>
      toastr.info("<?php echo $this->session->flashdata('info'); ?>");
  <?php } ?>
</script>
