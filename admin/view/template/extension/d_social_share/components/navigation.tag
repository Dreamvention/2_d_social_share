<sh_navigation>
    <ul class="nav nav-tabs">
        <li each={el, i in state.navigation} class="{state.navigation[i].active?'active':''}">

            <a href="#nav_{i}"  data-toggle="tab" class="htab-item {el.disabled ? 'disable_link ignore' : ''}">
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