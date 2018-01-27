<?php

class Response {
    public function text($text)
    {
        http_response_code(200);
        die($text);
    }
    
    public function debug($array)
    {
        http_response_code(200);
        die("<pre>" . print_r($array, true) . "</pre>");
    }
    
    public function render($template, $layout = "standart", $context = array())
    {
        http_response_code(200);
        $context["templatePage"] = $this->getTemplate($template, $context);
        
        die($this->getTemplate($layout, $context));
    }
    
    private function getTemplate($template, $context)
    {
        extract($context);
        ob_start();
        include_once ROOT . "/views/" . $template . ".php";
        return ob_get_clean();
    }
    
    public function http404()
    {
        http_response_code(404);
        die("404 Not Found");
    }
}
