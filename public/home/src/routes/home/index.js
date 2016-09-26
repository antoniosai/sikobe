/**
 * React Starter Kit (https://www.reactstarterkit.com/)
 *
 * Copyright © 2014-2016 Kriasoft, LLC. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React from 'react';
import Home from '../../components/Home';

export default {

  path: '/',

  async action({ render, context }) {
    const baseUrl = context.store.getState().runtime.baseUrl;

    return <Home context={context} baseUrl={baseUrl} />;
  },

};
