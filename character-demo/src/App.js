import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Landing from './components/Landing/Landing.js';
import Main from './components/Main/Main.js';

export default class App extends React.Component {

  render() {

    return (
      <BrowserRouter>
        <Switch>
            <Route exact path="/" component={Landing}></Route>
            <Route path="/main" component={Main}></Route>
          </Switch>
        </BrowserRouter>
    );

  }
}