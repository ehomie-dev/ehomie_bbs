function setCookie(name, value, min, domain) {
    var _cookie = name + "=" + escape(value);
    if (min) {
        var exp = new Date;
        exp.setTime(exp.getTime() + min * 60 * 1e3);
        _cookie += ";expires=" + exp.toGMTString()
    }
    if (domain) {
        _cookie += ";domain=" + escape(domain);
        _cookie += ";path=/"
    }
    document.cookie = _cookie
}
function getCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null) {
        return unescape(arr[2])
    }
    return null
}
var switchMobile = {
    UA: navigator.userAgent,
    addClass: function() {
        document.body.className = "xiaoyu_mobile";
        if (!this._isMobile) {
            document.body.className = "xmbbs_desktop_mobile"
        }
    },
    initBtn: function() {
        var _this = this;
        _this.$desktopBtn = $("#J_switchDesktop");
        _this.$mobileBtn = $("#J_switchMobile");
        _this.$desktopBtn.on("click.mobile",
        function(e) {
            e.preventDefault();
            if (!_this.$desktopBtn.hasClass("disable")) {
                setCookie("_disableMobile", 1, 60 * 24, "xiaomi.cn");
                location.reload()
            }
        });
        _this.$mobileBtn.on("click.mobile",
        function(e) {
            e.preventDefault();
            if (!_this.$mobileBtn.hasClass("disable")) {
                setCookie("_disableMobile", 0, 60 * 24, "xiaomi.cn");
                location.reload()
            }
        });
        if (_this._isMobile) {
            _this.$mobileBtn.addClass("disable")
        } else {
            _this.$desktopBtn.addClass("disable")
        }
    },
    checkMobile: function() {
        var _this = this,
        _disableMobile = parseInt(getCookie("_disableMobile"));
        if (_this.UA.indexOf("Android") > -1 || _this.UA.indexOf("iPhone") > -1 || _this.UA.indexOf("iPod") > -1 || _this.UA.indexOf("Symbian") > -1) {
            if (!_disableMobile) {
                _this._isMobile = 1;
                setCookie("_disableMobile", 0, 60 * 24, "xiaomi.cn")
            } else {
                _this._isMobile = 0
            }
            _this.addClass()
        } else {
            document.body.className = "xmbbs_desktop"
        }
    },
    init: function() {
        var _this = this;
        _this.checkMobile()
    }
};
var xmbbsMobile = {};
var hosturl = "";
$(function() {
    switchMobile.initBtn();
    xmbbs = {
	userHover: function() {
    $(".user").click(function() {
        $(".user_con").is(":hidden");
        $(".user_con").slideToggle(0);
    })
	},
        closeClick: function() {
            $("body").delegate(".modal_full,.close", "click",
            function() {
                $(".modal_full").remove()
            })
        },
        readShow: function() {
            $(".theme_list").hover(function() {
                $(this).find(".digest").find(".read").show()
            },
            function() {
                $(this).find(".digest").find(".read").hide()
            })
        },
        getHost: function(url) {
            var host = "null";
            if (typeof url == "undefined" || null == url) url = window.location.href;
            var regex = /.*\:\/\/([^\/]*).*/;
            var match = url.match(regex);
            if (typeof match != "undefined" && null != match) host = match[1];
            return host
        },
        checkbrower: function() {
            var brower = navigator.userAgent;
            if (brower.indexOf("MSIE") > 0) {
                if (brower.indexOf("MSIE 6.0") > 0 || brower.indexOf("MSIE 7.0") > 0 || brower.indexOf("MSIE 8.0") > 0) {
                    $("body").addClass("ie8reduce")
                }
            }
        },   /* 小.鱼.设.计团.队qq56282838.5*/
        fixfooter: function() {
            setTimeout(function() {
                var h_footer = $(".footer").outerHeight(false);
                var h_header = $(".head_wrap").outerHeight(true);
                var h_container = $(".container_wrap").outerHeight(true);
                var h_window = $(window).height();
            },
            500)
        },
        plateHover: function() {
            var o = $(".sidebarplate"),
            oBtn = o.find("span"),
            oUl = o.find("ul");
            oBtn.on("mouseover",
            function() {
                var index = $(this).index();
                oBtn.removeClass("on").eq(index).addClass("on");
                oUl.removeClass("on").eq(index).addClass("on")
            })
        },
        init: function() {
            var _t = this;
            _t.userHover();
            _t.closeClick();
            _t.readShow();
            _t.url = "http://" + _t.getHost(window.location.href);
            _t.checkbrower();
            _t.fixfooter();
            _t.plateHover()
        },
        url: ""
    };
    xmbbs.init();
    hosturl = xmbbs.url;
    if (switchMobile._isMobile) {
        var headerMenu = {
            $headerMenu: $(".header_menu"),
            $headerMenuToggle: $('<span class="header_menu_toggle"><i></i></span>'),
            init: function() {
                this.$headerMenu.find("span").on({
                    click: function() {
                        var $list = $(this).next(".header_menu_list, .header_more_list");
                        if ($list.filter(":visible").length > 0) {
                            $list.slideUp("fast")
                        } else {
                            $list.slideDown("fast")
                        }
                    }
                });
                this.$headerMenuToggle.find("i").on("click.xmbbs",
                function() {
                    $(".header_menu").toggleClass("show")
                });
                this.$headerMenu.before(this.$headerMenuToggle)
            }
        };
        $.extend(xmbbsMobile, {
            headerMenu: headerMenu
        });
        xmbbsMobile.headerMenu.init()
    }
});
