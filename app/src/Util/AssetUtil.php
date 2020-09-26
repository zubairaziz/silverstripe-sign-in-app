<?php

namespace App\Util;

use SilverStripe\Control\Director;
use SilverStripe\Core\Manifest\ManifestFileFinder;
use SilverStripe\Core\Path;
use SilverStripe\View\Requirements;

class AssetUtil
{
    private static $manifestCache = null;
    private static $assetIconSymbolsCache = null;
    private static $assetIconInlineCache = [];
    private static $spritemapFile = 'spritemap.svg';
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
     * Returns an SVG icon based on a spritemap file
     *
     * Requires this webpack plugin to be used and configured properly
     * https://github.com/cascornelissen/svg-spritemap-webpack-plugin
     *
     * The viewBox attribute is extracted from the spritemap symbol
     * and applied to the parent <svg> so it's easier to work with in CSS
     */
    public static function getAssetIcon($name)
    {
        $spritemapPath = self::getAsset(self::$spritemapFile);
        $symbols = self::getAssetIconSymbols();

        // Special cases where we want to preserve the colors of the original SVG
        $useImage = [];

        if (in_array($name, $useImage)) {
            return self::getAssetIconInline($name);
        }

        if (array_key_exists("sprite-{$name}", $symbols)) {
            $symbol = $symbols["sprite-$name"];

            return sprintf('
                <svg data-icon="%s" aria-hidden="true" viewBox="%s">
                    <use xlink:href="%s#sprite-%s"></use>
                </svg>
            ', $name, $symbol->getAttribute('viewBox'), $spritemapPath, $name);
        }
    }

    /**
     * Returns an SVG icon based on file
     */
    public static function getAssetIconInline($name)
    {
        if (array_key_exists($name, self::$assetIconInlineCache)) {
            return self::$assetIconInlineCache[$name];
        }

        $svg = new \DomDocument;
        $svg->validateOnParse = true;
        $svg->load(self::getAbsResourcePath("images/{$name}.svg"));
        $svg->getElementsByTagName('svg')[0]->setAttribute('data-icon', $name);

        $svgHtml = $svg->saveHTML();

        self::$assetIconInlineCache[$name] = $svgHtml;

        return $svgHtml;
    }

    /**
     * Loads all the symbols (icons) in the SVG spritemap file
     */
    private static function getAssetIconSymbols()
    {
        if (!is_null(self::$assetIconSymbolsCache)) {
            return self::$assetIconSymbolsCache;
        }

        $spritemapAbsPath = self::getAbsResourcePath(self::$spritemapFile);

        if (!file_exists($spritemapAbsPath)) {
            return [];
        }

        $spritemap = new \DomDocument;
        $spritemap->validateOnParse = true;
        $spritemap->load($spritemapAbsPath);
        $symbolNodes = $spritemap->getElementsByTagName('symbol');
        $symbols = [];

        foreach ($symbolNodes as $node) {
            $symbols[$node->getAttribute('id')] = $node;
        }

        self::$assetIconSymbolsCache = $symbols;

        return self::$assetIconSymbolsCache;
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
