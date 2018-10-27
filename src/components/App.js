import React, { Component } from 'react';
import { HashRouter as Router, Route } from 'react-router-dom';

import RootModal from './RootModal';
import { Characters } from './Character';
import { ReactComponent as Logo } from '../logo.svg';

import './App.scss';

class App extends Component {
  render() {
    return (
      <Router>
        <div className="App">
          <header className="App__header">
            <section className="App__logo-wrapper">
              <Logo height="auto" width="400" />
            </section>
          </header>
          <section className="App__body">
            <Route path="/" component={Characters} />
          </section>
          <footer className="App__footer">
            <span>{'(╯°□°）╯︵'}</span> <div>&copy; 2018</div>
          </footer>
          <RootModal />
        </div>
      </Router>
    );
  }
}

export default App;
