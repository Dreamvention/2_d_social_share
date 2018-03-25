riot.tag2('d_social_share', '<div class="page-header"><div class="container-fluid"><div class="form-inline pull-right"><button onclick="{save_setting}" data-go="0" id="save_and_stay" data-toggle="tooltip" title="{state.button_save_and_stay}" class="btn btn-success"><i class="fa fa-save"></i></button><button onclick="{save_setting}" data-go="1" id="save" data-toggle="tooltip" title="{state.button_save}" class="btn btn-primary"><i class="fa fa-save"></i></button><a href="{state.cancel}" data-toggle="tooltip" title="{state.button_cancel}" class="btn btn-default" id="cancel-button"><i class="fa fa-reply"></i></a></div><h1>{state.heading_title} {state.version}</h1><sh_breadcrumbs></sh_breadcrumbs></div></div><div class="container-fluid"><div class="panel panel-default panel_top_radius"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> {state.text_edit} </h3><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_name}</label></div><div class="col-sm-10"><input class="form-control" onchange="{this.changeName}" name="{state.codename}_setting[name]" riot-value="{state.name}"></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_status}</label></div><div class="col-sm-10"><span class="sh_button_enable"><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[status]" class="switcher" data-label-text="{state.text_enabled}" checked="{state.status ? \'checked\':\'\'}" id="status" value="1"></span></div></div></div></div><div class="panel-body" if="{state.status}"><sh_navigation></sh_navigation><form id="setting_form" action=""><div class="tab-content "><div class="tab-pane active" id="nav_buttons"><sh_buttons></sh_buttons></div><div class="tab-pane " id="nav_design"><sh_design></sh_design></div><div class="tab-pane " id="nav_setting"><sh_settings></sh_settings></div><div class="tab-pane" id="nav_help_me"><sh_help_me></sh_help_me></div></div></form><hr><sh_show_room></sh_show_room></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        this.changeName = function(e)
        {
            self.state.name = e.target.value;
            self.store.updateState(['name'], self.state.name);
        }.bind(this)
        this.save_setting = function(e)
        {
            e.preventDefault = true;
            var go = parseInt(e.currentTarget.getAttribute('data-go'));
            data_ = {
                "d_social_share_setting": {
                    "custom_url": this.state.custom_url,
                    "buttons": this.state.buttons,
                    "design": this.state.design,
                    "config": this.state.config
                },
                "status": this.state.status,
                "name": this.state.name
            }
            self.store.dispatch('setting/save_setting', data_);
            if (go == 1) {
                $(location).attr('href', this.state.cancel);
            }
        }.bind(this)
        self.state = this.store.getState();
        self.on('mount', function () {
            console.log(this.state)
            loadlibs();
            $('#status').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.status = state;
                self.store.updateState(['status'], self.state.status);
            })

        })
        self.on('updated', function () {
            loadlibs();
        });
        self.on('update', function () {
            self.state = self.store.getState();
        });
        loadlibs = function () {
            $("[type='checkbox']").bootstrapSwitch({
                'onColor': 'success',
                'onText': self.state.text_yes,
                'offText': self.state.text_no,
            });
        }
});

