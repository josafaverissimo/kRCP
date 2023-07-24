<?php

namespace Source\App\Pages;

use Source\Core\Helpers;

abstract class HTML
{
    private string $title;

    protected function __construct(string $title)
    {
        $this->setTitle($title);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    abstract protected function body(): string;

    abstract protected function getStyles(): array;

    abstract protected function getScripts(): array;

    private function getTitle(): string
    {
        return $this->title;
    }

    private function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function getStyleUrl($style): string
    {
        return Helpers::baseUrl("public/assets/css/{$style}");
    }

    private function getScriptUrl($script): string
    {
        return Helpers::baseUrl("public/assets/js/{$script}");
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
                {$styleSheetsHTML}
            </head>
            <body>
        HTML;
    }

    protected function footer(array $scripts = null): string
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
        $styles = array_map([$this, "getStyleUrl"], $this->getStyles());
        $scripts = array_map([$this, "getScriptUrl"], $this->getScripts());

        $head = $this->head($this->getTitle(), $styles);
        $body = $this->body();
        $footer = $this->footer($scripts);
        $html = "{$head}{$body}{$footer}";

        return preg_replace("/> +</", "><", str_replace(
            ["\r", "\n"],
            "",
            preg_replace(
                "/ +/i",
                " ",
                $html,
            )
        ));
    }
}
