<sh_design>
    <div class="row">
        <h4 class="col-sm-12">{state.text_design}</h4>
        <div class="col-sm-2">
            <label >{state.text_size}</label>
        </div>
        <div class="col-sm-10">
            <select name="sizes_id" class="form-control">
                <option each={value, size in state.design.sizes} value={size} selected={state.design.size==size}>{state.text[size]}</option>
            </select>
        </div>
    </div>
    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        console.log(self.state.design.size)
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>
</sh_design>