<?php

require("core/fileSystemCore.php");

class StorageUtenti extends FileSystem{

    function createUtenteFolder($idUtente){
        global $uploadsPath, $utenteFolderPlaceholder;

        $userFolder = $uploadsPath.$utenteFolderPlaceholder.$idUtente;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        

    }

    function uploadUtenteFile($idUtente, $file){
        global $uploadsPath, $utenteFolderPlaceholder, $validFileExtensions;

        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));


        if (!in_array($fileExtension, $validFileExtensions)) {
            return 1;
        }

        // Cartella di destinazione
        $dest_path = $uploadsPath.$utenteFolderPlaceholder.$idUtente."/". $fileName;

        // Crea la cartella se non esiste
        if (!is_dir($uploadsPath.$utenteFolderPlaceholder.$idUtente)) {
            
            return 2;

        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return 0;
        } else {
            return 3;
        }
    }

    function saveUser($idUtente){
        $this->createUtenteFolder($idUtente);
    }

    public function saveUtente($utente, $id) {
        $path = __DIR__ . "/../../../uploads/utenti/" . $id;
    
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        $filePath = $path . "/profilo.json";
        $datiUtente = [
            "utente_id" => $utente->getUtenteId(),
            "nome" => $utente->getNome(),
            "cognome" => $utente->getCognome(),
            "email" => $utente->getEmail(),
            "username" => $utente->getUsername(),
            "descrizione" => $utente->getDescrizione(),
            "telefono_contatto" => $utente->getTelefonoContatto(),
            "data_registrazione" => $utente->getDataRegistrazione(),
            "immagine_profilo" => $utente->getImmagineProfilo()
        ];
    
        file_put_contents($filePath, json_encode($datiUtente, JSON_PRETTY_PRINT));
    }
    


}



?>