// import _ from 'lodash';
import * as types from './MutationTypes';

// Declaração de todos os mutations
export default {
  // Mutation responsável por atualização do usuário logado
  [types.UPDATE_USER](state, payload) {
    state.currentUser = payload;
  },

};
