<?php

namespace Model;

class User extends Model
{
    protected static string $table = 'users';
    private const COOKIE_KEY = 'logged_in_user';

    private static function get_cookie_key(): string
    {
        return md5(static::COOKIE_KEY);
    }

    /**
     * Get current user if authenticated otherwise return false
     *
     * @return boolean|array
     */
    public static function current_user(): bool|array
    {
        $key = static::get_cookie_key();
        if (isset($_COOKIE[$key])) {
            $data = base64_decode($_COOKIE[$key]);
            $data = json_decode($data, 1);
            return User::find($data['id']);
        } else {
            return false;
        }
    }

    /**
     * Login the user 
     *
     * @param string $username
     * @param string $password
     * @return array|boolean
     */
    public static function login($username, $password): array|bool
    {
        $hashed_password = md5($password);
        $user = User::read(['*'], ["`username` = '$username'","`password` = '$hashed_password'"]);
        if(!$user)
            return false;

        $cookie_data =  [
            'id' => $user['id'],
        ];

        setcookie(static::get_cookie_key(), base64_encode(json_encode($cookie_data)), time() + 60 * 60 * 24 * 30);
        return $user;
    } 

    /**
     * Sign Up the user
     *
     * @param array $data
     * @return array|boolean
     */
    public static function signup($data): array|bool{
        $username = $data['username'];
        $hashed_password = md5($data['password']);

        // The username already exists
        if(User::read(['1'], ["username = $username"]))
            return false;

        User::create([
            'username' => $username,
            'password' => $hashed_password,
            'phone' => $data['phone'],
        ]);

        return User::read(['*'], ["username = $username"]);
    }

}