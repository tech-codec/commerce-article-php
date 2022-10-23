<?php

namespace Framework\Twig;

/**
 * elle permet de faire une troncature de text
 */
class TextExtension extends \Twig\Extension\AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new \Twig\TwigFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    /**
     * renvoi un extrait du contenu
     *
     * @param string $content
     * @param integer $maxLength
     * @return string
     */
    public function excerpt(string $content, int $maxLength = 100): string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lasSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lasSpace) . '...';
        }
        return $content;
    }
}
