/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { notify } from '../Util';
import { getIncidents } from '../../actions/actions';

class Incident extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired, 
    getIncidents: PropTypes.func.isRequired
  };

  constructor() {
    super();

    this.state = this.getDefaultState();

    this.timeout = null;
    this.fetchInterval = 60000; //60000
  }

  componentDidMount() {
    if (this.state.data == null) {
      this.collectData();
    }
  }

  componentWillReceiveProps(nextProps) {
    if (typeof nextProps.data.action != "undefined") {
      if (!nextProps.data.action.started) {
        if (nextProps.data.action.error) {
          notify('error', nextProps.data.action.errorMessage, 'Error');
        } else {
          if (typeof nextProps.data.data != "undefined") {
            this.setState({data: nextProps.data.data});
          }
        }

        if (!this.isDetailOpened) {
          this.timeout = setTimeout(() => {
            this.collectData();
          }, this.fetchInterval);
        }
      }
    }
  }

  getDefaultState() {
    return {
      data: null
    };
  }

  render() {
    return (
      <div className="portlet light about-text">
        <h4><i className="fa fa-check icon-info"></i> Kejadian Terkini</h4>
        {this.getLoading()}
      </div>
    );
  }

  getLoading() {
    return (
      <div className="padding-20 text-center">
        <img src={`${this.props.baseUrl}/assets/img/loading-spinner-grey.gif`} className="loading" /> 
        <span>&nbsp;&nbsp;Mengunduh data... </span>
      </div>
    );
  }

  collectData() {
    clearTimeout(this.timeout);

    // this.props.getIncidents();
  }

}

const mapStateToProps = (state) => {
  return {
    data: state.informations
  }
};

const mapDispatchToProps = {
  getIncidents
};

export default connect(mapStateToProps, mapDispatchToProps)(Incident);
