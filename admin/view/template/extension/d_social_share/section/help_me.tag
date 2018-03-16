<sh_help_me>
    <h3 >{state.text_help_me}</h3>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>
</sh_help_me>