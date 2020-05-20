require('./bootstrap');

window.Vue = require('vue');

Vue.component('fortel-component', require('./components/FortelComponent.vue').default);
Vue.component('league-component', require('./components/LeagueComponent.vue').default);
Vue.component('match-component', require('./components/MatchComponent.vue').default);
Vue.component('prediction-component', require('./components/PredictionComponent.vue').default);

const app = new Vue({
    el: '#app',
});