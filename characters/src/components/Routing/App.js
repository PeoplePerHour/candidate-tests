import React from 'react'
import { Router, Route, browserHistory, IndexRoute } from 'react-router'
import Home from './Home'
import Filtered from '../Filtered'

class App extends React.Component {
    render() {
        return (
            <Router history={browserHistory}>
                <Route path={'/'} component={Filtered}>
                    <IndexRoute component={Filtered}/>
                    <Route path={'home'} component={Home} />
                    <Route path={'filtered'} component={Filtered} />
                </Route>
            </Router>
        )
    }
}

export default App
