var FACEBOOK = {
    init: function () {
        window.fbAsyncInit = function () {
            FB.init({
                appId: facebookAppId,
                xfbml: false,
                status: true,
                version: facebookAppApi
            });

        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }
};

$(document).ready(function () {
    $('#facebook-share').click(function() {
        FACEBOOK.init();
    });
});