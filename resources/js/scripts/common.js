import { lowerCase } from 'lodash';

export default {
    name: 'Common',

    methods: {
        stripTags(string) {
            return string.replace(/(<([^>]+)>)/gi, '');
        },
        properCase(string) {
            let toLower = lowerCase(string.replace(/[A-Z]/g, ' $&'));
            return (toLower + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                return $1.toUpperCase();
            });
        },
    },
};
