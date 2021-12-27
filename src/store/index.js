import Vue from "vue";
import Vuex from "vuex";

import moduleAuth from './module/auth'
import moduleTask from './module/task'

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
     auth: moduleAuth,
     task: moduleTask
  },
});
