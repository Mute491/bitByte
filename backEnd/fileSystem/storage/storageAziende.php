
<?php

require("core/fileSystemCore.php");

class StorageAziende extends FileSystem {

    function createAziendaFolder($idAzienda){
        $uploadsPath = $this->getUploadsPath();
        $aziendaFolderPlaceholder = $this->getAziendaFolderPlaceholder();

        $userFolder = $uploadsPath . $aziendaFolderPlaceholder . $idAzienda;

        if (!is_dir($userFolder)) {
            if (!mkdir($userFolder, 0755, true)) {
                error_log("Errore: impossibile creare $userFolder");
                return false;
            }
        }

        return true;
    }

    function uploadAziendaFile($idAzienda, $file){
        $uploadsPath = $this->getUploadsPath();
        $aziendaFolderPlaceholder = $this->getAziendaFolderPlaceholder();
        $validImageExtensions = $this->getValidImageExtensions();

        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if (!in_array($fileExtension, $validImageExtensions)) {
            return 1;
        }

        $dest_path = $uploadsPath . $aziendaFolderPlaceholder . $idAzienda . "/" . $fileName;

        if (!is_dir($uploadsPath . $aziendaFolderPlaceholder . $idAzienda)) {
            return 2;
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return 0;
        } else {
            return 3;
        }
    }

    function saveAzienda($azienda, $file) {
        return $this->uploadAziendaFile($azienda->getAziendaId(), $file);
    }

    function deleteAziendaFile($idAzienda, $fileName) {
        $uploadsPath = $this->getUploadsPath();
        $aziendaFolderPlaceholder = $this->getAziendaFolderPlaceholder();

        $filePath = $uploadsPath . $aziendaFolderPlaceholder . $idAzienda . "/" . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}



?>