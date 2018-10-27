import React from 'react';

import cn from 'classnames';
import './avatar.scss';

const Avatar = ({ src, alt, square = false }) => (
  <div className={cn('Avatar', { 'Avatar--square': square })}>
    <div className="Avatar__image-container">
      <img src={src} alt={alt ? alt : 'avatar'} />
    </div>
  </div>
);

export default Avatar;
