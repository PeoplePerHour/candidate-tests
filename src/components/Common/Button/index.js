import React from 'react';
import cn from 'classnames';

import './button.scss';

const Button = ({
  disabled,
  children,
  onClick,
  plain = false,
  color,
  active,
  ...rest
}) => {
  const classNames = cn('Button', {
    'Button--plain': plain,
    'Button--active': active,
    [`Button--${color}`]: color
  });

  return (
    <button
      className={classNames}
      onClick={onClick}
      disabled={disabled}
      {...rest}
    >
      {children}
    </button>
  );
};

export default Button;
