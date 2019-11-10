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
        let activeProject = this.getAttribute('data-project');
        let url = this.getAttribute('href');

        Swal.fire({
            title: "Are you sure?",
            html: "You're about to push new content to <strong><u>" + activeProject + "</u></strong>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes, push it!",
        })
        .then((result) => {
            if (!result.dismiss) {
                return new Promise(function (resolve, reject) {
                    let request = new XMLHttpRequest();
                    request.open('GET', url, true);
    
                    request.onload = () => {
                        let response = JSON.parse(request.response);
                        if (response.message) {
                            resolve(response.message);
                        } else {
                            reject(response.error);
                        } // end if - else
                    };
    
                    request.onerror = function() {
                        reject('An error ocurred during the transaction, try again later');
                    };
    
                    request.send();
                });
            }
        })
        .then(response => {
            if (response !== undefined) {
                Swal.fire({
                    title: "Done!",
                    html: "Content was pushed successfully, visit your AWS console for more details on the build status.",
                    icon: "success",
                    footer: response
                });
            } // end if
        })
        .catch(error => {
            Swal.fire({
                title: "Oh no!",
                html: error,
                icon: "error"
            });
        });
    });
} // end for