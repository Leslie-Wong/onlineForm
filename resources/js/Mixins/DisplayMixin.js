export default {
    methods: {
        displayNotification(title, message, group) {
            // this.$notify({ type: type, text: message ,title:null, duration:3500 });
            this.$notify({
                group: group,
                title: title,
                text: message,
                type:""
              });
        },
    }
}
