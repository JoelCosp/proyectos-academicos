<template>
    <!-- Footer -->
<footer class="text-center text-lg-start bg-body-tertiary text-muted main-footer">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom footerSection mb-0">
    <!-- Left -->
    
    <!-- Left -->

    <!-- Right -->
    <div class="social-media">
      <a href="" class="">
        <img src="/images/facebookIcon.svg" alt="" class="social-icon">
      </a>
      <a href="" class="">
        <img src="/images/instagramIcon.svg" alt="" class="social-icon">
      </a>
      <a href="" class="">
        <img src="/images/twitterIcon.svg" alt="" class="social-icon">
      </a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="footerSection pt-4">
    <div class="container text-center text-md-start">
      <!-- Grid row -->
      <div class="row">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <img class="pb-4" src="/images/iWatchLogo.svg" alt="">
          <p class="footerInfoIWatch">{{ $t('footer_welcome_starter_title') }}</p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <!-- <h6 class="text-uppercase fw-bold mb-4 t-footer">
            Products
          </h6> -->
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_help_center') }}</a>
          </p>
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_jobs') }}</a> 
          </p>
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_cookies') }}</a> 
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <!-- <h6 class="text-uppercase fw-bold mb-4 t-footer">
            Useful links
          </h6> -->
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_gift_cards') }}</a>
          </p>
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_terms_use') }}</a>
          </p>
          <p>
            <a href="#!" class="text-reset">{{ $t('footer_corporate_information')}}</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <!-- <h6 class="text-uppercase fw-bold mb-4 t-footer">Contact</h6> -->
          <p>Carrer Ntra. Sra. de Lourdes, 34, 08750 Molins de Rei, Barcelona</p>
          <p>ies-bernatelferrer@xtec.cat</p>
          <p>+ 936 683 762</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4 footerSection">
    © 2021 Copyright:
    <a class="text-reset fw-bold" href="https://mdbootstrap.com/">iWatch</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->
</template>