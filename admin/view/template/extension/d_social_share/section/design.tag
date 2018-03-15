<sh_design>
        <h3 >{state.text_design}</h3>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label>{state.text_size}</label>
                </div>
                <div class="col-sm-10">
                    <select  class="form-control" onchange="{changeSize}" name="{state.codename}_setting[design][size]">
                        <option each={value, size in state.design.sizes} value={size}
                                selected={state.design.size==size}>
                            {state.text.sizes[size]}
                        </option>
                    </select>
                </div>
            </div></div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_style}</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control" onchange="{this.changeStyles}" name="{state.codename}_setting[design][style]">
                    <option each={value, sty in state.design.styles} value={sty}
                            selected={state.design.style==sty}>
                        {state.text.styles[sty]}
                    </option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
            <div class="row">
            <div class="col-sm-2">
                <label>{state.text_rounded}</label>
            </div>
            <div class="col-sm-10">
            <span class="sh_button_enable">
                    <input type="hidden" name="" value="0"/>
                    <input type="checkbox" name="{state.codename}_setting[design][rounded]" class="switcher"
                           data-label-text="{ state.text_enabled }"
                           checked="{state.design.rounded ? 'checked':''}"
                           id="rounded"
                           value="1" onchange="{changeRounded}"/>
                </span>

            </div>
            </div>

    </div>

    <script>
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
    </script>
</sh_design>