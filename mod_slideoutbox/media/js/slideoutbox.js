jQuery(function($) {
    // Get slidebox options
    var options = Joomla.getOptions('mod_slideoutbox');
    var moduleId = options.moduleId;
    var scrollDepth = options.scrollDepth;
    var cookieExpire = options.cookieExpire;

    // Flag to track if slideout has appeared
    var hasAppeared = false;

    // Sets a cookie with name, value, and expiration days (0 = immediate expiry)
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        if (exdays === 0) {
            d.setTime(d.getTime() - 1); // Expire immediately
        } else {
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        }
        const expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
    }
    
    // Retrieves the value of a cookie by name
    function getCookie(cname) {
        const name = cname + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length);
        }
        return ""; // Empty string if cookie not found
    }

    // Check if close cookie exists
    function checkCookie() {
        const closedCookie = getCookie("mod_slideoutbox_closed_" + moduleId);
        if (closedCookie != "") {
            $('#sbox-' + moduleId).parent('.sbox').remove(); // Remove the Slideoutbox DOM element
            return false;  
        }
        return true; // Allow the slideout to proceed
    }

    function unsetCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
    }

    // Only proceed if no close cookie is set
    if (checkCookie()) {
        $(window).on('scroll', function() {
            if (!hasAppeared) {
                // Get current scroll position in pixels
                const scrollTop = $(window).scrollTop();
                
                // Calculate total scrollable height of the document
                const docHeight = $(document).height() - $(window).height();
                
                // Compute scroll percentage; fallback to 0 for short pages
                const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;

                if (scrollPercent >= scrollDepth) {
                    $('#sbox-' + moduleId).addClass('active');
                    hasAppeared = true; // Prevent further scroll checks
                }
            }
        });

        // Set the close cookie if the user clicks the close button
        $('#sbox-' + moduleId + ' .close').on('click', function() {
            $('#sbox-' + moduleId).parent('.sbox').remove();
            setCookie("mod_slideoutbox_closed_" + moduleId, "closed", cookieExpire);
        });
    }
});