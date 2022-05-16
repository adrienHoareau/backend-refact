<?php

require_once __DIR__ . '/PlaceholdersReplacer.php';

class QuoteReplacer implements PlaceholdersReplacer
{
    public const SUMMARY_PLACEHOLDER = '[quote:summary]';
    public const SUMMARY_HTML_PLACEHOLDER = '[quote:summary_html]';
    public const DESTINATION_LINK_PLACEHOLDER = '[quote:destination_link]';
    public const DESTINATION_NAME_PLACEHOLDER = '[quote:destination_name]';
    
    /**
     * 
     * @var Quote
     */
    private $quote;
    /**
     * 
     * @var Site
     */
    private $site;
    /**
     * 
     * @var Destination
     */
    private $destination;
    
    public function __construct(Quote $quote, Destination $destination, Site $site)
    {
        $this->quote = $quote;
        $this->site = $site;
        $this->destination = $destination;
    }
    
    public function replace(string $text): string
    {
        $text = $this->replaceSummaryPlaceholder($text);
        $text = $this->replaceSummaryHtmlPlaceholder($text);
        $text = $this->replaceDestinationNamePlaceholder($text);
        $text = $this->replaceDestinationLinkPlaceholder($text);
        
        return $text;
    }
    
    private function replaceSummaryPlaceholder(string $text): string
    {
        return str_replace(self::SUMMARY_PLACEHOLDER, $this->quote->renderText(), $text);
    }
    
    private function replaceSummaryHtmlPlaceholder(string $text): string
    {
        return str_replace(self::SUMMARY_HTML_PLACEHOLDER, $this->quote->renderHtml(), $text);
    }
    
    private function replaceDestinationNamePlaceholder(string $text): string
    {
        return str_replace(self::DESTINATION_NAME_PLACEHOLDER, $this->destination->countryName, $text);
    }
    
    private function replaceDestinationLinkPlaceholder(string $text): string
    {
        return str_replace(self::DESTINATION_LINK_PLACEHOLDER, $this->site->url . '/' . $this->destination->countryName . '/quote/' . $this->quote->id, $text);
    }
}
