import {
  LOAD_AREA_POSTS_START, LOAD_AREA_POSTS_SUCCESS, LOAD_AREA_POSTS_ERROR
} from '../constants';

const areaPosts = (state = {}, action) => {
  switch (action.type) {
    case LOAD_AREA_POSTS_START:
    case LOAD_AREA_POSTS_SUCCESS:
    case LOAD_AREA_POSTS_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default areaPosts;
