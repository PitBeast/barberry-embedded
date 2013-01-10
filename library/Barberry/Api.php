<?php
namespace Barberry;

class Api
{
    public static function get(Config $config, $id, Filter\FilterInterface $filter = null)
    {
        $requestSource = new RequestSource(array(
            '_SERVER' => array(
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/' . $id,
            )));
        $application = new Application($config, $filter, $requestSource);
        return $application->run();
    }

    public static function put(Config $config, $fileDescriptions = null)
    {
        $overrideProperties = array(
            '_SERVER' => array(
                'REQUEST_METHOD' => 'POST',
                'REQUEST_URI' => '/',
            ),
            '_POST' => array(),
        );
        if (is_scalar($fileDescriptions)) {
            if ($fileInfo = self::fileInfo($fileDescriptions)) {
                $file = array($fileInfo['name'] => $fileInfo);
            } else {
                $file = array();
            }
            $overrideProperties['_FILES'] = $file;
        } elseif (is_array($fileDescriptions)) {
            $files = array_reduce(
                $fileDescriptions,
                function ($result, $filePath) {
                    if (is_scalar($filePath) && $fileInfo = self::fileInfo($filePath)) {
                        $result[$fileInfo['name']] = $fileInfo;
                    }
                    return $result;
                },
                array()
            );
            $overrideProperties['_FILES'] = $files;
        }
        $requestSource = new RequestSource($overrideProperties);
        $application = new Application($config, null, $requestSource);
        return $application->run();
    }

    public static function delete(Config $config, $id)
    {
        $requestSource = new RequestSource(array(
            '_SERVER' => array(
                'REQUEST_METHOD' => 'DELETE',
                'REQUEST_URI' => '/' . $id,
            )));
        $application = new Application($config, null, $requestSource);
        return $application->run();
    }

    protected static function fileInfo($filePath) {
        if (is_scalar($filePath)
            && is_file($filePath)
            && is_readable($filePath)
            && filesize($filePath)) {
            return array(
                'size' => filesize($filePath),
                'tmp_name' => $filePath,
                'error' => UPLOAD_ERR_OK,
                'name' => basename($filePath),
                'trusted' => true,
            );
        }
        return null;
    }

}
