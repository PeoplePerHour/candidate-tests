import React from "react";
import { Provider } from "react-redux";
import "./App.scss";

import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import Home from "./components/Home";
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Redirect,
} from "react-router-dom";
import store from "./store";

function App() {
  return (
    <Provider store={store}>
      <Router>
        <Navbar />
        <Switch>
          <Route exact path="/">
            <Redirect to="/characters" />
          </Route>
          <Route exact path="/characters" component={Home}/>
        </Switch>
        <Footer />
      </Router>
    </Provider>
  );
}

export default App;
