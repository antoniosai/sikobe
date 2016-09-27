import {
  LOAD_INFORMATIONS_START, LOAD_INFORMATIONS_SUCCESS, LOAD_INFORMATIONS_ERROR,
  LOAD_AREAS_START, LOAD_AREAS_SUCCESS, LOAD_AREAS_ERROR,
  LOAD_AREAS_STATUSES_START, LOAD_AREAS_STATUSES_SUCCESS, LOAD_AREAS_STATUSES_ERROR,
  LOAD_AREA_STATUSES_START, LOAD_AREA_STATUSES_SUCCESS, LOAD_AREA_STATUSES_ERROR
} from '../constants';

function _dispatch(dispatch, types, url, props, all) {
  dispatch({
    type: types.start,
    payload: {
      data: null,
      action: {
        started: true,
        error: false,
        errorMessage: null
      }
    },
  });

  apiClient.get(url, props)
  .then(function(response) {
    dispatch({
      type: types.success,
      payload: {
        data: ((all) ? response : response.data),
        action: {
          started: false,
          error: false,
          errorMessage: null
        }
      },
    });
  }).catch(function(error) {
    dispatch({
      type: types.error,
      payload: {
        data: null,
        action: {
          started: false,
          error: true,
          errorMessage: error.message
        }
      },
    });
  });
}

export function getInformations(props) {
  return async (dispatch) => {
    const url = '/informations';

    return _dispatch(dispatch, {
      start: LOAD_INFORMATIONS_START, 
      success: LOAD_INFORMATIONS_SUCCESS, 
      error: LOAD_INFORMATIONS_ERROR
    }, url, props, false);
  };
}

export function getIncidents() {
  // return async (dispatch) => {
  //   const url = '/informations';

  //   return _dispatch(dispatch, {
  //     start: LOAD_INFORMATIONS_START, 
  //     success: LOAD_INFORMATIONS_SUCCESS, 
  //     error: LOAD_INFORMATIONS_ERROR
  //   }, url, null, false);
  // };
}

export function getPosts() {
  // return async (dispatch) => {
  //   const url = '/informations';

  //   return _dispatch(dispatch, {
  //     start: LOAD_INFORMATIONS_START, 
  //     success: LOAD_INFORMATIONS_SUCCESS, 
  //     error: LOAD_INFORMATIONS_ERROR
  //   }, url, null, false);
  // };
}

export function getAreas(props) {
  return async (dispatch) => {
    const url = '/areas';

    return _dispatch(dispatch, {
      start: LOAD_AREAS_START, 
      success: LOAD_AREAS_SUCCESS, 
      error: LOAD_AREAS_ERROR
    }, url, props, false);
  };
}

export function getAreaStatuses(areaId, props) {
  return async (dispatch) => {
    let url = '';
    if (_.isNumber(areaId)) {
      url = '/areas/' + areaId + '/statuses';
    } else {
      url = '/area-statuses';
      props = areaId;
    }

    return _dispatch(dispatch, {
      start: LOAD_AREA_STATUSES_START, 
      success: LOAD_AREA_STATUSES_SUCCESS, 
      error: LOAD_AREA_STATUSES_ERROR
    }, url, props, false);
  };
}

export function getAreasStatuses(props) {
  return async (dispatch) => {
    let url = '/area-statuses';

    return _dispatch(dispatch, {
      start: LOAD_AREAS_STATUSES_START, 
      success: LOAD_AREAS_STATUSES_SUCCESS, 
      error: LOAD_AREAS_STATUSES_ERROR
    }, url, props, false);
  };
}

export function getAreaPhotos(areaId, props) {
  const url = '/areas/' + areaId + '/photos';
  return apiClient.get(url, props);
}
