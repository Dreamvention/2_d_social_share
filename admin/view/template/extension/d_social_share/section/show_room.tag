<sh_show_room>
    <div class="show-buttons-wrap">
        <div class="show-wrap">
            <div class="show-back-foot">
            </div>
        </div>
        <div class="button_load">
            <div id="{state.codename}" ></div>
        </div>
    </div>
    <link rel="stylesheet" href="{state.styles_link[state.design.style]}" type="text/css" if="{state.design.style != 'custom'}">

    <script>
        function getButtons(){
            $("#"+ self.state.codename ).jsSocials({
                url: self.state.custom_url ,
                text: self.state.config.text_to_share,
                showLabel: self.state.config.showLabel,
                showCount: self.state.config.showCount ,
                shareIn: self.state.config.shareIn,
                smallScreenWidth: self.state.config.breakpoints.smallScreenWidth ,
                largeScreenWidth: self.state.config.breakpoints.largeScreenWidth ,
                shares: getButtonsShares()
            })
        }
        function addClass(className,classValues) {
            styleContainer =className+'{';
            for (key in classValues){
                styleContainer+=key+':'+classValues[key]+';'
            }
            styleContainer +='}';
            return  styleContainer;
        }
        function SetStyles() {
            $('html > head').find('[title="d_social_share"]').remove();
            var style = '<style title="d_social_share">';//'</style>'
            style += addClass('.jssocials-share-link',
                {
                    'border-radius': self.state.design.rounded?'50% !important':'0',
                    'padding':self.state.design.sizes[self.state.design.size].padding+" !important",
                    'font-size':self.state.design.sizes[self.state.design.size]['font-size'],
                }
            )
            if (self.state.design.style == 'flat'){
                for(var button_key in self.state.buttons) {
                    var button = self.state.buttons[button_key];
                    if (button.enabled){
                        var className = '.jssocials-share-'+button.id+' .jssocials-share-link';
                        color = {
                            'color':button.style.color,
                            'background-color':button.style.background_color+'!important',
                            'border-color':button.style.background_color+'!important'
                        }
                        style += addClass(className,color)
                        className = '.jssocials-share-'+button.id+' .jssocials-share-link:hover';
                        color_hover = {
                            'color':button.style.color,
                            'background-color':button.style.background_color_hover+'!important',
                            'border-color':button.style.background_color_hover+'!important'
                        }
                        style += addClass(className,color_hover)
                    // var className = '.jssocials-share-'+button.id+' .jssocials-share-link:active';
                    }
                }
            }
            style+='</style>'
            var $style = $(style)
            $('html > head').append($style);
        }
        getButtonsShares=function () {
            var buttons = [];
            for(var button_key in self.state.buttons) {
                var button = self.state.buttons[button_key];
                if (button.enabled){
                    var button_share = button.share;
                    button_share.share = button.id;
                    // if (typeof button.style.native != 'undefined' && button.style.native ){
                    //     if (typeof button_share.renderer=='undefined')
                    //     button_share.renderer = getNativeButton(button.id)
                    // } donn't work yet in admin
                    buttons.push(button_share)
                }
            }
            return buttons;
        }
        function getNativeButton(native) {
            switch (native) {
                case 'facebook':
                    return function () {
                        var $result = $("<div>");
                        var script = document.createElement("script");
                        script.text = "(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));";
                        $result.append(script);
                        $("<div>").addClass("fb-share-button")
                            .attr("data-layout", "button_count")
                            .appendTo($result);
                        return $result;
                    }
                case 'googleplus':
                    return function () {
                        var $result = $("<div>");

                        var script = document.createElement("script");
                        script.src = "https://apis.google.com/js/platform.js";
                        $result.append(script);

                        $("<div>").addClass("g-plus")
                            .attr({
                                "data-action": "share",
                                "data-annotation": "bubble"
                            })
                            .appendTo($result);

                        return $result;
                    }
                case 'linkedin':
                    return function () {
                        var $result = $("<div>");

                        var script = document.createElement("script");
                        script.src = "//platform.linkedin.com/in.js";
                        $result.append(script);

                        $("<script>").attr({type: "IN/Share", "data-counter": "right"})
                            .appendTo($result);

                        return $result;
                    }
                case 'twitter':
                    return function () {
                        var $result = $("<div>");

                        var script = document.createElement("script");
                        script.text = "window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));";
                        $result.append(script);

                        $("<a>").addClass("twitter-share-button")
                            .text("Tweet")
                            .attr("href", "https://twitter.com/share")
                            .appendTo($result);

                        return $result;
                    }
                case 'pinterest':
                    return function () {
                        var $result = $("<div>");

                        var script = document.createElement("script");
                        script.src = "//assets.pinterest.com/js/pinit.js";
                        $result.append(script);

                        $("<a>").append($("<img>").attr("//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png"))
                            .attr({
                                href: "//www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fjs-socials.com%2Fdemos%2F&media=%26quot%3Bhttp%3A%2F%2Fgdurl.com%2Fa653%26quot%3B&description=Next%20stop%3A%20Pinterest",
                                "data-pin-do": "buttonPin",
                                "data-pin-config": "beside",
                                "data-pin-color": "red"
                            })
                            .appendTo($result);

                        return $result;
                    }
            }
        }
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();
        self.on('mount', function () {
            // костыли потому что не могу биндить стиль if он всеравно подключается
            setTimeout(SetStyles,200);
            getButtons();//jsSocials

        })
        self.on('updated', function () {
            setTimeout(SetStyles,50);
            getButtons();//jsSocials
        });
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>
</sh_show_room>