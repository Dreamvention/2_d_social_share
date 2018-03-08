<shb_style>
    <div class="shb_style">
        <div class="text_color_picker">
            <div class="input-group color-picker {opts.button}_color" id="">
                <label>{ state.text_color_text }</label>
                <input type="text"
                       name="{ state.codename }_setting[buttons][i][color]"
                       class="form-control"
                       value="{ opts.styles.color }"
                       data-back="color"
                />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="text_color_picker">
            <div class="input-group color-picker {opts.button}_color">
                <label>{ state.text_color_background_text }</label>
                <input type="text"
                       name="{ state.codename }_setting[buttons][i][background_color]"
                       class="form-control"
                       value="{ opts.styles.background_color }"
                       data-back="background_color"
                />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="text_color_picker">
            <div class="input-group color-picker {opts.button}_color">
                <label>{ state.text_color_background_active_text }</label>
                <input type="text"
                       name="{ state.codename }_setting[buttons][i][background_color_active]"
                       class="form-control"
                       value="{ opts.styles.background_color_active }"
                       data-back="background_color_active"
                />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="text_color_picker">
            <div class="input-group color-picker {opts.button}_color">
                <label>{ state.text_color_background_hover_text }</label>
                <input type="text"
                       name="{ state.codename }_setting[buttons][{opts.button}][style][background_color_hover]"
                       class="form-control colss"
                       value="{ opts.styles.background_color_hover }"
                       data-back='background_color_hover'
                />
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
    </div>
    <script>
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

    </script>

</shb_style>