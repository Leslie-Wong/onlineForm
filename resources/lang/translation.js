export default {
    methods: {
        /**
         * Translate the given key.
         */
        __(key, replace = {}) {
            let language = [];
            if(this.$page.language){
                language = this.$page.language;
            }else if(this.$page.props.language){
                language = this.$page.props.language;
            }
            var translation = language[key]
                ? language[key]
                : key

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            return translation
        },
        _url(url){
            if(url.indexOf("http") == -1)
                return Ziggy.url + url;

            return url;
        }
    },
}
