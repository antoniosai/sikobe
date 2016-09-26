/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import { GoogleMapLoader, GoogleMap, InfoWindow, Marker } from "react-google-maps";

class Mapping extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired,
    items: PropTypes.array
  };

  constructor() {
    super();

    this.state = this.getDefaultState();
  }

  componentWillReceiveProps(nextProps) {
    if (nextProps.items != null) {
      const markers = _.filter(nextProps.items.map((item, index) => {
        if (item.latitude != 0 && item.longitude != 0) {
          return {
            index: index,
            position: new google.maps.LatLng(item.latitude, item.longitude),
            showInfo: false
          };
        }
      }), (item) => {
        if (item) {
          return item;
        }
      });

      this.setState({markers: markers});
    }
  }

  getDefaultState() {
    return {
      markers: []
    };
  }

  render() {
    if (this.props.items == null) {
      return null;
    }

    const latLngCenter = this.getLatLngCenter(this.props.items.map((item) => {
      return [item.latitude, item.longitude];
    }));

    return (
      <GoogleMapLoader containerElement={<div style={{height: '300px'}}></div>}
        googleMapElement={
          <GoogleMap
            containerProps={{style: {
              height: '300px',
            }}} defaultZoom={10} defaultCenter={latLngCenter}>
            {this.state.markers.map((marker, index) => {
              const ref = `marker_${index}`;

              return (
                <Marker key={index} ref={ref} position={marker.position}
                 title={this.props.items[marker.index].title}
                 onClick={this.handleMarkerClick.bind(this, marker)}>
                  {marker.showInfo ? this.renderInfoWindow(ref, marker) : null}
                </Marker>
              );
                  
            })}
          </GoogleMap>
        }
      /> //end of GoogleMapLoader
    );
  }

  //Toggle to 'true' to show InfoWindow and re-renders component
  handleMarkerClick(marker) {
    marker.showInfo = true;
    this.setState(this.state);
  }
  
  handleMarkerClose(marker) {
    marker.showInfo = false;
    this.setState(this.state);
  }

  renderInfoWindow(ref, marker) {
    return (
      <InfoWindow key={`${ref}_info_window`}
        onCloseclick={this.handleMarkerClose.bind(this, marker)}>
        <div>
          <h5 className="font-dark bold uppercase">{this.props.items[marker.index].title}</h5>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].short_description}
          </p>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].address}
          </p>
          <p className="margin-top-0 margin-bottom-0">
            {this.props.items[marker.index].district.data.title} - {this.props.items[marker.index].village.data.title}
          </p>
        </div>
      </InfoWindow>
    );
  }

  rad2degr(rad) { return rad * 180 / Math.PI; }
  degr2rad(degr) { return degr * Math.PI / 180; }
  getLatLngCenter(items) {
    const LATIDX = 0;
    const LNGIDX = 1;
    let sumX = 0;
    let sumY = 0;
    let sumZ = 0;
    let lat = 0;
    let lng = 0;

    for (let i = 0; i < items.length; i++) {
      if (items[i][LATIDX] != 0 && items[i][LNGIDX] != 0) {
        lat = this.degr2rad(items[i][LATIDX]);
        lng = this.degr2rad(items[i][LNGIDX]);

        // sum of cartesian coordinates
        sumX += Math.cos(lat) * Math.cos(lng);
        sumY += Math.cos(lat) * Math.sin(lng);
        sumZ += Math.sin(lat);
      }
    }

    const avgX = sumX / items.length;
    const avgY = sumY / items.length;
    const avgZ = sumZ / items.length;

    // convert average x, y, z coordinate to latitude and longtitude
    lng = Math.atan2(avgY, avgX);
    const hyp = Math.sqrt(avgX * avgX + avgY * avgY);
    lat = Math.atan2(avgZ, hyp);

    return new google.maps.LatLng(this.rad2degr(lat), this.rad2degr(lng));
  }

}

export default Mapping;
