<?php
/**
 * FileSlaveService.php
 */
namespace PhoenixLauncher\src\Service;

require_once __DIR__ . '/../Service/Configuration.php';

/**
 *  FileSlaveService 
 */
class FileSlaveService
{
    //const HASH_ALGO = 'sha512';
    const HASH_ALGO = 'md5';
    private $path;
    private $memoryTable;

    /**
     * FileSlaveService ctor
     */
    public function __construct()
    {
        $this->path = Configuration::$FILE_SALVE ['base'];
        $this->memoryTable = [ ];
    }

    public function package($package)
    {
        return json_decode(file_get_contents($this->path . '/' . $package . '/package.json'),true);
    }

    public function collectHashes($package)
    {
        $this->getHashes ( $this->path . '/' . $package );

        file_put_contents($this->path . '/' . $package . '/package.json',json_encode($this->memoryTable));
        return $this->memoryTable;
    }

    public function getHashes($dir, &$results = array())
    {
        if ( !is_dir($dir) )
        {
            return false;
        }

        $files = scandir ( $dir );
        
        foreach ( $files as $key => $value )
        {
            if ( strstr($value, 'package') == false)
            {
                $path = realpath ( $dir . '/' . $value );
                if (! is_dir ( $path ))
                {
                    $this->memoryTable [] = [ 
                            str_replace('/hp/as/af/my/www/API/PhoenixLauncher/public/repository/release/','',$path),
                            hash_file ( self::HASH_ALGO, $path ) 
                    ];
                }
                else if ($value != "." && $value != "..")
                {
                    $this->getHashes ( $path, $results );
                }
            }
        }
        
        return $results;
    }
    public function getFile(string $file): string
    {
        $f = fopen('test.log','a');
        fwrite($f, realpath($this->path . $file));
        fclose($f);
        
        if ( file_exists(realpath($this->path . $file)) )
        {
            $out = file_get_contents(realpath($this->path . $file));

            return $out;
        }
        else
        {
            return 'No file found';
        }
        ;
    }

    public function getLauncher()
    {
        try 
        {
            return file_get_contents( Configuration::$FILE_SALVE ['exe'] );
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
    public function getUpdater()
    {
        try 
        {
            return file_get_contents( Configuration::$FILE_SALVE ['updater'] );
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}

