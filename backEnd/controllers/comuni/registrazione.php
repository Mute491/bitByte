<?php
// Verifica parametri comuni
if (!isset($_POST["tipo"]) || $_POST["tipo"] === "") {
    echo "Parametro 'tipo' mancante.";
    http_response_code(400);
    exit;
}

$tipo = $_POST["tipo"]; // 'utente' o 'azienda'

if ($tipo === "utente") {
    require("../../db/models/utenti.php");
    require("../../fileSystem/storage/storageUtenti.php");

    if (
        isset($_POST["email"], $_POST["password"], $_POST["username"], $_POST["nome"], 
              $_POST["cognome"], $_POST["descrizione"], $_POST["nTelefono"]) &&
        $_POST["email"] !== "" && $_POST["password"] !== "" && $_POST["username"] !== "" &&
        $_POST["nome"] !== "" && $_POST["cognome"] !== "" && $_POST["nTelefono"] !== ""
    ) {
        $utente = new Utenti();
        $fs = new StorageUtenti();

        $descrizione = $_POST["descrizione"] ?? "";

        $result = $utente->addUtente(
            $_POST["email"],
            $_POST["password"],
            $_POST["username"],
            $_POST["nome"],
            $_POST["cognome"],
            $descrizione,
            $_POST["nTelefono"]
        );

        if ($result == 0) {
            $fs->saveUser($_POST["username"]);
            echo "Utente registrato con successo.";
            http_response_code(201);
        } else {
            echo "Errore durante la registrazione dell'utente: $result";
            http_response_code(500);
        }
    } else {
        echo "Parametri utente mancanti.";
        http_response_code(400);
    }
}elseif ($tipo === "azienda") {
    require_once("../../db/models/aziende.php");
    require_once("../../fileSystem/storage/storageAziende.php");
    require_once("../../fileSystem/storage/core/fileSystemCore.php");
    

    if (
        isset($_POST["email"], $_POST["password"], $_POST["email_contatto"], $_POST["nome"], 
              $_POST["sito_web"], $_POST["descrizione"], $_POST["telefono_contatto"]) &&
        $_POST["email"] !== "" && $_POST["password"] !== "" && $_POST["email_contatto"] !== "" &&
        $_POST["nome"] !== "" && $_POST["telefono_contatto"] !== ""
    ) {
        $azienda = new Aziende();
        $fs = new StorageAziende();

        $descrizione = $_POST["descrizione"] ?? "";

        // Step 1: registra nel DB
        $result = $azienda->addAzienda(
            $_POST["nome"],
            $descrizione,
            $_POST["sito_web"],
            $_POST["email_contatto"],
            $_POST["telefono_contatto"],
            $_POST["email"],
            $_POST["password"]
        );

        if ($result == 0) {
            // Step 2: recupera i dati appena salvati per popolare l'oggetto
            $azienda->getAziendaByEmail($_POST["email"]);

            // Step 3: salva nel file system (passa $_FILES["file"])
            if (isset($_FILES["file"])) {
                $fs->saveAzienda($azienda, $_FILES["file"]);
            }
            

            echo "Azienda registrata con successo.";
            http_response_code(201);
        } else {
            echo "Errore durante la registrazione dell'azienda: $result";
            http_response_code(500);
        }
    } else {
        echo "Parametri azienda mancanti.";
        http_response_code(400);
    }

}
 else {
    echo "Tipo non valido. Deve essere 'utente' o 'azienda'.";
    http_response_code(400);
}
?>
