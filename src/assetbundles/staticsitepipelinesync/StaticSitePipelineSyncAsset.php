<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows to trigger an AWS CodeBuild remotely, to publish a new version
 * of a static website with the latest version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fortyfive\staticsitepipelinesync\assetbundles\StaticSitePipelineSync;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * StaticSitePipelineSyncAsset
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    45RPM
 * @package   StaticSitePipelineSync
 * @since     1.0.0
 */
class StaticSitePipelineSyncAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@fortyfive/staticsitepipelinesync/assetbundles/staticsitepipelinesync/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/StaticSitePipelineSync.js',
        ];

        $this->css = [
            'css/StaticSitePipelineSync.css',
        ];

        parent::init();
    }
}
