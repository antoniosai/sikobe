/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { notify } from '../Util';
import { getAreaPosts } from '../../actions/actions';
import Item from '../Post/Item';

class Posts extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    areaId: PropTypes.number.isRequired,
    getAreaPosts: PropTypes.func.isRequired, 
    dataIsLoaded: PropTypes.func,
    openDetail: PropTypes.func.isRequired
  };

  constructor() {
    super();

    this.state = this.getDefaultState();

    this.isDataLoaded = false;
  }

  componentDidMount() {
    if (this.state.items == null) {
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
            if ( ! this.isDataLoaded && this.props.dataIsLoaded) {
              this.isDataLoaded = true;
              this.props.dataIsLoaded();
            }

            this.setState({items: nextProps.data.data});
          }
        }
      }
    }
  }

  getDefaultState() {
    return {
      items: null
    };
  }

  render() {
    if (this.state.items == null) {
      return null;
    }

    let items = (<li>Belum ada posko di area ini.</li>);

    if (this.state.items.length > 0) {
      items = this.state.items.map((item) => {
        return <Item key={`post-item-${item.id}`}
         baseUrl={this.props.baseUrl} data={item}
         openDetail={this.props.openDetail} />;
      });
    }

    return (
      <div className="search-content-1">
        <div className="row">
          <div className="col-xs-12">
            <div className="search-container">
              <ul>{items}</ul>
            </div>
          </div>
        </div>
      </div>
    );
  }

  collectData() {
    this.props.getAreaPosts({
      area: this.props.areaId,
      limit: 0, 
      include: 'district,village,photos'
    });
  }

}

const mapStateToProps = (state) => {
  return {
    data: state.areaPosts
  }
};

const mapDispatchToProps = {
  getAreaPosts
};

export default connect(mapStateToProps, mapDispatchToProps)(Posts);
