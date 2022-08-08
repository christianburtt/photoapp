<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center pt-2 pb-2">
            <!-- <img class="img img-responsive img-fluid" src="<?php echo base_url('assets/images/lifesonglogo.png'); ?>" /> -->
            <h1>Applicație de Foto</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="text-center">Autentificare</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center">
            <?php echo form_open('home/login', array('class' => 'form')); ?>
            <div class="form-group d-grid">
                <input type="text" class="form-control mb-1" id="email" name="email" placeholder="Utiliztor / Email" required />
                <input type="password" class="form-control mb-1" id="password" name="password" placeholder="Parola" required />
            </div>
            <div class="row">
                <div class="d-grid col-6">
                    <a class="btn btn-outline-success" id="register" href="<?= base_url('home/register'); ?>">Registrare</a>
                </div>
                <div class="d-grid col-6">

                    <input type="submit" class="btn btn-primary" id="login" value="Întră" />
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="row mt-2">
                <div class="col text-center">
                    <div id="g_id_onload" data-client_id="280987633492-vggneilvh8a3d7c0jtdoikqjpm40k6ca.apps.googleusercontent.com" data-login_uri="https://photoapp.secondhandwebdesign.com/glogin" data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin w-100" data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with" data-shape="pill" data-logo_alignment="left">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0&appId=443835907646869&autoLogAppEvents=1" nonce="VAec9VLi"></script>
<div class="fb-login-button" data-width="354" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="true" data-use-continue-as="true" data-scope="<public_profile,email>"></div>
                </div>
            </div>
        </div>
        <!--col-->
    </div>
    <!--row-->

</div> <!-- container -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});
</script>
