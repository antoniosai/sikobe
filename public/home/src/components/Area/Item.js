/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';

class Item extends Component {

  static propTypes = {
    data: PropTypes.object.isRequired,
    openDetail: PropTypes.func.isRequired
  };

  render() {
    const data = this.props.data;

    let imageTitle = null;
    let imageUrl   = this.props.baseUrl + '/assets/img/default-area-image.jpg';
    if (data.photos.data.length > 0) {
      imageTitle = data.photos.data[0].title;
      imageUrl   = data.photos.data[0].url
    }

    return (
      <div className="col-md-4">
        <div className="mt-element-ribbon tile-container" onClick={this.handleOpenDetail.bind(this)}>
          {this.getRibbon()}
          <div className="tile-thumbnail">
            <img src={imageUrl} alt={imageTitle} />
          </div>
          <div className="tile-title">
            <h3>{data.title}</h3>
            <div className="tile-desc">
              <p>{data.address}</p>
              <p className="margin-top-0">
                <span className="font-grey-salt">{data.village.data.title} - {data.district.data.title}</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    );
  }

  handleOpenDetail() {
    this.props.openDetail(this.props.data);
  }

  getRibbon() {
    let ribbon = null;

    if (typeof this.props.data.latest_status == "undefined") {
      return ribbon;
    }

    switch (this.props.data.latest_status.data.scale) {
      case 1:
        ribbon = (
          <div className="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-success uppercase">
            <div className="ribbon-sub ribbon-bookmark"></div>
            <i className="icon-feed"></i>
          </div>
        );
        break;
      case 2:
        ribbon = (
          <div className="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-primary uppercase">
            <div className="ribbon-sub ribbon-bookmark"></div>
            <i className="icon-feed"></i>
          </div>
        );
        break;
      case 3:
        ribbon = (
          <div className="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-info uppercase">
            <div className="ribbon-sub ribbon-bookmark"></div>
            <i className="icon-feed"></i>
          </div>
        );
        break;
      case 4:
        ribbon = (
          <div className="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-warning uppercase">
            <div className="ribbon-sub ribbon-bookmark"></div>
            <i className="icon-feed"></i>
          </div>
        );
        break;
      case 5:
        ribbon = (
          <div className="ribbon ribbon-vertical-right ribbon-shadow ribbon-color-danger uppercase">
            <div className="ribbon-sub ribbon-bookmark"></div>
            <i className="icon-feed"></i>
          </div>
        );
        break;
    }

    return ribbon;
  }

}

export default Item;
