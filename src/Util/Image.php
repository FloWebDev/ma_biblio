<?php

namespace App\Util;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Image
{
    private $params;
    const MIME = [
        'image/gif' => '.gif',
        'image/jpeg' => '.jpg',
        'image/png' => '.png'
    ];

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * Permet de créer une image en fonction d'une url
     * donnée et d'un nom de fichier
     * 
     * @param string $url - Adresse URL de l'image
     * @param string $name - Nom du fichier à enregistrer (sans l'extension)
     *
     * @return string|null - Retourne le nom du fichier créé, 
     * ou null si le fichier n'a pas pu être créé
     */
    public function createFileImage(string $url = null, string $name = null): ?string
    {
        $file = null;
        if (is_null($url) || is_null($name)) {
            return $file;
        }

        // Le "@" est nécessaire afin de s'assurer qu'aucune erreur ne sera remonté
        $image = @file_get_contents($url);
        if (!$image) {
            return $file;
        }

        $infoImage = @getimagesize($url);
        $mime = ((is_array($infoImage) && array_key_exists('mime', $infoImage)) ? $infoImage['mime'] : null);

        if (is_null($mime) || !array_key_exists($mime, self::MIME)) {
            return null;
        }

        $pathFileToSave = $this->params->get('book_directory') . '/' . 'b' . $name . self::MIME[$mime];

        $saveFile = @file_put_contents($pathFileToSave, $image);

        if (!$saveFile) {
            return $file;
        } else {
            $file = 'b' . $name . self::MIME[$mime];
        }

        return $file;
    }
}
