import React from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import Characters from "../compoments/characters";

export default function Routes() {
  return (
    <BrowserRouter>
      <Switch>
        <Route path="/" exact component={Characters} />
      </Switch>
    </BrowserRouter>
  );
}
