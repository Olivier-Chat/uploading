<?php
    $errors=[];
    $isUploaded = false;
    $uploadFile = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $uploadDir = 'uploads/';
        $extensionsAccepted = ['jpg','png','webp','gif'];
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . uniqid() . '.' . $extension;
        if ( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name'] )> 1000000){
            $errors[] = 'Fichier trop volumineux, le fichier doit peser moins de 1Mo';
        }
        if (! in_array($extension,$extensionsAccepted)){
            $errors[] = 'L\'extension ".' .$extension. '" n\'est pas accepté (jpg, png, webp)';
        }
        if (count($errors) === 0){
           move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
            $errors[] = 'Image, bien uploadée';
            $isUploaded = true;
        }
    }
if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $isUploaded = false;
            if( isset($_GET['toDelete']) && file_exists($_GET['toDelete'])){
                unlink($_GET['toDelete']);
            $errors = ['Permis, bien effacée'];
            } else{
                $errors = ['Pas de permis enregistré'];
            }

    }
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' integrity='sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://bootswatch.com/4/solar/bootstrap.css' >
    <link rel='stylesheet' href='style.css'>
    <title>Download</title>
</head>
<body>
<div class='container'>
    <div class='row'>
        <div class='col-6'>

            <form action='' method='POST' enctype='multipart/form-data'>
                <fieldset >
                    <div class='form-group' >
                        <label for='firstName'>Prénom</label>
                        <input type='text' class='form-control' id='firstName' name='firstName' value='<?php echo isset($_POST['firstName'])? $_POST['firstName'] : '';?>' placeholder='Entrez votre Prénom'>

                        <label for='lastName'>Nom</label>
                        <input type='text' class='form-control' id='lastName' name='lastName' value='<?php echo isset($_POST['lastName'])?$_POST['lastName'] : '';?>' placeholder='Entrez votre Nom'>
                        <label for='avatar'>Photo</label>
                        <input type='file' class='form-control-file' name='avatar' id='avatar' aria-describedby='fileHelp'>
                    </div>
                    <div class='form-group' >
                        <button type='submit' class='btn btn-primary'>Créer permis</button>
                        <?php foreach ($errors as $error):?>
                           <p> <?=$error?> </p>
                        <?php endforeach;?>
                    </div>
                </fieldset>
            </form>
            <form action='' method='GET'>
                    <div class='form-group' >
                    <?php if ($isUploaded):?>
                        <input type='hidden' name='toDelete' value='<?=$uploadFile?>'>
                    <?php endif;?>
                        <button type='submit' class='btn btn-warning'>Effacer permis</button>
                    </div>
            </form>
        </div>
        <div class='col-6 img-display'>
            <?php if ($isUploaded):?>
            <img class='img-avatar' src='<?=$uploadFile?>' alt='<?=$_FILES['avatar']['tmp_name']?>'>
            <div class='result'>
                <p class='text-dark font-weight-bold'>Firstname: <?=$_POST['firstName']?></p>
                <p class='text-dark font-weight-bold'>LastName: <?=$_POST['lastName']?></p>
            </div>
            <?php endif;?>
        </div>
    </div>

</div>



    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>
</body>
</html>
