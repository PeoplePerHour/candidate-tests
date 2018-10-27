import React from 'react';
import renderer from 'react-test-renderer';
import Avatar from './';

it('renders correctly', () => {
  const tree = renderer
    .create(<Avatar src="https://placekitten.com/200/300" alt="kitten" />)
    .toJSON();
  expect(tree).toMatchSnapshot();
});
