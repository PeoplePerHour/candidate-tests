
class GenderFilter extends React.Component {
  constructor(props) {	
    super();
	this.selectOptions = [ 
	  { value: '', name: 'no selection' },
	  { value: 'male', name: 'male' }, 
	  { value: 'female', name: 'female' } 
	];
	console.log("props",props);
  }
  
  
  render() {	
    return (
	  <select class="dropd-filter"	
	    value={this.props.gender}	
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