<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Entity/Destination.php';
require_once __DIR__ . '/../src/Entity/Quote.php';
require_once __DIR__ . '/../src/Entity/Site.php';
require_once __DIR__ . '/../src/Entity/Template.php';
require_once __DIR__ . '/../src/Entity/User.php';
require_once __DIR__ . '/../src/Helper/SingletonTrait.php';
require_once __DIR__ . '/../src/Context/ApplicationContext.php';
require_once __DIR__ . '/../src/Repository/Repository.php';
require_once __DIR__ . '/../src/Repository/DestinationRepository.php';
require_once __DIR__ . '/../src/Repository/QuoteRepository.php';
require_once __DIR__ . '/../src/Repository/SiteRepository.php';
require_once __DIR__ . '/../src/TemplateManager.php';
require_once __DIR__ . '/../src/PlaceholdersReplacers/QuoteReplacer.php';

class QuoteReplacerTest extends TestCase
{
    /**
     * 
     * @var Quote
     */
    private $quote;
    /**
     * 
     * @var QuoteReplacer
     */
    private $quoteReplacer;
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
    
    /**
     * Init the mocks
     */
    public function setUp(): void
    {
        $faker = \Faker\Factory::create();
        $destinationId = $faker->randomNumber();
        $this->destination = DestinationRepository::getInstance()->getById($destinationId);
        $this->quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());
        $this->site = SiteRepository::getInstance()->getById($this->quote->siteId);
        
        $this->quoteReplacer =  new QuoteReplacer($this->quote, $this->destination, $this->site);
    }
    
    public function testPlaceholderSummaryIsReplaced(): void
    {
        $content = $this->quoteReplacer->replace('some text '.QuoteReplacer::SUMMARY_PLACEHOLDER);
        $this->assertEquals('some text ' . $this->quote->id, $content);
    }
    
    public function testPlaceholderSummaryHtmlIsReplaced(): void
    {
        $content = $this->quoteReplacer->replace('some text '.QuoteReplacer::SUMMARY_HTML_PLACEHOLDER);
        $this->assertEquals('some text <p>' . $this->quote->id . '</p>', $content);
    }
    
    public function testPlaceholderDestinationNameHtmlIsReplaced(): void
    {
        $content = $this->quoteReplacer->replace('some text '.QuoteReplacer::DESTINATION_NAME_PLACEHOLDER);
        $this->assertEquals('some text ' . $this->destination->countryName, $content);
    }
    
    public function testPlaceholderDestinationLinkHtmlIsReplaced(): void
    {
        $content = $this->quoteReplacer->replace('some text '.QuoteReplacer::DESTINATION_LINK_PLACEHOLDER);
        $this->assertEquals('some text ' . $this->site->url . '/' . $this->destination->countryName . '/quote/' . $this->quote->id, $content);
    }
}
