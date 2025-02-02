<?php
function proc_markdown($filename) {
    if (!file_exists($filename)) return "<p>file not found</p>";
    $content = file_get_contents($filename);

    //headings
    $content = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $content);
    $content = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $content);
    $content = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $content);

    //bold and italic
    $content = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $content);
    $content = preg_replace('/_(.*?)_/', '<i>$1</i>', $content);

    //links
    $content = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $content);

    //images
    $content = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1">', $content);

    //unordered lists
    $content = preg_replace('/\n\* (.*)/', '<ul><li>$1</li></ul>', $content);
    $content = preg_replace('/<\/ul>\n<ul>/', '', $content);

    //ordered lists
    $content = preg_replace('/\n\d+\. (.*)/', '<ol><li>$1</li></ol>', $content);
    $content = preg_replace('/<\/ol>\n<ol>/', '', $content);

    return nl2br($content);
}
?>