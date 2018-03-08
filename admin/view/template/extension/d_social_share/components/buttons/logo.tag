<shb_logo>
    <div class="shb_logo" onclick="{changeIcon}"><i class="{opts.logo}"></i></div>
    <script>
        changeIcon = function (e){

        }
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('mount', function () {
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

    </script>

</shb_logo>