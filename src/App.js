import React from "react";
import "./App.scss";
import Routes from "./routers/index";
import { Provider } from 'react-redux';
import store from "./store"
import 'bootstrap/dist/css/bootstrap.min.css';

function App() {
  return (
    <Provider store={store}>
      <Routes />
    </Provider>
  );
}

export default App;

