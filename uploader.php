<?php

class Uploader
{
    public $destFolder = 'uploads';

    public $alloweFileTypes = array(
        IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG
    );

    public function upload($file)
    {
        $returnFilePath = '';
        if (!$file['error']) {
            $destFile = $this->destFolder . DIRECTORY_SEPARATOR . time() . '-' . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $destFile) || copy($file['tmp_name'], $destFile)) {
                $returnFilePath = $destFile;
            }
        }
        return $returnFilePath;
    }

    public function delete($filename)
    {
        if (file_exists($filename)) {
            return unlink($filename);
        }
    }

    public function valid($file)
    {
        return in_array(exif_imagetype($file['tmp_name']), $this->alloweFileTypes);
    }
}