
class SpeciesFilter extends React.Component {
  constructor(props) {
    super();
    this.selectOptions = [ 
	  { value: '', name: 'no selection' },		
	  { value: 'alien', name: 'alien' }, 
	  { value: 'human', name: 'human' },
	  { value: 'unknown', name: 'unknown' },
	  { value: 'mytholog', name: 'mytholog' },
	  { value: 'Poopybutthole', name: 'Poopybutthole' },
	  { value: 'humanoid', name: 'humanoid' }
    ];
  }

  
  render() {
    return (
	  <select class="dropd-filter"	
	    value={this.props.species}	
		onChange={ this.props.updateFilter } 
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