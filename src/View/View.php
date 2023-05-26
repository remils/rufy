<?php

namespace Remils\Rufy\View;

final class View
{
    protected array $templates = [];

    public function __construct(
        protected string $path,
    ) {
    }

    public function render(ViewNode $node): string
    {
        $content = $this->getContentTemplate($this->path . $node->getTemplate());

        foreach ($node->getNodes() as $key => $value) {
            if (is_array($value)) {
                $value = join(PHP_EOL, array_map(fn (ViewNode $node) => $this->render($node), $value));
            } else {
                $value = $this->render($value);
            }

            $content = str_replace(
                sprintf('{{@%s}}', $key),
                $value,
                $content,
            );
        }

        foreach ($node->getData() as $key => $value) {
            $content = str_replace(
                [
                    sprintf('{{$%s}}', $key),
                    sprintf('{!$%s!}', $key),
                ],
                [
                    htmlspecialchars(strval($value), ENT_QUOTES, 'UTF-8'),
                    strval($value),
                ],
                $content,
            );
        }

        return $content;
    }

    protected function getContentTemplate($filename): string
    {
        if (array_key_exists($filename, $this->templates)) {
            return $this->templates[$filename];
        }

        $this->templates[$filename] = file_get_contents($filename);

        return $this->getContentTemplate($filename);
    }
}
