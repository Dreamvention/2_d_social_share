<d_social_share>
    <div class="page-header">
        <div class="container-fluid">
            <div class="form-inline pull-right">
                <button onclick={save_setting} id="save" data-toggle="tooltip" title="{state.button_save}"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                    <i class="fa fa-pencil"></i> {state.text_edit_module}
                </h3>
            </div>

            <div class="panel-body">
                <sh_navigation></sh_navigation>
                    <div class="tab-content ">
                        <div class="tab-pane" id="nav_buttons">
                            <sh_buttons></sh_buttons>
                        </div>
                        <div class="tab-pane active" id="nav_design">
                            <sh_design></sh_design>
                        </div>
                        <div class="tab-pane" id="nav_setting">
                            <sh_setting></sh_setting>
                        </div>
                        <div class="tab-pane" id="nav_help_me">
                            <sh_help_me></sh_help_me>
                        </div>
                </div>
                <hr>

                <sh_show_room></sh_show_room>
            </div>

        </div>
    </div>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();
        self.on('mount', function () {
            loadlibs();
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
        // BREADCRUMBS HELPER
    </script>

</d_social_share>
