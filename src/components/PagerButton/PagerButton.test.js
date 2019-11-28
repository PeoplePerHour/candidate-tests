
import * as  React from 'react';
import * as ReactDOM from 'react-dom';

import PagerButton from './PagerButton'


it('renders PagerButton without crashing', () => {
    const div = document.createElement('div');
    ReactDOM.render(<PagerButton/>, div);
    expect(div.firstChild).toMatchSnapshot();
    ReactDOM.unmountComponentAtNode(div);
})
