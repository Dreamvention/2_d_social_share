<shb_logo>
    <div class="shb_logo" onclick="{changeIcon}"><i class=""></i></div>
    <!--<input type="text" class="form-control" name="icon" value="{opts.logo}">-->
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

        // self.state.library='ss';
        // var picker = $('[name=icon]').fontIconPicker({
        //     source:    $.iconset[self.state.library],
        //     emptyIcon: false,
        //     hasSearch: true,
        //     iconsPerPage: 1000
        // }).on('change', function(e){
        //     $('[name=icon]').val($(this).val());
        // });
    </script>

</shb_logo>