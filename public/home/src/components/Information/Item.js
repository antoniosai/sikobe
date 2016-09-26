/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import moment from 'moment';

class Item extends Component {

  static propTypes = {
    data: PropTypes.object.isRequired,
    openDetail: PropTypes.func.isRequired
  };

  render() {
    const data = this.props.data;

    return (
      <li className="mt-list-item" onClick={this.handleOpenDetail.bind(this)}>
        <div className="list-icon-container">
          <i className="fa fa-angle-right"></i>
        </div>
        <div className="list-datetime bold uppercase font-green">{moment(data.created_at.date).format('D MMMM YYYY, HH:mm:ss')}</div>
        <div className="list-item-content">
          <h3 className="uppercase">{data.title}</h3>
          <p>{data.short_description}</p>
        </div>
      </li>
    );
  }

  handleOpenDetail() {
    this.props.openDetail(this.props.data);
  }

}

export default Item;
