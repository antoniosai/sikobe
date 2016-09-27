/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { notify } from '../Util';
import moment from 'moment';
import { getAreaStatuses } from '../../actions/actions';

class Statuses extends Component {

  static propTypes = {
    areaId: PropTypes.number.isRequired,
    getAreaStatuses: PropTypes.func.isRequired, 
    dataIsLoaded: PropTypes.func
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

    let items = (<p>Belum ada status terbaru dari area ini.</p>);

    if (this.state.items.length > 0) {
      items = (
        <div className="todo-tasklist">{this.state.items.map((item) => {
          return (
            <div key={`area-status-item-${item.id}`} className={`todo-tasklist-item margin-top-10 ${this.getBorderColor(item)}`}>
              <div className="todo-tasklist-item-text" dangerouslySetInnerHTML={{__html: item.description.replace(/(?:\r\n|\r|\n)/g, '<br />')}} />
              <div className="todo-tasklist-controls">
                <span className="todo-tasklist-date">
                  <i className="fa fa-calendar"></i> {moment(item.datetime.date).format('D MMMM YYYY, HH:mm:ss')}
                </span>
                <span className="todo-tasklist-badge badge badge-roundless">#{item.scale}</span>
              </div>
              {this.getPhotos(item)}
            </div>
          );
        })}
        </div>
      );
    }

    return (
      <div className="portlet light no-padding margin-top-10">
        <div className="portlet-title">
          <div className="caption">
            <i className="icon-bubble"></i>
            <span className="caption-subject font-hide bold uppercase">Status</span>
          </div>
        </div>
        <div className="portlet-body">{items}</div>
      </div>
    );
  }

  getPhotos(item) {
    if (item.photos.data.length == 0) {
      return null;
    }

    const items = item.photos.data.map((item) => {
      return (
        <div key={`area-status-photo-item-${item.url}`} className="col-xs-6 col-sm-4">
          <a href={item.url} target="_blank" className="thumbnail">
            <img src={item.url} alt={item.title} />
          </a>
        </div>
      );
    });

    return (
      <div className="row area-status-photos margin-top-10">{items}</div>
    );
  }

  getBorderColor(item) {
    let color = '';

    switch (item.scale) {
      case 1:
        color = 'todo-tasklist-item-border-green';
        break;
      case 2:
        color = 'todo-tasklist-item-border-blue';
      case 3:
        color = 'todo-tasklist-item-border-purple';
        break;
      case 4:
        color = 'todo-tasklist-item-border-yellow';
        break;
      case 5:
        color = 'todo-tasklist-item-border-red';
        break;
    }
    
    return color;
  }

  collectData() {
    this.props.getAreaStatuses(this.props.areaId, {
      limit: 0, 
      include: 'photos'
    });
  }

}

const mapStateToProps = (state) => {
  return {
    data: state.areaStatuses
  }
};

const mapDispatchToProps = {
  getAreaStatuses
};

export default connect(mapStateToProps, mapDispatchToProps)(Statuses);
