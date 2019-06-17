<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fortyfive\staticsitepipelinesync;

use fortyfive\staticsitepipelinesync\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use yii\base\Event;

/**
 * Class StaticSitePipelineSync
 *
 * @author    45RPM
 * @package   StaticSitePipelineSync
 * @since     1.0.0
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
    public $schemaVersion = '1.0.0';

    /**
     * @var boolean
     */
    public $hasCpSettings = true;

    /**
     * @var boolean
     */
    public $hasCpSection = true;

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
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        // Register our CP URL rules
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['GET static-site-pipeline-sync'] = 'static-site-pipeline-sync/cp/index';
                $event->rules['GET static-site-pipeline-sync/publish'] = 'static-site-pipeline-sync/cp/publish';
            }
        );

        // Register our CP routes
        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                if (\Craft::$app->user->identity->admin) {
                    $event->navItems['sync-site'] = [
                        'label' => "Site Sync",
                        'url' => 'static-site-pipeline-sync'
                    ];
                }
        });

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
    protected function createSettingsModel()
    {
        return new Settings();
    }


    /**
     * @inheritdoc
     */
    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'static-site-pipeline-sync/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
