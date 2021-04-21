import * as types from './GettersTypes';

export default {
  [types.GET_CURRENT_USER](state) {
    return state.currentUser;
  },
  [types.GET_CURRENT_PROJETO](state) {
    return state.selectedProjeto;
  },
};

