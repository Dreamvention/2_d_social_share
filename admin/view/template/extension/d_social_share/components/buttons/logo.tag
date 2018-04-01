<shb_logo>
    <input type="text" class="form-control" name="icon" id='icon-{opts.id}' value="{opts.logo}">
    <style>
        .icons-selector{
            /*background-color: red;*/
        }
        .fip-grey.icons-selector .selector-popup{
            min-width: 320px;
            position: absolute;
            left:50%;
            -webkit-transform: translate(-50%);
            -moz-transform: translate(-50%);
            -ms-transform: translate(-50%);
            -o-transform: translate(-50%);
            transform: translate(-50%);
        }
    </style>
    <script>
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