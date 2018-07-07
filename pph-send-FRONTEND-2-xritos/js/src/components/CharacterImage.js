
class Image extends React.Component {
  constructor(props) {
    super();
	this.state = { 
	  srcZ: null, 
	  img: 'inline-block', 
	  fallback: 'none' 
	};
	
	this.loadFallback = this.loadFallback.bind(this);
  }
	
	
  loadFallback() {
    this.setState({ 
	  img: 'none', 
	  fallback: 'inline-block' 
	});	
	console.log('error loading image');
	this.props.showProfile();
  }
	
	
  loadImageSource() {
    const addImageProcess = (src) => { 
	  return new Promise((resolve, reject) => { 
		let img = new Image();
		img.onload  = resolve(img);
		img.onerror = reject(img);
		img.src = src;	
	  })	
	}
		
	addImageProcess(this.props.sourceZ).then((u) => {
	  this.setState({ 
	    srcZ: this.props.sourceZ, 
		img: 'inline-block', 
		fallback: 'none' 
	  });
	},
	(err) => {	
	  console.log("rejected: ", err)
	  this.setState({ 
	    srcZ: this.props.sourceZ, 
		img: 'none', 
		fallback: 'inline-block' 
	  });
	});	
  }
	
	
  componentDidMount() {
    this.loadImageSource();
  }
	
	
  componentDidUpdate(prevProps) {	
    if (prevProps.sourceZ && prevProps.sourceZ===this.props.sourceZ) { return; }		
	this.loadImageSource();	
  }
  
  
  render() {
    return (
	  <div style={{display:'inline-block'}}>
	    <img  alt="" 
		  style={{display:this.state.img}} 
		  src={this.state.srcZ} 
		  onLoad={this.props.showProfile} 
		  onError={this.loadFallback} 
		/>
		<span 
		  style={{width:'200px',display:this.state.fallback}}
		>NO IMAGE SRC</span>
	  </div>
	);
  }  
}