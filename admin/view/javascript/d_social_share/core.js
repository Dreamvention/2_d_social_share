
//////////////////////////////
// Social share module core //
//////////////////////////////
var sm_core = (function() {

    riot.observable(this);

    this.createStore = function(state)
    {
        this.state = Immutable.fromJS(state, function (key, value, path) {
            return Immutable.isIndexed(value) ? value.toList() : value.toOrderedMap();
        });

        this.stateCached = this.state.toJS();
        this.stateOld = this.stateCached;
        return this;
    }

    this.updateState = function(key, data)
    {
        this.state = this.state.setIn(key, data);
        this.stateCached = this.state.toJS();
        riot.update();
    }

    this.setState = function(data)
    {
        this.state = this.state.mergeDeep(data);
        this.stateCached = this.state.toJS();
        riot.update();
    }

    this.getState = function()
    {
        return this.stateCached;
    }

    this.getToken = function()
    {
        return this.stateCached.token;
    }

    this.getError = function()
    {
        if(!this.stateCached.errors){
            this.stateCached.errors = {};
        }
        return this.stateCached.errors;
    }

    this.getChange = function()
    {
        return getDiff(this.stateOld, this.stateCached);
    }

    this.setChange = function(state)
    {
        this.stateOld = state;
    }

    this.dispatch = function(action, state)
    {
        this.trigger(action, state);
    }

    this.subscribe = function(action, callback)
    {
        this.on(action, callback);
    }

    this.notification_handler = function(json)
    {
        _.each(json, function(element, index) {

            if (typeof element === 'object') {

                _.each(element, function(inner_element) {
                    alertify.notify(inner_element, index);
                });

            } else {
                alertify.notify(element, index);
            }

        });
    }

    this.try_parse_json = function(string)
    {
        try {
            var o = JSON.parse(string);

            // Handle non-exception-throwing cases:
            // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
            // but... JSON.parse(null) returns null, and typeof null === "object",
            // so we must check for that, too. Thankfully, null is falsey, so this suffices:
            if (o && typeof o === "object") {
                return o;
            }
        }
        catch (e) { }

        return false;
    }

    this.get_ignored_issues_count = function()
    {
        var ignored = 0;
        if (typeof this.stateCached.scan.scan_issues.issues == 'object') {
            _.each(this.stateCached.scan.scan_issues.issues, function(el) { if (el.ignore_status) { ignored += 1; } })
        }
        if (typeof this.stateCached.scan.scan_issues.quarantine == 'object') {
            _.each(this.stateCached.scan.scan_issues.quarantine, function(el) { if (el.ignore_status) { ignored += 1; } })
        }
        if (typeof this.stateCached.scan.scan_issues.spam == 'object') {
            _.each(this.stateCached.scan.scan_issues.spam, function(el) { if (el.ignore_status) { ignored += 1; } })
        }

        return ignored;
    }

    this.update_blink_state = function(status)
    {
        if (status == null) {
            status = (this.stateCached.setting.config.main.two_factor_auth.status == 1) ? true : false;
        }

        if (status && !this.stateCached.setting.config.main.two_factor_auth.confirmed) {
            this.stateCached.two_auth_blink = true;
        } else {
            this.stateCached.two_auth_blink = false;
        }

        this.updateState(['two_auth_blink'], this.stateCached.two_auth_blink);
    }

    return this;
})();

// ALIAS
var d_social_share = sm_core;
