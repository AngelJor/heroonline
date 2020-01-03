<?php


class WebResponse
{
    private static $content = '';

    public static function run($target = '', $action = '') {
        $controllerName = ucfirst($target)."Controller";
        $controller = new $controllerName();
        $functionName = $action;
        $controller->$functionName($_POST);
    }


public static function render($template = '', $params = []) {
    ob_start();

    include_once _SERVER_PATH_REAL.'View/'.$template;

    self::$content .= ob_get_clean();
}

public static function renderPartial($template = '', $params = []) {
    ob_start();

    include _SERVER_PATH_REAL.'View/'.$template;

    return ob_get_clean();
}

public static function print() {
        echo self::$content;
    }
    public static function renderWithJson($params = []){
    ob_start();

    echo json_encode($params);

    self::$content .= ob_get_clean();
}
}