<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use stdClass;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository {

    /**
     * @param string $language
     *
     * @return []
     */
    public function getCategoriesIndex($language = 'fr') {
        $categoriesResponse = [];
        $categories = $this->getEntityManager()->getRepository('AppBundle:Category')->findAll();

        foreach ($categories as $category) {
            $cat = new stdClass();
            $cat->id = $category->getName();
            $cat->photo = $category->getPhoto();
            foreach ($category->getLanguages() as $lang) {
                if ($lang->getLanguage()->getName() == $language) {
                    $cat->name = $lang->getName();
                    break;
                }
            }
            array_push($categoriesResponse, $cat);
        }

        return $categoriesResponse;
    }

    /**
     * @param string $language
     *
     * @return []
     */
    public function getCategoriesMenu($language = 'fr') {
        
        $categoriesResponse = [];
        $categories = $this->getEntityManager()->getRepository('AppBundle:Category')->findAll();

        foreach ($categories as $category) {
            $cat = new stdClass();
            $cat->id = $category->getName();
            foreach ($category->getLanguages() as $lang) {
                if ($lang->getLanguage()->getName() == $language) {
                    $cat->name = $lang->getName();
                    break;
                }
            }
            $cat->dishes = [];
            foreach ($category->getDishes() as $dish) {
                if ($dish->getIsActive() == true) {
                    $dishResponse = new stdClass();
                    $dishResponse->photo = $dish->getPhoto();
                    foreach ($dish->getLanguages() as $dishLanguage) {
                        if ($dishLanguage->getLanguage()->getName() == $language) {
                            $dishResponse->name = $dishLanguage->getName();
                            $dishResponse->description = $dishLanguage->getDescription();
                            break;
                        }
                    }
                    $dishResponse->icons = [];
                    foreach ($dish->getIcons() as $icon) {
                        array_push($dishResponse->icons, $icon->getIcon()->getImage());
                    }
                    $dishResponse->portions = [];
                    foreach ($dish->getPortions() as $dishPortion) {
                        foreach ($dishPortion->getPortion()->getLanguages() as $portionLanguage) {
                            if ($portionLanguage->getLanguage()->getName() == $language) {
                                $portionResponse = new stdClass();
                                $portionResponse->id = $dishPortion->getId();
                                $portionResponse->name = $portionLanguage->getName();
                                $portionResponse->price = number_format($dishPortion->getPrice(), 2);
                                array_push($dishResponse->portions, $portionResponse);
                                break;
                            }
                        }
                    }
                    array_push($cat->dishes, $dishResponse);
                }
            }
            array_push($categoriesResponse, $cat);
        }
        
        return $categoriesResponse;
    }

}
