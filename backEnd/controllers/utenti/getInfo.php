<?php

    require("../../db/models/utenti.php");
    require("../../fileSystem/storage/storageUtenti.php");

    if(isset($_GET["id"]) && $_GET["id"]!=""){

        session_start();

        if(isset($_SESSION["utente_id"])){

            $utenti = new Utenti();
            $storageUtenti = new StorageUtenti();

            $userId = $_GET["id"];

            $utenti -> connectToDatabase();
            
            $result = $utenti -> getUtenteById($userId);

            if($result != 0){

                echo("errore durante il fetching del'utente");
                http_response_code(500);

            }

            $result = $utenti -> fetchCompetenzeUtente();

            $userData = $utenti -> toArray();

            unset($userData["password"]);
            unset($userData["data_registrazione"]);

            $path = $storageUtenti -> getFileSystemUrl();
            $path .= $storageUtenti -> getUploadsPath();
            $path .= $storageUtenti -> getUtenteFolderPlaceholder();

            $userData["immagine_profilo"] = $path . $userData["immagine_profilo"];

            echo(json_encode($userData));

            http_response_code(200); //OK

        }
        else{

            echo("non autenticato");
            http_response_code(403);

        }

    }
    else{

        echo("campi obbligatori mancanti");
        http_response_code(403);

    }

?>