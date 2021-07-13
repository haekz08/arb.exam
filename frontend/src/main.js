import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import VueGoogleCharts from 'vue-google-charts'
Vue.use(VueGoogleCharts)
import axios from 'axios'
import VueAxios from 'vue-axios'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser, faMap, faFlag } from '@fortawesome/free-solid-svg-icons'
import { faLock } from '@fortawesome/free-solid-svg-icons'
import { faDatabase } from '@fortawesome/free-solid-svg-icons'
import { faSearch } from '@fortawesome/free-solid-svg-icons'
import { faTimes } from '@fortawesome/free-solid-svg-icons'
import { faPlus } from '@fortawesome/free-solid-svg-icons'
import { faSave } from '@fortawesome/free-solid-svg-icons'
import { faPlusCircle } from '@fortawesome/free-solid-svg-icons'
import { faEdit } from '@fortawesome/free-solid-svg-icons'
import { faChevronLeft } from '@fortawesome/free-solid-svg-icons'
import { faInfoCircle } from '@fortawesome/free-solid-svg-icons'
import { faBalanceScale } from '@fortawesome/free-solid-svg-icons'
import { faUsers } from '@fortawesome/free-solid-svg-icons'
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons'
import { faMinus } from '@fortawesome/free-solid-svg-icons'
import { faList } from '@fortawesome/free-solid-svg-icons'
import { faMinusCircle } from '@fortawesome/free-solid-svg-icons'
import { faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { faCubes } from '@fortawesome/free-solid-svg-icons'
import { faCartPlus } from '@fortawesome/free-solid-svg-icons'
import { faCog } from '@fortawesome/free-solid-svg-icons'
import { faCube } from '@fortawesome/free-solid-svg-icons'
import { faTag } from '@fortawesome/free-solid-svg-icons'
import { faSitemap } from '@fortawesome/free-solid-svg-icons'
import { faSort } from '@fortawesome/free-solid-svg-icons'
import { faCalendar } from '@fortawesome/free-solid-svg-icons'
import { faBarcode } from '@fortawesome/free-solid-svg-icons'
import { faPencilAlt } from '@fortawesome/free-solid-svg-icons'
import { faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import { faListOl } from '@fortawesome/free-solid-svg-icons'
import { faMapMarker } from '@fortawesome/free-solid-svg-icons'
import { faChartPie } from '@fortawesome/free-solid-svg-icons'
import { faRoad } from '@fortawesome/free-solid-svg-icons'
import { faTruck } from '@fortawesome/free-solid-svg-icons'
import { faPaperclip } from '@fortawesome/free-solid-svg-icons'
import { faTasks } from '@fortawesome/free-solid-svg-icons'
import { faChartLine } from '@fortawesome/free-solid-svg-icons'
import { faCheck } from '@fortawesome/free-solid-svg-icons'
import { faCheckSquare } from '@fortawesome/free-solid-svg-icons'
import { faInfo } from '@fortawesome/free-solid-svg-icons'
import { faCogs } from '@fortawesome/free-solid-svg-icons'
import { faWrench } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {server_details} from './config.js';

Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.prototype.$log = console.log.bind(console)
Vue.use(VueSweetalert2);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin)

library.add(faUser)
library.add(faLock)
library.add(faDatabase)
library.add(faSearch)
library.add(faTimes)
library.add(faPlus)
library.add(faSave)
library.add(faPlusCircle)
library.add(faEdit)
library.add(faChevronLeft)
library.add(faInfoCircle)
library.add(faBalanceScale)
library.add(faUsers)
library.add(faCheckCircle)
library.add(faMinus)
library.add(faList)
library.add(faMinusCircle)
library.add(faTimesCircle)
library.add(faCubes)
library.add(faCartPlus)
library.add(faCog)
library.add(faCube)
library.add(faTag)
library.add(faSitemap)
library.add(faSort)
library.add(faCalendar)
library.add(faBarcode)
library.add(faPencilAlt)
library.add(faThumbsUp)
library.add(faListOl)
library.add(faMapMarker)
library.add(faChartPie)
library.add(faRoad)
library.add(faTruck)
library.add(faPaperclip)
library.add(faTasks)
library.add(faChartLine)
library.add(faFlag)
library.add(faCheck)
library.add(faCheckSquare)
library.add(faInfo)
library.add(faCogs)
library.add(faWrench)
Vue.component('font-awesome-icon', FontAwesomeIcon)
axios.defaults.headers.common['Authorization']= 'Bearer '+store.state.token;
axios.defaults.baseURL = server_details.SERVER_URL;

router.beforeEach((to, from, next) => {
    //console.log(to.path);
    if (store.getters.loggedIn && to.path=='/login') {
        next({
            path: '/'
        })
    } else {
        next()
    }
    // if (!store.getters.loggedIn && to.path=='/') {
    //     next({
    //         path: '/booking'
    //     })
    // } else {
    //     next()
    // }
    //next()
})


Number.prototype.toStringN2 = function() {

    let parts = this.toFixed(2).split(".");
    if(Number(parts[0]) === 0)
        return 0;
    if(parts.length === 1){
        return Number(parts[0]).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
    else{
        parts[0] = parts[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        // console.log(parts[0],parts.join("."))
        return parts.join(".");
    }
}
Number.prototype.toStringN = function() {
    return this.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

Number.prototype.toParenthesisN = function() {
    return this < 0 ? "("+Math.abs(this).toStringN()+")" : this.toStringN();
}
Number.prototype.toParenthesisN2 = function() {
    return this < 0 ? "("+Math.abs(this).toStringN2()+")" : this.toStringN2();
}

export const bus=new Vue();
new Vue({
  el: '#app',
  router,
  store,
  icons,
  template: '<App/>',
  components: {
    App
  },
  computed:{
      loggedIn(){
          return this.$store.getters.loggedIn
      }
  },
  created(){
      if(this.loggedIn){
          // setTimeout(() => {
          //     let resolved = router.resolve(router.history.current.path);
          //     if( resolved.resolved.matched.length > 0){
          //         router.push(router.history.current.path)
          //     }else{
          //         router.push('/404')
          //     }
          // },1000);
      }else{
          router.push('/login')
      }
  },
})
