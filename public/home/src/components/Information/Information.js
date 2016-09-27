/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import List from './List';

class Information extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  getDefaultState() {
    return {
      isDataLoaded: false
    };
  }

  render() {
    return (
      <div className="portlet light about-text">
        <h4><i className="fa fa-check icon-info"></i> Informasi Terkini</h4>
        {this.getLoading()}
        <List baseUrl={this.props.baseUrl} dataLoaded={this.handleDataLoaded.bind(this)} />
      </div>
    );
  }

  handleDataLoaded() {
    this.setState({isDataLoaded: true});
  }

  getLoading() {
    return ! this.state.isDataLoaded ? (
      <div className="padding-20 text-center">
        <img src={`${this.props.baseUrl}/assets/img/loading-spinner-grey.gif`} className="loading" /> 
        <span>&nbsp;&nbsp;Mengunduh data... </span>
      </div>
    ) : null;
  }

}

export default Information;
