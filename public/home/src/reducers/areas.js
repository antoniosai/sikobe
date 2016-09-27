import {
  LOAD_AREAS_START, LOAD_AREAS_SUCCESS, LOAD_AREAS_ERROR
} from '../constants';

const areas = (state = {}, action) => {
  switch (action.type) {
    case LOAD_AREAS_START:
    case LOAD_AREAS_SUCCESS:
    case LOAD_AREAS_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default areas;
