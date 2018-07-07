class StatusFilter extends React.Component {
  constructor(props) {	
    super();
	this.selectOptions = [ 
	  { value: '', name: 'no selection' },
	  { value: 'unknown', name: 'unknown'}, 
	  { value: 'alive', name: 'alive'},
	  { value: 'dead', name: 'dead' }
	];
  }

  
  render() {
    return (
	  <select class="dropd-filter"	
	    value={this.props.status}	
		onChange={this.props.updateFilter} 
	  >
	  {this.selectOptions.map((x) => {
	    return (
		  <option 
			value={x.value}
		  >
	        {x.name}
	      </option>	
		)	  
	  })}
	  </select>
	);
  }
}