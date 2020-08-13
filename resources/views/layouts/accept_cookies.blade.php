    <script>
        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==" ") c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function eraseCookie(name) {
            document.cookie = name+"=; Max-Age=-99999999;";
        }

        $(document).ready(function() {
            if (!getCookie("acceptprivacy"))
                $("#privacyDisplay").show();
        });
    </script>
    <div id="privacyDisplay" style="display: none; min-height: 30px; width: 100%; position: fixed; bottom: 0px; left: 0px; padding: 10px; background: #111111; color: #ffffff; z-index: 99999;">
        <div class="row">
            <div class="col-md-6">
                We use cookies to understand how you use our site and to improve your experience. By continuing to use our site, you accept our use of cookies, <a href="https://portal.snaccooperative.org/terms_and_privacy">Privacy Policy and Terms of Use</a>.
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-info" id="privacyAccept" onClick="setCookie('acceptprivacy', 'true', 90); $('#privacyDisplay').remove();">Accept and Continue</button>
            </div>
        </div>
    </div>
