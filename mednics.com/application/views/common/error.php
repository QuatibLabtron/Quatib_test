<?php $this->load->view('common/header'); ?>

<div class="erroe-section">

    <div class="container">

        <div class="error">
            <div class="row">

                <div class="col-lg-6 col-md-6">

            <div class="error-image">

                <img src="<?php echo base_url() ?>assets/images/logos/eee.jpg" alt="" class="error-img">

            </div>

        </div>

        <div class="col-lg-6 col-md-6">

            <div class="error-cont">

                <h3> <Span> <i class="fa-solid fa-triangle-exclamation"></i> Error</Span></h3>

                <p class="error-info">Either something went wrong or the page does not exist anymore Let us help guide

                    you and get you back to home</p>

                <a href="<?php echo base_url() ?>" class="error-btn">

                    <p>Go To Home </p>

                </a>

            </div>

        </div></div>

        </div>

    </div>

</div>

<?php $this->load->view('common/footer'); ?>

