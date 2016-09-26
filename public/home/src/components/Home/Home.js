/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';
import Information from '../Information';
import Incident from '../Incident';
import Area from '../Area';
import Post from '../Post';

class Home extends Component {

  static propTypes = {
    baseUrl: PropTypes.string.isRequired
  };

  render() {
    return (
      <div className="row">
        <div className="col-md-4">
          <Information baseUrl={this.props.baseUrl} />
          <Incident baseUrl={this.props.baseUrl} />
          <Post baseUrl={this.props.baseUrl} />
        </div>
        <div className="col-md-8">
          <Area baseUrl={this.props.baseUrl} />
        </div>
      </div>
    );
  }

}

export default Home;
