<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fortyfive\staticsitepipelinesync\models;

use fortyfive\staticsitepipelinesync\StaticSitePipelineSync;

use Craft;
use craft\base\Model;

/**
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
    public $github_username ;
    /**
     * @var string
     */
    public $github_repository ;
    /**
     * @var string
     */
    public $github_repository_branch ;
    /**
     * @var string
     */
    public $github_login ;
    /**
     * @var string
     */
    public $github_password ;
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
    public $s3_bucket_name;
    /**
     * @var string
     */
    public $object_key;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['github_username',
                'github_repository',
                'github_repository_branch',
                'github_login',
                'github_password',
                'aws_region',
                'aws_access_key',
                'aws_secret',
                's3_bucket_name',
                'object_key'], 'required' ],
        ];
    }
}
