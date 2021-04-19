import axios from 'axios';
import * as types from './MutationTypes';

export default {


  /**
   * Atualiza o projeto selectionado
   * @param {*} commit, função derivada do contexto da store
   */
   updateCurrentUser({ commit }, user) {
    commit(types.UPDATE_USER, user);
  },
};