riot.tag2('sh_breadcrumbs', '<ul class="breadcrumb"><li each="{el in state.breadcrumbs}"><a href="{el.href}">{el.text}</a></li></ul>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('mount', function () {
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

});
riot.tag2('sh_navigation', '<ul class="nav nav-tabs navigation"><li each="{el, i in state.navigation}"><a href="#nav_{i}" data-toggle="tab" class="htab-item {el.disabled ? \'disable_link ignore\' : \'\'}"><i class="{el.icon}"></i> {el.text} </a></li></ul>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('mount', function () {
            $($('.navigation li')[0]).addClass('active')
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

});
riot.tag2('sh_buttons', '<h3>{state.text_buttons}</h3><div class="buttons-wrap"><sh_button_info each="{button,i in state.buttons}"></sh_button_info></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
});
riot.tag2('sh_design', '<h3>{state.text_design}</h3><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_size}</label></div><div class="col-sm-10"><select class="form-control" onchange="{changeSize}" name="{state.codename}_setting[design][size]"><option each="{value, size in state.design.sizes}" riot-value="{size}" selected="{state.design.size==size}"> {state.text.sizes[size]} </option></select></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_style}</label></div><div class="col-sm-10"><select class="form-control" onchange="{this.changeStyles}" name="{state.codename}_setting[design][style]"><option each="{value, sty in state.design.styles}" riot-value="{sty}" selected="{state.design.style==sty}"> {state.text.styles[sty]} </option></select></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_rounded}</label></div><div class="col-sm-10"><span class="sh_button_enable"><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[design][rounded]" class="switcher" data-label-text="{state.text_enabled}" checked="{state.design.rounded ? \'checked\':\'\'}" id="rounded" value="1" onchange="{changeRounded}"></span></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();

        this.changeStyles = (e) => {
            self.state.design.style = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        this.changeRounded = (e) => {
            self.state.design.rounded = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        this.changeSize = (e) =>{
            self.state.design.size = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        self.on('mount', function () {
            $('#rounded').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.design.rounded = state;
                self.store.updateState(['design'], self.state.design);
            });
        })

        self.on('update', function () {
            self.state = self.store.getState();
        });
});
riot.tag2('sh_help_me', '<div id="help_section"><div class="row"><div class="col-lg-offset-3 col-lg-6 col-sm-12 col-md-12"><div class="panel panel-default help_protection_panel"><div class="panel-heading"><i class="fa fa-life-ring" aria-hidden="true"></i> {state.text_help_me}</div><div class="panel-body"><p class="help_description">{state.text_help_me_description}</p><div class="text-center help_button m-b"><a href="https://dreamvention.zendesk.com/hc/en-us/requests/new" target="_blank" class="btn btn-danger"><i class="fa fa-life-ring" aria-hidden="true"></i> {state.button_create_ticket}</a></div><p class="help_help_text">{state.help_help_me}</p></div></div></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
});
riot.tag2('sh_settings', '<h3>{state.text_settings}</h3><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_custom_url}</label></div><div class="col-sm-10"><input class="form-control" onchange="{this.changeCustom}" name="{state.codename}_setting[custom_url]" riot-value="{state.custom_url}"></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_style_share}</label></div><div class="col-sm-10"><select class="form-control" onchange="{this.changeShareIn}" name="{state.codename}_setting[config][shareIn]"><option each="{value, key in state.config.shareIns}" riot-value="{value}" selected="{state.config.shareIn==value}"> {state.text.shareIns[value]}-{value} </option></select></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_show_label}</label></div><div class="col-sm-10"><span class="sh_button_enable"><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[config][showLabel]" class="switcher" data-label-text="{state.text_enabled}" checked="{state.config.showLabel ? \'checked\':\'\'}" id="showLabel" value="1" onchange="{changeShowLabel}"></span></div></div></div><div class="form-group"><div class="row"><div class="col-sm-2"><label>{state.text_show_count}</label></div><div class="col-sm-10"><span class="sh_button_enable"><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[config][showCount]" class="switcher" data-label-text="{state.text_enabled}" checked="{state.config.showLabel ? \'checked\':\'\'}" id="showCount" value="1" onchange="{changShowCount}"></span></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        this.changeCustom = (e) =>{
            self.state.custom_url= e.target.value;
            self.store.updateState(['custom_url'], self.state.custom_url);
        }
        this.changeShareIn = (e) =>{
            self.state.config.shareIn = e.target.value;
            self.store.updateState(['config'], self.state.config);
        }
        self.on('update', function () {
            self.state = self.store.getState();
        });
        self.on('mount', function () {
            $('#showCount').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.config.showCount = state;
                self.store.updateState(['config'], self.state.config);
            })
            $('#showLabel').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.config.showLabel = state;
                self.store.updateState(['config'], self.state.config);
            });
        })

});
riot.tag2('sh_show_room', '<div class="show-buttons-wrap"><div class="show-wrap"><div class="show-back-foot"></div></div><div class="button_load"><div id="{state.codename}"></div></div></div><link rel="stylesheet" href="{state.styles_link[state.design.style]}" type="text/css" if="{state.design.style != \'custom\'}">', '', '', function(opts) {
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
            var style = '<style title="d_social_share">';
            style += addClass('.jssocials-share-link',
                {
                    'border-radius': self.state.design.rounded?'50% !important':'0',
                    'padding':self.state.design.sizes[self.state.design.size].padding+" !important",
                    'font-size':self.state.design.sizes[self.state.design.size]['font-size'],
                })
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
                        className = '.jssocials-share-'+button.id+' .jssocials-share-link:active';
                        color_active = {
                            'color':button.style.color,
                            'background-color':button.style.background_color_active+'!important',
                            'border-color':button.style.background_color_active+'!important'
                        }
                        style += addClass(className,color_active)
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

            setTimeout(SetStyles,200);
            getButtons();

        })
        self.on('updated', function () {
            setTimeout(SetStyles,50);
            getButtons();
        });
        self.on('update', function () {
            self.state = self.store.getState();
        });
});
riot.tag2('sh_button_info', '<div class="sh_button_wrap"><div class="sh_title page-header"><h3>{this.i}</h3></div><div class="form-group"><span class="sh_button_enable"><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[buttons][enable]" class="switcher" id="{this.i}" data-size="mini" data-label-text="{state.text_enabled}" checked="{button.enabled ? \'checked\':\'\'}" value="1"></span></div><div if="{button.enabled}"><div class="form-group" if="{isLabeled}"><label for="">{state.text_button_label}</label><input type="text" class="form-control" riot-value="{button.share.label}" onchange="{labelChange}"></div><div class="form-group"><input type="text" hidden riot-value="{button.share.logo}"><label for="">{state.text_button_icon}</label><shb_logo logo="{button.share.logo}"></shb_logo></div><div class="form-group" if="{state.design.style==\'flat\'}"><label for="">{state.text_colors}</label><shb_style styles="{button.style}" button="{i}"></shb_style></div><div class="form-group" if="{!(typeof (button.style.native) === \'undefined\')}"><span class="sh_button_native" if="{!(typeof (button.style.native) === \'undefined\')}"><label for="">{state.text_native}</label><input type="hidden" name="" value="0"><input type="checkbox" name="{state.codename}_setting[buttons][{this.i}][style][native]" class="switcher" data-size="mini" checked="{button.style.native ? \'checked\':\'\'}" id="{this.i}_native" value="1"></span></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();

        this.isLabeled = !self.state.design.rounded && self.state.config.showLabel;
        this.isCustomStyle = self.state.design.style == 'flat' ;
        labelChange = function (e) {
            self.state.buttons[e.item.i].share.label = e.target.value;
            self.store.updateState(['buttons'], self.state.buttons);
        };
        self.on('mount', function () {
            $('#' + this.i).on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[e.currentTarget.id].enabled = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });

            $('#' + this.i + '_native').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[self.i].style.native = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
            this.isLabeled = !self.state.design.rounded && self.state.config.showLabel;
            this.isCustomStyle = self.state.design.style == 'flat' ;

        })
        self.on('update', function (e) {
            self.state = self.store.getState();
        })
        self.on('updated', function (e) {
            $('#' + this.i + '_native').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[self.i].style.native = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
            this.isLabeled = !self.state.design.rounded && self.state.config.showLabel;
            this.isCustomStyle = self.state.design.style == 'flat' ;

            self.state = self.store.getState();
        });
        native = function () {
            $('#' + this.i + '_native').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[self.i].style.native = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
        }
});




