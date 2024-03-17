var Navigation = {
    init: function () {
        this.$navigtaion = jQuery('.navigation');
        this.$navigtaionToggle = jQuery('.toggle-navigation');
        this.$navigationLinksContainers = jQuery('.navigation-links > li');
        this.$navigationLinks = jQuery('.navigation-links > li > a');
        this.$searchInput = jQuery('.navigation .navigation-search');
        this.$searchForm = jQuery('.navigation-search-container form');
        this.$searchButton = jQuery('.navigation-search-icon');
        this.$body = jQuery('body');
        this.registerHoverEvent();
        this.registerLinkOpenEvent();
        this.registerOpenCloseEvent();
        this.registerMobileStickEvent();
        this.registerSearchClick();
    },
    registerSearchClick: function() {
        var _this = this;
        _this.$searchButton.on('click', function( event ) {
            event.preventDefault();
            console.log( _this.$searchInput.val().trim(),  _this.$searchInput.val().trim().length);
            if( _this.$searchInput.val().trim().length > 0 ) {
                _this.$searchForm.submit();
            }
        })
    },
    isMobile: function () {
        return jQuery(window).width() < 992;
    },
    registerHoverEvent: function () {
        var _this = this;
        _this.$navigationLinksContainers.on('mouseover', function () {
            if( _this.isMobile() === true) {
                return;
            }
            var $elem = jQuery(this);
            $elem.find('.sub-navigation').addClass('active');
        });

        _this.$navigationLinksContainers.on('mouseleave', function () {
            if( _this.isMobile() === true ) {
                return;
            }
            var $elem = jQuery(this);
            $elem.find('.sub-navigation').removeClass('active');
        });
    },
    registerLinkOpenEvent: function() {
        var _this = this;
        this.$navigationLinks.on('click', function (e) {
            if ( _this.isMobile() === false ) {
                return;
            }
            e.preventDefault();


            var $elem = jQuery(this),
                $subNav = $elem.siblings('.sub-navigation');

            if( $subNav.hasClass('active') ){
                $subNav.removeClass('active');
                return;
            }

            jQuery('.sub-navigation').removeClass('active');
            $subNav.addClass('active');
        });
    },
    registerOpenCloseEvent: function () {
        var _this = this;
        _this.$navigtaionToggle.on('click', function () {
            _this.$navigtaion.toggleClass('collapsed');
            _this.$navigtaion.toggleClass('open');
            _this.$body.toggleClass('nav-is-open');
        })
    },
    handleHeaderStickiness: function () {
        var _this = this,
            scrollTop = jQuery(window).scrollTop(),
            width = jQuery(window).width();

        var threshold = 0;

        if( width <= 992 ) {
            threshold =  width <= 600 && _this.$body.hasClass('admin-bar') ? 76 : 30;
        }

        if( scrollTop > threshold ) {
            _this.$body.addClass('stick');
        } else {
            _this.$body.removeClass('stick');
        }
    },
    registerMobileStickEvent: function() {
        var _this = this;

        jQuery(window).scroll(function () {
            _this.handleHeaderStickiness();
        });

        jQuery(window).resize(function () {
            _this.handleHeaderStickiness();
        });

        _this.handleHeaderStickiness();
    }
};

jQuery(document).ready(function () {
    var $appleLink = jQuery('#app_store_link');
    var $androidLink = jQuery('#android_link');

    var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    var isAndroid = /Android/.test(navigator.userAgent) && !window.MSStream;

    if ( isIOS ) {
        $androidLink.hide();
    }

    if ( isAndroid ) {
        $appleLink.hide();
    }

    Navigation.init();
});
