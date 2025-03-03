<?php
namespace Iuto\SaePhp\Model;
class RestaurantSearch {
    private array $restaurants;

    public function __construct(array $restaurants) {
        $this->restaurants = $restaurants;
    }

    public function search(array $filters): array {
        return array_filter($this->restaurants, function($restaurant) use ($filters) {
            if (!empty($filters['type']) && !in_array($restaurant->getType(), $filters['type'])) {
                return false;
            }

            if (!empty($filters['cuisine'])) {
                if (!is_array($restaurant->getCuisine()) || !array_intersect($filters['cuisine'], $restaurant->getCuisine())) {
                    return false;
                }
            }

            if(!empty($filters["option"])){
                $options = $filters["option"];
                if(in_array("wheelchair", $options)){
                    if(!$restaurant->getWheelchair()){
                        return false;
                    }
                }
                if(in_array("vegetarian", $options)){
                    if(!$restaurant->getVegetarian()){
                        return false;
                    }
                }
                if(in_array("vegan", $options)){
                    if(!$restaurant->getVegan()){
                        return false;
                    }
                }
                if(in_array("delivery", $options)){
                    if(!$restaurant->getDelivery()){
                        return false;
                    }
                }
            }
            return true;
        });
    }
}