import {
  LOAD_AREA_STATUSES_START, LOAD_AREA_STATUSES_SUCCESS, LOAD_AREA_STATUSES_ERROR
} from '../constants';

const areaStatuses = (state = {}, action) => {
  switch (action.type) {
    case LOAD_AREA_STATUSES_START:
    case LOAD_AREA_STATUSES_SUCCESS:
    case LOAD_AREA_STATUSES_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default areaStatuses;
