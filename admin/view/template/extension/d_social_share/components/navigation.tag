<sh_navigation>
    <ul class="nav navigation">
        <li each={el, i in state.navigation}
                class="{el.active?'active':''}">
            <a id="nav_{i}" href="{el.href}" class="htab-item {el.disabled ? 'disable_link ignore' : ''}">
                <i class="{el.icon}"></i> {el.text}
                <!-- <div if={el.disabled} class="coming_soon_bage">{state.text_coming_soon}</div> -->
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