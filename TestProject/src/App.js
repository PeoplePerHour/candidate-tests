import React, { Component } from 'react';
import { HeaderComponent } from './HeaderComponent.js';
import { MainComponent } from './MainComponent.js';
import { FooterComponent } from './FooterComponent.js';
import './App.sass';

class App extends Component {
  render() {
    return (
      <div className="App">
        <HeaderComponent />
        <MainComponent />
        <FooterComponent />
      </div>
    );
  }
}

export default App;
