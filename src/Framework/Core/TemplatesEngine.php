<?php

namespace Src\Framework\Core;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Template\Template;

class TemplatesEngine
{
    private PlatesEngine $platesEngine;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("the {$path} directory does not exists");
        }

        $engine = new PlatesEngine();
        $engine->setDirectory($path);
        $engine->setFileExtension('php');

        $this->platesEngine = $engine;
    }

    /**
    * Add a new folder to templates engine
    *
    * @throws \InvalidArgumentException
    */
    public function addFolder(string $name, string $path): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("the \$name parameter must not be empty");
        }

        if (!file_exists($path)) {
            throw new \InvalidArgumentException("the {$path} directory does not exists");
        }

        $this->platesEngine->addFolder($name, $path);
    }

    public function make(string $view): Template
    {
        return $this->platesEngine->make($view);
    }

    public static function renderViewDirectly(string $view, array $data = []): string
    {
        $templatesEngine = new self(__DIR__.'/../../../resources/templates/views/');
        $templatesEngine->addFolder('layouts', __DIR__.'/../../../resources/templates/views/layouts/');
        echo $templatesEngine->make($view)->render($data);
        exit(1);
    }

    public static function renderErrorView(string $title, string $message, int $code): string
    {
        echo self::renderViewDirectly('error', [
            'title' => $title,
            'message' => $message,
            'code' => $code
        ]);
        exit(1);
    }
}
