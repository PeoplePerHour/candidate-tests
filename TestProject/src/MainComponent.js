import React, { Component } from 'react';
import { Filters } from './FiltersComponent.js';
import './MainComponent.sass';

import { ListComponent } from './ListComponent.js';

export class MainComponent extends Component {
  render() {
    return (
      <main className="main">
        <Filters/>
        <ListComponent />
      </main>
    );
  }
}
