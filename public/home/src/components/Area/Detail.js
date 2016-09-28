/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { GoogleMapLoader, GoogleMap, InfoWindow, Marker } from "react-google-maps";
import { notify } from '../Util';
import { getAreaPhotos } from '../../actions/actions';
import Posts from './Posts';
import Statuses from './Statuses';

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
      isPostsLoaded: false,
      isPhotosLoaded: false,
      isStatusesLoaded: false,
      isShown: false,
      photos: []
    };
  }

  componentDidMount() {
    const onShown = () => {
      this.renderUI();
      
      let state = {
        isShown: true
      };

      if (typeof this.props.data.photos != "undefined") {
        state.isPhotosLoaded = true;
      }

      this.setState(state);
    };
    const onHidden = () => {
      jQuery('#todo-task-modal').unbind('shown.bs.modal', onShown);
      jQuery('#todo-task-modal').unbind('hidden.bs.modal', onHidden);

      if (this.props.onClose) {
        this.props.onClose();
      }
    };

    jQuery('#todo-task-modal').on('shown.bs.modal', onShown);
    jQuery('#todo-task-modal').on('hidden.bs.modal', onHidden);
    jQuery('#todo-task-modal').modal('show');
  }

  componentDidUpdate() {
    if ( ! this.state.isPhotosLoaded) {
      getAreaPhotos(this.props.data.id).then((response) => {
        this.setState({
          isPhotosLoaded: true,
          photos: response.data
        });
      }).catch((error) => {
        notify('error', error.message, 'Error');

        this.setState({
          isPhotosLoaded: true
        });
      });
    }
  }

  render() {
    const data = this.props.data;
    
    return (
      <div id="todo-task-modal" className="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard={false}>
        <div className="modal-dialog">
          <div className="modal-content scroller" style={{height: 100 + '%'}} data-always-visible={1} data-rail-visible={0}>
            <div className="modal-header">
              <button type="button" className="close" data-dismiss="modal" aria-hidden="true" />
              <h4 className="font-dark bold uppercase">{data.title}</h4>
            </div>
            <div className="modal-body todo-task-modal-body">
              <div className="row">
                <div className="col-md-6">
                  <i className="icon-direction"></i> {data.address} - {data.village.data.title} - {data.district.data.title}
                </div>
                <div className="col-md-6 text-right">
                  <p className="todo-task-modal-bg margin-top-0" dangerouslySetInnerHTML={{__html: data.description.replace(/(?:\r\n|\r|\n)/g, '<br />')}} />
                </div>
              </div>
              <div className="row">
                <div className="col-md-6">
                  {this.getMap()}
                </div>
                <div className="col-md-6">
                  <div className="portlet light about-text post-container">
                    <h4 style={{paddingTop: '10px', paddingBottom: '10px'}}>
                      <i className="fa fa-check icon-info"></i> Posko
                    </h4>
                    {this.getPostsLoading()}
                    <Posts baseUrl={this.props.baseUrl} areaId={data.id}
                     dataIsLoaded={this.handlePostsIsLoaded.bind(this)}
                     openDetail={this.handleOpenPostDetail.bind(this)} />
                  </div>
                </div>
              </div>
              {this.getPhotosLoading()}
              {this.getPhotos()}
              {this.getStatusesLoading()}
              <Statuses areaId={data.id} dataIsLoaded={this.handleStatusesIsLoaded.bind(this)} />
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

  handlePostsIsLoaded() {
    this.setState({isPostsLoaded: true});
  }

  handleOpenPostDetail(data) {
    // this.setState({openDetailData: data});
  }

  handleStatusesIsLoaded() {
    this.setState({isStatusesLoaded: true});
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
    if (typeof this.props.data.photos == "undefined" && this.state.photos.length == 0) {
      return null;
    }

    let photos = this.state.photos;
    if (photos.length == 0 && typeof this.props.data.photos != "undefined") {
      photos = this.props.data.photos.data;
    }

    if (photos.length == 0) {
      return null;
    }

    const items = photos.map((item) => {
      return (
        <div key={`area-photo-item-${item.url}`} className="cbp-item">
          <a href={item.url} className="cbp-caption cbp-lightbox" data-title="">
            <div className="cbp-caption-defaultWrap">
              <img src={item.url} alt={item.title} />
            </div>
          </a>
        </div>
      );
    });

    return (
      <div className="portfolio-content portfolio-4 margin-top-10 area-photos">
        <div id="js-area-grid-full-width" className="cbp">
          {items}
        </div>
      </div>
    );
  }

  getPostsLoading() {
    return ! this.state.isPostsLoaded ? this.getLoading() : null;
  }

  getPhotosLoading() {
    return ! this.state.isPhotosLoaded ? this.getLoading() : null;
  }

  getStatusesLoading() {
    return ! this.state.isStatusesLoaded ? this.getLoading() : null;
  }

  getLoading() {
    return (
      <div className="padding-20 text-center">
        <img src={`${this.props.baseUrl}/assets/img/loading-spinner-grey.gif`} className="loading" /> 
        <span>&nbsp;&nbsp;Mengunduh data... </span>
      </div>
    );
  }

  handleClose() {
    jQuery('#todo-task-modal').modal('hide');
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
