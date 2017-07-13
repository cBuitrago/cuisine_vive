<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ExceptionController extends Controller {

    public function showExceptionAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage($session);

        return $this->render('Exception/error404.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'liv' => $this->dateLivraison(),
        ));
    }

    private function getLanguage($session) {

        if (!empty($_POST["language"])) {

            $language = $_POST["language"];
            $session->set("language", $language);
        } elseif (!$session->has("language") || empty($session->get("language"))) {

            $languageServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $language = ($languageServer == "en") ? "en" : "fr";
            $session->set("language", $language);
        }

        return $session->get("language");
    }

    private function getLang($language) {
        $path = $this->get('kernel')->getRootDir() . '/../web'
                . '/Resources/public/data/index' . $language . '.json';
        return json_decode(file_get_contents($path));
    }

    private function dateLivraison() {

        $dayWeek = jddayofweek(unixtojd(time()));

        switch ($dayWeek) {
            case 0:
                $day = 6;
                break;
            case 1:
                $day = 5;
                break;
            case 2:
                $day = 4;
                break;
            case 3:
                $day = 3;
                break;
            case 4:
                $day = 2;
                break;
            case 5:
                $day = 8;
                break;
            case 6:
                $day = 7;
                break;

            default:
                $day = 7;
                break;
        }

        $date = new \DateTime();
        $nextSamedi = $date->setTimestamp(time() + (86400 * intval($day)));

        return $nextSamedi;
    }

}
