

class Filters extends React.Component {

	constructor(props) {
	
		super();
		this.state = { 
		
					gender	: 	'' 	, 
					status	: 	'' 	, 
					species	:	''	,
					page	:	0	
		};
		
		let THAT = this;
		window.addEventListener('popstate', function(event) 
		{						
				THAT.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
				THAT.goSearch(false);
				
		}, false);
		
	}
	
	goSearch	 = (history) => {
									this.props.dispatch({ type: 'DO_SEARCH', pushHistory: history });
									let obj 			=	{
											gender:		this.props.searched.filters.gender 	,			
											status:		this.props.searched.filters.status 	,
											species:	this.props.searched.filters.species ,
											page:		this.props.searched.filters.page 	
									}									
									this.setState( obj );
	};

	componentDidMount() {													
									this.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
									this.goSearch(true);
	}	
		
	render() {		
		return ( 
				<div class="search-filters">
					<button class="nav-but" onClick={	(ev) => {this.props.dispatch({ type: 'GO_BACK' });this.goSearch(true);} 	}>&laquo; Previous</button>
					<button class="nav-but" onClick={	(ev) => {this.props.dispatch({ type: 'GO_NEXT' });this.goSearch(true);} 	}>Next &raquo;</button>
					<div class="filter-block"><h2 class="filter-title">Gender</h2><GenderFilter 	gender	={this.state.gender }	updateFilter={	(ev) => { this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'gender', val: ev.target.value });this.goSearch(true);  }	} /></div>
					<div class="filter-block"><h2 class="filter-title">Status</h2><StatusFilter 	status	={this.state.status }	updateFilter={	(ev) => { this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'status', val: ev.target.value });this.goSearch(true);  }	} /></div>
					<div class="filter-block"><h2 class="filter-title">Species</h2><SpeciesFilter 	species	={this.state.species}	updateFilter={	(ev) => { this.props.dispatch({ type: 'UPDATE_FILTER' , prop:'species', val: ev.target.value });this.goSearch(true); }	} /></div>
				</div>	
		);
	}
}


	

class GenderFilter extends React.Component {

	constructor(props) {
	
		super();
		this.selectOptions = [ 
							{ value:''			,name:'no selection'	}	,
							{ value:'male'		,name:'male' 			}	, 
							{ value:'female'	,name:'female'			} 
		];
		console.log("props",props);
	}

		
	render() {	
		return  (
			<select class="dropd-filter"	value={this.props.gender}	onChange={ this.props.updateFilter } >
					{ 	
						this.selectOptions.map( 
														(x) => 	{
																	return <SelectOption  optionValue={x.value} optionName={x.name}  />																	
																} 
						)
					}
			</select>
		);
	}
			
}



class StatusFilter extends React.Component {

	constructor(props) {
	
		super();
		this.selectOptions = [ 
							{ value:''			,name:'no selection' }	,
							{ value:'unknown'	,name:'unknown' 	 }	, 
							{ value:'alive'		,name:'alive'		 }	,
							{ value:'dead'		,name:'dead'		 }
		];
	}
	
	render() {
		return  (
			<select class="dropd-filter"	value={this.props.status}	onChange={ this.props.updateFilter } >
					{ 	
						this.selectOptions.map( 
														(x) => 	{
																	return <SelectOption   optionValue={x.value} optionName={x.name}  />																	
																} 
						)
					}
			</select>
		);
	}
}




class SpeciesFilter extends React.Component {

	constructor(props) {
		super();
		this.selectOptions = [ 
							{ value:''				,name:'no selection'	},		
							{ value:'alien' 		,name:'alien' 			}, 
							{ value:'human'			,name:'human'			},
							{ value:'unknown'		,name:'unknown'			},
							{ value:'mytholog'		,name:'mytholog'		},
							{ value:'Poopybutthole'	,name:'Poopybutthole'	},
							{ value:'humanoid'      ,name:'humanoid'        }
		];
	}
	
	render() {
		return  (
			<select class="dropd-filter"	value={this.props.species}	onChange={ this.props.updateFilter } >
					{ 	
						this.selectOptions.map( 
														(x) => 	{
																	return <SelectOption   optionValue={x.value} optionName={x.name}  />																	
																} 
						)
					}
			</select>
		);
	}
}




class SelectOption extends React.Component {
  render() {  
    return <option value={this.props.optionValue}>{this.props.optionName}</option>;
  }
}
