<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center pt-2 pb-2">
            <!-- <img class="img img-responsive img-fluid" src="<?php echo base_url('assets/images/lifesonglogo.png');?>" /> -->
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
            <?php echo form_open('home/login', array('class'=>'form')); ?>
            <div class="form-group d-grid">
                <input type="text" class="form-control mb-1" id="email" name="email" placeholder="Utiliztor / Email" required/>
                <input type="password"  class="form-control mb-1" id="password" name="password" placeholder="Parola" required/>
            </div>
            <div class="row">
                <div class="d-grid col-6">
                <a class="btn btn-outline-success" id="register" href="<?=base_url('home/register'); ?>" >Registrare</a>
                </div>
                <div class="d-grid col-6">

                <input type="submit" class="btn btn-primary" id="login" value="Întră"/>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="row">
                <div class="col">
            <div class="g-signin2 w-100" data-onsuccess="onSignIn"></div>
            </div>
            </div>
        </div><!--col-->
    </div><!--row-->

</div> <!-- container -->
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
</script>