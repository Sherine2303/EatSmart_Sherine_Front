<?php
    /* Modele de gestion des categories assurant les interactions directes avec la base de donnees */
    class CategorieModel 
    {
        /* Propriete contenant l'instance de l'objet PDO pour les requetes */
        private $pdo;

        /* Constructeur etablissant la connexion initiale avec le serveur de base de donnees */
        public function __construct()
        {
            try {
                /* Initialisation de la connexion PDO avec forçage de l'encodage en UTF-8 */
                $this->pdo = new PDO("mysql:host=localhost;dbname=eatsmart_bdd_bruno;charset=utf8", "root", "");
                /* Configuration pour declencher des exceptions systematiques lors des erreurs SQL */
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                /* Interruption immediate en cas de defaillance technique de la liaison */
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        /* Extraction de l'ensemble des lignes de la table categorie */
        public function getDBAllCategories() 
        {
            $stmt = $this->pdo->query("SELECT * FROM categorie");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Selectionne une categorie precise a partir de sa cle primaire */
        public function getDBCategoriesByID($idCategories)
        {
            $req = "
                SELECT * FROM categorie
                WHERE id_categorie = :idCategorie
            ";
            /* Preparation de la requete SQL pour premunir l'application des injections */
            $stmt = $this->pdo->prepare($req);
            /* Securisation du parametre d'identification par forçage du type entier */
            $stmt->bindValue(":idCategorie", $idCategories, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        /* Recupere tous les articles associes a une categorie particuliere */
        public function getArticlesByCategorieID($id)
        {
            $sql = "SELECT * FROM article WHERE id_categorie = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /* Insere une nouvelle ligne de categorie dans la base de donnees */
        public function createDBCategorie($data){
            $req = "INSERT INTO categorie (id_categorie,nom)
                VALUES (:id_categorie,:nom)";
            $stmt =$this->pdo->prepare($req);
            
            /* Association explicite des valeurs passees en argument aux marqueurs SQL */
            $stmt->bindParam(":id_categorie",$data['id_categorie'], PDO::PARAM_INT);
            $stmt->bindParam(":nom",$data['nom'], PDO::PARAM_STR);
            $stmt->execute();
            
            /* Retour des informations de l'enregistrement cree en reaffectant l'identifiant */
            $categorie = $this->getDBCategoriesByID($data['id_categorie']);
            return $categorie;
        }

        /* Met a jour les champs nom et identifiant d'une categorie existante */
        public function updateDBCategorie ($id,$data){
            $req = "UPDATE categorie
                    SET id_categorie= :id_categorie, nom= :nom
                    WHERE id_categorie= :id";
            $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":id_categorie",$data['id_categorie'], PDO::PARAM_INT);
            $stmt->bindParam(":nom",$data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            /* Renvoie un booleen indiquant si au moins une ligne a ete effectivement modifiee */
            return $stmt->rowCount()>0;
        }

        /* Supprime un enregistrement de la table categorie selon l'identifiant fourni */
        public function deleteDBCategorie ($id){
            $req = "DELETE FROM categorie 
                    WHERE id_categorie = :id";
            $stmt = $this->pdo->prepare($req);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            /* Renvoie vrai si la suppression a effectivement impacte et retire une ligne de la base */
            return $stmt->rowCount()>0;
        }
    }
?>