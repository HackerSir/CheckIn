<?php

namespace App\Presenters;

class ContentPresenter
{
    /**
     * 顯示用的內容（HTML）
     *
     * @param  null|string  $content
     * @return string
     */
    public function showContent(?string $content): string
    {
        if (empty($content)) {
            return '';
        }
        //過濾HTML
        $content = e($content);
        //處理換行
        $content = nl2br($content);
        //Regex Pattern
        /**
         * @see https://github.com/nahid/linkify/blob/master/src/Nahid/Linkify/Linkify.php#L142
         */
        $urlPattern = '~(?xi)
              (?:
                (?:(?:ht|f)tps?://)                     # scheme://
                |                                       #   or
                www\d{0,3}\.                            # "www.", "www1.", "www2." ... "www999."
                |                                       #   or
                www\-                                   # "www-"
                |                                       #   or
                [a-z0-9.\-]+\.[a-z]{2,4}(?=/)           # looks like domain name followed by a slash
              )
              (?:                                       # Zero or more:
                [^\s()<>]+                              # Run of non-space, non-()<>
                |                                       #   or
                \((?:[^\s()<>]+|(\([^\s()<>]+\)))*\)    # balanced parens, up to 2 levels
              )*
              (?:                                       # End with:
                \((?:[^\s()<>]+|(\([^\s()<>]+\)))*\)    # balanced parens, up to 2 levels
                |                                       #   or
                [^\s`!\-()\[\]{};:\'".,<>?«»“”‘’]       # not a space or one of these punct chars
              )
        ~';
        //處理網址
        $content = preg_replace_callback($urlPattern, function ($matches) {
            $url = $matches[0];
            $url = urldecode($url);
            $contentLine = '<a href="' . $url . '" target="_blank">' . $url . '</a>';

            return $contentLine;
        }, $content);

        return $content;
    }
}
