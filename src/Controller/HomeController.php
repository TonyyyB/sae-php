<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\DataBaseProvider;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Restaurant;
class HomeController extends Controller
{
    public function get(): void
    {
        //$jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        //$this->render('home', ["restaurants" => $jp->loadRestaurants(5)]);
        /*$rest = new Restaurant(
            44.7475, // longitude
            1.5048, // latitude
            "1234567890", // osm_id
            "restaurant", // type
            "Restaurant de la Galette", // name
            "IUTables'O", // operator
            "IUTables'O", // brand
            "Mo-Th 11:30-14:30, 18:30-22:00; Fr 11:30-14:30, 18:30-23:00; Sa-Su 11:30-23:00", // opening_hours
            true, // wheelchair
            ["gastronomie"], // cuisine
            true, // vegetarian
            false, // vegan
            true, // delivery
            false, // takeaway
            ["internet"], // internet_access
            "4", // stars
            "40", // capacity
            true, // drive_through
            "Q3153345", // wikidata
            "Q3153345", // brand_wikidata
            "1234567890", // siret
            "01 44 12 34 56", // phone
            "https://example.com", // website
            "https://facebook.com/iutables", // facebook
            true, // smoking

            "45", // com_insee
            "Commune de la Galette", // com_nom
            "Orléans", // region
            "75", // code_region
            "75004", // departement
            "75004", // code_departement
            "Orléans", // commune
            "75004", // code_commune
            "1234567890" // osm_edit
        );
        $this->render('home', [
            "restaurants" => $rest
        ]);
        print_r($rest->getOpeningHours());*/
        $dbp = new DataBaseProvider();

    }
}