<?php
    /* Modèle de gestion des commandes assurant la liaison avec la base de données */
    class CommandeModel 
    {
        /* Propriété stockant l'instance de connexion PDO */
        private $pdo;

        /* Constructeur initialisant la connexion à la base de données MySQL */
        public function __construct()
        {
            try {
                /* Tentative de connexion avec encodage UTF-8 pour éviter les erreurs de caractères */
                $this->pdo = new PDO("mysql:host=localhost;dbname=eatsmart_bdd_bruno;charset=utf8", "root", "");
                /* Configuration de PDO pour lever des exceptions en cas d'erreur SQL */
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                /* Arrêt du script et affichage du message d'erreur en cas d'échec de connexion */
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        /* Récupère l'intégralité des enregistrements de la table commande */
        public function getDBAllCommandes() 
        {
            $stmt = $this->pdo->query("SELECT * FROM commande");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Récupère une commande spécifique à partir de son identifiant unique */
        public function getDBCommandesByID($idCommandes)
        {
            $req = "
                SELECT * FROM commande
                WHERE id_commande = :idCommande
            ";
            /* Utilisation d'une requête préparée pour prémunir l'application des injections SQL */
            $stmt = $this->pdo->prepare($req);
            /* Sécurisation et typage du paramètre ID sous forme d'entier */
            $stmt->bindValue(":idCommande", $idCommandes, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        /* Sélectionne les commandes associées à un produit spécifique via une jointure */
        public function getCommandesByArticleID($id)
        {
            $sql = "SELECT commande.* FROM commande
                    INNER JOIN assoc_article_commande ON commande.id_commande = assoc_article_commande.id_commande
                    WHERE assoc_article_commande.id_article = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Récupère tous les articles ainsi que leurs quantités pour une commande donnée */
        public function getArticlesByCommandeID($id)
        {
            $sql = "SELECT article.id_article, article.nom, article.prix, article.description, article.id_categorie,
                        assoc_article_commande.quantite_article
                    FROM article
                    INNER JOIN assoc_article_commande ON article.id_article = assoc_article_commande.id_article
                    WHERE assoc_article_commande.id_commande = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        /* Insère une nouvelle commande en base de données et retourne l'enregistrement créé */
        public function createDBCommande($data){
            /* L'identifiant 'id_commande' est omis de la requête car géré par l'AUTO_INCREMENT de MySQL */
            $req = "INSERT INTO commande (date_commande,prix_total,etat)
                VALUES (:date_commande,:prix_total,:etat)";
            $stmt =$this->pdo->prepare($req);
            
            /* Liaison des données reçues aux paramètres nommés de la requête préparée */
            $stmt->bindParam(":date_commande",$data['date_commande'], PDO::PARAM_STR);
            $stmt->bindParam(":prix_total",$data['prix_total'], PDO::PARAM_STR);
            $stmt->bindParam(":etat",$data['etat'], PDO::PARAM_STR);
            $stmt->execute();
            
            /* Récupération du dernier identifiant unique généré automatiquement par la base de données */
            $nouvelId = $this->pdo->lastInsertId();
            
            /* Chargement et retour de la commande nouvellement insérée à des fins de confirmation */
            $commande = $this->getDBCommandesByID($nouvelId);
            return $commande;
        }
        
        /* Crée l'association entre un produit et une commande dans la table pivot */
        public function createAssocArticleCommande($idCommande, $idArticle, $quantite)
        {
            $req = "INSERT INTO assoc_article_commande (id_article, id_commande, quantite_article)
                    VALUES (:id_article, :id_commande, :quantite_article)";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindParam(":id_article", $idArticle, PDO::PARAM_INT);
            $stmt->bindParam(":id_commande", $idCommande, PDO::PARAM_INT);
            $stmt->bindParam(":quantite_article", $quantite, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
?>