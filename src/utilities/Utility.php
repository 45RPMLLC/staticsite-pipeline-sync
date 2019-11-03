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

namespace fortyfive\staticsitepipelinesync\utilities;

use Craft;
use fortyfive\staticsitepipelinesync\StaticSitePipelineSync;
use fortyfive\staticsitepipelinesync\assetbundles\StaticSitePipelineSync\StaticSitePipelineSyncAsset;

/**
 * Static Site Pipeline Sync utility that allows to trigger AWS code builds
 *
 * @package StaticSitePipelineSync
 * @author  45RPM
 * @since   1.1.0
 */
class Utility extends \craft\base\Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('static-site-pipeline-sync', 'Push Content');
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'static-site-pipeline-sync';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias('@fortyfive/staticsitepipelinesync/assetbundles/staticsitepipelinesync/dist/img/StaticSitePipelineSync-icon.svg');
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(StaticSitePipelineSyncAsset::class);

        return Craft::$app->getView()->renderTemplate('static-site-pipeline-sync/_utility', [
            'buildProjects' => StaticSitePipelineSync::getInstance()->getSettings()->buildProjects
        ]);
    }

}