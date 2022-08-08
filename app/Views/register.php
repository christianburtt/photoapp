<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center pt-2 pb-2">
            <!-- <img class="img img-responsive img-fluid" src="<?php echo base_url('assets/images/lifesonglogo.png');?>" /> -->
            <h1>Applicație de Foto</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="text-center">Cont Nou</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <?php echo form_open('home/register', array('class'=>'form needs-validation', 'novalidate'=>'')); ?>
            <div class="form-group d-grid">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control <?php if(isset($err['email'])) echo 'is-invalid';?>" name="email" id="email" placeholder="name@example.com" required>
                    <label for="email">Adresă de Email</label>
                    <?php if(isset($err['email'])) echo "<div class='invalid-feedback'>{$err['email']}</div>";?>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control <?php if(isset($err['name'])) echo 'is-invalid';?>" name="name" id="name" placeholder="Nume Prenume" required>
                    <label for="name">Nume și Prenume</label>
                    <?php if(isset($err['name'])) echo "<div class='invalid-feedback'>{$err['name']}</div>";?>

                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?php if(isset($err['pw'])) echo 'is-invalid';?>" name="pw" id="pw" placeholder="parola" required>
                    <label for="pw">Parola</label>
                    <?php if(isset($err['pw'])) echo "<div class='invalid-feedback'>{$err['pw']}</div>";?>

                </div>
            </div>
            <div class="row">
                <div class="d-grid col-6">
                <a class="btn btn-outline-success" id="cancel" href="<?=base_url('home/'); ?>" >Anula</a>
                </div>
                <div class="d-grid col-6">
                <input type="hidden" name="submitting" value="true" />
                <input type="submit" class="btn btn-primary" id="register" value="Înregistrare"/>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div><!--col-->
    </div><!--row-->

</div> <!-- container -->