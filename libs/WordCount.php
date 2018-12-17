<?php

class WordCount {
    

    public static function word_limit($content, $limit) {
        $words = explode(" ", $content);
        return implode(" ", array_splice($words, 0, $limit));
    }
}