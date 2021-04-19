import Vue from 'vue';
import Vuex from 'vuex';

import mutations from './Mutations';
import actions from './Actions';
import getters from './Getters';

Vue.use(Vuex);

// Declaração da Store do sistema
// Nesta store deve ser colocada todas as informações que são compartilhadas entre
// todos os componentes
const store = new Vuex.Store({
  currentUser: null,
  mutations,
  actions,
  getters,
});

export default store;
