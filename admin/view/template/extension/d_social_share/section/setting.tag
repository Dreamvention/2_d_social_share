<sh_settings>
    <h3 >{state.text_settings}</h3>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_custom_url}</label>
            </div>
            <div class="col-sm-10">
                <input class="form-control" onchange="{this.changeCustom}"
                       name="{state.codename}_setting[custom_url]" value="{state.custom_url}"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_style_share}</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control" onchange="{this.changeShareIn}"
                        name="{state.codename}_setting[config][shareIn]">
                    <option each={value, key in state.config.shareIns} value={value}
                            selected={state.config.shareIn==value}>
                        {state.text.shareIns[value]}-{value}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_show_label}</label>
            </div>
            <div class="col-sm-10">
            <span class="sh_button_enable">
                    <input type="hidden" name="" value="0"/>
                    <input type="checkbox" name="{state.codename}_setting[config][showLabel]" class="switcher"
                           data-label-text="{ state.text_enabled }"
                           checked="{state.config.showLabel ? 'checked':''}"
                           id="showLabel"
                           value="1" onchange="{changeShowLabel}"/>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_show_count}</label>
            </div>
            <div class="col-sm-10">
            <span class="sh_button_enable">
                    <input type="hidden" name="" value="0"/>
                    <input type="checkbox" name="{state.codename}_setting[config][showCount]" class="switcher"
                           data-label-text="{ state.text_enabled }"
                           checked="{state.config.showLabel ? 'checked':''}"
                           id="showCount"
                           value="1" onchange="{changShowCount}"/>
                </span>
            </div>
        </div>
    </div>
    <script>
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

    </script>

</sh_settings>