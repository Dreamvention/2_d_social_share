<sh_buttons>
        <h3>{state.text_buttons}</h3>

        <div class="buttons-wrap">
            <sh_button_info each="{button,i in state.buttons}"></sh_button_info>
        </div>


    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>

</sh_buttons>