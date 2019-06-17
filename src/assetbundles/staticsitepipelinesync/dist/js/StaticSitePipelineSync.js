/**
 * Static Site Pipeline Sync plugin for Craft CMS
 *
 * Static Site Pipeline Sync JS
 *
 * @author    45RPM
 * @copyright Copyright (c) 2019 45RPM
 * @link      https://www.45rpm.co/
 * @package   StaticSitePipelineSync
 * @since     1.0.0
 */
let $publishButton = document.getElementById('ssps-publish');
$publishButton.addEventListener('click',  (e) => {
    e.preventDefault();

    let $loaderSVG = document.getElementById('ssps-loader');
    let $doneMessage = document.getElementById('ssps-done');
    let $errorMessage = document.getElementById('ssps-error');
    let $fatalErrorMessage = document.getElementById('ssps-fatal-error');

    $loaderSVG.classList.remove('hide');
    $loaderSVG.classList.add('show');

    let request = new XMLHttpRequest();
    let url = $publishButton.getAttribute('href');
    request.open('GET', url, true);

    request.onload = () => {
        $loaderSVG.classList.remove('show');
        $loaderSVG.classList.add('hide');

        if (request.status >= 200 && request.status < 400) {
            // Success
            $doneMessage.classList.remove('hide');
        } else {
            // Error
            $errorMessage.classList.remove('hide');
        }
    };

    request.onerror = function() {
        // Fatal error
        $publishButton.classList.remove('show');
        $publishButton.classList.add('hide');
        $fatalErrorMessage.classList.remove('hide');
    };

    request.send();
});