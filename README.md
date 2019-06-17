# Static Site Pipeline Sync plugin for Craft CMS 3.x

This plugin allows trigger an AWS Pipeline based on S3 to publish a new version of a Static Website with the last version of content stored in Craft CMS.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

- Create an Amazon S3 bucket for the sample applications and enable versioning on that bucket. If you don't know how to do it [here](https://docs.aws.amazon.com/codepipeline/latest/userguide/tutorials-simple-s3.html#s3-create-s3-bucket) is a tutorial.
- AMI user (Key and Secret) with write access to the previous bucket.
- GitHub user (user and password) with read access to the repository where is hosted the static site app.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require fortyfive/staticsite-pipeline-sync /static-site-pipeline-sync

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Static Site Pipeline Sync.

4.- Go to the Plugin Settings and set the data required there. 

## Using Static Site Pipeline Sync

1. Be sure that all the Plugin settings are in place and that are correct.

2. After update your content in Craft CMS go to the Panel option - left side - **Site Sync**.

2. Make click on the button **Trigger Pipeline**.

Brought to you by [45RPM](https://www.45rpm.co/)
