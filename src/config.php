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

/**
 * Static Site Pipeline Sync config.php
 *
 * This file exists only as a template for the Static Site Pipeline Sync settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'static-site-pipeline-sync.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    'aws-region' => 'us-east-1',
    'aws_access_key' => 'AKIAIOSFODNN7EXAMPLE',
    'aws_secret' => 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY',
    'git_source' => 'GitHub|BitBucket',
    'git_url' => 'https://github.com/username/repo.git',
    'buildProjects' => [
        [
            'name' => 'Dev Build',
            'branch' => 'master',
            'enable' => true
        ]
    ]

];
