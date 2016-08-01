<?php

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    protected static $serviceManager;

    public static function init()
    {

        chdir(dirname(__DIR__));

        $zf2ModulePaths = array(dirname(dirname(__DIR__)));
        if (($path = static::findParentPath('vendor'))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }

        include __DIR__ . '/../init_autoloader.php';
        $config = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
            'modules'                 => array(
                'Application',
            )
        );

        Zend\Mvc\Application::init($config);

        $localConfig = include __DIR__ . '/test.local.php';

        $serviceManager
            = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig($localConfig));
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    /* @return \Zend\ServiceManager\ServiceManager */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    /**
     *
     * @param string $path
     *
     * @return boolean|string false if the path cannot be found
     */
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $srcDir = realpath($dir . '/../');
        return $srcDir . '/' . $path;
    }
}

Bootstrap::init();