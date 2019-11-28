
import * as  React from 'react';
import * as ReactDOM from 'react-dom';
import { Provider } from "react-redux";
import store from "../../redux/store";



import List from './list'



it('renders without crashing', () => {
    const div = document.createElement('div');
    ReactDOM.render(<Provider store={store}><List/></Provider>, div);
    expect(div).toMatchSnapshot();
    ReactDOM.unmountComponentAtNode(div);
})
