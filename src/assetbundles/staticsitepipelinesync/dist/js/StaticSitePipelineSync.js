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

// Funciones asíncronas
//(async function () {

let $publishButton = document.getElementById('ssps-publish');
$publishButton.addEventListener('click',  (e) => {
    e.preventDefault();

    let $loaderSVG = document.getElementById('ssps-loader');
    $loaderSVG.classList.remove('hide');
    $loaderSVG.classList.add('show');

    fetch($publishButton.getAttribute('href'))
        .then(function(response) {
            $loaderSVG.classList.remove('show');
            $loaderSVG.classList.add('hide');
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' +
                    response.status);
                return;
            }
            console.log(response.json());
        })
        .catch(function(err) {
            $publishButton.classList.remove('show');
            $publishButton.classList.add('hide');
            console.log(err);
            console.log('algo falló');
        });
});

//})();