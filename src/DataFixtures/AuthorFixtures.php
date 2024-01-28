<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class AuthorFixtures extends Fixture
{
    public const AUTHOR = 'author_';

    public function load(ObjectManager $manager): void
    {
        $authors = [
            [
                'name' => 'Bolesław Prus',
                'bio' => 'Bolesław Prus – polski pisarz, prozaik, publicysta okresu pozytywizmu, współtwórca polskiego realizmu, kronikarz Warszawy, myśliciel i popularyzator wiedzy, działacz społeczny, propagator turystyki pieszej i rowerowej.'
            ],
            [
                'name' => 'Janusz Zajdel',
                'bio' => 'Janusz Andrzej Zajdel – polski pisarz, autor fantastyki naukowej, prekursor nurtu fantastyki socjologicznej w Polsce. Jego imieniem nazwano najważniejszą polską nagrodę literacką w dziedzinie fantastyki.'
            ],
            [
                'name' => 'Stanisław Lem',
                'bio' => 'Stanisław Herman Lem – polski pisarz gatunku hard science fiction, filozof, futurolog oraz krytyk. Jego debiutem książkowym była wydana w 1951 roku powieść Astronauci'
            ],
            [
                'name' => 'Edmund Wnuk-Lipiński',
                'bio' => 'Edmund Alojzy Wnuk-Lipiński – polski socjolog i nauczyciel akademicki, profesor nauk humanistycznych, pisarz fantastyki naukowej'
            ],
            [
                'name' => 'Tomasz Kołodziejczak',
                'bio' => 'Tomasz Kołodziejczak – polski pisarz science fiction i fantasy oraz wydawca, publicysta i redaktor w mediach związanych z fantastyką, komiksem i grami. Dawniej również działacz fandomu',
            ],
            [
                'name' => 'Juliusz Słowacki',
                'bio' => null
            ]
        ];

        $counter = 1;
        foreach ($authors as $author) {
            $authorObj = new Author();

            $authorObj
                ->setName($author['name'])
                ->setBiogram($author['bio'])
            ;

            $this->addReference(self::AUTHOR . $counter, $authorObj);
            $manager->persist($authorObj);

            $counter++;
        }

        $manager->flush();
    }
}
