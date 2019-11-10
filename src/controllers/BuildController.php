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

namespace fortyfive\staticsitepipelinesync\controllers;

use fortyfive\staticsitepipelinesync\StaticSitePipelineSync;

use Aws\CodeBuild\CodeBuildClient;

use Craft;
use craft\web\Controller;

use yii\web\Response;

/**
 * Class BuildController
 *
 * Triggers a code build from the selected project to update content sourced by Craft CMS
 *
 * @package StaticSitePipelineSync
 */
class BuildController extends Controller
{
    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = false;

    /**
     * Trigger the code build that updates the content coming from Craft CMS, this
     * method validates:
     * - That the request comes from the Control Panel
     * - Access level (for now admin onlys)
     *
     * After executing these validations it makes sure the aws user has access to the
     * codebuild projects and that the value coming from the form matches at least one
     * of the projects from the AWS account.
     * Executes the build process and returns a valid build ID.
     * @return Response object
     */
    public function actionDeploy(): Response
    {
        try {
            $this->requireCpRequest();
            $this->requireAdmin();

            $awsRegion = StaticSitePipelineSync::getInstance()->getSettings()->aws_region;
            $awsAccessKey = StaticSitePipelineSync::getInstance()->getSettings()->aws_access_key;
            $awsSecret = StaticSitePipelineSync::getInstance()->getSettings()->aws_secret;
            $s3Bucket = StaticSitePipelineSync::getInstance()->getSettings()->s3_bucket;
            $gitSource = StaticSitePipelineSync::getInstance()->getSettings()->git_source === 'BitBucket' ? 'BITBUCKET' : 'GITHUB';
            $gitUrl = StaticSitePipelineSync::getInstance()->getSettings()->git_url;
            $buildProjects = StaticSitePipelineSync::getInstance()->getSettings()->buildProjects;

            // Let's make sure we have a project name and that name matches what the user provided
            if (Craft::$app->getRequest()->get('name') === null) {
                throw new \Exception('Missing codebuild project name to run the build process.');
            } // end if

            $buildProject = [];
            foreach ($buildProjects as $project) {
                if ($project['name'] === Craft::$app->getRequest()->get('name')) {
                    $buildProject = $project;
                    break;
                } // end if
            } // end foreach

            if (empty($buildProject)) {
                throw new \Exception('Code build project name doesn\'t match the ones saved on the settings page.');
            } // end if

            $client = new CodeBuildClient([
                'region' => $awsRegion,
                'version' => 'latest',
                'credentials' => [
                    'key' => $awsAccessKey,
                    'secret' => $awsSecret,
                ]
            ]);

            $activeBuildProjects = $client->listProjects();
            $isValidBuildProject = false;
            if (empty($activeBuildProjects)) {
                throw new \Exception('No active projects on your AWS account, make sure you\'re using the correct region and user has enough permissions.');
            } // end if

            foreach ($activeBuildProjects['projects'] as $project) {
                if ($project === $buildProject['name']) {
                    $isValidBuildProject = true;
                    break;
                } // end if
            } // end if

            if (!$isValidBuildProject) {
                throw new \Exception('Selected build project doesn\'t exist on the AWS account, make sure you\'re using the correct region and the user has enough permissions.');
            } // end if

            $build = $client->startBuild([
                // Let's make sure our build can be easily identified
                'artifactsOverride' => [
                    'artifactIdentifier' => 'CraftCMS_Artifact_Override',
                    'namespaceType' => 'BUILD_ID',
                    'packaging' => 'ZIP',
                    'location' => $s3Bucket,
                    'name' => time() . '_CMS.zip',
                    'path' => $buildProject['name'] . '/CraftCMSArtifacts',
                    'type' => 'S3'
                ],
                'gitCloneDepthOverride' => 1,
                'projectName' => $buildProject['name'],
                'sourceTypeOverride' => $gitSource,
                'sourceVersion' => 'refs/heads/' . $buildProject['branch'],
                'sourceLocationOverride' => $gitUrl,
                'sourceAuthOverride' => [
                    'resource' => $gitUrl,
                    'type' => 'OAUTH',
                ]
            ]);

            return $this->asJson(['message' => "Build ID is {$build['build']['id']}"]);

        } catch (\Exception $e) {
            Craft::error("Static Site Pipeline Sync error: {$e->getMessage()}", 'static-site-pipeline-sync');
            return $this->asErrorJson('An error occurred and the request failed, check the application logs for more details');
        } // end try - catch - catch
    }

}