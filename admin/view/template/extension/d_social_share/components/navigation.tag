<sh_navigation>
    <ul class="nav nav-tabs">
        <li each={el, i in state.navigation} >
            <a href="#nav_{i}"  data-toggle="tab" class="htab-item {el.disabled ? 'disable_link ignore' : ''}">
                <i class="{el.icon}"></i> {el.text}
            </a>
        </li>
    </ul>
    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = this.store.getState();

        self.on('update', function () {
            self.state = self.store.getState();
        });

    </script>

</sh_navigation>