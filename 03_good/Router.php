<?php

namespace app;


class Router
{

    private array $getRoutes = [];
    private array $postRoutes = [];
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }


    /**
     * @return Database
     */
    public function getDb() {
        return $this->db;
    }


    /**
     * @param $url
     * @param $fn
     */
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }


    /**
     * @param $url
     * @param $fn
     */
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }


    public function resolve()
    {
        $currentURL = $_SERVER["PATH_INFO"] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $fn = null;
        if ($method == 'GET') {
            $fn = $this->getRoutes[$currentURL] ?? null;
        } elseif ($method == 'POST') {
            $fn = $this->postRoutes[$currentURL] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
//            TODO: maybe add a 404 page?
            echo "Page not found";
        }
    }


    /**
     * @param $view
     * @param array $params
     */
    public function renderView($view, $params = [])
    {

        foreach ($params as $key => $value) {
            // the double $$ notation means that a variable is thereby instantiated with the same
            // name as the given string.
            $$key = $value;
        }
        // e.g. the variable $products is to be found in index.php because the variable is instantiated before it gets
        // included


        // output is by default send to the browser,
        // but we need to store it in a variable to be
        // used in _layout. Therefore is ob_start used: to
        // cache the output and save it instead of passing it
        // to the browser
        ob_start();
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean();

        // and now if _layout is included it will make use of the $content
        // variable
        include_once __DIR__."/views/_layout.php";

    }



}