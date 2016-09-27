import {
  LOAD_INFORMATIONS_START, LOAD_INFORMATIONS_SUCCESS, LOAD_INFORMATIONS_ERROR
} from '../constants';

const informations = (state = {}, action) => {
  switch (action.type) {
    case LOAD_INFORMATIONS_START:
    case LOAD_INFORMATIONS_SUCCESS:
    case LOAD_INFORMATIONS_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default informations;
