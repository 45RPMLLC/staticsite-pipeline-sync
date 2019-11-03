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

namespace fortyfive\staticsitepipelinesync\models;

use Craft;
use craft\base\Model;

/**
 * Static Site Pipeline Sync Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    45RPM
 * @package   StaticSitePipelineSync
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $aws_region ;

    /**
     * @var string
     */
    public $aws_access_key;

    /**
     * @var string
     */
    public $aws_secret;

    /**
     * @var string
     */
    public $git_source;

    /**
     * @var string
     */
    public $git_url;

    /**
     * @var string
     */
    public $s3_bucket;

    /**
     * @var array
     */
    public $buildProjects;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['aws_region', 'aws_access_key', 'aws_secret', 'git_source', 'git_url', 's3_bucket'], 'required' ],
            [['buildProjects'], 'safe'],
        ];
    }
}
