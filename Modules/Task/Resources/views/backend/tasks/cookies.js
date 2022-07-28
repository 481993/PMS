<script type="text/javascript">

    document.addEventListener('wpcf7mailsent', function(event) {

      if ('3353' == event.detail.contactFormId) {

        let user = "subscribed";

        setCookie("username", user, 30);



        function setCookie(cname, cvalue, exdays) {

          const d = new Date();

          d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

          let expires = "expires=" + d.toUTCString();

          document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

          location.reload();

        }

      }

    }, false);
    </script>
     let user = getCookie("username");
     let closebtn = getCookie("closebtn");

    if (closebtn == "" && user == "") {

        jQuery('#modal-one').removeClass('hide');

    }
    jQuery('#btn-close').on('click', function() {

        let btnname = 'popupbtnx'

        setCookie("closebtn", btnname, 1);

        //jQuery.cookie("closebtn", true,  time() + 86400); // 1 day




    });

    function setCookie(cname, cvalue, exdays) {

        const d = new Date();

        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

        let expires = "expires=" + d.toUTCString();

        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

        jQuery(this).closest('#modal-one').fadeOut();

        // location.reload();

    }







    get Cookie
    function getCookie(cname) {

        let name = cname + "=";

        let decodedCookie = decodeURIComponent(document.cookie);

        let ca = decodedCookie.split(';');

        for (let i = 0; i < ca.length; i++) {

            let c = ca[i];

            while (c.charAt(0) == ' ') {

                c = c.substring(1);

            }

            if (c.indexOf(name) == 0) {

                return c.substring(name.length, c.length);

            }

        }

        return "";

    }
     function checkCookie() {

        let user = getCookie("username");

        if (user != "") {

            //  alert("Welcome again " + user);

        } else {

            user = prompt("Please enter your name:", "");

            if (user != "" && user != null) {

                setCookie("username", user, 30);

            }

        }

    }


