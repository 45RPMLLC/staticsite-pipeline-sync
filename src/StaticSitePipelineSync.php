<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fourtyfive\staticsitepipelinesync;

use fourtyfive\staticsitepipelinesync\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Elements;

use yii\base\Event;

use Cz\Git\GitRepository;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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

        /*Event::on(
            Elements::class,
            Elements::EVENT_AFTER_SAVE_ELEMENT,
            function(Event $event) {
                if ($event->element instanceof craft\elements\Entry) {
                    try {
                        $github_username = '';
                        $github_repository = '';
                        $github_repository_branch = 'master';
                        $github_login = '';
                        $github_password = '';

                        $store_path = CRAFT_BASE_PATH.'/storage/';

                        $aws_region = 'us-east-1';
                        $aws_access_key = "";
                        $aws_secret = "";
                        $s3_bucket_name = "";
                        $object_key = 'source.zip';

                        if( !file_exists("${store_path}${github_repository}") ){
                            GitRepository::cloneRepository("https://${github_login}:${github_password}@github.com/${github_username}/${github_repository}.git", "${store_path}${github_repository}");
                        }
                        $repo = new GitRepository("${store_path}${github_repository}");
                        $repo->fetch('origin', [$github_repository_branch]);
                        exec("cd ${store_path}${github_repository}; zip -r ${store_path}${object_key} . -x *.git* 2>&1", $output);

                        $s3 = new S3Client([
                            'region'  => $aws_region,
                            'version' => 'latest',
                            'credentials' => [
                                'key'    => $aws_access_key,
                                'secret' => $aws_secret,
                            ]
                        ]);

                        $result = $s3->putObject([
                            'Bucket' => $s3_bucket_name,
                            'Key'   => $object_key,
                            'SourceFile' => $store_path.$object_key
                        ]);

                    } catch (S3Exception $e) {

                        $e->getMessage();

                    }
                }
            }
        );*/

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
