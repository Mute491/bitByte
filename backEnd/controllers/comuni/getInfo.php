<?php
session_start();
require_once("../../db/models/utenti.php");
require_once("../../db/models/aziende.php");

// Verifica autenticazione
if (!isset($_SESSION['utente_id']) && !isset($_SESSION['azienda_id'])) {
    echo json_encode(["errore" => "Non autenticato"]);
    http_response_code(401);
    exit;
}

// Determina il tipo di account e inizializza il relativo oggetto
if (isset($_SESSION['utente_id'])) {
    $utente = new Utenti();
    if ($utente->connectToDatabase() != 0 || $utente->getUtenteById($_SESSION['utente_id']) != 0) {
        echo json_encode(["errore" => "Errore nel recupero dati utente"]);
        http_response_code(500);
        exit;
    }
    echo json_encode($utente->toArray());
} elseif (isset($_SESSION['azienda_id'])) {
    $azienda = new Aziende();
    if ($azienda->connectToDatabase() != 0 || $azienda->getAziendaById($_SESSION['azienda_id']) != 0) {
        echo json_encode(["errore" => "Errore nel recupero dati azienda"]);
        http_response_code(500);
        exit;
    }
    echo json_encode($azienda->toArray());
}
?>
