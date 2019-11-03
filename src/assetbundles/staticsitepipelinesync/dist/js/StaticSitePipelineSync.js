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
let $deployButtons = document.getElementsByClassName('ssps-publish');
for (let i = 0; i < $deployButtons.length; i++) {
    $deployButtons[i].addEventListener('click', function (event) {
        event.preventDefault();
        //
        let $utility_status = this.nextElementSibling;
        let $loaderSVG = $utility_status.firstElementChild;
        let $message = $utility_status.lastElementChild;

        $loaderSVG.classList.remove('hide');
        $loaderSVG.classList.add('show');

        let request = new XMLHttpRequest();
        let url = this.getAttribute('href');

        request.open('GET', url, true);

        this.classList.add('disabled');

        request.onload = () => {
            $loaderSVG.classList.remove('show');
            $loaderSVG.classList.add('hide');
            $message.classList.remove('hide');
            $message.classList.add('show');
            let response = JSON.parse(request.response);
            if (response.message) {
                $message.innerHTML = response.message;
            } else {
                $message.innerHTML = response.error;
            }
            this.classList.remove('disabled');
        };

        request.onerror = function() {
            // Fatal error
            console.log('** An error ocurred during the transaction, try again later');
        };

        request.send();

        setTimeout(() => {
            $message.classList.remove('show');
            $message.classList.add('hide');
            $message.innerHTML = '';
        }, 5000);
    });
} // end for