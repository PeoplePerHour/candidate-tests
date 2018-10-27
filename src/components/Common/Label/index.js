import React from 'react';
import cn from 'classnames';

import './label.scss';

const Label = ({ color, children }) => (
  <div className={cn('Label', { [`Label--${color}`]: color })}>{children}</div>
);

export default Label;
