# solution backend-refact
Voici ma solution au test proposé par https://github.com/Calmedica/backend-refact

La 1ere chose que je voulais faire c'était de vérifier le bon fonctionnement des tests, c'est pour cela que j'ai créé une commande de test dans le fichier MakeFile.

Ensuite pour répondre au besoin du test, je voulais décomposer TemplateManager en plusieurs services afin que chacun d'entre eux ne s'occupe que d'une tâche bien précise.
Le but étant que TemplateManager s'occupe que de transmettre les données du template à modifier à ces services.

Pour cela, j'ai commencé par créer une classe de test QuoteReplacerTest pour remplacer le placeholder le plus simple `[quote:summary]`
J'ai ensuite créé le service QuoteReplacer pour valider ce 1er test (cf commit "init service QuoteReplacer").
En suivant, j'ai modifié la classe TemplateManager pour utiliser le service QuoteReplacer pour vérifier que la classe de test TemplateManagerTest fonctionnait toujours malgré ma modification.
Puis j'ai migré un à un les autres placeholders tout en suivant cette approche de TDD.

Au final deux services ont été créés QuoteReplacer et UserReplacer. Tous deux implémentent la même interface ce qui permet à TemplateManager d'être beaucoup plus concis tout en étant ouvert à l'ajout de nouveaux services pour remplacer des placeholders, ce qui respecte les principes SOLID et qui répond au but de cet excercice de refactoring.