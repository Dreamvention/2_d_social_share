<sh_show_room>
    <div class="show-buttons-wrap">
        <div class="show-wrap">
            <div class="show-back-foot">
            </div>
        </div>
        <div class="button_load">
            124
        </div>
    </div>
    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();
        self.on('mount', function () {
        })
        self.on('updated', function () {
        });
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>
</sh_show_room>