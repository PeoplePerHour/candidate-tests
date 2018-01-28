<?php

namespace PPH;

/**
 * Class CacheManager
 *
 * @package PPH
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class CacheManager
{
    public const CACHE_TYPE_FILESYSTEM = 'filesystem';

    /** @var array */
    private $settings;

    /** @var bool */
    private $enabled;

    /**
     * CacheManager constructor.
     *
     * @param bool $enabled
     */
    public function __construct($enabled = true)
    {
        $settingFile   = __DIR__ . '/../config.php';
        $this->enabled = $enabled;
        try {
            if ( ! \file_exists($settingFile)) {
                throw new \Error('Could not find the config.php file at the entry point level.');
            }
            /** @noinspection PhpIncludeInspection */
            $this->settings = include $settingFile;
            if ( ! \array_key_exists('cache', $this->settings)) {
                throw new \Error("Could not find 'cache' settings key.");
            }

        } catch (\Throwable $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * Disables caching manager
     */
    public function disableCaching()
    {
        $this->enabled = false;
    }

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @throws \Error
     */
    private function checkCacheDir()
    {
        $cacheFolderPath = $this->settings['cache']['path'];
        if ( ! \file_exists($cacheFolderPath) && ! \mkdir($cacheFolderPath, 0775, true)) {
            throw new \Error('Cache directory does not exist and could not be created!');
        } elseif ( ! \is_readable($cacheFolderPath) || ! \is_writable($cacheFolderPath)) {
            if ( ! \chmod($cacheFolderPath, 0775)) {
                throw new \Error("Cache folder should be writable and readable. Folder: {$cacheFolderPath}");
            }
        }

        return true;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function generateFileKey(string $key): string
    {
        return \md5($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isNotExpired(string $key): bool
    {
        $fileName       = $this->settings['cache']['path'] . \DIRECTORY_SEPARATOR . $this->generateFileKey($key);
        $fileExpiration = \filemtime($fileName) + 30;
        if ($fileExpiration > \time()) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     *
     * @return bool|null|string
     */
    public function load(string $key)
    {
        $result = null;
        try {
            if ($this->checkCacheDir()) {
                $filePath = $this->settings['cache']['path'];
                $fileName = $this->generateFileKey($key);
                if (\file_exists($filePath . \DIRECTORY_SEPARATOR . $fileName) && $this->isNotExpired($key)) {
                    $result = \file_get_contents($filePath . \DIRECTORY_SEPARATOR . $fileName);
                }
            }
        } catch (\Throwable $e) {
            $result = null;
        } finally {
            return $result;
        }
    }

    /**
     * @param $key
     * @param $data
     *
     * @return bool
     */
    public function store($key, $data)
    {
        $filePath = $this->settings['cache']['path'];
        $fileName = $this->generateFileKey($key);
        try {
            if ($this->checkCacheDir()) {
                if (\file_put_contents($filePath . \DIRECTORY_SEPARATOR . $fileName, \json_encode($data))) {
                    return true;
                }
            }

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

}