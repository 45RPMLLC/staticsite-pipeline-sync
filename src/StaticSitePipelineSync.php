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

namespace fortyfive\staticsitepipelinesync;

use fortyfive\staticsitepipelinesync\models\Settings;
use fortyfive\staticsitepipelinesync\utilities\Utility;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\services\Utilities;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\Cp;

use yii\base\Event;

/**
 * Class StaticSitePipelineSync
 *
 * @author    45RPM
 * @package   StaticSitePipelineSync
 * @since     1.1.0
 *
 */
class StaticSitePipelineSync extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var StaticSitePipelineSync
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.1.0';

    /**
     * @var boolean
     */
    public $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Utility::class;
            }
        );

        // Register our CP URL rules
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['static-site-pipeline-sync/deploy'] = 'static-site-pipeline-sync/build/deploy';
            }
        );

        Craft::info(
            Craft::t(
                'static-site-pipeline-sync',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('static-site-pipeline-sync/_settings', [
                'settings' => $this->getSettings()
            ]
        );
    }
}
