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

class TemplateManagerTest extends TestCase
{
    /**
     * Init the mocks
     */
    public function setUp(): void
    {
    }

    /**
     * Closes the mocks
     */
    public function tearDown(): void
    {
    }

    public function testAllPlaceholdersAreReplaced()
    {
        $faker = \Faker\Factory::create();

        $destinationId = $faker->randomNumber();
        $destination = DestinationRepository::getInstance()->getById($destinationId);
        $expectedUser = ApplicationContext::getInstance()->getCurrentUser();
        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());
        $site = SiteRepository::getInstance()->getById($quote->siteId);
        $url = $site->url . '/' . $destination->countryName . '/quote/' . $quote->id;

        $template = new Template(
            1,
            'Votre livraison à '.QuoteReplacer::DESTINATION_NAME_PLACEHOLDER,
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à ".QuoteReplacer::DESTINATION_NAME_PLACEHOLDER.".
Voici le lien pour suivre votre livraison : ".QuoteReplacer::DESTINATION_LINK_PLACEHOLDER."

Bien cordialement,

L'équipe Calmedica.com
");
        $templateManager = new TemplateManager();
        $quoteReplacer = new QuoteReplacer($quote, $destination, $site);
        $templateManager->addPlaceholdersReplacer($quoteReplacer);

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertEquals('Votre livraison à ' . $destination->countryName, $message->subject);
        $this->assertEquals("
Bonjour " . $expectedUser->firstname . ",

Merci de nous avoir contacté pour votre livraison à " . $destination->countryName . ".
Voici le lien pour suivre votre livraison : ".$url."

Bien cordialement,

L'équipe Calmedica.com
", $message->content);
    }
}
