export default {
    methods: {
        // __(key, replace = {}) {
        //     var translation = this.$page.props.language[key]
        //         ? this.$page.props.language[key]
        //         : key;
        //     Object.keys(replace).forEach(function (key) {
        //         translation = translation.replace(":" + key, replace[key]);
        //     });
        //     return translation;
        // },
        isNumber(evt) {
            evt = evt ? evt : window.event;
            let charCode = evt.which ? evt.which : evt.keyCode;
            if (
                (charCode > 31 &&
                    (charCode < 48 || charCode > 57) &&
                    charCode !== 46) ||
                evt.key === "-"
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
    },
};
