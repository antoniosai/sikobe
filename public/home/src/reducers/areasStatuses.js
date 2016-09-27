import {
  LOAD_AREAS_STATUSES_START, LOAD_AREAS_STATUSES_SUCCESS, LOAD_AREAS_STATUSES_ERROR
} from '../constants';

const areasStatuses = (state = {}, action) => {
  switch (action.type) {
    case LOAD_AREAS_STATUSES_START:
    case LOAD_AREAS_STATUSES_SUCCESS:
    case LOAD_AREAS_STATUSES_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default areasStatuses;
