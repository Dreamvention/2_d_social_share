<d_social_share>
    <div class="page-header">
        <div class="container-fluid">
            <div class="form-inline pull-right">
                <button onclick={save_setting} data-go="0" id="save_and_stay" data-toggle="tooltip"
                        title="{state.button_save_and_stay}" class="btn btn-success"><i class="fa fa-save"></i></button>
                <!--<button onclick={save_setting} data-go="1" id="save" data-toggle="tooltip" title="{state.button_save}"-->
                        <!--class="btn btn-primary"><i class="fa fa-save"></i></button>-->
                <a href="{state.cancel}" data-toggle="tooltip" title="{state.button_cancel}" class="btn btn-default"
                   id="cancel-button"><i class="fa fa-reply"></i></a>
            </div>
            <h1>{state.heading_title } {state.version }</h1>
            <sh_breadcrumbs></sh_breadcrumbs>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default panel_top_radius">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-pencil"></i> {state.text_edit}
                </h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>{state.text_name}</label>
                        </div>
                        <div class="col-sm-10">
                            <input class="form-control" onchange="{this.changeName}"
                                   name="{state.codename}_setting[name]" value="{state.name}"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>{state.text_status}</label>
                        </div>
                        <div class="col-sm-10">
                            <span class="sh_button_enable">
                                <input type="hidden" name="" value="0"/>
                                <input type="checkbox" name="{state.codename}_setting[status]" class="switcher"
                                       data-label-text="{ state.text_enabled }"
                                       checked="{state.status ? 'checked':''}"
                                       id="status"
                                       value="1"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body" >
                <sh_navigation></sh_navigation>
                <form id="setting_form" action="">
                    <div class="tab-content">
                        <div class="tab-pane active" id="nav_buttons">
                            <sh_buttons></sh_buttons>
                        </div>
                        <div class="tab-pane" id="nav_design">
                            <sh_design></sh_design>
                        </div>
                        <div class="tab-pane" id="nav_setting">
                            <sh_settings></sh_settings>
                        </div>
                        <div class="tab-pane" id="nav_help_me">
                            <sh_help_me></sh_help_me>
                        </div>
                    </div>
                </form>
                <hr>
                <sh_show_room></sh_show_room>
            </div>

        </div>
    </div>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        changeName(e)
        {
            self.state.name = e.target.value;
            self.store.updateState(['name'], self.state.name);
        }
        save_setting(e)
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
        }
        self.state = this.store.getState();
        self.on('mount', function () {
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
            var picker = $('[name=icon]').fontIconPicker({
                source: $.iconset['fontawesome'],
                emptyIcon: false,
                hasSearch: true,
                iconsPerPage: 1000
            }).on('change', function (e,i) {
                self.state.buttons[e.target.id.replace('icon-','')].share.logo=$(this).val()
                self.store.updateState(['buttons'], self.state.buttons);
            });
        }
    </script>

</d_social_share>
