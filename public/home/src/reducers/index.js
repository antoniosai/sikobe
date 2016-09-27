import { combineReducers } from 'redux';
import runtime from './runtime';
import intl from './intl';
import informations from './informations';
import areas from './areas';
import areaStatuses from './areaStatuses';

export default combineReducers({
  runtime,
  intl,
  informations,
  areas,
  areaStatuses
});
