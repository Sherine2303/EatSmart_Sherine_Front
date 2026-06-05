<?php
/* Inclusion du fichier modele contenant les requetesSQL relatives aux categories */
require_once "models/CategorieModel.php";

/* Controleur charge de traiter les requetes liees aux categories de produits et de retourner les reponses adaptees */
class CategorieController
{
    /* Propriete privee destinee a stocker l'instance globale du modele de categorie */
    private $model;

    /* Constructeur initialisant l'instance par defaut du modele associe */
    public function __construct()
    {
        $this->model = new CategorieModel();
    }

    /* Recupere l'integralite des categories stockees et les retourne au format JSON */
    public function getAllCategories()
    {
        $categories = $this->model->getDBAllCategories();
        echo json_encode($categories);
    }

    /* Extraction et renvoi des informations specifiques d'une categorie via son identifiant unique */
    public function getDBCategoriesByID($idCategories)
    {
        $categorie = $this->model->getDBCategoriesByID($idCategories);
        echo json_encode($categorie);
    }

    /* Liste tous les articles appartenant a une categorie donnee en sollicitant une jointure via le modele */
    public function getArticlesByCategorieID($id)
    {
        /* Instanciation interne securisee pour assurer l'isolement du traitement de la requete */
        $categorieModel = new CategorieModel();
        $articles = $categorieModel->getArticlesByCategorieID($id);
        echo json_encode($articles);
    }

    /* Prend en charge l'insertion d'une nouvelle categorie transmise par le client */
    public function createCategorie($data)
    {
        $categorie = $this->model->createDBCategorie($data);
        /* Definition du code de statut HTTP 210 signalant le succes de la creation de la ressource */
        http_response_code(201);
        echo json_encode($categorie);
    }

    /* Modifie les donnees d'une categorie existante identifiee par son identifiant unique */
    public function updateCategorie($id, $data){
        $success = $this->model->updateDBCategorie($id, $data);
        
        /* Verification du booleen de retour pour valider si la modification a effectivement ete appliquee */
        if ($success){
            /* Statut HTTP 204 utilise lorsqu'une requete reussit mais ne necessite aucun retour de corps de texte */
            http_response_code(204);
        } else {
            /* Statut HTTP 404 renvoye si la cible de la modification n'a pas pu etre localisee en base */
            http_response_code(404);
            echo json_encode(["message" => "Categorie non trouvé non modifiée"]);
        }
    }
}