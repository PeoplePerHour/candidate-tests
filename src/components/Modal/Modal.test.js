
import * as  React from 'react';
import * as ReactDOM from 'react-dom';

import Modal from './Modal'


it('renders Modal without crashing', () => {
    const div = document.createElement('div');
    ReactDOM.render(<Modal/>, div);
    expect(div.firstChild).toMatchSnapshot();
    ReactDOM.unmountComponentAtNode(div);
})
