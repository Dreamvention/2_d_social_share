<sh_buttons>
    <h3>{state.text_buttons}</h3>
    <div class="buttons-wrap" id="sortable">
        <sh_button_info each="{button,i in state.buttons}" class="portlet"
                        id="btn-{i}"></sh_button_info>
    </div>
    </div>
    <style>
        .portlet-placeholder {
            border: 1px dotted black;
            margin: 0 1em 1em 0;
            height: 120px;
        }
        .sh_title:hover {
            cursor: move;
            color: #106e41;
        }
    </style>

    <script>
        $(function () {
            $("#sortable").sortable({
                connectWith: "#sortable",
                handle: ".sh_title",
                placeholder: "portlet-placeholder ui-corner-all",
                update: function () { save_new_order() }
            });

            function save_new_order() {
                var a = [];
                var btn_order={};
                $('#sortable').children().each(function (i) {
                    var btn_id = $(this).attr('id').replace('btn-', '');
                    self.state.buttons[btn_id].sort_order = i;
                });
                self.store.updateState(['buttons'], self.state.buttons);

            }
        })

        $(".portlet")
            .addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
            .find(".sh_title")
            .addClass("ui-widget-header ui-corner-all")

        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>

</sh_buttons>