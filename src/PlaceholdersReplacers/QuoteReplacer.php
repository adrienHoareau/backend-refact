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
    
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }
    
    public function replace(string $text, array $data): string
    {
        $text = $this->replaceSummaryPlaceholder($text);
        $text = $this->replaceSummaryHtmlPlaceholder($text);
        
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
    
    public function getQuote(): Quote
    {
        return $this->quote;
    }
}
