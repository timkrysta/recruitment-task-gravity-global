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
