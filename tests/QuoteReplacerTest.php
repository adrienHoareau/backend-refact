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
        $faker = \Faker\Factory::create();
        $destinationId = $faker->randomNumber();
        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());

        $template = new Template(
            1,
            'some subject [quote:summary]',
            "some text [quote:summary]"
        );
        $quoteReplacer = new QuoteReplacer($quote);
        $subject = $quoteReplacer->replace($template->subject, []);
        $content = $quoteReplacer->replace($template->content, []);

        $this->assertEquals('some subject ' . $quote->id, $subject);
        $this->assertEquals('some text ' . $quote->id, $content);
    }
}
