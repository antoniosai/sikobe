/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import List from './List';
import Detail from './Detail';

class Post extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired, 
    filter: PropTypes.object
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  componentWillReceiveProps(nextProps) {
    if (typeof nextProps.filter != "undefined") {
      this.setState({filter: nextProps.filter});
    }
  }

  getDefaultState() {
    return {
      filter: {
        district: 'all',
        village: 'all',
        area: null
      },
      isDataLoaded: false,
      openDetailData: null
    };
  }

  render() {
    return (
      <div className="portlet light about-text post-container">
        <h4><i className="fa fa-check icon-info"></i> Posko</h4>
        {this.getLoading()}
        <List baseUrl={this.props.baseUrl} isAutoLoad={true}
         filter={this.state.filter}
         dataIsLoaded={this.handleDataIsLoaded.bind(this)}
         openDetail={this.handleOpenDetail.bind(this)} />
        {this.getDetailData()}
      </div>
    );
  }

  handleDataIsLoaded() {
    this.setState({isDataLoaded: true});
  }

  handleOpenDetail(data) {
    this.setState({openDetailData: data});
  }

  handleCloseDetail() {
    this.setState({openDetailData: null});
  }

  getDetailData() {
    if (this.state.openDetailData == null) {
      return null;
    }

    return <Detail baseUrl={this.props.baseUrl}
     data={this.state.openDetailData}
      onClose={this.handleCloseDetail.bind(this)} />
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

export default Post;
