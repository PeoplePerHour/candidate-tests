import * as React from "react";
import * as ReactDom from 'react-dom'
import App from "./App"

//for is 11
require('es6-promise').polyfill()

const root = document.getElementById('app-root')
ReactDom.render(<App/>,root)