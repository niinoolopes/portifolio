import Vue from "vue";
import Vuex from "vuex";

import actions from './actions'
import mutations from './mutations'
import moduleAuth from './module/auth'
import moduleTask from './module/task'

Vue.use(Vuex);

export default new Vuex.Store({
  actions,
  mutations,
  modules: {
    auth: moduleAuth,
    task: moduleTask
  },
});
