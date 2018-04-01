<sh_button_info>
    <div class="sh_button_wrap">
        <div class="sh_title page-header">
            <h3>{this.i}</h3>
        </div>
        <div class="form-group">
            <span class="sh_button_enable">
                    <input type="hidden" name="" value="0"/>
                    <input type="checkbox" name="{state.codename}_setting[buttons][enable]" class="switcher"
                           id="{this.i}"
                           data-size="mini"
                           data-label-text="{ state.text_enabled }"
                           checked="{button.enabled ? 'checked':''}"
                           value="1"/>
                </span>
        </div>
        <div if="{button.enabled}">
            <div class="form-group" if="{state.config.showLabel}">
                <label for="">{state.text_button_label}</label>
                <input type="text" class="form-control" value="{button.share.label}" onchange="{labelChange}">
            </div>
            <div class="form-group">
                <shb_logo logo="{button.share.logo}" id="{this.i}"></shb_logo>
            </div>
            <div class="form-group" if="{state.design.style=='flat'}">
                <label for="">{state.text_colors}</label>
                <shb_style styles="{button.style}" button="{i}"></shb_style>
            </div>
            <div class="form-group" if="{!(typeof (button.style.native) === 'undefined')}">
            <span class="sh_button_native" if="{!(typeof (button.style.native) === 'undefined')}">
                <label for="">{state.text_native}</label>
                    <input type="hidden" name="" value="0"/>
                    <input type="checkbox" name="{state.codename}_setting[buttons][{this.i}][style][native]"
                           class="switcher"
                           data-size="mini"
                           checked="{button.style.native ? 'checked':''}"
                           id="{this.i}_native"
                           value="1"/>
                </span>
            </div>
        </div>
    </div>
    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        //enable button
        this.isLabeled = !self.state.design.rounded && self.state.config.showLabel;
        this.isCustomStyle = self.state.design.style == 'flat' ;//|| self.state.design.style =='flat' feature
        labelChange = function (e) {
            self.state.buttons[e.item.i].share.label = e.target.value;
            self.store.updateState(['buttons'], self.state.buttons);
        };
        self.on('mount', function () {
            $('#' + this.i).on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[e.currentTarget.id].enabled = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
            // are not works native();
            $('#' + this.i + '_native').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[self.i].style.native = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
            this.isLabeled = !self.state.design.rounded && self.state.config.showLabel;
            this.isCustomStyle = self.state.design.style == 'flat' ;//|| self.state.design.style =='flat' feature

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
            this.isCustomStyle = self.state.design.style == 'flat' ;//|| self.state.design.style =='flat' feature

            self.state = self.store.getState();
        });
        native = function () {
            $('#' + this.i + '_native').on('switchChange.bootstrapSwitch', function (e, state) {
                self.state.buttons[self.i].style.native = state;
                self.store.updateState(['buttons'], self.state.buttons);
            });
        }
    </script>

</sh_button_info>



