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
    const onHidden = () => {
      jQuery('#todo-task-modal').unbind('hidden.bs.modal', onHidden);

      if (this.props.onClose) {
        this.props.onClose();
      }
    };

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
              <h4>
                <strong>{data.title}</strong> | {moment(data.created_at.date).format('D MMMM YYYY, HH:mm:ss')}
              </h4>
            </div>
            <div className="modal-body" dangerouslySetInnerHTML={{__html: data.description.replace(/(?:\r\n|\r|\n)/g, '<br />')}} />
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

  handleClose() {
    jQuery('#todo-task-modal').modal('hide');
  }
}

export default Detail;
