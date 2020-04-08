<?php

namespace App\Util;

class Slugger {

    /**
     * Permet de convertir une chaîne de caractères en slug
     * 
     * @param string $text
     * @param int $type
     * @return string|false
     */
    public function sluggify(string $text, $type = 1) {

        if ($type === 1) {
            // En minuscules
            $text = mb_strtolower($text);
        } elseif ($type === 2) {
            // En majuscules
            $text = mb_strtoupper($text);
        }
        // On met le text reçu en miniscule
        $slug = $this->accentDelete($text);

        return $slug;
    }

    /**
     * Permet de supprimer les caractères accentués
     * 
     * @link https://www.journaldunet.fr/web-tech/developpement/1202717-php-comment-retirer-tous-les-caracteres-speciaux-d-une-chaine-et-les-convertir-en-caracteres-normaux/
     * 
     * @param string $text
     * @return string
     */
    public function accentDelete(string $text)
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/ /'         => '-'
        );

        $text = preg_replace('/\s+/', ' ', $text);

        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}