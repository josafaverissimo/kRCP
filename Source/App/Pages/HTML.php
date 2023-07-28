<?php

namespace Source\App\Pages;

use Source\Core\Helpers;

abstract class HTML
{
    private string $icon;

    abstract protected function body(): string;

    public function __construct()
    {
        $this->setIcon(Helpers::baseUrl(CONF_HTML_DEFAULT_ICON));
    }

    public function __toString(): string
    {
        return Helpers::minify($this->render());
    }

    private function getStyleUrl($style): string
    {
        return Helpers::baseUrl("public/assets/css/{$style}");
    }

    private function getScriptUrl($script): string
    {
        return Helpers::baseUrl("public/assets/js/{$script}");
    }

    protected function setIcon(string $path): void
    {
        $this->icon = $path;
    }

    protected function getIcon(): string
    {
        return $this->icon;
    }

    protected function head(string $title, ?array $styles = null): string
    {
        $styleSheetsHTML = "";

        if (!empty($styles)) {
            foreach ($styles as $style) {
                $styleSheetsHTML .= "<link rel='stylesheet' href='{$style}'>";
            }
        }

        return <<<HTML
        <!doctype html>
        <html lang="pt-br">
            <head>
                <title>{$title}</title>
                <link rel="icon" type="image/x-icon" href="{$this->getIcon()}">
                {$styleSheetsHTML}
            </head>
            <body>
        HTML;
    }

    protected function footer(?array $scripts = null): string
    {
        $scriptsHTML = "";

        if (!empty($scripts)) {
            foreach ($scripts as $script) {
                $scriptsHTML .= "<script src='{$script}'></script>";
            }
        }

        return <<<HTML
            <footer>
                {$scriptsHTML}
            </footer>
            </body>
        </html>
        HTML;
    }

    protected function render(): string
    {
        $styles = static::STYLES;
        $scripts = static::SCRIPTS;

        if (!empty($styles)) {
            $styles = array_map([$this, "getStyleUrl"], $styles);
        }

        if(!empty($scripts)) {
            $scripts = array_map([$this, "getScriptUrl"], $scripts);
        }

        $head = $this->head(static::TITLE, $styles);
        $body = $this->body();
        $footer = $this->footer($scripts);

        return "{$head}{$body}{$footer}";
    }
}
