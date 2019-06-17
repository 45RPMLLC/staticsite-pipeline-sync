<?php


namespace fortyfive\staticsitepipelinesync\controllers;

use Craft;
use craft\web\Controller;

use Cz\Git\GitRepository;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class CpController extends Controller
{
    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = false;

    function actionIndex()
    {
        $this->renderTemplate( 'static-site-pipeline-sync/home');
    }

    function actionPublish()
    {
        try {
            $store_path = CRAFT_BASE_PATH.'/storage/';

            $github_username = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->github_username;
            $github_repository = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->github_repository;
            $github_repository_branch = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->github_repository_branch;
            $github_login = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->github_login;
            $github_password = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->github_password;

            $aws_region = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->aws_region;
            $aws_access_key = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->aws_access_key;
            $aws_secret = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->aws_secret;
            $s3_bucket_name = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->s3_bucket_name;
            $object_key = \fortyfive\staticsitepipelinesync\StaticSitePipelineSync::getInstance()->getSettings()->object_key;

            if( !file_exists("${store_path}${github_repository}") ){
                GitRepository::cloneRepository("https://${github_login}:${github_password}@github.com/${github_username}/${github_repository}.git", "${store_path}${github_repository}");
            }
            $repo = new GitRepository("${store_path}${github_repository}");
            if ( $repo->getCurrentBranchName() !== $github_repository_branch ){
                $repo->checkout($github_repository_branch);
            }
            if( $repo->hasChanges() ) {
                $repo->pull('origin');
            }

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

            return $this->asJson([
                'message' => "Pipeline Triggered"
            ]);

        } catch (\Exception $e){
            Craft::error(Craft::t('StaticSite-Pipeline-Sync', 'Error: {e}', ['e' => $e->getMessage()]), __METHOD__);
            return $this->asErrorJson("Sorry, something went wrong, please try again later.");
        }
    }

}