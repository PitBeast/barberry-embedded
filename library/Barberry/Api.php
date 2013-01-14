<?php
namespace Barberry;

class Api
{
    public static function get(Config $config, $id)
    {
        try {
            $application = new Application($config);
            return $application->getResources()->storage()->getById($id);
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
            return $application->getResources()->storage()->save(file_get_contents($filePath));
        }
        return null;
    }

    public static function delete(Config $config, $id)
    {
        try {
            $application = new Application($config);
            $application->getResources()->storage()->delete($id);
            $application->getResources()->cache()->invalidate($id);
            return true;
        } catch (Storage\NotFoundException $e) {
            return false;
        }
    }

}
