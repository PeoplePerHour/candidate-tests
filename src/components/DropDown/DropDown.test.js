
import * as  React from 'react';
import * as ReactDOM from 'react-dom';

import DropDown from './DropDown'


it('renders DropDown without crashing', () => {
    const div = document.createElement('div');
    ReactDOM.render(<DropDown/>, div);
    expect(div.firstChild).toMatchSnapshot();
    ReactDOM.unmountComponentAtNode(div);
})
