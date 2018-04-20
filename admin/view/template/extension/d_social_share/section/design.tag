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
    <legend>
        {state.text_animations}
    </legend>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_animation}</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control" onchange="{this.changeAnimations}" name="{state.codename}_setting[design][animation]">
                    <option each={value, i in state.design.animations} value={value}
                            selected={state.design.animation==value}>
                        {state.text.animations[value]}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                <label>{state.text_animation_type}</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control" onchange="{this.changeAnimationType}" >
                    <option each={value, i in state.design.animations_types} value={value}
                            selected={state.design.animation_type==value}>
                        {state.text.animations_types[value]}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <legend>
        {state.text_placements}
    </legend>
    <div class="form-group">
        <virtual if={state.design.placement=='fixed'}>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label>{state.text_placement}</label>
                </div>
                <div class="col-sm-10">

                    <select class="form-control" onchange="{this.changeFixedPlacement}">
                        <option each={value, key in state.design.fixed_placement} selected={state.design.fixed==value}
                                value="{value}">
                            {state.text.fixed_placement[value]}
                        </option>
                    </select>
                </div>
            </div></div>
        </virtual>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label>{state.text_placement}</label>
                </div>

                <div class="col-sm-10">
                    <select class="form-control" onchange="{this.changePlacement}">
                        <option each={value, key in state.design.placements} selected={state.design.placement==value}
                                value="{value}">
                            {state.text.placements[value]}

                        </option>
                    </select>
                </div>
            </div></div>
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
                           data-on-text="{ state.text_enabled }"
                           data-off-text="{ state.text_enabled }"
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
        this.changeAnimationType = (e) =>{
            self.state.design.animation_type = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        this.changeAnimations = (e) =>{
            self.state.design.animation = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        this.changeFixedPlacement = (e) =>{
            self.state.design.fixed = e.target.value;
            self.store.updateState(['design'], self.state.design);
        }
        this.changePlacement = (e) =>{
            self.state.design.placement = e.target.value;
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