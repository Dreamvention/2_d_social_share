(function ($, window, document, undefined) {
    var Socials,
        SocialButtons;
    var popup = {
        width: 200,
        height: 200
    };

    var sharingWindowFeatures = {
    };

    function load_count(data) {
        if (data && data.shares) {
            this.count = data.shares;
        } else {
            this.count = 0;
        }

    }

    function append_count($el, count) {
        if ($el.find('.d-social-count')) {
            $el.parent().append('<div class="d-social-count-wrap"><span>' + count + '</span></div>')
        } else {
            $el.find('.d-social-count').html(count);
        }
    }

    Socials = {
        facebook: {
            url: "https://graph.facebook.com/?id=",
            callback: function (data) {
                if (data) {
                    this.count = data.share.share_count;
                } else {
                    this.count = 0;
                }

            },
            share: "http://www.facebook.com/sharer/sharer.php?u="
        },
        vk: {
            url: "https://vk.com/share.php?act=count&url=",
            callback: function (data) {
                // VK.com doesn't support callback parametr for JSONP
                // This callback will never be called
            },
            share: "https://vk.com/share.php?url="
        },
        odnoklasniki: {
            url: "https://ok.ru/dk?ref=",
            callback: function (data) {
            },
            share: "http://odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl="
        },
        twitter: {
            url: "https://cdn.api.twitter.com/1/urls/count.json?url=",
            callback: function (data) {
                if (data) {
                    this.count = data.count;
                } else {
                    this.count = 0;
                }
            },
            share: "https://twitter.com/intent/tweet?url="
        },
        linkedin: {
            url: "https://www.linkedin.com/countserv/count/share?format=jsonp&url=",
            callback: function (data) {
                if (data) {
                    this.count = data.count;
                } else {
                    this.count = 0;
                }
            },
            share: "https://www.linkedin.com/cws/share?url="
        },
        pinterest: {
            url: "https://api.pinterest.com/v1/urls/count.json?url=",
            callback: function (data) {
                if (data) {
                    this.count = data.count;
                } else {
                    this.count = 0;
                }
            },
            // Have some trouble with this
            share: "https://www.pinterest.com/pin/create/button/?media={image}&url="
        },
        google: {
            url: "https://clients6.google.com/rpc",
            callback: load_count,
            // Have some trouble with this
            share: "https://plus.google.com/share?" + "url=",
        }
    };

    SocialButtons = {
        init: function (options, el) {
            var self = this,
                $el = $(el),
                network = $el.data("social"),
                oSocial = Socials[network];


            if (oSocial) {
                /**
                 * VK.com doesn't support callback parameter for JSONP
                 * VK.com wanna call VK.Share.count()
                 */
                if (network === "vk") {
                    window.VK = window.VK || {};
                    window.VK.Share = VK.Share || {};
                    window.VK.Share.count = function (index, count) {
                        Socials["vk"].count = count;
                    }
                }
                if (network == 'odnoklasniki') {
                    window.ODKL = window.ODKL || {};
                    window.ODKL.Share = ODKL.Share || {};
                    window.ODKL.Share.count = function (uid, value) {
                        Socials["odnoklasniki"].count = value;
                    }
                }
                options = options || {};

                if (options.url) {
                    self.shareUrl = options.url;
                } else {
                    self.shareUrl = window.location.href;
                }

                if (oSocial.url) {
                    if (network == 'google') {
                        $.ajax({
                            type: 'POST',
                            url: 'https://clients6.google.com/rpc',
                            processData: true,
                            contentType: 'application/json',
                            data: JSON.stringify({
                                'method': 'pos.plusones.get',
                                'id': self.shareUrl,
                                'params': {
                                    'nolog': true,
                                    'id': self.shareUrl,
                                    'source': 'widget',
                                    'userId': '@viewer',
                                    'groupId': '@self'
                                },
                                'jsonrpc': '2.0',
                                'key': 'p',
                                'apiVersion': 'v1'
                            }),
                            success: function (response) {
                                $el.attr("data-count", response.result.metadata.globalCounts.count);
                                append_count($el, response.result.metadata.globalCounts.count)
                            }
                        })
                    }
                    // else if (network=='pinterest'){
                    //     $.ajax({
                    //         type: 'GET',
                    //         dataType: 'jsonp',
                    //         url: 'https://api.pinterest.com/v1/urls/count.json',
                    //         data: {'url': url}
                    //     })
                    //         .done(function(data){callback(data.count)})
                    //         .fail(function(){callback(0)})
                    // }
                    else{
                        $.getScript(
                            oSocial.url + self.shareUrl + "&callback=jQuery.fn.socialButtons." + network + "SetCount",
                            function (data, textStatus, jqxhr) {
                                $el.attr("data-count", oSocial.count);
                                append_count($el, oSocial.count)
                            }
                        );
                    }
                }

                if (oSocial.share) {
                    $el.on("click.socialButtons", function () {
                        window.open(
                            oSocial.share + self.shareUrl,
                            'SharingWindow',
                            sharingWindowFeatures
                        );
                    });
                }
            }
        },
        setCount: function (network, count) {
            console.log(count);
        },
        getCount: function () {

        }
    };

    $.fn.socialButtons = function (options) {
        return this.each(function () {
            var socialButtons = Object.create(SocialButtons);

            if (SocialButtons[options]) {
                return SocialButtons[options].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof options === 'object' || typeof options === 'undefined') {
                return socialButtons.init(options, this);
            } else {
                $.error('"' + options + '" method does not exist in jQuery.switcher');
            }
        });
    };

    for (var network in Socials) {
        if (Socials.hasOwnProperty(network)) {
            $.fn.socialButtons[network + "SetCount"] = Socials[network].callback.bind(Socials[network]);
        }
    }

}(jQuery, window, document));