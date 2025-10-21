<?php
class Account extends Model
{
    protected $table = 'account';

    // A method to hash the password before inserting
    public function hashPassword($data)
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']); // Remove plain password
        }
        return $data;
    }
}