riot.tag2('shb_style', '<div class="shb_style"><div class="text_color_picker"><div class="input-group color-picker {opts.button}_color" id=""><label>{state.text_color_text}</label><input type="text" name="{state.codename}_setting[buttons][i][color]" class="form-control" riot-value="{opts.styles.color}" data-back="color"><span class="input-group-addon"><i></i></span></div></div><div class="text_color_picker"><div class="input-group color-picker {opts.button}_color"><label>{state.text_color_background_text}</label><input type="text" name="{state.codename}_setting[buttons][i][background_color]" class="form-control" riot-value="{opts.styles.background_color}" data-back="background_color"><span class="input-group-addon"><i></i></span></div></div><div class="text_color_picker"><div class="input-group color-picker {opts.button}_color"><label>{state.text_color_background_active_text}</label><input type="text" name="{state.codename}_setting[buttons][i][background_color_active]" class="form-control" riot-value="{opts.styles.background_color_active}" data-back="background_color_active"><span class="input-group-addon"><i></i></span></div></div><div class="text_color_picker"><div class="input-group color-picker {opts.button}_color"><label>{state.text_color_background_hover_text}</label><input type="text" name="{state.codename}_setting[buttons][{opts.button}][style][background_color_hover]" class="form-control colss" riot-value="{opts.styles.background_color_hover}" data-back="background_color_hover"><span class="input-group-addon"><i></i></span></div></div></div>', '', '', function(opts) {
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();
        self.on('mount', function () {
            $(function () {
                $( '.'+opts.button+'_color').colorpicker().on('changeColor', function (e) {
                    var place = $(e.target).find('input')[0].dataset.back;
                    self.state.buttons[opts.button].style[place] = e.color.toString('rgba');
                    self.store.updateState(['buttons'], self.state.buttons);
                });
            });
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

});
riot.tag2('shb_logo', '<div class="shb_logo" onclick="{changeIcon}"><i class="{opts.logo}"></i></div>', '', '', function(opts) {
        changeIcon = function (e){

        }
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('mount', function () {
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

});