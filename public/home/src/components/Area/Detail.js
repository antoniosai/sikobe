/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import moment from 'moment';

class Detail extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    data: PropTypes.object.isRequired,
    onClose: PropTypes.func
  };

  componentDidMount() {
    const onShown = () => {
      jQuery('#js-grid-full-width').cubeportfolio({
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
              <p className="todo-task-modal-bg margin-top-0" dangerouslySetInnerHTML={{__html: data.description.replace(/(?:\r\n|\r|\n)/g, '<br />')}} />
              <p className="todo-task-modal-bg">
                <i className="icon-direction"></i> {data.address} - {data.village.data.title} - {data.district.data.title}
              </p>
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

  getPhotos() {
    if (this.props.data.photos.data.length == 0) {
      return null;
    }

    const items = this.props.data.photos.data.map((item) => {
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
      <div className="portfolio-content portfolio-4">
        <div id="js-grid-full-width" className="cbp">
          {items}
        </div>
      </div>
    );
  }

  handleClose() {
    jQuery('#todo-task-modal').modal('hide');
  }
}

export default Detail;
