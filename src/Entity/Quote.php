<?php

class Quote
{
    public $id;
    public $siteId;
    public $destinationId;
    public $dateQuoted;

    public function __construct($id, $siteId, $destinationId, $dateQuoted)
    {
        $this->id = $id;
        $this->siteId = $siteId;
        $this->destinationId = $destinationId;
        $this->dateQuoted = $dateQuoted;
    }

    public function renderHtml(): string
    {
        return '<p>' . $this->id . '</p>';
    }
    
    public function renderText(): string
    {
        return (string) $this->id;
    }   
}
