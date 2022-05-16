<?php

require_once __DIR__ . '/../vendor/autoload.php';

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

$faker = \Faker\Factory::create();

$template = new Template(
    1,
    'Votre livraison à [quote:destination_name]',
    "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe Calmedica.com
");

$destination = DestinationRepository::getInstance()->getById($faker->randomNumber());
$quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destination->id, $faker->date());
$site = SiteRepository::getInstance()->getById($quote->siteId);
$quoteReplacer = new QuoteReplacer($quote, $destination, $site);
$templateManager = new TemplateManager();
$templateManager->addPlaceholdersReplacer($quoteReplacer);
$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => $quote
    ]
);

echo $message->subject . "\n" . $message->content;
