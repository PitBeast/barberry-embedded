<?php
namespace Barberry;

class Api
{
    public static function get(Config $config, $id)
    {
        try {
            $application = new Application($config);
            return $application->resources()->storage()->getById($id);
        } catch (Storage\NotFoundException $e) {
            return null;
        }
    }

    public static function put(Config $config, $filePath)
    {
        if (is_scalar($filePath)
            && is_file($filePath)
            && is_readable($filePath)
            && filesize($filePath)
        ) {
            $application = new Application($config);
            $fileResource = fopen($filePath, 'r');
            $id = $application->resources()->storage()->save($fileResource);
            rewind($fileResource);
            $application->resources()->cache()->save($fileResource, new Request('/'.$id));
            fclose($fileResource);
            return $id;
        }
        return null;
    }

    public static function delete(Config $config, $id)
    {
        try {
            $application = new Application($config);
            $application->resources()->storage()->delete($id);
            $application->resources()->cache()->invalidate($id);
            return true;
        } catch (Storage\NotFoundException $e) {
            return false;
        }
    }

}
