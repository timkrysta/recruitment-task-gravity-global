<?php

namespace Timkrysta\GravityGlobal\Models;

class User
{
    const DATA_SOURCE_FILENAME = 'users.json';

    /** 
     * Get all users.
     *
     * @return array All users
     */
    public static function all(): array
    {
        $data = file_get_contents(self::getDataSourceFilePath());
        $users = json_decode($data);
        return $users;
    }
    
    /**
     * Delete an user by Id
     *
     * @param  mixed $userId
     * @return bool true if user was deleted and false if user was not found
     */
    public static function deleteById(int $userId): bool
    {
        $file = self::getDataSourceFilePath();
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        $index = null;
        foreach ($users as $key => $user) {
            if ($user['id'] == $userId) {
                $index = $key;
                break;
            }
        }
        
        // If the user was found, remove it from the array
        if ($index !== null) {
            array_splice($users, $index, 1);
            $jsonData = json_encode($users);
            file_put_contents($file, $jsonData);
            return true;
        }
        
        return false;
    }

    public static function create(array $newUserAttributes): bool
    {
        $file = self::getDataSourceFilePath();
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        array_push($users, $newUserAttributes);

        $jsonData = json_encode($users);
        file_put_contents($file, $jsonData);
        return true;
    }

    /**
     * The best implementation (that meets the requirement of storing data in a file instead of a database) I could come up still has a O(n) time complexity.
     * However it does not use any PHP loop to utilize built-in functions that underthehood are written in C which is more effiicient.
     */
    public static function getLatestUserId(): int
    {
        $file = self::getDataSourceFilePath();
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        $usersIds = array_column($users, 'id');
        
        return max($usersIds);
    }

    /** 
     * Get the path of the file that contains data about users.
     *
     * @return string File path
     */
    private static function getDataSourceFilePath(): string
    {
        $dataSource = __DIR__ . '/../../dataset/' . self::DATA_SOURCE_FILENAME;
        return $dataSource;
    }
}
