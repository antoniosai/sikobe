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
    baseUrl: PropTypes.string.isRequired, 
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
        {this.getFirstPhoto()}
        <div className="list-datetime bold uppercase font-green">{moment(data.created_at.date).format('D MMMM YYYY, HH:mm:ss')}</div>
        <div className="list-item-content">
          <h3 className="uppercase">{data.area.data.title}</h3>
          <p>{data.short_description}</p>
        </div>
      </li>
    );
  }

  handleOpenDetail() {
    this.props.openDetail(this.props.data.area.data);
  }

  getFirstPhoto() {
    let imageTitle = null;
    let imageUrl   = this.props.baseUrl + '/assets/img/default-area-image.jpg';
    if (this.props.data.photos.data.length > 0) {
      imageTitle = this.props.data.photos.data[0].title;
      imageUrl   = this.props.data.photos.data[0].url
    }

    return (
      <div className="list-thumb">
        <a href="javascript:;">
          <img src={imageUrl} alt={imageTitle} />
        </a>
      </div>
    );
  }

}

export default Item;
