<?php

namespace Auth;

use \models\Model as Model;

class Auth extends Model
{
    /**
     * Check data user and return user id
     *
     * @param {string} $login - user login
     * @param {string} $password - user password
     * @return {boolean} true or false
     */
    public function login(array $data, array $user, $flag=''): bool
    {   
        $data = $this->validate($data, [
            'login' => 'empty|length',
            'password' => 'empty'
        ]);

        if ($flag) {
            $result_compare = hash_equals($data['password'], $user['password']);
        } else {
            $result_compare = password_verify($data['password'], $user['password']);
        }

        if ($data['login'] != $user['login']) {
            return false;
        } else if (!$result_compare) {
            return false;
        } else {
            return true;
        }
    }
}