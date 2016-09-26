/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { notify } from '../Util';
import { getAreas } from '../../actions/actions';

class Area extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired, 
    getAreas: PropTypes.func.isRequired
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
      <div className="portlet light">
        <div className="portlet-title">
          <div className="caption form">
            <div className="form-group form-md-line-input form-md-floating-label padding-top-0 margin-bottom-0">
              <div className="input-group">
                <div className="input-group-control">
                  <select id="filter-district" className="form-control">
                    <option value="all">Semua Kecamatan</option>
                  </select>
                </div>
                <div className="input-group-control">
                  <select id="filter-village" className="form-control">
                    <option value="all">Semua Kelurahan</option>
                  </select>
                </div>
                <div className="input-group-control">
                  <input type="text" className="form-control" placeholder="Pencarian" />
                </div>
                <span className="input-group-btn btn-right">
                  <button type="button" className="btn red-sunglo" type="button">Filter</button>
                </span>
              </div>
            </div>
          </div>
        </div>
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

    // this.props.getAreas();
  }

}

const mapStateToProps = (state) => {
  return {
    data: state.informations
  }
};

const mapDispatchToProps = {
  getAreas
};

export default connect(mapStateToProps, mapDispatchToProps)(Area);
