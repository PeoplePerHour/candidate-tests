import React from 'react';
import renderer from 'react-test-renderer';
import Label from './';

it('renders correctly', () => {
  const tree = renderer.create(<Label color="green">Green</Label>).toJSON();
  expect(tree).toMatchSnapshot();
});
