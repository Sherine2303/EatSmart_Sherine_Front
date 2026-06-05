<?php
/* Configuration des entetes HTTP pour autoriser les requetes cross-origin (CORS) indispensable pour le developpement de l'API decoupee */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

/* Interception de la requete de pre-verification OPTIONS envoyee par le navigateur avant une requete POST ou PUT */
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

/* Chargement et initialisation des differents controleurs de l'application */
require_once "./controllers/ArticleController.php";
$articleController = new ArticleController();

require_once "./controllers/CategorieController.php";
$categorieController = new CategorieController();

require_once "./controllers/CommandeController.php";
$commandeController = new CommandeController();

/* Verification de la presence du parametre de routage global transmis dans l'URL */
if (empty($_GET["page"])) {
    /* Renvoi d'un message d'erreur si aucune route n'est spécifiée */
    echo "La page n'existe pas";
} else {
    /* Decoupage de la chaine de l'URL en segments distincts en utilisant le separateur slash */
    $url = explode("/", $_GET['page']); 
    
    /* Recuperation de la methode HTTP utilisee pour l'appel de l'API (GET, POST, PUT, DELETE) */
    $method = $_SERVER["REQUEST_METHOD"]; 

    /* Premier niveau de routage base sur la ressource principale demandee dans le premier segment */
    switch($url[0]) {
        
        /* Gestion de la ressource liee aux articles */
        case "articles":
            switch($method){
                case "GET":
                    /* Exemple de route : /articles/3/commandes */
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "commandes") {
                        $commandeController->getCommandesByArticleID($url[1]);
                    /* Exemple de route : /articles/3 */
                    } elseif (isset($url[1])) {
                        $articleController->getDBArticlesByID($url[1]);
                    /* Exemple de route : /articles */
                    } else {
                        echo $articleController->getAllArticles();
                    }
                    break;
                case "POST":
                    /* Lecture du flux brut d'entree de la requete contenant le payload JSON transmis par le client */
                    $data = json_decode(file_get_contents("php://input"), true);
                    $articleController->createArticle($data);
                    break;
                case "DELETE":
                    if (isset($url[1])) {
                        $articleController->deleteArticle($url[1]);
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "ID de l'article manquant dans l'URL"]);
                    }
                    break;
                case "PUT":
                    if (isset($url[1])) {
                        $data = json_decode(file_get_contents("php://input"), true);
                        $articleController->updateArticle($url[1], $data);
                        echo json_encode($data);
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "ID de l'article manquant dans l'URL"]);
                    }
                    break;
            }
            break;
            
        /* Gestion de la ressource liee aux categories de produits */
        case "categories":
            switch($method){
                case "GET":
                    /* Exemple de route : /categories/3/articles */
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "articles") {
                        $categorieController->getArticlesByCategorieID($url[1]);
                    /* Exemple de route : /categories/3 */
                    } elseif (isset($url[1])) {
                        $categorieController->getDBCategoriesByID($url[1]);
                    /* Exemple de route : /categories */
                    } else {
                        echo $categorieController->getAllCategories();
                    }
                    break;
                case "POST":
                    $data = json_decode(file_get_contents("php://input"), true);
                    $categorieController->createCategorie($data);
                    break;
                case "PUT":
                    if (isset($url[1])) {
                        $data = json_decode(file_get_contents("php://input"), true);
                        $categorieController->updateCategorie($url[1], $data);
                        echo json_encode($data);
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "ID de la categorie manquant dans l'URL"]);
                    }
                    break;
                case "DELETE":
                    if (isset($url[1])) {
                        $categorieController->deleteCategorie($url[1]);
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "ID de la categorie manquant dans l'URL"]);
                    }
                    break;
            }
            break;
            
        /* Gestion de la ressource liee au traitement des commandes */
        case "commandes":
            switch($method){
                case "GET":
                    /* Exemple de route : /commandes/3/articles */
                    if (isset($url[1]) && isset($url[2]) && $url[2] === "articles") {
                        $commandeController->getArticlesByCommandeID($url[1]);
                    /* Exemple de route : /commandes/3 */
                    } elseif (isset($url[1])) {
                        $commandeController->getDBCommandesByID($url[1]);
                    /* Exemple de route : /commandes */
                    } else {
                        echo $commandeController->getAllCommandes();
                    }
                    break;
                 case "POST":
                    $data = json_decode(file_get_contents("php://input"), true);
                    $commandeController->createCommande($data);
                    break;
            }
            break;    
            
        /* Traitement par defaut applique si le premier segment d'URL ne correspond a aucun point d'entree defini */
        default :
            echo "La page n'existe pas";
    }
}
?>