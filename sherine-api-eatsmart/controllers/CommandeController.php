<?php
/* Inclusion du fichier modele contenant la logique d'acces aux donnees des commandes */
require_once "models/CommandeModel.php";

/* Controleur prenant en charge la reception des requetes HTTP et le formatage des reponses pour l'API */
class CommandeController
{
    /* Instance du modele injectee pour interagir avec la base de donnees */
    private $model;

    /* Constructeur initialisant l'instance unique du modele de commande */
    public function __construct()
    {
        $this->model = new CommandeModel();
    }

    /* Recupere l'ensemble des commandes et renvoie le resultat encodé en JSON */
    public function getAllCommandes()
    {
        $commandes = $this->model->getDBAllCommandes();
        echo json_encode($commandes);
    }

    /* Recupere les details d'une commande donnee via son identifiant unique */
    public function getDBCommandesByID($idCommandes)
    {
        $commande = $this->model->getDBCommandesByID($idCommandes);
        echo json_encode($commande);
    }

    /* Recherche et renvoie toutes les commandes liees a un produit specifique */
    public function getCommandesByArticleID($articleId)
    {
        /* Instanciation locale securisee du modele pour le traitement de la requete de jointure */
        $commandeModel = new CommandeModel();
        $commandes = $commandeModel->getCommandesByArticleID($articleId);
        echo json_encode($commandes);
    }

    /* Liste l'integralite des articles associes a un identifiant de commande précis */
    public function getArticlesByCommandeID($id)
    {
        $commandeModel = new CommandeModel();
        $articles = $commandeModel->getArticlesByCommandeID($id);
        echo json_encode($articles);
    }

    /* Gere la creation d'une commande complete (enregistrement principal et liaisons d'articles) */
    public function createCommande($data)
    {
        /* Insertion de l'enregistrement principal dans la table commande et recuperation du tuple cree */
        $commande = $this->model->createDBCommande($data);
        
        /* Verification de la reussite de l'insertion en base de donnees */
        if (!$commande) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur lors de la création de la commande"]);
            return;
        }
        
        /* Verification de la presence et de la validite du tableau d'articles pour eviter les erreurs d'index */
        if (isset($data['articles']) && is_array($data['articles'])) {
            /* Parcours de la liste des articles recus pour peupler la table d'association pivot */
            foreach ($data['articles'] as $article) {
                $this->model->createAssocArticleCommande(
                    $commande['id_commande'], /* Utilisation de la clé primaire auto-generée renvoyee par le modele */
                    $article['id_article'],
                    $article['quantite']
                );
            }
        }

        /* Construction de la structure du tableau de reponse pour correspondre aux attentes du client */
        $reponse = [
            [
                "id_commande" => $commande['id_commande'],
                "date_commande" => $commande['date_commande'],
                "prix_total" => (float)$commande['prix_total'], /* Transtypage en flottant pour conserver la precision numerique */
                "etat" => $commande['etat'],
                "message" => "Insertion réussie"
            ]
        ];

        /* Envoi du code de statut HTTP 210 (Created) et transmission du flux JSON finalise */
        http_response_code(201);
        echo json_encode($reponse);
        
        /* Interruption propre du script pour garantir qu'aucune chaine parasite ne corrompe le JSON */
        exit; 
    }
}
?>