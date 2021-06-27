<?php

namespace BWB\Framework\mvc\controllers;

use BWB\Framework\mvc\dao\DAOProducts;
use BWB\Framework\mvc\dao\DAOTestGroup;
use DateTime;

/**
 * Le contrôleur pour les tests (groupe de tests et test unique)
 * herite de SecurizedController (les tokens)
 */
class TestGroupController extends SecurizedController
{
    /**
     * Le constructeur de la classe Controller charge les datas passées par le client,
     * Pour charger le security middleware, le contrôleur parent invoque la methode
     * @see \BWB\Framework\mvc\Controller::securityLoader() 
     * pour charger la couche securité afin de l'injecter dans l'objet response gerant l'affichage.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère la liste de produits dont a besoin
     * l'affichage de la création d'un groupe de tests
     */
    public function testGroupForm()
    {
        $this->response->render("testGroupView", ["products" => (new DAOProducts())->getAll()]);
    }

    /**
     * Récupère les données du formulaire de création d'un groupe de tests
     * avec la méthode inputPost (= $_POST)
     * ajoute à la BdD le groupe de test
     *  et met à jour les tables relationnelles employee-test_group et test-group_product
     */
    public function testGroupCreate()
    {
        // NOT IDEAL. SOLUTION WAS TO LEAVE THE ID IN THE VALUE
        // (COULD STILL REVERT TO XMLHttpRequest)
        // THIS IS THE EXTRACTION
        $productChoice = explode("-", $this->inputPost()["product-choice"]);
        $productId = $productChoice[0];

        $name = $this->inputPost()["test-group-name"];
        $description = $this->inputPost()["description"];
        $last_date_tested = (new DateTime())->format("Y-m-d");

        $daoTestGroup = new DAOTestGroup();

        if ($daoTestGroup->create([$name, $description, $last_date_tested])) {
            $lastId = $daoTestGroup->getLastGroupCreated()["MAX(id)"];

            // /!\ HERE employee_id IS HARD-CODED
            // NEEDS TO BE CHANGED OTHERWISE #2 IS CARRYING THE COMPANY /!\
            $daoTestGroup->createEmployeeTestGroup(2, $lastId);
            $daoTestGroup->createTestGroupProduct($lastId, $productId);

            $this->response->render("addTestView", ["testGroup" => $daoTestGroup->retrieve($lastId)]);
        }
    }

    /**
     * Ajoute un test unique dans le groupe de test.
     * 
     * Récupère (file_get_contents) les données envoyées par l'objet XMLHttpRequest
     * Les ajoute à la BdD et met à jour la table relationnelle test-test_group
     * renvoie (echo) les données du test en json qui seront utilisées pour l'affichage
     */
    public function addTest()
    {
        $sendData = json_decode(file_get_contents("php://input"), true);

        $daoTestGroup = new DAOTestGroup();

        $lastTestId = $daoTestGroup->getLastTestId()["MAX(id)"] + 1;

        // ajoute a testdb.test (id, name, description, minimum_value, maximum_value)
        if ($daoTestGroup->createSingleTest($lastTestId, $sendData["testName"], $sendData["description"], $sendData["minVal"], $sendData["maxVal"])) {

            $result = intval($sendData["testResult"]);
            $min = intval($sendData["minVal"]);
            $max = intval($sendData["maxVal"]);
            // Normalized data in range from 0 to 1
            $percentage = ($result - $min) / ($max - $min);
            $is_test_passed = $percentage >= 0.8 ? 1 : 0;


            // ajoute a testdb.`test-test_group` (test_group_id, test_id, percentage, is_test_passed)
            if ($daoTestGroup->createTestTestGroup($sendData["testGroupId"], $lastTestId, $percentage, $is_test_passed)) {

                $lastTest = $daoTestGroup->getLastTestCreated();
                $returnedDatas = ["testName" => $lastTest->getName(), "description" => $lastTest->getDescription(), "minVal" => $lastTest->getMinimumValue(), "maxVal" => $lastTest->getMaximumValue(), "testResult" => $lastTest->getPercentage()];

                echo json_encode($returnedDatas);
            }
        }
    }
}
