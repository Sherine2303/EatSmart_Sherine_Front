<?php
    /* Modele de gestion des articles assurant l'interface directe avec la table article de la base de donnees */
    class ArticleModel 
    {
        /* Propriete privee conservant l'instance de connexion PDO */
        private $pdo;

        /* Constructeur initialisant l'accès à la base de données MySQL */
        public function __construct()
        {
            try {
                /* Connexion via l'extension PDO avec configuration du jeu de caracteres en UTF-8 */
                $this->pdo = new PDO("mysql:host=localhost;dbname=eatsmart_bdd_bruno;charset=utf8", "root", "");
                /* Configuration pour forcer la levee d'exceptions en cas d'anomalie dans l'execution SQL */
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                /* Interruption de l'execution du script en cas de defaillance lors de l'initialisation */
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        /* Extrait l'ensemble des enregistrements de la table article */
        public function getDBAllArticles() 
        {
            $stmt = $this->pdo->query("SELECT * FROM article");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Recupere les informations d'un article unique via son identifiant numerique principal */
        public function getDBArticlesByID($idArticles)
        {
            $req = "
                SELECT * FROM article
                WHERE id_article = :idArticle
            ";
            /* Utilisation d'une requete preparee pour neutraliser les risques d'injections SQL */
            $stmt = $this->pdo->prepare($req);
            /* Assignation et typage strict du parametre d'identification en tant qu'entier */
            $stmt->bindValue(":idArticle", $idArticles, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        /* Liste tous les articles associes a une categorie specifique passée en argument */
        public function getDBArticlesByCategorieID($categorieId)
        {
            $req = "SELECT * FROM article WHERE id_categorie = :categorieId";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(":categorieId", $categorieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Effectue l'insertion d'un nouvel article dans la base de donnees */
        public function createDBArticle($data){
            $req = "INSERT INTO article (id_article,nom,prix,description,id_categorie)
                VALUES (:id_article,:nom,:prix,:description,:id_categorie)";
            $stmt =$this->pdo->prepare($req);
            
            /* Liaison dynamique des differentes variables de donnees aux marqueurs de la requete */
            $stmt->bindParam(":id_article",$data['id_article'], PDO::PARAM_INT);
            $stmt->bindParam(":nom",$data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prix",$data['prix'], PDO::PARAM_STR);
            $stmt->bindParam(":description",$data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":id_categorie",$data['id_categorie'], PDO::PARAM_INT);
            $stmt->execute();
            
            /* Extraction de l'enregistrement fraîchement cree pour confirmer l'insertion complete */
            $article = $this->getDBArticlesByID($data['id_article']);
            return $article;
        }

        /* Supprime un article specifique de la table en fonction de l'identifiant fourni */
        public function deleteDBArticle ($id){
            $req = "DELETE FROM article 
                    WHERE id_article = :id";
            $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            /* Retourne un booleen apres verification du nombre de lignes affectees par l'operation */
            return $stmt->rowCount()>0;
        }

        /* Met a jour l'integralite des proprietes d'un article existant identifie par son ID */
        public function updateDBArticle ($id,$data){
            $req = "UPDATE article
                    SET id_article= :id_article, nom= :nom, prix= :prix, description= :description, id_categorie= :id_categorie
                    WHERE id_article= :id";
            $stmt = $this->pdo->prepare($req);

            /* Liaison des nouveaux parametres et de l'identifiant de ciblage initial */
            $stmt->bindParam(":id_article",$data['id_article'], PDO::PARAM_INT);
            $stmt->bindParam(":nom",$data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prix",$data['prix'], PDO::PARAM_INT);
            $stmt->bindParam(":description",$data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":id_categorie",$data['id_categorie'], PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            /* Renvoie vrai si la requete a reellement modifie les donnees existantes dans la base */
            return $stmt->rowCount()>0;
        }
    }
?>