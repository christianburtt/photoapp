<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- STYLESHEETS ============================================= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Bine ati venit la PHOTOAPP!</h1>
                <p>Pentru verificarea contul dvs. va rog sa dati un click la acest buton:</p>
                <a class="btn btn-lg btn-success w-50 mx-auto" id="verify" href="<?php echo base_url('/verify/'.$code);?>">Verificare</a>

                <p>Multumesc frumos!</p>
            </div>
        </div>
    </div>

    </body>
</html>