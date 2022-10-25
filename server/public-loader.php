<?php

$original_path = $_SERVER['REQUEST_URI'];

$path = realpath(LIGHTS_PATH . $original_path);

if (!$path) {
    $path = realpath(LIGHTS_PATH_DATA . $original_path);
}

if (!$path) {
    $path = realpath(LIGHTS_PATH_THEME . $original_path);
}

if (!$path) {
    header('HTTP/1.0 404 Not Found', true, 404);
    echo '404 Resource Not Found';
    exit;
}

if (ob_get_level()) {
    ob_end_clean();
}

ob_start();
$discard = ob_get_clean();
$mime = [];

$mime['type'] = mime_content_type($path);

if (str_ends_with($path, '.css')) {
    $mime['type'] = 'text/css';
}

if (str_ends_with($path, '.js')) {
    $mime['type'] = 'text/javascript';
}

if ($mime['type']) {
    $mimetype = $mime['type'];
} else {
    $mimetype = 'image/' . substr($path, strrpos($path, '.') + 1);
}

header('Content-Type: ' . $mimetype); // always send this
if (false === strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
    header('Content-Length: ' . filesize($path));
}

$last_modified = gmdate('D, d M Y H:i:s', filemtime($path));
$etag = '"' . md5($last_modified) . '"';
header("Last-Modified: $last_modified GMT");
header('ETag: ' . $etag);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 100000000) . ' GMT');

// Support for Conditional GET
$client_etag = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : false;

if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    $_SERVER['HTTP_IF_MODIFIED_SINCE'] = false;
}

$client_last_modified = trim($_SERVER['HTTP_IF_MODIFIED_SINCE']);

// If string is empty, return 0. If not, attempt to parse into a timestamp
$client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;

// Make a timestamp for our most recent modification...
$modified_timestamp = strtotime($last_modified);

if (($client_last_modified && $client_etag)
    ? (($client_modified_timestamp >= $modified_timestamp) && ($client_etag == $etag))
    : (($client_modified_timestamp >= $modified_timestamp) || ($client_etag == $etag))
) {
    header('304 Not Modified', true, 304);
    exit;
}

// If we made it this far, just serve the file
readfile($path);
