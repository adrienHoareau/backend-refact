<?php

require_once __DIR__ . '/PlaceholdersReplacer.php';

class UserReplacer implements PlaceholdersReplacer
{
    public const FIRST_NAME_PLACEHOLDER = '[user:first_name]';
    
    /**
     * 
     * @var User
     */
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function replace(string $text): string
    {   
        return $this->replaceFirstnamePlaceholder($text);
    }
    
    private function replaceFirstnamePlaceholder(string $text): string
    {
        return str_replace(self::FIRST_NAME_PLACEHOLDER, ucfirst(mb_strtolower($this->user->firstname)), $text);
    }
}
