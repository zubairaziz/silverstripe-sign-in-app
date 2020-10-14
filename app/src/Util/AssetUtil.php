<?php

namespace App\Util;

use SilverStripe\Control\Director;
use SilverStripe\Core\Manifest\ManifestFileFinder;
use SilverStripe\Core\Path;
use SilverStripe\View\Requirements;

class AssetUtil
{
    private static $manifestCache = null;
    private static $themeDir = 'app/client';

    /**
     * Requires each css file in the manifest
     */
    public static function requireSiteCSS()
    {
        $manifest = self::getManifest();

        if (!empty($manifest['entrypoints'])) {
            foreach ($manifest['entrypoints'] as $entrypoint) {
                if (array_key_exists('css', $entrypoint)) {
                    foreach ($entrypoint['css'] as $path) {
                        Requirements::themedCSS(self::getResourcePath($path));
                    }
                }
            }
        }
    }

    /**
     * Requires each js file in the manifest and any additional scripts
     */
    public static function requireSiteJS()
    {
        Requirements::set_force_js_to_bottom(true);

        // Polyfill for svg sprites
        Requirements::javascript(
            'https://cdnjs.cloudflare.com/ajax/libs/svgxuse/1.2.6/svgxuse.min.js',
            ['defer' => true]
        );

        $manifest = self::getManifest();

        if (!empty($manifest['entrypoints'])) {
            foreach ($manifest['entrypoints'] as $name => $entrypoint) {
                if (array_key_exists('js', $entrypoint)) {
                    foreach ($entrypoint['js'] as $path) {
                        Requirements::themedJavascript(self::getResourcePath($path));
                    }
                }
            }
        }
    }

    /**
     * Returns a path to a resource file
     */
    public static function getAsset($path)
    {
        return self::getResourcePath($path);
    }

    /**
     * Returns a file's actual content (only really useful for SVGs)
     */
    public static function getAssetInline($path)
    {
        return file_get_contents(self::getAbsResourcePath($path));
    }

    /**
     * Loads the manifest.json file so the paths are available for Requirements
     *
     * Requires this webpack plugin to be used and configured properly
     * https://github.com/webdeveric/webpack-assets-manifest
     */
    private static function getManifest()
    {
        if (!is_null(self::$manifestCache)) {
            return self::$manifestCache;
        }

        $manifestFile = self::getAbsResourcePath('manifest.json');

        if (file_exists($manifestFile)) {
            $contents = json_decode(file_get_contents($manifestFile), true);
            self::$manifestCache = $contents;
        } else {
            self::$manifestCache = false;
        }

        return self::$manifestCache;
    }

    /**
     * Returns a path to a file relative to the theme's resources folder (usually the dist or output directory)
     */
    public static function getResourcePath($path)
    {
        return Path::join(
            '/',
            ManifestFileFinder::RESOURCES_DIR,
            self::$themeDir,
            'dist',
            $path
        );
    }

    /**
     * Returns an absolute path to a file on disk
     */
    public static function getAbsResourcePath($path)
    {
        $resourcePath = Director::makeRelative(self::getResourcePath($path));

        return Director::getAbsFile($resourcePath);
    }
}
