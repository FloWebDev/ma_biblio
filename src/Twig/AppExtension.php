<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @link https://symfony.com/doc/current/templating/twig_extension.html
 */
class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('bbcode', [$this, 'formatBbCode']),
        ];
    }

    /**
     * Permet de parser du BBCode
     * 
     * @param string $text - Texte BBCode à parser
     * @param int|bool $nl2br - Saut de ligne ou non (par défaut oui)
     */
    public function formatBbCode($text, $nl2br = 1)
    {
        // Important, sinon risque de faille XSS
        $text = htmlspecialchars($text);

        // @link https://www.primfx.com/forum/programmation/php/balise-code-avec-php-parser-bbcode-1082/
        $find = [
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            // '~\[pre\](.*?)\[/pre\]~s',
            '~\[color=red\](.*?)\[/color=red\]~s'
        ];

        $replace = array(
            '<b>$1</b>',
            '<i>$1</i>',
            '<u>$1</u>',
            // '<code>$1</code>',
            '<span style="color: red;">$1</span>'
        );

        $text = preg_replace($find, $replace, $text);

        if ($nl2br == 1) {
            $text = nl2br($text);
        }

        return $text;
    }
}