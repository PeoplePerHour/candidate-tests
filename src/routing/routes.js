import React from 'react';
import { Redirect } from 'react-router';

import App from './../components/App';
import CharactersPage from './../pages/CharactersPage';

const routes = [
  {
    component: App,
    name: 'RickAndMorty',
    routes: [
      {
        path: '/characters',
        exact: true,
        component: CharactersPage,
        name: 'Characters',
        menuName: 'characters',
        routes: []
      },
      {
        path: '',
        exact: false,
        component: (props) => <Redirect to="/characters"/>
      }
    ]
  }
];

export default routes;
