import React, { Component } from 'react';
import logo from './files/logo.svg';
import './HeaderComponent.sass';

export class HeaderComponent extends Component {
  
  constructor() {
    super();
    this.trigger = undefined;
    this.computeTop = this.computeTop.bind(this);
  }
  
  computeTop() {
    let elem = document.querySelector('html');
    let header = document.querySelector('header.header');
    window.addEventListener('scroll', function(e) {
      if(elem.scrollTop <= 90){
        header.classList.remove('shrink');
      }else{
        header.classList.add('shrink');
      }
    });
  }
  
  componentDidMount() {
    this.computeTop();
  }
  
  render() {
    return (
      <header className="header">
        <div className="logo">
          <a href="/"><img src={logo} alt="Logo"/></a>
        </div>
      </header>
    );
  }
}
