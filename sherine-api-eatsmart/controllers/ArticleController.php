<?php
/* Inclusion du fichier modele contenant l'ensemble des requetes SQL specifiques aux articles */
require_once "models/ArticleModel.php";

/* Controleur prenant en charge les requetes HTTP concernant les articles du restaurant */
class ArticleController
{
    /* Propriete encapsulant l'instance du modele de donnees associe */
    private $model;

    /* Constructeur instanciant le modele d'article pour l'ensemble de la classe */
    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    /* Extraction de l'integralite des articles de la base de donnees et exportation au format JSON */
    public function getAllArticles()
    {
        $articles = $this->model->getDBAllArticles();
        echo json_encode($articles);
    }

    /* Recherche et renvoi des donnees d'un article unique cible par son identifiant principal */
    public function getDBArticlesByID($idArticles)
    {
        $article = $this->model->getDBArticlesByID($idArticles);
        echo json_encode($article);
    }

    /* Recupere les articles associes a un identifiant de categorie specifique */
    public function getArticlesByCategorieID($categorieId)
    {
        $articles = $this->model->getDBArticlesByCategorieID($categorieId);
        echo json_encode($articles);
    }

    /* Traite la creation d'un nouvel article a partir du flux de donnees transmis par le client */
    public function createArticle($data)
    {
        $article = $this->model->createDBArticle($data);
        /* Definition du code HTTP 201 indiquant le succes de la creation de la ressource */
        http_response_code(201);
        echo json_encode($article);
    }

    /* Supprime un article existant de la base de donnees en se basant sur son identifiant */
    public function deleteArticle($id){
        $success = $this->model->deleteDBArticle($id);
        
        /* Verification de la bonne execution de la requete de suppression */
        if ($success){
            /* Renvoi du code HTTP 204 indiquant le traitement reussi sans corps de reponse */
            http_response_code(204);
        } else {
            /* Renvoi d'une erreur 404 si la ressource a supprimer n'a pas ete trouvee dans la table */
            http_response_code(404);
            echo json_encode(["message" => "Article introuvable"]);
        }
    }

    /* Met a jour les champs d'un article specifique prealablement stocke */
    public function updateArticle($id, $data){
        $success = $this->model->updateDBArticle($id, $data);
        
        /* Evaluation du resultat de la requete de mise a jour transmise au modele */
        if ($success){
            /* Code HTTP 204 utilise pour acquitter le succes de la modification sans transfert de texte additionnel */
            http_response_code(204);
        } else {
            /* Renvoi d'un code d'erreur 404 si l'identifiant ne correspondait a aucun enregistrement modifiable */
            http_response_code(404);
            echo json_encode(["message" => "Client non trouvé non modifiée"]);
        }
    }
}
?>