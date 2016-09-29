/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { GoogleMapLoader, GoogleMap, InfoWindow, Marker } from "react-google-maps";

class Detail extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    data: PropTypes.object.isRequired,
    onClose: PropTypes.func
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  getDefaultState() {
    return {
      isShown: false
    };
  }

  componentDidMount() {
    const onShown = () => {
      this.renderUI();
      
      let state = {
        isShown: true
      };

      this.setState(state);
    };
    const onHidden = () => {
      jQuery('#post-modal').unbind('shown.bs.modal', onShown);
      jQuery('#post-modal').unbind('hidden.bs.modal', onHidden);

      if (this.props.onClose) {
        this.props.onClose();
      }
    };

    jQuery('#post-modal').on('shown.bs.modal', onShown);
    jQuery('#post-modal').on('hidden.bs.modal', onHidden);
    jQuery('#post-modal').modal('show');
  }

  render() {
    const data = this.props.data;
    
    return (
      <div id="post-modal" className="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard={false}>
        <div className="modal-dialog">
          <div className="modal-content scroller" data-always-visible={1} data-rail-visible={0}>
            <div className="modal-header">
              <button type="button" className="close" data-dismiss="modal" aria-hidden="true" />
              <h4 className="font-dark bold uppercase">{data.title}</h4>
            </div>
            <div className="modal-body post-modal-body">
              <div className="row">
                <div className="col-md-7">
                  {this.getMap()}
                  <div className="margin-top-10">
                    <i className="icon-direction"></i> {data.address} - {data.village.data.title} - {data.district.data.title}
                  </div>
                </div>
                <div className="col-md-5">
                  <div className="portlet light">
                    <div className="card-icon">
                      <a href={`tel:${data.phone}`}><i className="icon-call-end font-red-sunglo theme-font"></i></a>
                    </div>
                    <div className="card-title">
                      <span>{data.leader} | <a href={`tel:${data.phone}`}>{data.phone}</a></span>
                    </div>
                  </div>
                </div>
              </div>
              {this.getPhotos()}
            </div>
            <div className="modal-footer">
              <button type="button" className="btn dark btn-outline" data-dismiss="modal">
                Tutup
              </button>
            </div>
          </div>
        </div>
      </div>
    );
  }

  getMap() {
    if (this.props.data.latitude == 0 || this.props.data.longitude == 0) {
      return null;
    }

    if ( ! this.state.isShown) {
      return null;
    }

    const latLngCenter = new google.maps.LatLng(this.props.data.latitude, this.props.data.longitude);

    return (
      <GoogleMapLoader containerElement={<div style={{height: '200px'}}></div>}
        googleMapElement={
          <GoogleMap
            containerProps={{style: {
              height: '200px',
            }}} defaultZoom={13} defaultCenter={latLngCenter}>
            <Marker position={latLngCenter} />
          </GoogleMap>
        }
      /> //end of GoogleMapLoader
    );
  }

  getPhotos() {
    if (typeof this.props.data.photos == "undefined") {
      return null;
    }

    const items = this.props.data.photos.data.map((item) => {
      return (
        <div key={`post-photo-item-${item.url}`} className="cbp-item">
          <a href={item.url} className="cbp-caption cbp-lightbox" data-title="">
            <div className="cbp-caption-defaultWrap">
              <img src={item.url} alt={item.title} />
            </div>
          </a>
        </div>
      );
    });

    return (
      <div className="portfolio-content portfolio-4 area-photos margin-top-10">
        <div id="js-area-grid-full-width" className="cbp">
          {items}
        </div>
      </div>
    );
  }

  handleClose() {
    jQuery('#post-modal').modal('hide');
  }

  renderUI() {
    jQuery('#js-area-grid-full-width').cubeportfolio({
      layoutMode: 'mosaic',
      sortToPreventGaps: true,
      defaultFilter: '*',
      animationType: 'fadeOutTop',
      gapHorizontal: 0,
      gapVertical: 0,
      gridAdjustment: 'responsive',
      mediaQueries: [{
        width: 1500,
        cols: 5
      }, {
        width: 1100,
        cols: 4
      }, {
        width: 800,
        cols: 3
      }, {
        width: 480,
        cols: 2
      }, {
        width: 320,
        cols: 1
      }],
      caption: 'zoom',
      displayType: 'lazyLoading',
      displayTypeSpeed: 100,

      // lightbox
      lightboxDelegate: '.cbp-lightbox',
      lightboxGallery: true,
      lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
    });
  }
}

export default Detail;
