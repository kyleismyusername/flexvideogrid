import Vue from 'vue'
import App from './App.vue'
import VuePaginate from 'vue-paginate'
import VueAspectRatio from "vue-aspect-ratio"

Vue.use(VuePaginate)
Vue.component("vue-aspect-ratio", VueAspectRatio)


Vue.config.productionTip = false

new Vue({
    render: h => h(App)
}).$mount('#vue-video-index')