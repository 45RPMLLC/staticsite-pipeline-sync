<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fourtyfive\staticsitepipelinesync\assetbundles\StaticSitePipelineSync;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
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
        $this->sourcePath = "@fourtyfive/staticsitepipelinesync/assetbundles/staticsitepipelinesync/dist";

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
