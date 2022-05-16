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
    public function testPlaceholderSummaryIsReplaced(): void
    {
        $quoteReplacer = $this->getQuoteReplacer();
        $content = $quoteReplacer->replace('some text '.QuoteReplacer::SUMMARY_PLACEHOLDER, []);
        $this->assertEquals('some text ' . $quoteReplacer->getQuote()->id, $content);
    }
    
    public function testPlaceholderSummaryHtmlIsReplaced(): void
    {
        $quoteReplacer = $this->getQuoteReplacer();
        $content = $quoteReplacer->replace('some text '.QuoteReplacer::SUMMARY_HTML_PLACEHOLDER, []);
        $this->assertEquals('some text <p>' . $quoteReplacer->getQuote()->id . '</p>', $content);
    }
    
    private function getQuoteReplacer(): QuoteReplacer
    {
        $faker = \Faker\Factory::create();
        $destinationId = $faker->randomNumber();
        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());
        
        return new QuoteReplacer($quote);
    }
}
