import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

const opts = {
    icons: {
        iconfont: 'mdi',
      },
    theme: {
        themes: {
            light: {
                primary: '#ACCCBD',
                secondary: '#9F9377',
                tertiary: '#10CF9B',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
                gray: '#EFEFEF'
            },
        },
    },
};

export default new Vuetify(opts);