/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import Mapping from './Mapping';
import List from './List';

class Area extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    territory: PropTypes.object.isRequired
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  getDefaultState() {
    return {
      filter: {
        district: 'all',
        village: 'all',
        search: null
      },
      isDataLoaded: false,
      items: null
    };
  }

  render() {
    const districts = this.props.territory.districts.map((item) => {
      return (<option key={`district-${item.id}`} value={item.id}>{item.name}</option>);
    });

    const villages = this.props.territory.villages.map((item) => {
      return (<option key={`village-${item.id}`} value={item.id}>{item.name} | {item.district}</option>);
    });

    return (
      <div className="area-container">
        <div className="portlet light">
          <div className="portlet-title">
            <div className="caption form">
              <div className="form-group form-md-line-input form-md-floating-label padding-top-0 margin-bottom-0">
                <div className="input-group">
                  <div className="input-group-control">
                    <select id="filter-district" className="form-control">
                      <option value="all">Semua Kecamatan</option>
                      {districts}
                    </select>
                  </div>
                  <div className="input-group-control">
                    <select id="filter-village" className="form-control">
                      <option value="all">Semua Kelurahan</option>
                      {villages}
                    </select>
                  </div>
                  <div className="input-group-control">
                    <input type="text" id="filter-search" className="form-control" placeholder="Pencarian" />
                  </div>
                  <span className="input-group-btn btn-right">
                    <button type="button" className="btn red-sunglo" onClick={this.handleFilter.bind(this)}>
                      Filter
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <Mapping baseUrl={this.props.baseUrl}
           items={this.state.items} />
        </div>
        {this.getLoading()}
        <List baseUrl={this.props.baseUrl}
         filter={this.state.filter}
         dataIsLoaded={this.handleDataIsLoaded.bind(this)}
         loadedData={this.handleLoadedData.bind(this)} />
      </div>
    );
  }

  handleFilter() {
    const district = document.getElementById('filter-district');
    const districtId = district.options[district.selectedIndex].value;

    const village = document.getElementById('filter-village');
    const villageId = village.options[village.selectedIndex].value;

    this.setState({
      filter: {
        district: districtId,
        village: villageId,
        search: document.getElementById('filter-search').value
      },
      isDataLoaded: false
    });
  }

  handleDataIsLoaded() {
    this.setState({isDataLoaded: true});
  }

  handleLoadedData(items) {
    this.setState({items: items});
  }

  getLoading() {
    return ! this.state.isDataLoaded ? (
      <div className="padding-20 text-center">
        <img src={`${this.props.baseUrl}/assets/img/loading-spinner-grey.gif`} className="loading" /> 
        <span>&nbsp;&nbsp;Mengunduh data... </span>
      </div>
    ) : null;
  }

}

export default Area;
