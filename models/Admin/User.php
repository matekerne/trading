<?php

namespace Admin;

use \models\Model as Model;
use Admin\Apartment as Apartment;

class User extends Model
{
    public function get_all()
    {
        $users = [];

        $db = \DB::get_connection();

        $sql = "SELECT u.id, u.login, u.name, u.email, GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS groups FROM users u JOIN users_groups u_g ON u.id = u_g.user_id JOIN groups g ON u_g.group_id = g.id WHERE u.id > 1 GROUP BY u.id ORDER BY u.id DESC";
        
        $query = $db->prepare($sql);

        if ($query->execute()) {      
            $i = 0; 
            while ($row = $query->fetch()) { 
                $users[$i]['id'] = $row['id'];
                $users[$i]['login'] = $row['login'];
                $users[$i]['groups'] = $row['groups'];
                $users[$i]['name'] = $row['name'];
                $users[$i]['email'] = $row['email'];
                
                $i++;
            }

            return $users;
        } else {
            return false;
        }
    }

    public function get_by_groups(array $groups)
    {

    }

    public function create(array $data): bool
    {
        $data = $this->validate($data, [
            'login' => 'empty|length',
            'name' => 'empty|length',
            'email' => 'empty|length|email',
            'groups' => 'empty',
            'password' => 'empty|length',
        ]);

        $db = \DB::get_connection();

        $sql = 'INSERT INTO users (login, name, email, password) VALUES (:login, :name, :email, :password)';

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = $db->prepare($sql);
        $query->bindParam(':login', $data['login']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':email', $data['email']);
        $query->bindParam(':password', $password);

        if ($query->execute()) {
            $user_id = $db->lastInsertId();

            $sql = 'INSERT INTO users_groups (user_id, group_id) VALUES (:user_id, :group_id)';

            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $user_id);

            $result = 0;
            foreach ($data['groups'] as &$group_id) {
                $query->bindParam(':group_id', $group_id);

                if ($query->execute()) {
                    $result += 1;
                } else {
                    $result -= 1;
                }
            }

            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function show(string $id)
    {
        $db = \DB::get_connection();

        $sql = "SELECT u.id, u.login, u.name, u.email, GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS groups FROM users u JOIN users_groups u_g ON u.id = u_g.user_id JOIN groups g ON g.id = u_g.group_id WHERE u.id = :id GROUP BY u.id";
        
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            return $query->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update(array $data): bool
    {
        $data = $this->validate($data, [
            'login' => 'empty|length',
            'name' => 'empty|length',
            'email' => 'empty|length|email',
            'groups' => 'empty',
        ]);

        $db = \DB::get_connection();
        
        // На тот случай если пользователь хочет оставить старый пароль
        if (!$data['password']) {
            $condition = 'login = :login, name = :name, email = :email'; 
        } else {
            $condition = 'login = :login, name = :name, email = :email, password = :password';
        }

        $sql = "UPDATE users SET $condition WHERE id = :id";

        $query = $db->prepare($sql);
        $query->bindParam(':id', $data['user_id']);
        $query->bindParam(':login', $data['login']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':email', $data['email']);

        // На тот случай если пользователь хочет оставить старый пароль
        if ($data['password']) {
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
            $query->bindParam(':password', $password);
        }

        if ($query->execute()) {
            $user_id = $data['user_id'];

            $sql = 'DELETE FROM users_groups WHERE user_id = :user_id';

            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $user_id);

            if ($query->execute()) {
                $sql = 'INSERT INTO users_groups (user_id, group_id) VALUES (:user_id, :group_id)';

                $query = $db->prepare($sql);
                $query->bindParam(':user_id', $user_id);

                $result = 0;
                foreach ($data['groups'] as &$group_id) {
                    $query->bindParam(':group_id', $group_id);

                    if ($query->execute()) {
                        $result += 1;
                    } else {
                        $result -= 1;
                    }
                }

                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete(string $id): bool
    {
        $db = \DB::get_connection();

        $sql = 'DELETE FROM users WHERE id = :id';
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            $sql = 'DELETE FROM users_groups WHERE user_id = :user_id';

            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $id);

            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function check_exists(array $data)
    {
        $data = $this->validate($data, [
            'login' => 'empty|length',
        ]);

        $db = \DB::get_connection();

        $sql = 'SELECT id, login, email, name, password FROM users WHERE login = :login';

        $query = $db->prepare($sql);
        $query->bindParam(':login', $data['login']);
        $query->execute();
        $user = $query->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
}