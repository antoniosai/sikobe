import {
  LOAD_POSTS_START, LOAD_POSTS_SUCCESS, LOAD_POSTS_ERROR
} from '../constants';

const posts = (state = {}, action) => {
  switch (action.type) {
    case LOAD_POSTS_START:
    case LOAD_POSTS_SUCCESS:
    case LOAD_POSTS_ERROR:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
};

export default posts;
