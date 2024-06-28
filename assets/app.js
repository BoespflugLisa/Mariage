import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Vue declaration
import Vue from 'vue';
import vuetify from './plugins/vuetify';

import VueCountdown from '@chenfengyuan/vue-countdown';
import Home from "../templates/views/home.vue"; 
import Presents from "../templates/views/presents.vue";
import DonationPromiseForm from "../templates/views/donationPromiseForm.vue";
import Pictures from "../templates/views/pictures.vue" 
import AddPicturesView from "../templates/views/addPicturesView.vue";
import TimeCard from "../templates/components/timeCard.vue";
import AppbarComponent from "../templates/components/appbarComponent.vue";
import FooterComponent from "../templates/components/footerComponent.vue"
import TitleComponent from "../templates/components/titleComponent.vue";
import EllipseWeddingDate from "../templates/components/ellipseWeddingDate.vue";
import MapLinkComponent from "../templates/components/mapLinkComponent.vue";
import PictureGalleryComponent from "../templates/components/pictureGalleryComponent.vue";
import MobileDivider from "../templates/components/mobileDivider.vue";
import HomeCarouselComponent from "../templates/components/homeCarouselComponent.vue"

Vue.component(VueCountdown.name, VueCountdown);
Vue.component('home', Home);
Vue.component('presents', Presents);
Vue.component('picturesview', Pictures);
Vue.component('timecard', TimeCard);
Vue.component('appbarcomponent', AppbarComponent);
Vue.component('footercomponent', FooterComponent);
Vue.component('titlecomponent', TitleComponent);
Vue.component('ellipseweddingdate', EllipseWeddingDate);
Vue.component('maplinkcomponent', MapLinkComponent);
Vue.component('picturegallerycomponent', PictureGalleryComponent);
Vue.component('addpictures', AddPicturesView);
Vue.component('donationpromiseform', DonationPromiseForm);
Vue.component('mobileDivider', MobileDivider);
Vue.component('homecarouselcomponent', HomeCarouselComponent);

/**
 * Create Vue app
 */
new Vue({
    vuetify,
}).$mount('#app');