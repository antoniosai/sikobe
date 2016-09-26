/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { notify } from '../Util';
import { getInformations } from '../../actions/actions';
import Item from './Item';
import Detail from './Detail';

class List extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    getInformations: PropTypes.func.isRequired,
    dataLoaded: PropTypes.func
  };

  constructor() {
    super();

    this.state = this.getDefaultState();

    this.isDataLoaded = false;
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
            if ( ! this.isDataLoaded && this.props.dataLoaded) {
              this.isDataLoaded = true;
              this.props.dataLoaded();
            }

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
      data: null,
      openDetailData: null
    };
  }

  render() {
    if (this.state.data == null) {
      return null;
    }

    const items = _.map(this.state.data, (item) => {
      return <Item key={`information-item-${item.id}`} data={item}
       openDetail={this.handleOpenDetail.bind(this)} />;
    });

    return (
      <div className="mt-element-list">
        <div className="mt-list-container list-news">
          <ul>
            {items}
          </ul>
        </div>
        <div className="mt-list-container list-simple">
          <a className="list-toggle-container collapsed" href="/informations">
            <div className="list-toggle uppercase">
              Lihat semua <i className="fa fa-angle-right"></i>
            </div>
          </a>
        </div>
        {this.getDetailData()}
      </div>
    );
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

  collectData() {
    clearTimeout(this.timeout);

    this.props.getInformations({
      limit: 2
    });
  }

}

const mapStateToProps = (state) => {
  return {
    data: state.informations
  }
};

const mapDispatchToProps = {
  getInformations
};

export default connect(mapStateToProps, mapDispatchToProps)(List);
