<sh_help_me>
    <div id="help_section">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6 col-sm-12 col-md-12">
                <div class="panel panel-default help_protection_panel">
                    <div class="panel-heading"><i class="fa fa-life-ring" aria-hidden="true"></i> {state.text_help_me}</div>
                    <div class="panel-body">
                        <p class="help_description">{state.text_help_me_description}</p>
                        <div class="text-center help_button m-b"><a href="https://dreamvention.zendesk.com/hc/en-us/requests/new"
                                                                target="_blank" class="btn btn-danger"><i
                                class="fa fa-life-ring" aria-hidden="true"></i> {state.button_create_ticket}</a></div>
                        <p class="help_help_text">{state.help_help_me}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>
</sh_help_me>