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
        <div class="panel panel-default security_panel panel_top_radius">
            <div class="panel-heading">
                <h3 class="panel-title" >
                    <i class="fa fa-pencil"></i> {state.text_edit_module}
                </h3>
            </div>

            <div class="panel-body">
                <sh_navigation></sh_navigation>
                <hr>
                <sh_buttons if={state.navigation.buttons.active}></sh_buttons>
                <sh_design if={state.navigation.design.active}></sh_design>
                <sh_setting if={state.navigation.setting.active}></sh_setting>
                <sh_help_me if={state.navigation.help_me.active}></sh_help_me>

            </div>

        </div>
    </div>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });

        // BREADCRUMBS HELPER
    </script>

</d_social_share>
