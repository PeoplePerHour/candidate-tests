import React from 'react';
import ShallowRenderer from 'react-test-renderer/shallow'; // ES6
import App from './App';

it('renders without crashing', () => {
  const renderer = new ShallowRenderer();
  renderer.render(<App />);
});
