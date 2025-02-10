<?php

function proc_markdown($filename) {
    if (!file_exists($filename)) {
        return "<p>Error: File not found.</p>";
    }

    $content = file_get_contents($filename);

    $content = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $content);
    $content = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $content);
    $content = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $content);

    $content = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $content);
    $content = preg_replace('/_(.*?)_/', '<i>$1</i>', $content);

    $content = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $content);
    $content = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1">', $content);

    $content = preg_replace('/^\* (.+)$/m', '<li>$1</li>', $content);
    $content = preg_replace('/(<li>.*<\/li>)/', '<ul>$1</ul>', $content);

    $content = preg_replace('/^\d+\.\s(.+)$/m', '<li>$1</li>', $content);
    $content = preg_replace('/(<li>.*<\/li>)/', '<ol>$1</ol>', $content);

    return nl2br($content);
}

?>
