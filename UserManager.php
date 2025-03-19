<?php
require_once("DatabaseManager.php");
require_once("Entity/User.php");

class UserManager extends DatabaseManager
{
    /**
     * Récupère toutes les voitures de la base de données.
     *
     * @param PDO $pdo La connexion PDO.
     *
     * @return array Tableau d'instances Car.
     */
    public function selectAll(): array
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user;");
        $requete->execute();
        $arrayUsers = $requete->fetchAll();
        //Je parcours le tableau de résultats 
        $users = [];
        foreach ($arrayUsers as $arrayUser) {
            //J'instancie un objet avec les données d'une Voiture ( tableau associatif)
            $users[] = new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"], $arrayUser["email"]);
        }

        return $users;
    }

    /**
     * Récupère une voiture par ID de la base de données.
     * @param  PDO $pdo
     * @param  int $id
     * @return User
     */
    public function selectUserByID(int $id): User|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user WHERE id = :id;");
        $requete->execute([
            ":id" => $id
        ]);

        $arrayUser = $requete->fetch();

        $userObject = new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"], $arrayUser["email"]);

        //Retourner l'instance de Car créée avec l'occurence Car de la BDD
        return $userObject;
    }

    /**
     * Récupère un User par l'email
     * @param  PDO $pdo
     * @param  string $email
     * @return User
     */

    public function selectUserByEmail(string $email): User|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user WHERE email = :email;");
        $requete->execute([
            ":email" => $email
        ]);

        $arrayUser = $requete->fetch();
        if ($arrayUser != false) {

            //Retourner l'instance du Mail créée avec l'occurence User de la BDD
            return new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"], $arrayUser["Email"]);
        }
        return false;
    }

    /**
     * Récupère un User par le username
     * @param  PDO $pdo
     * @param  string $username
     * @return User
     */

    public function selectUserByUsername(string $username): User|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user WHERE username = :username;");
        $requete->execute([
            ":username" => $username
        ]);

        $arrayUser = $requete->fetch();
        if ($arrayUser != false) {
            //Retourner l'instance du username créée avec l'occurence User de la BDD
            $userObject = new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"], $arrayUser["Email"]);

            return $userObject;
        }
        return false;
    }
    /**
     * insertUser
     *
     * @param  PDO $pdo
     * @param  User $user
     * @return bool
     */
    public function insertUser(User $user): bool
    {
        $requete = self::getConnexion()->prepare("INSERT INTO user (username,password,email) VALUES (:username,:password,:email);");

        $requete->execute([
            "username" => $user->getUsername(),
            "password" => $user->getPassWord(),
            "email" => $user->getEmail(),

        ]);
        return $requete->rowCount() > 0;
    }

    /**
     * updateUserByID
     *
     * @param  PDO $pdo
     * @param  User $user
     * @return bool
     */
    public function updateUserById(User $user): bool
    {
        $requete = self::getConnexion()->prepare("UPDATE user SET username = :username, password = :password, email = :email WHERE id = :id;");
        $requete->execute(
            [
                "username" => $user->getUsername(),
                "password" => $user->getPassWord(),
                "email" => $user->getEmail(),
            ]
        );

        return $requete->rowCount() > 0;
    }

    /**
     * deleteUserByID
     *
     * @param  PDO $pdo
     * @param  int $id
     * @return bool
     */
    public function deleteUserByID(int $id): bool
    {
        $requete = self::getConnexion()->prepare("DELETE FROM user WHERE id = :id;");
        $requete->execute([
            ":id" => $id
        ]);

        return $requete->rowCount() > 0;
    }

    public function verifyError(array $errors, array $form)
    {
        if (empty($form["email"])) {
            $errors["email"] = "L'email est vide";
        }


        if (empty($form["username"])) {
            $errors["username"] = "Le username est vide";
        }


        if (strlen($form["password"]) < 8) {
            $errors["password"] = "le mot de passe est trop court !";
        }

        if (empty($form["password"])) {
            $errors["password"] = "Le mot de passe est vide";
        }

        if (!filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = " Le mail est invalide";
        }
        return $errors;
    }
}
