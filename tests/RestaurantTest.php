<?php
namespace Iuto\SaePhp\Model;

use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    private $restaurant;

    protected function setUp(): void
    {
        $this->restaurant = new Restaurant(
            2.3522, 48.8566, '123456', 'restaurant', 'Le Petit Bistro',
            'John Doe', 'Bistro Chain', 'Mo-Fr 08:00-18:00; Sa 09:00-17:00', true,
            ['French', 'Italian'], true, false, true, true, '50', false, '01 23 45 67 89',
            'https://lepetitbistro.com', 'https://facebook.com/lepetitbistro',
            'Île-de-France', 'Paris', 'Paris'
        );
    }

    public function testGetters()
    {
        $this->assertEquals(['lat' => 48.8566, 'lon' => 2.3522], $this->restaurant->getCoordinates());
        $this->assertEquals(48.8566, $this->restaurant->getLatitude());
        $this->assertEquals(2.3522, $this->restaurant->getLongitude());
        $this->assertEquals(123456, $this->restaurant->getOsmId());
        $this->assertEquals('Le Petit Bistro', $this->restaurant->getName());
        $this->assertEquals('restaurant', $this->restaurant->getType());
        $this->assertEquals('John Doe', $this->restaurant->getOperator());
        $this->assertEquals('Bistro Chain', $this->restaurant->getBrand());
        $this->assertTrue($this->restaurant->getWheelchair());
        $this->assertEquals(['French', 'Italian'], $this->restaurant->getCuisine());
        $this->assertTrue($this->restaurant->getVegetarian());
        $this->assertFalse($this->restaurant->getVegan());
        $this->assertTrue($this->restaurant->getDelivery());
        $this->assertTrue($this->restaurant->getTakeaway());
        $this->assertEquals('50', $this->restaurant->getCapacity());
        $this->assertFalse($this->restaurant->getDriveThrough());
        $this->assertEquals('0123456789', $this->restaurant->getPhone());
        $this->assertEquals('https://lepetitbistro.com', $this->restaurant->getWebsite());
        $this->assertEquals('https://facebook.com/lepetitbistro', $this->restaurant->getFacebook());
        $this->assertEquals('Île-de-France', $this->restaurant->getRegion());
        $this->assertEquals('Paris', $this->restaurant->getDepartement());
        $this->assertEquals('Paris', $this->restaurant->getCommune());
    }

    public function testParseOpeningHours()
    {
        $tests = [
            'Mo-Fr 08:00-18:00; Sa 09:00-17:00' => [
                "08:00-18:00", "08:00-18:00", "08:00-18:00", "08:00-18:00", "08:00-18:00", "09:00-17:00", "",
            ],
            'Mo 08:00-18:00' => [
                "08:00-18:00", "", "", "", "", "", "",
            ],
            'Mo-Fr 08:00-18:00' => [
                "08:00-18:00", "08:00-18:00", "08:00-18:00", "08:00-18:00", "08:00-18:00", "", "",
            ],
            'Mo,We,Fr 08:00-18:00' => [
                "08:00-18:00", "", "08:00-18:00", "", "08:00-18:00", "", "",
            ],
            'Invalid Input' => null,
            '' => null,
        ];

        foreach ($tests as $input => $expected) {
            $restaurant = new Restaurant(
                2.3522, 48.8566, '123456', 'restaurant', 'Le Petit Bistro',
                'John Doe', 'Bistro Chain', $input, true, ['French', 'Italian'],
                true, false, true, true, '50', false, '01 23 45 67 89',
                'https://lepetitbistro.com', 'https://facebook.com/lepetitbistro',
                'Île-de-France', 'Paris', 'Paris'
            );

            $this->assertEquals($expected, $restaurant->getOpeningHours());
        }
    }

    public function testRenderOpeningHours()
    {
        $html = $this->restaurant->renderOpeningHours(true);
        $this->assertStringContainsString('Lundi', $html);
        $this->assertStringContainsString('08:00-18:00', $html);
    }

    public function testRenderCard()
    {
        $avis1 = $this->createMock(Avis::class);
        $avis1->method('getNote')->willReturn(4);
        $avis2 = $this->createMock(Avis::class);
        $avis2->method('getNote')->willReturn(5);

        $this->restaurant->setAvis([$avis1, $avis2]);

        $html = $this->restaurant->renderCard();

        $this->assertStringContainsString('Le Petit Bistro', $html);
        $this->assertStringContainsString('French', $html);
        $this->assertStringContainsString('Italian', $html);
        $this->assertStringContainsString('Note : 4.5/5', $html);
        $this->assertStringContainsString('width: 90%;', $html);
    }

    public function testRenderDetail()
    {
        $avis1 = $this->createMock(Avis::class);
        $avis1->method('getNote')->willReturn(4);
        $avis2 = $this->createMock(Avis::class);
        $avis2->method('getNote')->willReturn(5);

        $this->restaurant->setAvis([$avis1, $avis2]);

        $html = $this->restaurant->renderDetail(true);

        $this->assertStringContainsString('Le Petit Bistro', $html);
        $this->assertStringContainsString('Végétarien', $html);
        $this->assertStringContainsString('Livraison disponible', $html);
        $this->assertStringContainsString('Note moyenne :', $html);
        $this->assertStringContainsString('4.5/5', $html);
        $this->assertStringContainsString('width: 90%;', $html);
    }

    public function testPhoneNormalization()
    {
        $restaurant = new Restaurant(
            2.3522, 48.8566, '123456', 'restaurant', 'Le Petit Bistro',
            'John Doe', 'Bistro Chain', 'Mo-Fr 08:00-18:00; Sa 09:00-17:00', true,
            ['French', 'Italian'], true, false, true, true, '50', false, '01 23 45 67 89',
            'https://lepetitbistro.com', 'https://facebook.com/lepetitbistro',
            'Île-de-France', 'Paris', 'Paris'
        );
        $this->assertEquals('0123456789', $restaurant->getPhone());

        $restaurant = new Restaurant(
            2.3522, 48.8566, '123456', 'restaurant', 'Le Petit Bistro',
            'John Doe', 'Bistro Chain', 'Mo-Fr 08:00-18:00; Sa 09:00-17:00', true,
            ['French', 'Italian'], true, false, true, true, '50', false, null,
            'https://lepetitbistro.com', 'https://facebook.com/lepetitbistro',
            'Île-de-France', 'Paris', 'Paris'
        );
        $this->assertNull($restaurant->getPhone());
    }

    public function testAvis()
    {
        $avis = new Avis(
            0,
            new User('john.doe@example.com', 'John', 'Doe', 'password'),
            'Great food!',
            5,
            $this->restaurant
        );

        $this->restaurant->setAvis([$avis]);
        $this->assertCount(1, $this->restaurant->getAvis());
        $this->assertSame($avis, $this->restaurant->getAvis()[0]);

        $this->restaurant->addAvis($avis);
        $avisList = $this->restaurant->getAvis();
        $this->assertCount(2, $avisList);
        $this->assertSame($avis, $avisList[1]);
    }
}
