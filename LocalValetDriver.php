<?php

/**
 * @global ValetDriver
 */

class LocalValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return void
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath . '/')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (
            file_exists($sitePath . $uri) &&
            !is_dir($sitePath . $uri) &&
            pathinfo($sitePath . $uri)['extension'] != 'php'
        ) {
            return $sitePath . $uri;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_GET['slug'] = $uri;

        if (empty($uri) || $uri === '/') {
            return $sitePath . '/server/index.php';
        } else {
            if (str_starts_with($uri, '/logout')) {
                return $sitePath . '/server/logout.php';
            }

            if (str_starts_with($uri, '/public/')) {
                return $sitePath . '/server/public.php';
            }

            if (str_starts_with($uri, '/lights-admin/ajax/')) {
                $path = str_replace('/lights-admin/ajax/', '', $uri);
                return $sitePath . '/server/admin-ajax.php';
            }

            if (str_starts_with($uri, '/lights-admin')) {
                return $sitePath . '/server/admin.php';
            }

            // if (is_dir($sitePath . '/public' . $uri)) {
            //     return $sitePath . '/public' . $uri . '/index.php';
            // }

            // if (file_exists($sitePath . $uri)) {
            //     return $sitePath . $uri;
            // }

            // if (file_exists($sitePath . $uri . '.php')) {
            //     return $sitePath . $uri . '.php';
            // }

            return $sitePath . '/server/index.php';
        }
    }
}
