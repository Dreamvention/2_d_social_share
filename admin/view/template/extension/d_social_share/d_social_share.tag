<d_social_share>
    <p id="findMe">Do I even Exist?</p>
    <!-- Options in HTML -->
    <h3>{ opts.title }</h3>

    <script>

        // Options in JavaScript
        var title = opts.title
        this.on('mount', function(){
            var test3 = document.getElementById('findMe')
            console.log('test3', test3) // Succeeds, fires once (per mount)
        })

        this.on('update', function(){
            var test2 = document.getElementById('findMe')
            console.log('test2', test2) // Succeeds, fires on every update
        })
    </script>
</d_social_share>
