<?php

    require("../../backEnd/controllers/getInfo.php");

    $aziendaData = getInfoAzienda();

?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 
    </head>
    <body class="black">
        <nav>
            <div class="nav-wrapper light-blue darken-1">
                <a href="#" class="brand-logo center">Logo</a>
                <?php 
                
                    if(isset($_SESSION["azienda_id"]) && $_SESSION["azienda_id"] == $_GET["id"]){

                        echo('<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="left hide-on-med-and-down">
                                <li><a href="paginaOfferte.php"><i class="material-icons left">business</i>Offerte di Lavoro</a></li>
                            </ul>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a class="dropdown-trigger" href="#!" data-target="dropdownmenu"><i class="material-icons left">person</i>Nome Azienda<i class="material-icons right">arrow_drop_down</i></a></li>
                            </ul>
                            <ul id="dropdownmenu" class="dropdown-content light-blue darken-1">
                                <li><a href="modificaProfilo.html"><i class="material-icons left">edit</i>Modifica Profilo</a></li>
                                <li class="divider"></li>
                                <li><a href="../../backEnd/controllers/utenti/logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
                            </ul>
                            <ul id="dropdownmenu_mobile" class="dropdown-content light-blue darken-2">
                                <li><a href="modificaProfilo.html"><i class="material-icons left">edit</i>Modifica Profilo</a></li>
                                <li class="divider"></li>
                                <li><a href="../../backEnd/controllers/utenti/logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
                            </ul>
                            <ul class="sidenav light-blue darken-1" id="mobile-demo">
                                <li><a href="candidature.html"><i class="material-icons left">business_center</i>Candidature</a></li>
                                <li><a href="paginaOfferte.php"><i class="material-icons left">business</i>Offerte di Lavoro</a></li>
                                <li><a class="dropdown-trigger" href="#!" data-target="dropdownmenu_mobile"><i class="material-icons left">person</i><i class="material-icons right">arrow_drop_down</i></a></li>
                            </ul>');

                    }
                
                ?>
            </div>
        </nav>
        <div class="container">

            <!-- FOTO, NOME AZIENDA, USERNAME -->

            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="card-panel grey darken-4 z-depth-1">
                    <div class="row valign-wrapper">
                        <div class="col s4 l2 square-container">
                        <?php 

                            if(isset($aziendaData["logo"])){
                                echo('<img id="propic" src="'.$aziendaData["logo"].'" class="circle responsive-img">');
                            }
                            else{
                                echo('<img id="propic" src="../assets/defaultPropic.jpg" class="circle responsive-img">');
                            }

                        ?>
                        </div>
                        <div class="col s8 l10">
                            <h4 id="nome" class="white-text">

                            <?php echo($aziendaData["nome"]); ?>

                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DESCRIZIONE -->

            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="card-panel grey darken-4 z-depth-1">
                    <div class="row valign-wrapper">
                        <div class="col s12">
                            <p id="descrizione" class="white-text">
                                <?php echo($aziendaData["descrizione"]); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTATTI -->
             <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="card-panel grey darken-4 z-depth-1">
                    <div class="row valign-wrapper">
                        <div class="col s12 white-text">
                            <p>
                                <h6>Contatti</h6>
                                Telefono: <?php echo($aziendaData["telefono_contatto"]); ?>
                                <br>
                                Email: <?php echo($aziendaData["email_contatto"]); ?>
                                <h6>Sedi Azienda</h6>
                                <div id="sedi">
                                    Sedi:
                                    <br>
                                    <?php

                                        $c = 1;

                                        foreach($aziendaData["sediAzienda"] as $sede){

                                            echo("Sede ".$c." in:<br>");
                                            echo($sede->getPaese()." ".$sede->getRegione()." ".$sede->getCitta()." ".$sede->getIndirizzo()."<br>");

                                        }
                                    
                                    ?>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
        <script type="text/javascript" src="../js/materialize.js"></script>
        <script type="text/javascript" src="../js/scripts.js"></script>
    </body>
</html>