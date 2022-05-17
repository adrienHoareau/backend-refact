<?php

require_once __DIR__ . '/PlaceholdersReplacers/PlaceholdersReplacer.php';

class TemplateManager
{
    /**
     * @var PlaceholdersReplacer[]
     */
    private $placeholdersReplacers = [];
    
    public function getTemplateComputed(Template $tpl, array $data)
    {
        $replaced = clone($tpl);
        $replaced->subject = $this->replacePlaceholders($replaced->subject);
        $replaced->content = $this->replacePlaceholders($replaced->content);

        return $replaced;
    }

    private function replacePlaceholders(string $text): string
    {
        foreach ($this->placeholdersReplacers as $placeholdersReplacer) {
            $text = $placeholdersReplacer->replace($text);
        }

        return $text;
    }
    
    public function addPlaceholdersReplacer(PlaceholdersReplacer $replacer): void
    {
        $this->placeholdersReplacers[] = $replacer;
    }
}
