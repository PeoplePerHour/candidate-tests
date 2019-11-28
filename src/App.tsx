import * as React from "react";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import List from "./components/List/List";
import { Provider } from "react-redux";
import store from "./redux/store";
import "./styles/style.scss";
const nothing = "/src/assets/nothing.png"

const FouOFourPage=()=><div className={'p404'}>
  <h1>Are You Lost ???</h1>
<img src={nothing} alt=""/>

<h1>404 !!</h1></div>


export default function App(): JSX.Element {
  return (
    <Router>
      <Provider store={store}>
        <Switch>
      <Route exact path="/" component={List} />
      <Route path="*" component={FouOFourPage} />
      </Switch>
      </Provider>
    </Router>
  );
}
