<?php
// template.php

class Template {
    protected $sections = [];
    protected $layout;

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function defineSection($name, $content) {
        $this->sections[$name] = $content;
    }

    public function renderSection($name) {
        return $this->sections[$name] ?? '';
    }

    public function render() {
        extract($this->sections);
        require $this->layout;
    }
}

$template = new Template();

function defineSection($name, $callback) {
    global $template;
    ob_start();
    $callback();
    $content = ob_get_clean();
    $template->defineSection($name, $content);
}

function renderSection($name) {
    global $template;
    echo $template->renderSection($name);
}