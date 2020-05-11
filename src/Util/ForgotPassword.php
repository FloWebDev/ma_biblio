<?php

namespace App\Util;

/**
 * @link https://phpsources.net/code/php/securite/85_crypter-et-decrypter-une-chaine-avec-lefonction-mcrypt-ecb
 */
class ForgotPassword {
    const KEY = 'ABCDEFG123!';

    /**
     * Permet de générer un slug pour forgot_password
     * 
     * @return string
     */
    public function getEncryptSlug() {
        $dateTime = new \DateTime();
        $dateTime->modify('+15 minutes');
        $slug = uniqid() . '@' . $dateTime->format('Y-m-d H:i:s');

        $encrypted_slug = openssl_encrypt($slug, 'AES-128-ECB', self::KEY);
        $encrypted_slug = str_replace(['+', '/', '='], ['-', '_', ''], $encrypted_slug);

        return urlencode($encrypted_slug);
    }

    /**
     * Permet de vérifier la validité d'un forgot_password
     * 
     * @param string $encrypted_slug
     * 
     * @return bool
     */
    public function check($encrypted_slug) {
        $res = false;
        $encrypted_slug = urldecode($encrypted_slug);

        // str_replace() en sens inverse de la méthode getEncryptSlug()
        $encrypted_slug = str_replace(['-', '_', ''], ['+', '/', '='], $encrypted_slug);

        $slug = openssl_decrypt($encrypted_slug, 'AES-128-ECB',
        self::KEY);

        $explodeSlug = explode('@', $slug);

        if (is_array($explodeSlug) && count($explodeSlug) == 2) {
            $currentDateTime = new \DateTime();
            $currentDateTime = $currentDateTime->format('Y-m-d H:i:s');

            if ($currentDateTime <= $explodeSlug[1]) {
                $res = true;
            }
        }

        return $res;
    }
}