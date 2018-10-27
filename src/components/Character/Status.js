import React from 'react';
import { Label } from '../Common';

const getColor = text => {
  switch (text.toLowerCase()) {
    case 'alive':
      return 'green';
    case 'dead':
      return 'black';
    case 'unknown':
      return 'orange';
    default:
      return 'gray';
  }
};

const Status = ({ text }) => <Label color={getColor(text)}>{text}</Label>;

export default Status;
