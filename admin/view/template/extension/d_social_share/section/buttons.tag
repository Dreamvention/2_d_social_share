<sh_buttons>
    <div class="row">
        <ul>
            <li each={el, i in state.buttons}>
                <input type="text" value="{el.id}" onchange="{change}">
            </li>
        </ul>
        <ul>
            <li each={el, i in state.buttons}>
                {el.id}
            </li>
        </ul>
    </div>

    <script>
        this.mixin({store: d_social_share});
        var self = this;
        self.state = self.store.getState();
        change(data,datae){
            console.log(datae)
            this.update()
        }
        self.on('update', function () {
            self.state = self.store.getState();
        });
    </script>

</sh_buttons>