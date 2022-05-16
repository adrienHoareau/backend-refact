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
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        foreach ($this->placeholdersReplacers as $placeholdersReplacer) {
            $text = $placeholdersReplacer->replace($text);
        }
        
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  && ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {
            (strpos($text, '[user:first_name]') !== false) && $text = str_replace('[user:first_name]'       , ucfirst(mb_strtolower($_user->firstname)), $text);
        }

        return $text;
    }
    
    public function addPlaceholdersReplacer(PlaceholdersReplacer $replacer): void
    {
        $this->placeholdersReplacers[] = $replacer;
    }
}
