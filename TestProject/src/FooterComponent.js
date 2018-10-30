import React, { Component } from 'react';
import './FooterComponent.sass';

export class FooterComponent extends Component {
  render() {
    return (
      <footer>
        <div className="footerInner">
          <span>&copy; 2018</span>
        </div>
      </footer>
    );
  }
}
