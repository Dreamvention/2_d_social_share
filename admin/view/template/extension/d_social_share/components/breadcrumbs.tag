<sm_breadcrumbs>
    <ul class="breadcrumb">
        <li each={el in state.breadcrumbs}>
            <a href="{el.href}">{el.text}</a>
        </li>
    </ul>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('mount', function () {
            console.log(self.state )
        })
        self.on('update', function () {
            self.state = self.store.getState();
        });

    </script>

</sm_breadcrumbs>