import React, { Component } from 'react';
import './FiltersComponent.sass';
import equalizer from './files/eq.svg';


import { Observable, observables, getQueryVariable } from './theModules.js';

export class Filters extends Component {
  constructor() {
    super();

    this.state = {
      open : false
    };

    this.filters = {
      gender: {
        value: "",
        data: ['Male','Female','Genderless','Unknown']
      },
      species: {
        value: "",
        data: ['Human','Alien','Animal','Parasite','Vampire','Robot','Poopybutthole','Mytholog','Cronenberg','Disease','Unknown']
      },
      status: {
        value: "",
        data: ['Alive','Dead','Unknown']
      },
    };


    this.toggle = this.toggle.bind(this);
    this.varsGet = this.varsGet.bind(this);
    this.filterChange = this.filterChange.bind(this);
    this.observable = new Observable({id: "filtersBar"});

    observables.push(this.observable);
  }

  filterChange(obj) {
    this.observable.setState(obj);
  }

  getValue(name, event) {
    let filt = this.filters;
    this.filters[name].value = event.target.value;
    this.filterChange((function() {
      let obj = {};
      for (let variable in filt) {
        if (filt.hasOwnProperty(variable)) {
          Object.assign(obj,{[variable]: filt[variable].value});
        }
      }
      return obj;
    }()));

    this.setState({});
  }

  toggle() {
    if (this.state.open) this.setState({open: false});
    else this.setState({open: true});
  }

  varsGet() {
    this.filters.gender.value = getQueryVariable("gender");
    this.filters.species.value = getQueryVariable("species");
    this.filters.status.value  = getQueryVariable("status");
  }

  componentDidMount() {
    this.varsGet();
  }

  render() {
    const open = this.state.open ? " open" : "";
    return (
      <div className={"filtersBar" + open}>
        <div className="icon" onClick={()=>{this.toggle()}}>
          <img alt="filters" src={equalizer} />
        </div>
        <div className="filters">
          <Filter
            name="Gender"
            onChange={(e)=>{this.getValue("gender", e)}}
            values={this.filters.gender.data}
            selected={this.filters.gender.value} />

          <Filter
            name="Species"
            onChange={(e)=>{this.getValue("species", e)}}
            values={this.filters.species.data}
            selected={this.filters.species.value} />

          <Filter
            name="Status"
            onChange={(e)=>{this.getValue("status", e)}}
            values={this.filters.status.data}
            selected={this.filters.status.value} />

        </div>
      </div>
    );
  }
}

export class Filter extends Component {
  render() {
    return (
      <label><span>{this.props.name} :</span>
        <select name={this.props.name} onChange={this.props.onChange} value={this.props.selected}>
          <option value="" key="0">Select</option>
            {this.props.values.map((item,i)=>{
              return <option key={i+1} value={item}>{item}</option>
            })}
        </select>
      </label>
    );
  }
}
