<?php
/**
 * Static Site Pipeline Sync plugin for Craft CMS 3.x
 *
 * This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.
 *
 * @link      https://www.45rpm.co/
 * @copyright Copyright (c) 2019 45RPM
 */

namespace fourtyfive\staticsitepipelinesync\models;

use fourtyfive\staticsitepipelinesync\StaticSitePipelineSync;

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
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
