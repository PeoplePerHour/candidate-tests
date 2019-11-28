
import * as  React from 'react';
import * as ReactDOM from 'react-dom';

import Details from './Details'

const data = [
    {
      id: 1,
      name: 'Rick Sanchez',
      status: 'Alive',
      species: 'Human',
      type: '',
      gender: 'Male',
      origin: {
        name: 'Earth (C-137)',
        url: 'https://rickandmortyapi.com/api/location/1'
      },
      location: {
        name: 'Earth (Replacement Dimension)',
        url: 'https://rickandmortyapi.com/api/location/20'
      },
      image: 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
      episode: [
        'https://rickandmortyapi.com/api/episode/1',
        'https://rickandmortyapi.com/api/episode/2',
      ],
      url: 'https://rickandmortyapi.com/api/character/1',
      created: '2017-11-04T18:48:46.250Z'
    },
]

it('renders without crashing', () => {
    const div = document.createElement('div');
    ReactDOM.render(<Details character={data}/>, div);
    expect(div.firstChild).toMatchSnapshot();
    ReactDOM.unmountComponentAtNode(div);
})
