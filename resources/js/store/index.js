import Vue from 'vue'
import Vuex from 'vuex'
import WorkSchedule from "./modules/WorkSchedule";

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules: {
        WorkSchedule
    }
})
