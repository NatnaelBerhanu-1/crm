import { defaults } from "chart.js";

var helperMixin = {
    methods: {
        parseDate: function (rawdate) {
            console.log(rawdate);
            var date = new Date(rawdate);
            console.log();
            return date.toLocaleString();
        }
    }
}

export default helperMixin;
