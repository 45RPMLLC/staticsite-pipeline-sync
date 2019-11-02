# Static Site Pipeline Sync plugin for Craft CMS 3.x

This plugin facilitates publishing content to static generator tools (e.g. Gatsby) when the build / publishing  process is hosted on AWS. It provides a simple interface that allows users to push content from Craft CMS to an AWS CodeBuild project.

## Requirements

- This plugin requires Craft CMS 3.2.0 or later
- A valid AWS user with an access key and secret (with CodeBuild and S3 access policies)
- An AWS CodeBuild project
- An S3 bucket to upload output artifacts
- A valid Git URL repository (Github or BitBucket)

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

2. Pay special attention to the **Project Settings** table, make sure you relate the right **Git branch** to the correct **CodeBuild Project**, otherwise you could end up publishing changes to the wrong environment.

3. After all settings are properly saved, an additional menu option appears on the **Utilities** menu called **Push Content**, follow the instructions and you should be able to trigger builds from within Craft CMS.

From the desk of [45RPM](https://www.45rpm.co/)
