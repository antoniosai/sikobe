/**
 * Author © 2016 Sulaeman <me@sulaeman.com>. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { Component, PropTypes } from 'react';

class TextBox extends Component {

  static propTypes = {
    maxLines: PropTypes.number,
  };

  static defaultProps = {
    maxLines: 1,
  };

  render() {
    let className = this.props.className;
    if (this.props.defaultValue != '') {
      className = className + ' edited';
    }

    return this.props.maxLines > 1 ?
      <textarea
        {...this.props}
        className={className}
        ref="input"
        key="input"
        rows={this.props.maxLines}
      /> :
      <input
        {...this.props}
        className={className}
        ref="input"
        key="input"
      />;
  }

}

export default TextBox;
