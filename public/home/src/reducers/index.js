import { combineReducers } from 'redux';
import runtime from './runtime';
import intl from './intl';
import informations from './informations';

export default combineReducers({
  runtime,
  intl,
  informations
});
