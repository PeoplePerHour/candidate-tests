import './characters.scss';
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { fetchChars } from '../../state/actions';
import CharacterCard from './Components/CharacterCard/CharacterCard';
import Loader from './Components/Loader/Loader';
import debounce from 'lodash/debounce';
import CHARS_API_URL from '../../constants';
import { urlParamsToObject, serializeParamsObject } from '../../helpers';

const initialFilters = {
  name: '',
  gender: ''
};

export class Characters extends Component {

  constructor(props) {
    super(props);
    this.state = {
      filters: initialFilters
    }
  }

  componentDidMount() {
    this.initializeUrlFilters();
  }

  initializeUrlFilters = () => {
    const paramsObject = this.props.location.search
      ? urlParamsToObject(this.props.location.search)
      : null;
    this.setState({
      ...this.state,
      filters: {
        name: paramsObject?.name ? paramsObject.name : '',
        gender: paramsObject?.gender ? paramsObject.gender : ''
      }
    }, () => { this.applyFilters() });
  }

  fetchChars = (url) => {
    this.props.fetchChars(url);
  }

  renderChars = () => {
    return this.props.chars && this.props.chars.map( char => <CharacterCard key={`${char.id}`} character={char} />)
  }

  renderPagination = () => {
    if (!this.props.info) { return null; }
    return(
      <div className="pagination">
        <button onClick={() => this.applyFilters()}  className="pagination__btn">0</button>
        { this.props?.info?.prev && 
          <button className="pagination__btn pagination__btn--prev" onClick={() => this.fetchChars(this.props.info.prev)}>
            ‹ {this.props.info.prevPage}
          </button>
        }
        <span>{`Page ${this.props?.info?.currentPage} of ${this.props?.info?.pages}`}</span>
        { this.props?.info?.next && 
          <button className="pagination__btn pagination__btn--next" onClick={() => this.fetchChars(this.props.info.next)}>
            {this.props.info.nextPage} ›
          </button>
        }
      </div>
    );
  }

  handleHomeBtnClick = (e) => {
    e.preventDefault();
    this.props.history.push('/')
  }

  renderFilters = () => {
    return (
      <div>
        <a href="/" onClick={ (e) => {this.handleHomeBtnClick(e)}}>‹ HOME</a>
        <input value={this.state.filters.name} placeholder="Search by Name" onChange={ (e) => {this.handleNameFilterChange(e)} } />
        <select onChange={(e) => {this.handleGenderFilterChange(e.target.value)}} value={this.state.filters.gender}>
          <option value="">All Genders</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Unknown">Unknown</option>
        </select>
        <button onClick={() => {this.resetFilters()}}>RESET</button>
      </div>
    );
  }

  handleNameFilterChange = (event) => {
    this.setState({
      ...this.state,
      filters: {
        ...this.state.filters,
        name: event.target.value
      }
    },() => {
      event.persist();
      if (!this.debouncedFn) {
        this.debouncedFn =  debounce(() => {
          this.applyFilters();
        }, 500);
      }
      this.debouncedFn();
    });
  }
  
  handleGenderFilterChange = (value) => {
    this.setState({
      ...this.state,
      filters: {
        ...this.state.filters,
        gender: value
      }
    }, () => { this.applyFilters() })
  }

  applyFilters = () => {
    const paramsSuffix = serializeParamsObject(this.state.filters);
    this.props.history.push(`/characters/?${paramsSuffix}`);
    this.fetchChars(`${CHARS_API_URL}/?${paramsSuffix}`);
  }

  resetFilters = () => {
    this.setState({
      ...this.state,
      filters: initialFilters
    }, () => { this.applyFilters() })
  }

  render() {
    return (
      <div className="characters">
        <div className="filters">
          <div className="container">
            <div className="filters__inner">
              {this.renderFilters()}
              {this.renderPagination()}
            </div>
          </div>
        </div>
        { this.props.loading && <Loader />}
        <div className="container">
          <div className={`characters-container ${this.props.loading ? 'loading' : ''}`}>
            {this.renderChars()}
          </div>
        </div>
        {this.props.error && <div className="error">{this.props.error}</div>}
      </div>
    );
  }
};

const mapStateToProps = (state /*, ownProps*/) => {
  return {
    loading: state.loading,
    chars: state.chars,
    info: state.info,
    error: state.error
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    fetchChars: page => dispatch(fetchChars(page))
  }
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Characters);
