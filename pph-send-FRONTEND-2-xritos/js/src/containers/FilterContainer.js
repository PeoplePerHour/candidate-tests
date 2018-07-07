
class Filters extends React.Component {
  constructor(props) {
    super();
	this.state = { 
	  gender: '', 
	  status: '', 
	  species: '',
	  page:	0	
	};
	
	this.goSearch = this.goSearch.bind(this);
	
	let THAT = this;
	window.addEventListener('popstate', function(event) {						
				THAT.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
				THAT.goSearch(false);
				
	}, false);
		
  }
	
	
  goSearch(history) {
	this.props.dispatch({ type: 'DO_SEARCH', pushHistory: history });
	let obj = {
	  gender: this.props.searched.filters.gender,			
	  status: this.props.searched.filters.status,
	  species: this.props.searched.filters.species,
	  page: this.props.searched.filters.page 	
	};									
	this.setState( obj );
  };

  
  componentDidMount() {													
	this.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
	this.goSearch(true);
  }	
	
	
  render() {		
    return ( 
	  <div class="search-filters">
	    <button class="nav-but" 
		  onClick={(ev) => {
			this.props.dispatch({ type: 'GO_BACK' });
		    this.goSearch(true);
		  }}
		>&laquo; Previous</button>
	    <button class="nav-but" 
		  onClick={(ev) => {
			this.props.dispatch({ type: 'GO_NEXT' });
			this.goSearch(true);
		  }}
		>Next &raquo;</button>
	    <div class="filter-block">
		  <h2 class="filter-title">Gender</h2>
		  <GenderFilter 
		    gender={this.state.gender }	
			updateFilter={(ev) => { 
			  this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'gender', val: ev.target.value });
			  this.goSearch(true);
			}} 
		  />
		</div>
	    <div class="filter-block">
		  <h2 class="filter-title">Status</h2>
		  <StatusFilter 
		    status={this.state.status }	
			updateFilter={(ev) => { 
			  this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'status', val: ev.target.value });
			  this.goSearch(true);
			}} 
		  />
		</div>
	    <div class="filter-block">
		  <h2 class="filter-title">Species</h2>
		  <SpeciesFilter 
		    species={this.state.species}	
			updateFilter={(ev) => { 
			  this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'species', val: ev.target.value });
			  this.goSearch(true); 
			}} 
		  />
		</div>
	  </div>	
	);
  }
}
