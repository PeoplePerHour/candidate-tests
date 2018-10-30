import React, { Component } from 'react';
import './ListComponent.sass';

import { ItemComponent } from './ItemComponent.js';
import { Modal } from './ModalComponent.js';

import { Observer, observables, getQueryVariable } from './theModules.js';


const $URL = 'https://rickandmortyapi.com/api/character/';

function isSearched(searchTerm) {
  return function (item) {
    return item.name.toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1;
  }
}

export class ListComponent extends Component {

  constructor() {
    super();

    this.state = {
      load: false,
      searchTerm: '',
      result: {},
      modal: false,
      selected: {},
      message: '',
    };

    this.registerToFilter = this.registerToFilter.bind(this);
    this.filterSearch = this.filterSearch.bind(this);
    this.varsGet = this.varsGet.bind(this);
    this.varsSet = this.varsSet.bind(this);
    this.onSearchChange = this.onSearchChange.bind(this);
    this.itemsFetched = this.itemsFetched.bind(this);
    this.apiCall = this.apiCall.bind(this);
    this.nextPage = this.nextPage.bind(this);
    this.showModal = this.showModal.bind(this);
    this.closeModal = this.closeModal.bind(this);

    this.observer = new Observer({hook: (value) => {
      this.filterSearch(value);
    }});
  }

  varsSet({ gender = '', species = '', status = '' } = {}) {
    const base = '/?';
    const temp = [];
    let uni = '/';
    if(gender.length) temp.push(`gender=${gender}`);
    if(species.length) temp.push(`species=${species}`);
    if(status.length) temp.push(`status=${status}`);
    if(temp.length) uni = base + temp.join('&');
    window.history.pushState(null, null, uni);
  }

  varsGet() {
    let gender = getQueryVariable("gender");
    let species = getQueryVariable("species");
    let status = getQueryVariable("status");
    const base = '?';
    const temp = [];
    let uni = '';
    if(gender.length) temp.push(`gender=${gender}`);
    if(species.length) temp.push(`species=${species}`);
    if(status.length) temp.push(`status=${status}`);
    if(temp.length) uni = base + temp.join('&');
    this.apiCall(`${$URL}${uni}`);
  }

  registerToFilter(value) {
    observables.forEach((item)=>{
      if(item.id === value) item.attach(this.observer);
    });
  }

  filterSearch(obj) {
    let {gender = "", species = "", status = ""} = obj;
    gender = gender.toString().trim();
    species = species.toString().trim();
    status = status.toString().trim();

    this.varsSet(obj);
    this.apiCall(`${$URL}?gender=${gender}&species=${species}&status=${status}`);
  }

  onSearchChange(event) {
    this.setState({ searchTerm: event.target.value });
  }

  itemsFetched(result) {
    this.setState({ message: '', result: result, load: true });
  }

  itemsError(error){
    let msg;
    if(error.toString() === 'TypeError: Failed to fetch') msg = "Nothing Found...";
    else msg = error.toString();
    this.setState({ message: msg, result: {}, load: true });
  }

  apiCall(url) {
    this.setState({ load: false });
    setTimeout(() => {
      fetch(url)
        .then(responce => responce.json())
        .then(result => this.itemsFetched(result))
        .catch(error => this.itemsError(error));
    }, 800);
  }

  prevPage() {
    this.apiCall(this.state.result.info.prev);
  }

  nextPage() {
    this.apiCall(this.state.result.info.next);
  }

  showModal(item) {
    this.setState({ modal: true, selected: item});
    document.body.classList.add('clip');
  }

  closeModal() {
    this.setState({ modal: false, selected: {}});
    document.body.classList.remove('clip');
  }

  componentDidMount() {
    this.registerToFilter("filtersBar");
    this.varsGet();
  }

  render() {

    // LOADER
    if(!this.state.load){
      return (
        <div className="loader">
          <div className="loaderLine"></div>
        </div>
      );
    }

    // Nothing Found
    if(this.state.message){
      return (
        <div className="nothingFound">
          <h1>{this.state.message}</h1>
        </div>
      );
    }

    let pre = "", nex = "";
    const { modal, selected } = this.state;
    if(this.state.result.info !== undefined){
      pre = this.state.result.info.prev !== "" ? "" : "disabled";
      nex = this.state.result.info.next !== "" ? "" : "disabled";
    }

    //LIST
    return (
      <div className="itemsApp">
        <div className="itemsList">
          {this.state.result.results.filter(isSearched(this.state.searchTerm)).map((item, i) => {
            return <ItemComponent key={i} item={item} onClick={ ()=> { this.showModal(item) } } />
          })}
        </div>
        <div className="pagination">
          <button onClick={()=>{this.prevPage()}} disabled={pre}>Previous</button>
          <button onClick={()=>{this.nextPage()}} disabled={nex}>Next</button>
        </div>

        {modal &&
          <Modal item={selected} close={()=>{this.closeModal()}}/>
        }
      </div>
    );
  }
}
